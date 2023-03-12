<?php

namespace MRGear\SMSIR\Providers;

use Illuminate\Support\ServiceProvider;
use MRGear\SMSIR\SMSIR;

class SMSIRServiceProvider extends ServiceProvider {
    public function boot() {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Config/smsir.php' => config_path('smsir.php'),
            ], 'config');

        }
    }
    public function register() {
        $this->mergeConfigFrom(__DIR__.'/../Config/smsir.php', 'smsir');
    }
}



