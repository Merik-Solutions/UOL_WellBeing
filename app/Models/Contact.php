<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $subject
 * @property string|null $message
 * @property string|null $image
 * @property string|null $seen_at
 * @property int|null $seen_by
 * @property string|null $reply
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Admin|null $admin
 * @mixin IdeHelperContact
 */
class Contact extends Model
{
    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'model_id',
        'model_type',
        'subject',
        'message',
        'seen_at',
        'seen_by',
        'reply',
    ];

    public function model()
    {
        return $this->morphTo('model');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'seen_by');
    }
}
