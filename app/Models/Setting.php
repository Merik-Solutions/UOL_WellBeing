<?php

namespace App\Models;

use App\Traits\ColumnTranslation;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property string $slug_ar
 * @property string $slug_en
 * @property string $value
 * @property int $input_type
 * @property int $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperSetting
 */
class Setting extends Model
{
    use ColumnTranslation;
    const INPUT_TEXT = 0;
    const INPUT_NUMBER = 1;
    const INPUT_TEXTAREA = 2;
    const INPUT_TYPE_EMAIL = 3;

    const CATEGORY_PAGES = 1;
    const CATEGORY_HOME_SECTIONS = 2;
    const CATEGORY_FOOTER = 3;
    const CATEGORY_CONTACT = 4;

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'slug_ar',
        'slug_en',
        'value',
        'input_type',
        'category',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['name'];
    }
}
