<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use App\Repositories\interfaces\ReservationRepository;
use App\Repositories\interfaces\ScheduleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    private $repo;

    public function __construct(ReservationRepository $repo)
    {
        $this->repo = $repo->pushCriteria(
            new OfDoctorCriteria(auth('doctor_api')->id()),
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $reservations = $this->repo
            ->at($request->date)
            ->with(['user', 'patient'])
            ->paginate(10);

        return responseJson(
            ReservationResource::collection($reservations),
            __('Loaded Successfully'),
        );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcoming()
    {
        $reservations = Reservation::query()
            ->ofDoctor(auth()->id())
            ->with(['user', 'patient'])
            ->upcoming()
            ->whereDoesntHave(
                'transactions',
                fn(Builder $q) => $q->where('status', '!=', 'SUCCESS'),
            )
            // ->whereNotIn('status', [
            //     Reservation::STATUS_CANCLED,
            //     Reservation::STATUS_FINISHED,
            // ])
            ->orderBy('date', 'asc')

            ->with('pending_request')
            ->paginate(10);

        return responseJson(
            ReservationResource::collection($reservations),
            __('Loaded Successfully'),
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function previous()
    {
        $reservations = Reservation::query()
            ->ofDoctor(auth()->id())
            ->with(['user', 'patient'])
            ->previous()
            ->whereDoesntHave(
                'transactions',
                fn(Builder $q) => $q->where('status', '!=', 'SUCCESS'),
            )
            ->orderBy('date', 'desc')
            ->paginate(10);

        return responseJson(
            ReservationResource::collection($reservations),
            __('Loaded Successfully'),
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reservation(Request $request)
    {
        $this->validate($request, [
            'reservation_id' =>
                'required|integer|exists:reservations,id,doctor_id,' .
                auth()->user()->id,
        ]);
        $reservation = $this->repo
            ->with(['user', 'patient'])
            ->find($request->reservation_id);
        $reservation = new ReservationResource($reservation);
        return responseJson(compact('reservation'), __('Loaded successfully'));
    }
}
