<?php

namespace App\Models;

use App\Traits\ColumnTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $code
 * @property string $flag
 * @property string $iso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    use ColumnTranslation;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    use HasFactory;

    public function getFlagAttribute()
    {
        return fileUrl($this->attributes['flag']);
    }
    /**
     * Set the flag cloumn
     *
     * @param  string|UploadedFile  $flag
     * @return void
     */
    public function setFlagAttribute(/* ?UploadedFile */ $flag)
    {
        if ($flag != null && $flag instanceof UploadedFile) {
            return $this->attributes['flag'] =
                '/storage/' . $flag->store('countries');
        }
    }
}
