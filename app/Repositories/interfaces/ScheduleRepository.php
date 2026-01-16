<?php

namespace App\Repositories\interfaces;

use App\Models\Schedule;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ScheduleRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface ScheduleRepository extends BaseInterface
{
    public function FindByFromAndToDate(
        int $doctor_id,
        string $date,
        string $from,
        string $to,
    ): ?Schedule;

    public function DoctorScheduleGroupedByDay(int $doctor_id): Collection;
    public function StoreDoctorScheduleGroupedByDay(
        int $doctor_id,
        array $days,
    );

    public function deleteDoctorScheduleIfNotExistsInIds(
        int $doctor_id,
        array $ids = [],
    ): void;

    public function UpdateMultiDaySchedule(
        array $day_schedules,
    ): \Illuminate\Support\Collection;
}
