<?php

namespace App\Models;

use App\Traits\ColumnTranslation;
use App\Traits\ModelHasLogs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string|null $name_ar
 * @property string|null $name_en
 * @property string|null $image
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Doctor[] $doctors
 * @property-read int|null $doctors_count
 * @property-read mixed $address
 * @property-read mixed $body
 * @property-read mixed $description
 * @property-read mixed $label
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $title
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory, ColumnTranslation;
    protected $fillable = ['name_ar', 'name_en', 'image'];

    public function getImageAttribute()
    {
        return fileUrl($this->attributes['image']);
    }
    /**
     * Set the image cloumn
     *
     * @param  string  $value
     * @return void
     */
    public function setImageAttribute(/* ?UploadedFile */ $value)
    {
        if ($value != null && $value instanceof UploadedFile) {
            return $this->attributes['image'] =
                '/storage/' . $value->store('categories');
        }
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'category_id');
    }
}
