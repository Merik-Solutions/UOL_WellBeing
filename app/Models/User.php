<?php

namespace App\Models;

use App\Traits\HasVerification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Laravel\Cashier\Billable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $code
 * @property string|null $new_phone
 * @property string|null $password
 * @property string|null $birthdate
 * @property string|null $image
 * @property int|null $gender
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $chat
 * @property-read int|null $chat_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $fcm_token
 * @property-read int|null $fcm_token_count
 * @property-read mixed $verification_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VerficationCode[] $verficationCodes
 * @property-read int|null $verfication_codes_count
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements JWTSubject
{
    protected static function booted()
    {
        static::addGlobalScope('wallet', function (Builder $builder) {
            $builder->select('*')->withWallet();
        });
    }

    use HasFactory, Notifiable, HasVerification, Billable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'new_phone',
        'code',
        'password',
        'birthdate',
        'gender',
        'image',
        'locale',
        'country_id',
        'national_id',
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
    protected $appends = ['pname', 'wallet'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => 'int',
    ];

    public function chat()
    {
        return $this->hasMany(Chat::class)->LastMessage();
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function mydata()
    {
        return $this->hasOne(Patient::class)->where('relation', 'myself');
    }

    public function getPnameAttribute()
    {
        if ($this->mydata()->first()) {

            return $this->mydata()->first()->name;
        } else {
            return 'no name';
        }
    }

    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function refundRequests(): MorphMany
    {
        return $this->morphMany(related: RefundRequest::class, name: 'refundable');
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(related: Transaction::class, name: 'sender');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(related: Country::class);
    }

    public function fcm_token(): MorphMany
    {
        return $this->morphMany(related: Device::class, name: 'notifiable');
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

    public function scopeWithWallet(Builder $builder)
    {
        $builder->addSelect(
            \DB::raw(
                "(select sum(
                CASE
                WHEN (reservations.status='cancled' and transactions.gateway='wallet') THEN total
                WHEN (transactions.gateway='wallet' ) THEN (-1*total)
                WHEN (reservations.id is null and billable_id is null)  THEN  total
                END
                )  from transactions
                            left join reservations on reservations.transaction_id =transactions.id
                            where
                            sender_type='App\\\\Models\\\\User'
                            and
                            sender_id=users.id limit 1 ) as wallet",
            ),
        );
    }

    public function getWallet()
    {
        return \DB::selectOne("
        select sum(
        CASE
        WHEN (reservations.status='cancled' and transactions.gateway='wallet') THEN total
        WHEN (transactions.gateway='wallet' ) THEN (-1*total)
        WHEN (reservations.id is null and billable_id is null)  THEN  total
        END
        )  as balance from transactions
                    left join reservations on reservations.transaction_id =transactions.id
                    where
                    sender_type='App\\\\Models\\\\User'
                    and
                    sender_id = ? limit 1
    ", [$this->id])->balance;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email:rfc,dns,spoof',
                'unique:users,email,' . $this->id,
            ],
            'phone' => [
                'required',
                'string',
                'unique:users,phone,' . $this->id,
                'phone:AE,EG,SA,BH',
                'regex:/^([0-9+])+$/',
                'regex:/^[+]/',
            ],
            // 'password' => ['nullable', 'string', 'confirmed'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d'],
            'gender' => ['required', 'boolean'],
            'image' => ['nullable', 'image'],
        ];
    }

    public function getAgeAttribute()
    {
        return now()->diffInYears(Carbon::parse($this->birthdate));
    }

    public function getImageAttribute()
    {
        return fileUrl($this->attributes['image'] ?? avatar());
    }

    /**
     * Set the image cloumn
     *
     * @param string $value
     * @return void
     */
    public function setImageAttribute($value)
    {
        if ($value != null && $value instanceof UploadedFile) {
            /** @var UploadedFile $value */

            return $this->attributes['image'] =
                '/storage/' . $value->store('users');
        }
        $this->attributes['image'] = $value;
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
        return $this->fcm_token->pluck('token')->toArray();
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

    public function CanPay(float $price): bool
    {
        return $this->getWallet() < $price;
    }

    public function addToWallet($amount, $gateway)
    {
        return $this->transactions()->create([
            'total' => $amount,
            'amount' => $amount,
            'gateway' => $gateway,
            'currency' => config('myfatoorah.country_iso'),
            'description' => 'Add To Wallet',
        ]);
    }

    public function getWalletAttribute()
    {
        $debit = \DB::selectOne(
            <<<MYSQL
(select sum(
                CASE
                WHEN (reservations.status='cancled' and transactions.gateway='wallet') THEN total
                WHEN (transactions.gateway='wallet' ) THEN (-1*total)
                WHEN (reservations.id is null and billable_id is null)  THEN  total
                END
                ) debit from transactions
                            left join reservations on reservations.transaction_id =transactions.id
                            where
                            sender_type='App\\\\Models\\\\User'
                            and
                            sender_id= {$this->id} limit 1 )
MYSQL
            ,
        )->debit;

        $credit = \DB::selectOne(
            <<<MYSQL
(select sum(
                CASE
                WHEN (reservations.status='cancled' and transactions.gateway='wallet') THEN total
                WHEN (transactions.gateway='wallet' ) THEN (-1*total)
                WHEN (reservations.id is null and billable_id is null)  THEN  total
                END
                ) credit from transactions
                            left join reservations on reservations.transaction_id =transactions.id
                            where
                            receiver_type='App\\\\Models\\\\User'
                            and
                            receiver_id= {$this->id} limit 1 )
MYSQL
            ,
        )->credit;

        return $debit - $credit;
    }
}
