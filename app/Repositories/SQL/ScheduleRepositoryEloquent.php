<?php

namespace App\Repositories\SQL;

use App\Http\Requests\Admin\Schedules\ScheduleRequest;
use App\Repositories\SQL\BaseRepository;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\ScheduleRepository;
use App\Models\Schedule;

// use App\Validators\ScheduleValidator;

/**
 * Class ScheduleRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class ScheduleRepositoryEloquent extends BaseRepository implements
    ScheduleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Schedule::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function FindByFromAndToDate(
        int $doctor_id,
        string $date,
        string $from,
        string $to,
    ): ?Schedule {
        $day = CarbonImmutable::parse($date)->weekday();

        $schedule = $this->OfDateInPeriod(CarbonImmutable::parse($from))
            ->OfDateInPeriod(CarbonImmutable::parse($to))
            ->where('day', $day + 1)
            ->where('doctor_id', $doctor_id)
            ->first();
        return $schedule;
    }

    public function DoctorScheduleGroupedByDay(int $doctor_id): Collection
    {
        return $this->findByField('doctor_id', $doctor_id)->groupBy('day');
    }

    public function StoreDoctorScheduleGroupedByDay(int $doctor_id, array $days)
    {
        $ids = [];
        $schedules = [];
        foreach ($days as $day) {
            $day_ids = array_column($day, 'id');
            foreach ($day as $schedule) {
                if ($schedule['from_time'] != null) {
                    $schedule['doctor_id'] = auth()->id();

                    $validator = Validator::make(
                        $schedule,
                        (new ScheduleRequest())->rulfzes(),
                    );
                    if ($validator->fails()) {
                        throw new ValidationException($validator);
                    }
                    $attributes = ['id' => $schedule['id'] ?? null];

                    $action_schedule = $schedules[] = $this->updateOrCreate(
                        $attributes,
                        $schedule,
                    );

                    $day_ids[] = $action_schedule->id;
                }
            }

            $ids = array_merge($ids, $day_ids);
        }
        return ['ids' => $ids, 'schedules' => $schedules];
    }

    public function deleteDoctorScheduleIfNotExistsInIds(
        int $doctor_id,
        array $ids = [],
    ): void {
        $this->where('doctor_id', $doctor_id)
            ->whereNotIn('id', $ids)
            ->delete();
    }

    public function UpdateMultiDaySchedule(array $day_schedules): Collection
    {
        collect($day_schedules)->map(function ($day_schedule) {
            $q = auth()
                ->user()
                ->schedules();
            if ($day_schedule['from_time']==null) {
                $q->where('doctor_id', auth()->id())
                ->where('day', $day_schedule['day'])->delete();
            } else {
            $q->updateOrCreate(
                collect($day_schedule)
                    ->only('day')
                    ->toArray(),
                $day_schedule,
            );
            }
        });
        return auth()
            ->user()
            ->schedules()
            ->get();
    }
}
