<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DoctorPackage
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $package_id
 * @property float $price
 * @property int $expires_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Package $package
 * @mixin IdeHelperDoctorPackage
 */
class DoctorPackage extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['doctor_id', 'package_id', 'price', 'expires_in'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];
    public function scopeOfDoctor(Builder $builder, $doctor_id): void
    {
        $builder->where('doctor_id', $doctor_id);
    }
    public function scopeOfPackage(Builder $builder, $package_id): void
    {
        $builder->where('package_id', $package_id);
    }
    public function package()
    {
        return $this->belongsTo(Package::class)->withDefault(new Package());
    }
    public function doctor()
    {
        return $this->belongsTo(doctor::class);
    }

    public function rules(): array
    {
        $package = $this->package;
        return [
            'package_id' => [
                'bail',
                'required',
                'integer',
                'exists:packages,id',
            ],
            'price' => [
                'required',
                'numeric',
                "min:$package->min_price",
                "max:$package->max_price",
            ],
            // 'expires_in' => [
            //     'required',
            //     'integer',
            //     "min:$package->min_expire_in",
            //     "max:$package->max_expire_in",
            // ],
        ];
    }
}
