<?php

namespace App\Providers;

use App\Models\Reservation;
use App\Models\UserDoctorPackage;
use App\Models\WithdrawRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'reservation' => Reservation::class,
            'package' => UserDoctorPackage::class,
            'withdraw' => WithdrawRequest::class,
        ]);
    }
}
