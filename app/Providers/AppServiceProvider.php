<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $asset_v = config('constants.asset_version', 1);
        View::share('asset_v', $asset_v);

        //Blade directive para formatear el número en el formato requerido.
        Blade::directive('num_format', function ($expression) {
            return "number_format($expression, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
        });

        //Blade directive para formatear los valores de cantidad en el formato requerido.
        Blade::directive('format_quantity', function ($expression) {
            return "number_format($expression, config('constants.quantity_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
        });

        //Blade directive  para formatear fecha.
        Blade::directive('format_date', function ($date) {
            if (!empty($date)) {
                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format(session('empresa.date_format'))";
            } else {
                return null;
            }
        });

        //Blade directive para formatear fecha y hora.
        Blade::directive('format_datetime', function ($date) {
            if (!empty($date)) {
                $time_format = 'h:i ';
                if (session('empresa.time_format') == 24) {
                    $time_format = 'H:i';
                }

                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format(session('empresa.date_format') . ' ' . '$time_format')";
            } else {
                return null;
            }
        });
    }
}
