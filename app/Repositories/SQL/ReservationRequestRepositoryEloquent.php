<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\ReservationRequestRepository;
use App\Models\ReservationRequest;
// use App\Validators\ReservationRequestValidator;

/**
 * Class ReservationRequestRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class ReservationRequestRepositoryEloquent extends BaseRepository implements
    ReservationRequestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReservationRequest::class;
    }

    public function confirm($request_id)
    {
        return $this->model->find($request_id)->confirm();
    }
    public function cancel($request_id)
    {
        return $this->model->find($request_id)->cancel();
    }
}
