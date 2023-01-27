<?php

return [
  'secret' => env('FLUXPAY_SECRET', ''),
  'key' => env('FLUXPAY_KEY', ''),
  'token' => env('FLUXPAY_TOKEN', ''),
  'token_expiry' => env('FLUXPAY_TOKEN_EXPIRY', ''),
  'id' => env('FLUXPAY_ID', ''),
  'auth_url' => env('FLUXPAY_AUTH_URL', ''),
  'checkout_url' => env('FLUXPAY_CHECKOUT_URL', ''),
  'verify_url' => env('FLUXPAY_VERIFY_URL', ''),
  'signing_secret' => env('FLUXPAY_SIGNING_SECRET', ''),
  'payment_type' => env('FLUXPAY_PAYMENT_TYPE', ''),
  'fee_bearer' => env('FLUXPAY_FEE_BEARER', ''),
  'currency' => env('FLUXPAY_CURRENCY', ''),
];
