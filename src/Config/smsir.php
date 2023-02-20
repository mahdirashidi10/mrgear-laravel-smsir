<?php
return [
    'api_key' => env('SMSIR_API_KEY'),
    'base_url' => env('SMSIR_BASE_URL'),
    'line_number' => env('SMSIR_LINE_NUMBER'),
    'template_id' => env('SMSIR_TEMPLATE_ID'),
    'channels' => [
        \MRGear\SMSIR\Notifications\SMSIRChannel::class
    ]
];