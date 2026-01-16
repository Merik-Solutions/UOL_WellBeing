<?php

namespace App\Repositories\interfaces;

use App\Repositories\interfaces\BaseInterface;

/**
 * Interface ReservationRequestRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface ReservationRequestRepository extends BaseInterface
{
    public function confirm($request_id);
    public function cancel($request_id);
}
