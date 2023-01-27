<?php
declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Contracts\Currency;
use App\Contracts\PaymentInterface;

/**
 *
 */
class FlutterwaveService extends Currency implements PaymentInterface
{

  function __construct(
    private string $secret_key,
    private string $standard_url,
  ){}

  public function authorize()
  {
    return httpClient()
      ->withToken($this->secret_key);
  }

  public function charge(string $fullname, string $email, string $reference, int|string $amount, string $redirect_url): string
  {
      $response = $this->authorize()
        ->post($this->standard_url, [
          'customer' => [
            'email' => $email,
            'name' => $fullname,
          ],
          'tx_ref' => $reference,
          'amount' => $this->toCurrenyUnit($amount),
          'currency' => config('flutterwave.currency'),
          'redirect_url' => $redirect_url,
        ]);
        if (str($response->status())->startsWith('4') || str($response->status())->startsWith('5')) {
          throw new \App\Exceptions\PaymentException($response->body());
        }
        $paymentResponseObject = (object) $response->json();
        return $paymentResponseObject->data['link'];
  }

  public function verify(\App\Models\Payment $payment)
  {
      // rehydrate the model instance
      $payment->refresh();

      $response = $this->authorize()
        ->get(config('flutterwave.verify_url'), [
          'tx_ref' => $payment->transaction_reference
        ])
        ->json();
        $paymentVerificationData = (object) $response['data'];

        if ( $paymentVerificationData->status != 'successful' ) {
          return;
        }

        if ( !$this->isExpectedCurrency($payment, $paymentVerificationData->currency)) {
          return;
        }

        if ( !$this->isPaymentAvailable($payment) ) {
          return;
        }

        if ( $this->isPaymentCompleted($payment) ) {
          return;
        }

        if ( $this->amountChargedIsAtLeastPaymentAmount($payment, $paymentVerificationData->charged_amount) ) {
          $payment->update([
            'charged_amount' => $this->toCurrenySubUnit($paymentVerificationData->charged_amount),
            'status' => \App\Enums\PaymentStatus::PAID()
          ]);
        }


        if ( $this->amountChargedIsLessThanPaymentAmount($payment, $paymentVerificationData->charged_amount) ) {
          $payment->update([
            'charged_amount' => $this->toCurrenySubUnit($paymentVerificationData->charged_amount),
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
    return $this->toCurrenySubUnit($amount_charged) >= $payment->amount;
  }

  private function amountChargedIsLessThanPaymentAmount(\App\Models\Payment $payment, int $amount_charged) : bool
  {
    return $this->toCurrenySubUnit($amount_charged) < $payment->amount;
  }

  private function isExpectedCurrency(\App\Models\Payment $payment, string $currency)
  {
    return $payment->currency === $currency;
  }

}
