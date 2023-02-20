<?php

namespace MRGear\SMSIR\Providers;

use Illuminate\Support\ServiceProvider;
use MRGear\SMSIR\SMSIRFacade;

class SMSIRServiceProvider extends ServiceProvider {
    public function boot() {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('smsir.php'),
            ], 'config');

        }
    }
    public function register() {
        $this->mergeConfigFrom(__DIR__.'/../Config/smsir.php', 'smsir');

        $this->app->bind('smsir',function() {
            return new SMSIRFacade();
        });
    }
}



