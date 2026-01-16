<?php

namespace App\Repositories\SQL;

use App\Criteria\OrderReservationByDateCriteria;
use App\Events\CallStarted;
use App\Models\Chat;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Transaction;
use App\Notifications\Patient\ReservationAccepted;
use App\Repositories\interfaces\ScheduleRepository;
use App\Services\Contracts\TokBoxContract;
use App\Services\Drivers\TokBoxDriver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use MyFatoorah\Library\MyfatoorahApiV2;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use OpenTok\OutputMode;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\ReservationRepository;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

/**
 * Class ReservationRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class ReservationRepositoryEloquent extends BaseRepository implements
    ReservationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Reservation::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        parent::boot();
        $this->pushCriteria(app(OrderReservationByDateCriteria::class));
    }

    public function upcoming()
    {
        return $this->with('doctor', 'pending_request')
            ->upComing()
            ->where('status', Reservation::STATUS_ACTIVE)

            ->whereDoesntHave(
                'transactions',
                fn(Builder $q) => $q->where('status', '!=', 'SUCCESS'),
            )
            ->orderBy('date', 'asc')
            ->orderBy('from_time', 'desc');
    }

    public function previous()
    {
        return $this->popCriteria(app(OrderReservationByDateCriteria::class))
            ->with('doctor')
            ->previous()
            ->whereDoesntHave(
                'transactions',
                fn(Builder $q) => $q->where('status', '!=', 'SUCCESS'),
            )
            ->orderBy('date', 'desc')
            ->orderBy('to_time', 'desc');
    }

    public static function status(): iterable
    {
        return self::getConstants('STATUS');
    }

    public function cancel($id)
    {
        $reservation = $this->find($id);
        /** @var Transaction $transaction */
        if (($transaction = $reservation->online_transaction) != null) {
            if ($transaction->gateway == 'online') {
                $payment_id = $transaction->invoice_id;
                app(PaymentMyfatoorahApiV2::class)->refund(
                    paymentId: $payment_id,
                    amount: $transaction->total,
                    currencyCode: config('myfatoorah.country_iso'),
                    reason: 'cancel reservation',
                    orderId: $transaction->id,
                );
            }
        }
        return $reservation->cancel();
    }

    public function at($date)
    {
        return $this->scopeQuery(
            fn($q) => $q->whereDate('date', Carbon::parse($date)),
        );
    }

    public function commingAfter($hours = 1)
    {
        return $this->whereDate('date', now())
            ->whereBetween('time_from', [now(), now()->addHours($hours)])
            ->get();
    }

    public function duration(): int
    {
        return $this->join(
            'doctors',
            'doctors.id',
            'reservations.doctor_id',
        )->sum('period');
    }
}
