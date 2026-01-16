<?php

namespace App\Http\Controllers\Api\v1\Patient;
use App\Http\Controllers\Controller;
use App\Repositories\interfaces\ReservationRequestRepository;

class ReservationRequestController extends Controller
{
    private $repo;

    public function __construct(ReservationRequestRepository $repo)
    {
        $this->repo = $repo;
    }
    public function confirm($id)
    {
        $this->repo->confirm($id);
        return responseJson(null, __('Request Confirmed Successfully'));
    }
    public function cancel($id)
    {
        $this->repo->cancel($id);
        return responseJson(null, __('Request Canceled Successfully'));
    }
}
