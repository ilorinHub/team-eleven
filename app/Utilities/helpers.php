<?php

if ( !function_exists('httpClient') ) {
  function httpClient()
  {
      return (\App::environment('production')) ? Http::acceptJson() : Http::withOptions(['verify' => false])->acceptJson();
  }
}

if ( !function_exists('toCurrenyUnit') ) {
  function toCurrenyUnit($amount)
  {
      return number_format((int) bcdiv((string)$amount, (string) 100), 2);
  }
}
