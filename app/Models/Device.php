<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Device
 *
 * @property int $id
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $user_agent
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $notifiable
 * @mixin IdeHelperDevice
 */
class Device extends Model
{
    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'user_agent',
        'token',
        'voip',
        'platform',
    ];

    public function notifiable(): MorphTo
    {
        return $this->morphTo('notifiable');
    }

    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOf($query, string $type): void
    {
        $query->where('notifiable_type', $type);
    }

    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFor($query, array $ids = []): void
    {
        $query->where('notifiable_id', $ids ?? []);
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDoctors($query, $doctors = []): void
    {
        $query
            ->where('notifiable_type', Doctor::class)
            ->whereIn('notifiable_id', $doctors);
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUsers($query, $users = []): void
    {
        $query->where('notifiable_type', User::class);
        $query->whereIn('notifiable_id', $users ?? []);
    }
    
    public function scopeOfAll($query, $users = []): void
    {
        $query->whereIn('notifiable_id', $users ?? []);
    }
    
    public function scopeOfPatients($query, $patients = []): void
    {
        $query->where('notifiable_type', Patient::class);
        $query->whereIn('notifiable_id', $patients ?? []);
    }

    /**
     * Set the user_agent
     *
     * @param  string  $value
     * @return void
     */
    public function setUserAgentAttribute($value)
    {
        return $this->attributes['user_agent'] = request()->header(
            'User-Agent',
        );
    }
}
