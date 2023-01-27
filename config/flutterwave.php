<?php

return [
  'public_key' => env('FLUTTERWAVE_PUBLIC_KEY', ''),
  'secret_key' => env('FLUTTERWAVE_SECRET_KEY', ''),
  'encryption_key' => env('FLUTTERWAVE_ENCRYPTION_KEY', ''),
  'webhook_secret_hash' => env('FLUTTERWAVE_WEBHOOK_SECRET_HASH', ''),
  'standard_url' => env('FLUTTERWAVE_STANDARD_URL', ''),
  'verify_url' => env('FLUTTERWAVE_VERIFY_URL', ''),
  'currency' => env('FLUTTERWAVE_CURRENCY', ''),
];
