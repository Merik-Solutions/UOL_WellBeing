<?php

namespace App\Providers;

use App\Services\Payment\MyFatoorah;
use Laravel\Cashier\Cashier;
use Laravel\Telescope\Telescope;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\VideoCall\Drivers\AgoraDriver;
use App\Services\VideoCall\Interfaces\SignatureContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->app->bind(SignatureContract::class, AgoraDriver::class);
        $this->app->bind(PaymentMyfatoorahApiV2::class, fn() => new MyFatoorah(
            config('myfatoorah.api_key'),
            config('myfatoorah.country_iso'),
            config('myfatoorah.test_mode'),
        ));
        Cashier::ignoreMigrations();
        Telescope::night();
        Paginator::useBootstrap();

        $current_locale = app()->getLocale();
        $available_locales = config('app.available_locales');

        // view::share('allRoles', Role::all());
        // aws s3 temporary url
        Storage::disk('local')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return URL::temporarySignedRoute(
                'download',
                $expiration,
                array_merge($options, ['path' => $path])
            );
        });

    }
}
