<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BankAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['data' => 'json'];
    public function owner(): MorphTo
    {
        return $this->morphTo('owner');
    }
}
