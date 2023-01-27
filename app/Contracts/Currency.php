<?php
declare(strict_types=1);

namespace App\Contracts;

abstract class Currency
{
  public function toCurrenyUnit($amount)
  {
      return (int) bcdiv((string)$amount, (string) 100);
  }

  public function toCurrenySubUnit($amount)
  {
      return (int) bcmul((string)$amount, (string) 100);
  }
}
