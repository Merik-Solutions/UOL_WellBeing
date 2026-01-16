<?php

namespace App\Models;

use App\Notifications\NewReservationAdded;
use App\Notifications\ReservationApproch;
use App\Notifications\ReservationCallFinished;
use App\Notifications\ReservationCallStart;
use App\Notifications\ReservationCancled;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Concerns\Traits\Payable;
use DB;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $user_id
 * @property int|null $transaction_id
 * @property int $schedule_id
 * @property int|null $promocode_id
 * @property string $price
 * @property string $date
 * @property string $from_time
 * @property string $to_time
 * @property string|null $canceled_at
 * @property string|null $status
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Transaction|null $bill
 * @property-read \App\Models\Chat|null $chat
 * @property-read \App\Models\Doctor $doctor
 * @property-read CarbonImmutable $from_date
 * @property-read mixed $start_in
 * @property-read CarbonImmutable $to_date
 * @property-read \App\Models\ReservationRequest|null $pending_request
 * @property-read \App\Models\Prescription $prescription
 * @property-read \App\Models\Rating|null $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReservationRequest[] $requests
 * @property-read int|null $requests_count
 * @property-read \App\Models\Schedule $schedule
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @mixin IdeHelperReservation
 */
class Reservation extends Model
{
    use Payable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $description = 'Make Reservation';
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'user_id',
        'schedule_id',
        'promocode_id',
        'price',
        'date',
        'from_time',
        'to_time',
        'canceled_at',
        'status',
        'wallet',
        'online',
        'description',
        'transaction_id',
        'withdraw_id',
        'isPaid',
        'reservation_status',
        'penalty_percent',
        'price_before_penalty',
        'invoice_id',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
         Reservation::creating(function($model) {           
            $model->status = 'active';
        });

        static::created(function ($model) {
            try {
                $model->doctor->notify(new NewReservationAdded($model));
            } catch (\Exception $e) {
            }
        });
    }

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCLED = 'cancled';
    const STATUS_FINISHED = 'finished';
    const STATUS_ON_CALL = 'on_call';
    const STATUS_WAIT_CONFIRMATION = 'wait_confirmation';

    const RESERVATION_PENDING = 'pending';
    const RESERVATION_DISPUTED = 'disputed';
    const RESERVATION_PAID = 'paid';

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class,'id','transaction_id');
    }
    
    public function promocode()
    {
        return $this->hasOne(Promocode::class,'id','promocode_id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class)->withDefault(new Schedule());
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class)->withDefault(
            new Prescription([
                'reservation_id' => $this->id,
                'doctor_id' => $this->doctor_id,
                'user_id' => $this->user_id,
            ]),
        );
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function reservationCallLog()
    {
        return $this->hasMany(UserDoctorCallLog::class);
    }

    public function videoCallRecord()
    {
        return $this->hasMany(VideoCallRecord::class);
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function requests()
    {
        return $this->hasMany(ReservationRequest::class, 'reservation_id');
    }

    public function pending_request()
    {
        return $this->hasOne(ReservationRequest::class, 'reservation_id')
            ->latestOfMany()
            ->where('status', 'pending');
    }

    // scopes

    public function scopeUpComing(Builder $builder)
    {
        $builder->where(
            fn($q) => $q->whereDate('date', '>=', now()->toDateString()),
            // ->whereTime('to_time', '>=', now()),
        );
        $builder->orWhere(DB::raw('DATE(`date`)'), '>', now()->toDateString());
    }

    public function scopePrevious(Builder $builder)
    {
        $builder->where(
            fn($q) => $q->whereDate('date', '<', now()->toDateString()),
            // ->whereTime('to_time', '<', now()),
        );
        $builder->orWhere(DB::raw('DATE(`date`)'), '<', now()->toDateString());
    }

    public function scopeOfUser(Builder $builder, ?int $user_id): void
    {
        $builder->where('user_id', $user_id);
    }

    public function scopeOfPatient($query, $patient_id): void
    {
        $query->where('patient_id', $patient_id);
    }

    public function scopeOfDoctor(Builder $builder, ?int $doctor_id): void
    {
        $builder->where('doctor_id', $doctor_id);
    }

    public function scopeCreationType(Builder $builder, $type)
    {
        $builder
            ->when(
                $type == 'monthly',
                fn($q) => $q->whereMonth('created_at', now()),
            )
            ->when(
                $type == 'yearly',
                fn($q) => $q->whereYear('created_at', now()),
            );
    }

    public function ScopeDuration(): int
    {
        return $this->join(
            'doctors',
            'doctors.id',
            'reservations.doctor_id',
        )->sum('period');
    }

    // attributes
    public function setFromTimeAttribute($value): void
    {
        $this->attributes['from_time'] = Carbon::parse($value);
    }

    public function setToTimeAttribute($value): void
    {
        $this->attributes['to_time'] = Carbon::parse($value);
    }

    public function getFromDateAttribute(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->date . ' ' . $this->from_time);
    }

    public function getToDateAttribute(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->date . ' ' . $this->to_time);
    }

    public function getPercentageAttribute(): float
    {
        return Setting::query()->find(7, ['value'])->value;
    }

    public function getStartInAttribute()
    {
        return Carbon::parse("{$this->date} {$this->from_time}")->diffInHours(
            Carbon::now(),
        );
    }

    public function hasReservation(Carbon $date, Carbon $anchor, Carbon $end)
    {
        $whereDate = Carbon::parse($this->date)->equalTo($date);
        $whereFromDate = Carbon::parse($this->from_time)->lessThanOrEqualTo(
            $anchor,
        );
        $wheretoDate = Carbon::parse($this->to_time)->greaterThanOrEqualTo(
            $end,
        );
        return $whereDate && $whereFromDate && $wheretoDate;
    }

    public function cancel()
    {
        $this->fill([
            'status' => static::STATUS_CANCLED,
            'cancled_at' => now(),
        ]);

        $this->save();
        $this->doctor->notify(new ReservationCancled($this));
        return $this;
    }

    public function start($notifable = 'user', $link = '')
    {
        $this->fill(['status' => static::STATUS_ON_CALL])->save();
        $this->$notifable->notify(new ReservationCallStart($this, $link));
        return $this;
    }

    public function finish($notifable = 'user')
    {
        $this->fill(['status' => static::STATUS_FINISHED])->save();
        $this->$notifable->notify(new ReservationCallFinished($this));
        return $this;
    }

    public function notifyMembers()
    {
        $this->doctor->notify(new ReservationApproch($this));
        $this->user->notify(new ReservationApproch($this));
    }

    public function complaint_feedback(){
         return $this->hasOne(ComplaintOrFeedback::class,'disputed_id');
    }

    public function withDraw(){
        return $this->hasOne(WithdrawRequest::class,'id','withdraw_id');
    }
}
