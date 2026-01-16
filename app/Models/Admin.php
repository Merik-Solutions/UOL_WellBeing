<?php

namespace App\Models;

use App\Traits\HashPassword;
use App\Traits\ModelHasLogs;
use App\Traits\ModelHasImage;
use Laravel\Cashier\Billable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Admin\Auth\VerifyEmail;
use Spatie\Activitylog\Traits\CausesActivity;
use App\Notifications\Admin\Auth\ResetPassword;
use HighIdeas\UsersOnline\Traits\UsersOnlineTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $image
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @mixin IdeHelperAdmin
 */
class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HashPassword, Billable,HasRoles;

    public $timestamps = true;
    protected $fillable = ['name', 'email', 'password', 'phone'];

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

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

}
