<?php

namespace App\Models;

use App\Services\Payment\MyFatoorah;
use Arr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Fluent;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string|null $billable_type
 * @property int|null $billable_id
 * @property string|null $sender_type
 * @property int|null $sender_id
 * @property string|null $receiver_type
 * @property int|null $receiver_id
 * @property string $gateway
 * @property string $amount
 * @property string|null $total
 * @property string|null $commission
 * @property string|null $vat_tax
 * @property string|null $currency
 * @property string|null $gateway_id
 * @property string|null $description
 * @property float|null $previous_amount
 * @property mixed $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $billable
 * @property-read Model|\Eloquent $receiver
 * @property-read Model|\Eloquent $sender
 * @mixin IdeHelperTransaction
 */
class Transaction extends Model
{
    use HasFactory;

    const BANK_TRANSACTION = 'bank_transfer';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($model) {
            /** @var self $model */
            //            if ($model->gateway == 'stripe') {
            //                $model->createStripeIntent();
            //            }
        });
    }
    protected static function boot()
    {       
        parent::boot();

        Transaction::creating(function($transaction) {           
            $transaction->previous_amount = 0;// auth()->user()->wallet ?? 0;
        });
    
        Transaction::updating(function($transaction){          
            $transaction->previous_amount = 0; //auth()->user()->wallet ?? 0;
        });
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gateway_data' => 'json',
    ];

    public function billable(): MorphTo
    {
        return $this->morphTo('billable');
    }

    public function sender(): MorphTo
    {
        return $this->morphTo('sender');
    }

    public function receiver(): MorphTo
    {
        return $this->morphTo('receiver');
    }

    public function refund_request()
    {
       return $this->hasOne(RefundRequest::class);
    }

    public function scopeForPatients(Builder $builder)
    {
        $builder->whereHasMorph('sender', User::class);
    }

    public function scopeForDoctors(Builder $builder)
    {
        $builder->whereHasMorph('receiver', Doctor::class);
    }

    public function scopeOfReceiver(Builder $builder, $receiver_id)
    {
        $builder->where('receiver_id', $receiver_id);
    }

    public function scopeIsfinished(Builder $builder): void
    {
        $builder->whereHasMorph('billable', Reservation::class, function (
            Builder $b,
        ) {
            $b->where('status', 'finished');
        });
        $builder->orWhereHasMorph('billable', UserDoctorPackage::class);
    }

    public function scopeIsWaiting(Builder $builder): void
    {
        $builder->whereHasMorph('billable', Reservation::class, function (
            Builder $b,
        ) {
            $b->whereNotIn('status', ['finished', 'cancled']);
        });
    }

    public function scopeDueToDoctor(Builder $builder)
    {
        $send = $builder->whereHasMorph('sender', Doctor::class)->sum('amount');

        $received = $builder
            ->whereHasMorph('receiver', Doctor::class)
            ->sum('amount');
        return $received - $send;
    }

    public function scopeCreationType(Builder $builder, $type)
    {
        $builder
            ->when(
                $type == 'daily',
                fn($q) => $q->whereDate('created_at', now()),
            )
            ->when(
                $type == 'weekly',
                fn($q) => $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            )
            ->when(
                $type == 'monthly',
                fn($q) => $q->whereMonth('created_at', now()),
            )
            ->when(
                $type == 'yearly',
                fn($q) => $q->whereYear('created_at', now()),
            );
    }

    public function scopeFilters(Builder $builder)
    {
        if (request()->category_id != null) {
            $builder->whereHasMorph(
                'receiver',
                Doctor::class,
                fn($doctor) => $doctor->where(
                    'category_id',
                    request()->category_id,
                ),
            );
        }

        if (request()->doctor_id != null) {
            $builder->whereHasMorph(
                'receiver',
                Doctor::class,
                fn($doctor) => $doctor->where('id', request()->doctor_id),
            );
        }

        if (request()->user_id != null) {
            $builder->whereHasMorph(
                'sender',
                User::class,
                fn($user) => $user->where('id', request()->user_id),
            );
        }
        if (request()->type) {
            if (request()->type == 'custom') {
                $start_date = request()->start_date;
                $end_date = request()->end_date;
            }
            if (request()->type == 'monthly') {
                 $builder->whereMonth('created_at', Carbon::now()->month);
            } elseif (request()->type == 'weekly') {
                $builder->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif (request()->type == 'custom') {
                $builder->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }
        }
    }

    public function createStripeIntent(): void
    {
        $intent = $this->sender->stripe()->paymentIntents->create([
            'amount' => str_replace(
                ['.', ','],
                '',
                number_format($this->total, 2),
            ),
            'currency' => $this->currency,
            'payment_method_types' => ['card'],
        ]);

        $this->fill(['stripe_session' => $intent]);
        $this->save();
    }

    public function getHasSessionAttribute(): bool
    {
        return $this->stripe_session != null && $this->gateway == 'stripe';
    }

    public function getClientSecretAttribute(): ?string
    {
        if ($this->has_session) {
            return $this->stripe_session['client_secret'];
        }
        return null;
    }

    public function getOnlineTypeAttribute()
    {
        return Arr::get($this->gateway_data, 'type');
    }

    public function getOnlineGatewayInfoAttribute()
    {
        return Arr::get($this->gateway_data ?? [], 'data.Data');
    }

    public function getOnlinePaymentIdAttribute()
    {
        return Arr::get($this->getOnlineGatewayInfoAttribute(), 'PaymentId');
    }

    public function getGatewayDataAttribute()
    {
        return new Fluent(
            json_decode($this->attributes['gateway_data'], true) ?? [],
        );
    }

}
