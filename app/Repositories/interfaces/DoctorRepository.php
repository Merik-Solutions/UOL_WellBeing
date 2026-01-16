<?php

namespace App\Repositories\interfaces;

use App\Models\Doctor;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Interface DoctorRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface DoctorRepository extends BaseInterface
{
    public function AddFCM(Doctor $user, string $fcm_data , String $platform=null , String $voip=null): void;

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);

    /**
     * get the price of reservation period
     *
     * @param mixed $doctor_id
     * @return float
     */
    public function PeriodPrice(int $doctor_id): float;

    public function verify($code): ?Doctor;

    public function getSchedule(Doctor $doctor);

    public function isPending();

    public function isActive();
}
