<?php

namespace MRGear\SMSIR;

use Illuminate\Support\Facades\Facade;

/**
 * SMSIR FACADE
 */
class SMSIRFacade extends Facade {
    protected static function getFacadeAccessor() { return 'smsir'; }
}