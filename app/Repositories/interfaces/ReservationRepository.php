<?php

namespace App\Repositories\interfaces;

use App\Models\Reservation;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Interface ReservationRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface ReservationRepository extends BaseInterface
{
    public function upcoming();
    public function previous();
    public static function status(): iterable;
    public function cancel($id);
    public function at($date);
    public function commingAfter($hours = 1);
    public function duration(): int;
}
