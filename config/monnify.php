<?php

return [
  'secret_key' => env('MONNIFY_SECRET_KEY', ''),
  'api_key' => env('MONNIFY_API_KEY', ''),
  'auth_url' => env('MONNIFY_AUTH_URL', ''),
  'token' => env('MONNIFY_TOKEN', ''),
  'token_expiry' => env('MONNIFY_TOKEN_EXPIRY', ''),
  'contract_code' => env('MONNIFY_CONTRACT_CODE', ''),
  'currency_code' => env('MONNIFY_CURRENCY_CODE', ''),
  'initialize_url' => env('MONNIFY_INITIALIZE_URL', ''),
  'verify_url' => env('MONNIFY_VERIFY_URL', ''),
];
