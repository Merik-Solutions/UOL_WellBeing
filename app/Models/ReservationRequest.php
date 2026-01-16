<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * App\Models\ReservationRequest
 *
 * @property int $id
 * @property int $reservation_id
 * @property string $date
 * @property string $from_time
 * @property string $to_time
 * @property string $status
 * @property string|null $changed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Reservation $reservation
 * @mixin IdeHelperReservationRequest
 */
class ReservationRequest extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_CONFIRMED = 'confirmed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservation_id',
        'status',
        'changed_at',
        'date',
        'from_time',
        'to_time',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function confirm()
    {
        $this->fill([
            'changed_at' => now(),
            'status' => static::STATUS_CONFIRMED,
        ])->save();
        $this->reservation()->update(
            [
                'status' => Reservation::STATUS_ACTIVE,
            ] + $this->only('date', 'from_time', 'to_time'),
        );
        return $this;
    }

    public function cancel()
    {
        $this->fill([
            'changed_at' => now(),
            'status' => static::STATUS_CANCELED,
        ])->save();

        return $this;
    }

    public function rules(): array
    {
        return [
            'reservation_id' => [
                'required',
                'integer',
                Rule::exists('reservations', 'id')
                    ->where('doctor_id', auth()->id())
                    ->where(fn(\Illuminate\Database\Query\Builder $q) => $q->where('status', 'active')->orWhereNull('status')),
            ],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after:today'],
            'from_time' => [
                'required',
                /*  'date', */ 'date_format:H:i',
                'before:to_time',
            ],
            'to_time' => [
                'required',
                /* 'date', */ 'date_format:H:i',
                'after:from_time',
            ],
        ];
    }
}
