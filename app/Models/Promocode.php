<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewPromocodeAdded;

/**
 * App\Models\Promocode
 *
 * @property string $code
 * @property string $type
 * @property string  $expired_at
 * @property integer $use_time
 * @property double $percent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserDoctorPackage[] $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservations
 * @property-read int|null $reservations_count
 * @mixin IdeHelperPromocode
 */
class Promocode extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::created(function ($promocode) {
            $users = User::all();
            \Notification::send($users, new NewPromocodeAdded($promocode));
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'type', 'expired_at', 'use_time', 'percent'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime:Y-m-d',
        'percent' => 'float',
    ];
    /**
     * get reservations
     *
     * @return HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'promocode_id');
    }

    /**
     * get packages
     *
     * @return HasMany
     */
    public function packages(): HasMany
    {
        return $this->hasMany(UserDoctorPackage::class, 'promocode_id');
    }

    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForReservation(Builder $query): void
    {
        $query->where('type', 'reservation');
    }

    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPackages(Builder $query): void
    {
        $query->where('type', 'package');
    }
    public function ScopeIsValid(Builder $builder)
    {
        $builder
            ->withCount('reservations', 'packages')
            ->having('packages_count', '<', DB::raw('`promocodes`.`use_time`'))
            ->orHaving(
                'reservations_count',
                '<',
                DB::raw('`promocodes`.`use_time`'),
            )
            ->orHavingRaw('`promocodes`.`use_time` is NULL');
    }
    public function ScopeIsAvailable(Builder $builder)
    {
        $builder->where('expired_at', '>', Carbon::now());
        $builder->orWhere('expired_at', null);
    }
    public function DiscountAmount($amount): float
    {
        return $amount * ($this->percent / 100);
    }
    public function PriceAfterDiscount($amount): float
    {
        return $amount - $this->DiscountAmount($amount);
    }

    public function rules()
    {
        return [
            'code' => ['required', 'string', 'max:50'],
            'type' => ['required', 'string', 'in:reservation,package'],
            'expired_at' => ['nullable', 'date'],
            'use_time' => ['nullable', 'integer', 'max:99999'],
            'percent' => ['required', 'numeric', 'min:0.5', 'max:100'],
        ];
    }
}
