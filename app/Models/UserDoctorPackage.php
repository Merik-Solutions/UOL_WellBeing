<?php

namespace App\Models;

use App\Models\Concerns\Traits\Payable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\UserDoctorPackage
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $package_id
 * @property int $doctor_package_id
 * @property int $user_id
 * @property int|null $transaction_id
 * @property int|null $promocode_id
 * @property float|null $pervious_amount
 * @property string $expired_at
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Transaction|null $bill
 * @property-read \App\Models\Doctor $doctor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Promocode|null $promocode
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @mixin IdeHelperUserDoctorPackage
 */
class UserDoctorPackage extends Model
{
    use HasFactory, Payable;

    protected $description = 'Subscripe Chat Package';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id',
        'package_id',
        'doctor_package_id',
        'expired_at',
        'price',
        'user_id',
        'patient_id',
        'wallet',
        'online',
        'invoice_id',
        'promocode_id',
        'transaction_id',
        'isPaid',
         'status',
        'withdraw_id',
        'penalty_percent',
        'price_before_penalty',
    ];
    
    const PACKAGE_PENDING = 'pending';
    const PACKAGE_DISPUTED = 'disputed';
    const PACKAGE_PAID = 'paid';

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function withDraw()
    {
        return $this->belongsTo(WithdrawRequest::class, 'withdraw_id');
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class, 'promocode_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class,'id','transaction_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'user_doctor_packages_id');
    }
    
    public function complaint_feedback(){
        return $this->hasOne(ComplaintOrFeedback::class,'disputed_id');
    }

    public function patient_messages()
    {
        return $this->hasMany(Message::class, 'user_doctor_packages_id')->where('sender_type',User::class);
    }
    
    public function latestMessage()
    {
       return $this->hasOne(Message::class, 'user_doctor_packages_id')->latest();
    }

    public function scopeMessageCount(Builder $builder)
    {
        $builder
            ->withCount(['patient_messages'])
            ->addSelect([
                'package_messages' => Package::select('quantity')
                    ->limit(1)
                    ->whereColumn(
                        'packages.id',
                        'user_doctor_packages.package_id',
                    ),
            ]);
    }

    public function scopeIsValid(Builder $builder)
    {
        $builder
            ->withCount([ 'messages' => function ($query) {
                $query->where('sender_type', '=', User::class);
            }])
            ->addSelect([
                'package_messages' => Package::select('quantity')
                    ->limit(1)
                    ->whereColumn(
                        'packages.id',
                        'user_doctor_packages.package_id',
                    ),
            ])
            ->having('messages_count', '<=', DB::raw('package_messages'));
    }

    public function scopeIsAvailable(Builder $builder)
    {
        $builder->where('expired_at', '>', Carbon::now());
    }

    public function scopeOfUser(Builder $builder, $user_id)
    {
        $builder->where('user_id', $user_id);
    }

    public function scopeOfPatient($query, $patient_id): void
    {
        $query->where('patient_id', $patient_id);
    }

    public function scopeOfDoctor(Builder $builder, $doctor_id)
    {
        $builder->where('doctor_id', $doctor_id);
    }

    /**
     * get user package doctor by chat id
     *
     * @param mixed $builder
     * @param mixed $chat_id
     * @return void
     */
    public function scopeOfChat(Builder $builder, $chat_id): void
    {
        $builder->whereHas('doctor', fn(Builder $q) => $q->ofChat($chat_id));
    }

    public function getPercentageAttribute(): float
    {
        return Setting::find(8, ['value'])->value;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'package_id' => [
                'required',
                'integer',
                'exists:packages,id',
                'exists:doctor_packages,package_id,doctor_id,' .
                request()->doctor_id,
            ],
            'promocode_id' => ['nullable', 'integer', 'exists:promocodes,id'],
            'patient_id' => ['nullable', 'integer', 'exists:patients,id'],
            'gateway' => ['sometimes', 'nullable', 'string', 'in:wallet,both,online,myfatoorah'],
            'wallet' => ['required', 'numeric',],
            'online' => ['required', 'numeric',],
            'invoice_id' => ['required', 'numeric',],
        ];
    }
}
