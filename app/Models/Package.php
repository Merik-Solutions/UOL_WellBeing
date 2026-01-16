<?php

namespace App\Models;

use App\Traits\ColumnTranslation;
use App\Traits\HasTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Package
 *
 * @property string $name_ar
 * @property string $name_en
 * @property string $description_ar
 * @property string $description_en
 * @property string $doc_description_ar
 * @property string $doc_description_en
 * @property double $min_price
 * @property double $max_price
 * @property int $min_expire_in
 * @property int $max_expire_in
 * @property double $quantity
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Doctor[] $doctors
 * @property-read int|null $doctors_count
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperPackage
 */
class Package extends Model
{
    use HasFactory, ColumnTranslation;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'doc_description_ar',
        'doc_description_en',
        'min_price',
        'max_price',
        'min_expire_in',
        'max_expire_in',
        'expire_in',
        'quantity',
        'isActive',
    ];
    protected $casts = [
        'min_price' => 'decimal:1',
        'max_price' => 'decimal:1',
    ];
    public function doctors()
    {
        return $this->belongsToMany(
            Doctor::class,
            'doctor_packages',
            'package_id',
            'doctor_id',
        )->with('price', 'exipres_in');
    }

    public function rules(): array
    {
        return [
            'name_ar' => ['required', 'string', 'max:191'],
            'name_en' => ['required', 'string', 'max:191'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'doc_description_ar' => ['string'],
            'doc_description_en' => ['string'],
            'min_price' => [
                'required',
                'numeric',
                'max:' . request()->max_price,
                'min:' . env('CASHIER_MIN'),
            ],
            'max_price' => [
                'required',
                'numeric',
                'min:' . request()->min_price,
            ],
            'expire_in' => [
                'required',
                'integer',
                'min:1',
                'max:max_expire_in',
            ],

            'quantity' => ['required', 'numeric', 'max:99999'],
        ];
    }
}
