<?php

namespace App\Models;

use App\Models\Concerns\Collections\ScheduleCollection;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property int $doctor_id
 * @property int|null $day
 * @property string|null $from_time
 * @property string|null $to_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read mixed $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservations
 * @property-read int|null $reservations_count
 * @mixin IdeHelperSchedule
 */
class Schedule extends Model
{
    const DAY_SUN = 0;
    const DAY_MON = 1;
    const DAY_TUE = 2;
    const DAY_WEN = 3;
    const DAY_THR = 4;
    const DAY_FRI = 5;
    const DAY_SAT = 6;

    protected $fillable = ['doctor_id', 'day', 'from_time', 'to_time'];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ScheduleCollection($models);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeOfDoctor(Builder $builder, $doctor_id): void
    {
        $builder->where('doctor_id', $doctor_id);
    }

    /* attributes */

    public function getAppointmentsAttribute()
    {
        if ($this->from_time === $this->to_time) {
            return [];
        }
        $date = Carbon::parse(request()->date);
        $period = optional($this->doctor)->period ?? 30;
        $anchor = CarbonImmutable::parse($this->from_time);
        $to = Carbon::parse($this->to_time);
        $times = [];
        while ($anchor->isBefore($to)) {
            $end = $anchor->addMinutes($period);
            if ($end->isAfter($to)) {
                $end = $to;
            }
            $has_reservation = Reservation::query()
                ->where('doctor_id', request()->doctor_id)
                ->whereNull('status')
                ->whereDate('date', $date)
                ->whereTime('from_time', '<=', $anchor)
                ->whereTime('to_time', '>=', $end)
                ->count(); 
            $schedule_period = new Fluent([
                'start' => $anchor,
                'end' => $end,
                'schedule_id' => $this->id,
                'has_reservation' => $has_reservation,
            ]);

            $times[] = $schedule_period;
            $anchor = $end;
        }
        return $times;
    }

    public function setFromTimeAttribute($value): void
    {
        $value = str_replace(' : ', ':', $value);
        if ($value != null) {
            $this->attributes['from_time'] = Carbon::parse($value);
        } else {
            $this->attributes['from_time'] = null;
        }
    }

    public function setToTimeAttribute($value): void
    {
        $value = str_replace(' : ', ':', $value);
        if ($value != null) {
            $this->attributes['to_time'] = Carbon::parse($value);
        } else {
            $this->attributes['to_time'] = null;
        }
    }

    public function scopeOfDateInPeriod(Builder $builder, $value): void
    {
        $builder->whereTime('from_time', '<=', $value);
        $builder->whereTime('to_time', '>=', $value);
    }

    public function scopeOfDay(Builder $builder, $value): void
    {
        if ($value != null) {
            $builder->where('day', $value);
        }
    }

    public function rules(): array
    {
        return [
            // 'doctor_id',
            'day' => ['required', 'integer', 'between:0,6'],

            'from_time' => ['required', 'date_format:h:i', 'after:to_date'],
            'to_time' => ['required', 'date_format:h:i', 'before:from_date'],
        ];
    }
}
