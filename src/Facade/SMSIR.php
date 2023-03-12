<?php
/**
 * mahdirashidi.developer@gmail.com
 */
namespace MRGear\SMSIR\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * SMSIR FACADE
 */
class SMSIR extends Facade {
    protected static function getFacadeAccessor() { return \MRGear\SMSIR\SMSIR::class; }
}