<?php

namespace App\Models;

use App\Notifications\Doctor\Auth\ResetPassword;
use App\Notifications\Doctor\Auth\VerifyEmail;
use App\Notifications\DoctorStatusChanged;
use App\Traits\ColumnTranslation;
use App\Traits\HashPassword;
use App\Traits\HasVerification;
use App\Traits\HasBankAccount;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Models\BankAccount;
use App\Rules\PhoneNumber;

/**
 * App\Models\Doctor
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $title_ar
 * @property string|null $title_en
 * @property string|null $description_ar
 * @property string|null $description_en
 * @property string|null $email
 * @property string|null $password
 * @property string $phone
 * @property string|null $new_phone
 * @property string|null $code
 * @property string|null $expirence
 * @property int|null $category_id
 * @property string|null $confirmed_at
 * @property int|null $status
 * @property array|null $heal_cases
 * @property float|null $price
 * @property int|null $period
 * @property int|null $verification_code
 * @property string|null $remember_token
 * @property int $gender
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $chats
 * @property-read int|null $chats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $fcm_token
 * @property-read int|null $fcm_token_count
 * @property-read mixed $address
 * @property-read mixed $available_day
 * @property-read mixed $available_on
 * @property-read mixed $available_time
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $slug
 * @property-read mixed $title
 * @property-read mixed $weakly_schedules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservation
 * @property-read int|null $reservation_count
 * @property-read \App\Models\Concerns\Collections\ScheduleCollection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VerficationCode[] $verficationCodes
 * @property-read int|null $verfication_codes_count
 * @mixin IdeHelperDoctor
 */
class Doctor extends Authenticatable implements JWTSubject
{
    use Notifiable,
        HasFactory,
        ColumnTranslation,
        HasVerification,
        HasBankAccount;

    protected static function booted()
    {
        static::addGlobalScope('getwallet', function (Builder $builder) {
            $builder
                ->select('*')
                ->addSelect(DB::raw('GetDoctorWallet(id) as wallet'));
        });
    }

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    public $timestamps = true;

    protected $fillable = [
        'name_ar',
        'name_en',
        'heal_cases_en',
        'heal_cases_ar',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'email',
        'password',
        'phone',
        'code',
        'expirence',
        'category_id',
        'national_id',
        'price',
        'period',
        'gender',
        'image',
        'confirmed_at',
        'new_phone',
        'birthdate',
        'signature',
        'company_name',
        'company_license',
        'license_number',
        'locale',
        'country_id',
        'isPackageActive',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'price' => 'float',
        'period' => 'integer',
        'heal_cases_en' => 'array',
        'heal_cases_ar' => 'array',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(related: Category::class);
    }

    // public function bank_account(): BelongsTo
    // {
    //     return $this->belongsTo(related: HasBankAccount::class);
    // }
    public function banks()
    {
        return $this->hasOne(BankAccount::class, 'owner_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(related: Schedule::class);
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(related: Reservation::class);
    }
    public function userDoctorPackage(): HasMany
    {
        return $this->hasMany(related: UserDoctorPackage::class);
    }

    public function verficationCodes(): MorphMany
    {
        return $this->morphMany(
            related: VerficationCode::class,
            name: 'verifiable',
        );
    }

    public function chats(): HasMany
    {
        return $this->hasMany(related: Chat::class);
    }

    public function country()
    {
        return $this->belongsTo(related: Country::class);
    }

    public function messages()
    {
        return $this->morphMany(related: Message::class, name: 'sender');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(related: Rating::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Package::class,
            table: 'doctor_packages',
            foreignPivotKey: 'doctor_id',
            relatedPivotKey: 'package_id',
            )->where('isActive',1)->withPivot(columns: ['price', 'expires_in']);
    }
        
    public function reservationPayable()
    {
        return $this->hasOne(Reservation::class)->where('isPaid', 0)->where('penalty_percent', null)
        ->selectRaw('doctor_id,SUM(price) as reservation_total')->groupBy('doctor_id');       
                    
    }
    public function packagePayable()
    {
        return $this->hasOne(UserDoctorPackage::class)->where('isPaid', 0)->where('penalty_percent', null)
            ->selectRaw('doctor_id,SUM(price) as udp_total')->groupBy('doctor_id');
    }

    public function penalizeReservationPayable()
    {
        return $this->hasOne(Reservation::class)->where('isPaid', 0)->where('penalty_percent','!=', null)
        ->selectRaw('doctor_id,SUM(price) as reservation_total')->groupBy('doctor_id');       
                    
    }
    public function penalizePackagePayable()
    {
        return $this->hasOne(UserDoctorPackage::class)->where('isPaid', 0)->where('penalty_percent','!=', null)
            ->selectRaw('doctor_id,SUM(price) as udp_total')->groupBy('doctor_id');
    }


    public function paidReservations()
    {
        return $this->hasMany(Reservation::class)->where('isPaid', 1)
        ->where('reservation_status', '=', Reservation::RESERVATION_PAID)
        ->selectRaw('doctor_id,withdraw_id,SUM(price) as reservation_total')->groupBy('withdraw_id');
    }
    public function paidPackages()
    {
        return $this->hasMany(UserDoctorPackage::class)->where('isPaid', 1)
        ->where('status', '=', UserDoctorPackage::PACKAGE_PAID)
        ->selectRaw('doctor_id,withdraw_id,SUM(price) as udp_total')->groupBy('withdraw_id');
    }

    public function fcm_token(): MorphMany
    {
        return $this->morphMany(related: Device::class, name: 'notifiable');
    }

    public function getWeaklySchedulesAttribute()
    {
        $today = CarbonImmutable::now();
        $week_dates = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $today->addDays($i);
            $day_number = $day->dayOfWeek + 1;
            $schedules = $this->schedules->where('day', $day_number);
            $appointments = [];
            foreach ($schedules as $schedule) {
                $times = $schedule->reservation_times;
                $appointments = array_merge($appointments, $times);
            }
            $week_dates[$day_number] = [
                'day' => $day,
                'times' => $appointments,
            ];
        }
        return $week_dates;
    }

    public function getAvailableOnAttribute()
    {
        $schedules = $this->weakly_schedules;
        $available_day = collect($schedules)
            ->where('times', '!=', [])
            ->where('times.has_reservation', 0)
            ->first();
        return optional($available_day);
    }

    public function getAvailableDayAttribute()
    {
        $available = $this->available_on;
        return optional($available['day'] ?? null);
    }

    public function getAvailableTimeAttribute()
    {
        $available = $this->available_on;
        return collect($available['times'])->first() ?? [];
    }

    /*scopes*/

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

    public function scopeOfCategory(Builder $query, $value): void
    {
        $query->when(
            $value != null,
            fn(Builder $builder) => $builder->Where('category_id', $value),
        );
    }

    public function scopeHasRating(Builder $query, $value): void
    {
        $query->WhereRelation('ratings', 'rate', $value);
    }

    public function scopeOfBetweenTime(
        Builder $query,
        $from = null,
        $to = null,
    ): void {
        $query->when($from != null, function (Builder $builder) use ($from) {
            $builder->WhereHas('schedules', function (Builder $q) use ($from) {
                $q->where('from_time', '<=', $from);
                $q->where('to_time', '>=', $from);
            });
        });
        $query->when($to != null, function (Builder $builder) use ($to) {
            $builder->WhereHas('schedules', function (Builder $q) use ($to) {
                $q->where('to_time', '<=', $to);
                $q->where('to_time', '>=', $to);
            });
        });
    }

    /**
     * get doctor by chat id
     *
     * @param mixed $builder
     * @param mixed $chat_id
     * @return void
     */
    public function scopeOfChat(Builder $builder, $chat_id): void
    {
        $builder->whereHas(
            'chats',
            fn(Builder $q) => $q->where('id', $chat_id),
        );
    }

    public function scopeIsActive(Builder $builder): void
    {
        $builder->where('status', 1);
    }

    public function scopeIsPending(Builder $builder): void
    {
        $builder->where('status', 0);
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.notifications.doctor.' . $this->id;
    }

    public function rules(): array
    {
        return [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'email' => [
                'required',
                'email' /* :rfc,dns,spoof' */,
                'unique:doctors,email,' . $this->id,
            ],
            'phone' => [
                'required',
                'string',
                'unique:doctors,phone,' . $this->id,
                'phone:AE,EG,SA,BH',
                // 'regex:/^([0-9+])+$/',
                // 'regex:/^[+]/',
                new PhoneNumber,
            ],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d'],
            'gender' => ['required', 'boolean'],
            'image' => ['nullable', 'image'],
            'heal_cases_ar' => ['nullable', 'array'],
            'heal_cases_ar.*' => ['string'],
            'heal_cases_en' => ['nullable', 'array'],
            'heal_cases_en.*' => ['string'],
            'period' => ['nullable', 'integer'],
            'national_id' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
            'company_license' => ['nullable', 'string'],
            'license_number' => ['nullable', 'alpha_dash'],
            'price' => [
                'nullable',
                'numeric',
                'min:' . config('services.stripe.min'),
            ],
            'title_ar' => ['nullable', 'string', 'max:191'],
            'title_en' => ['nullable', 'string', 'max:191'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
        ];
    }

    public function getImageAttribute()
    {
        return  $this->attributes['image'] ? fileUrl($this->attributes['image']): assets('kinda/assets/images/logo_icon.png');
    }

    public function getSignatureAttribute()
    {
        return $this->attributes['signature'] ? fileUrl($this->attributes['signature']) : assets('kinda/assets/images/logo_icon.png');
    }

    public function getLocaleNameAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->name_en;
        }
        return $this->name;
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        $fcm_token = $this->fcm_token->pluck('token')->toArray();
        return $fcm_token;
    }

    public function toggleStatus()
    {
        if ($this->status == 0) {
            $this->update(['confirmed_at' => now()]);

            toast(__('Activated Successfully'), 'success');
        }

        if ($this->status == 1) {
            $this->update(['confirmed_at' => null]);

            toast(__('Blocked Successfully'), 'success');
        }
        $doctor = $this->refresh();
        $this->notify(new DoctorStatusChanged($doctor));
        return $doctor;
    }

    public function getSchedule()
    {
        $working_days = $this->schedules->keyBy('day');
        $empty_days = collect(days())
            ->diffKeys($working_days)
            ->map(fn($_, $key) => Schedule::make(['day' => $key]));
        return $working_days->replace($empty_days);
    }

    public function getWaitingMoney()
    {
        return DB::selectOne(
            "SELECT sum(amount) as amount FROM `transactions` WHERE
    ((`transactions`.`receiver_type` = 'App\\\\Models\\\\Doctor')) AND `receiver_id` = ? AND ((`transactions`.`billable_type` = 'reservation'   AND EXISTS( SELECT * FROM `reservations` WHERE `transactions`.`billable_id` = `reservations`.`id` AND `status` NOT IN ('canceled' , 'finished'))))",
            [$this->id],
        )->amount;
    }
}
