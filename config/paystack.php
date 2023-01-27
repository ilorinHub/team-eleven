<?php

return [
  'secret_key' => env('PAYSTACK_SECRET_KEY', ''),
  'initialize_url' => env('PAYSTACK_INITIALIZE_URL', ''),
  'verify_url' => env('PAYSTACK_VERIFY_URL', ''),
];
