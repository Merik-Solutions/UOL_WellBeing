<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReservationRequest\StoreReservationRequestRequest;
use App\Models\ReservationRequest;
use App\Notifications\NewReservationRequest;
use App\Repositories\interfaces\ReservationRequestRepository;

class ReservationRequestController extends Controller
{
    public function __invoke(
        StoreReservationRequestRequest $request,
        ReservationRequestRepository $repo,
    ) {
        $reservation_request = $repo->updateOrCreate(
            [
                'reservation_id' => $request->reservation_id,
                'status' => ReservationRequest::STATUS_PENDING,
            ],
            $request->validated(),
        );
        $reservation_request->reservation->user->notify(
            new NewReservationRequest($reservation_request),
        );
        return responseJson($reservation_request, __('Saved Successfully'));
    }
}
