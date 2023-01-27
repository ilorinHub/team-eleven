<?php
declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentInterface;

/**
 *
 */
class PaystackService implements PaymentInterface
{

  function __construct(
    private string $secret_key,
    private string $initialize_url,
  ){}

  public function authorize()
  {
    return httpClient()
      ->withToken($this->secret_key);
  }

  public function charge(string $fullname, string $email, string $reference, int|string $amount, string $redirect_url)
  {
      $response = $this->authorize()
        ->post($this->initialize_url, [
          'email' => $email,
          'reference' => $reference,
          'amount' => $amount,
          'callback_url' => $redirect_url,
        ]);
        // return $response->body();
        if (str($response->status())->startsWith('4') || str($response->status())->startsWith('5')) {
          throw new \App\Exceptions\PaymentException($response->body());
        }
        $paymentResponseObject = (object) $response->json();
        return $paymentResponseObject->data['authorization_url'];
  }

  public function verify(\App\Models\Payment $payment)
  {
    // rehydrate the model instance
    $payment->refresh();

    $response = (object) $this->authorize()
      ->get(config('paystack.verify_url') . $payment->transaction_reference)
      ->json();
      $paymentVerificationData = (object) $response->data;

    if ( $paymentVerificationData->status !== 'success' ) {
      return;
    }

    if ( !$this->isPaymentAvailable($payment) ) {
      return;
    }

    if ( $this->isPaymentCompleted($payment) ) {
      return;
    }

    if ( $this->amountChargedIsAtLeastPaymentAmount($payment, $paymentVerificationData->amount) ) {
      $payment->update([
        'charged_amount' => $paymentVerificationData->amount,
        'status' => \App\Enums\PaymentStatus::PAID()
      ]);
    }


    if ( $this->amountChargedIsLessThanPaymentAmount($payment, $paymentVerificationData->amount) ) {
      $payment->update([
        'charged_amount' => $paymentVerificationData->amount,
        'status' => \App\Enums\PaymentStatus::INCOMPLETE()
      ]);
    }
  }

  private function isPaymentAvailable(\App\Models\Payment $payment) : bool
  {
    return null !== $payment;
  }

  private function isPaymentCompleted(\App\Models\Payment $payment) : bool
  {
    return $payment->status === \App\Enums\PaymentStatus::PAID();
  }

  private function amountChargedIsAtLeastPaymentAmount(\App\Models\Payment $payment, int $amount_charged) : bool
  {
    return $amount_charged >= $payment->amount;
  }

  private function amountChargedIsLessThanPaymentAmount(\App\Models\Payment $payment, int $amount_charged) : bool
  {
    return $amount_charged < $payment->amount;
  }
}
