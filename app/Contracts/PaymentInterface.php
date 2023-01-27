<?php
declare(strict_types=1);

namespace App\Contracts;

interface PaymentInterface
{
  public function authorize();
  public function charge(string $fullname, string $email, string $reference, int|string $amount, string $redirect_url);
  public function verify(\App\Models\Payment $payment);
}


