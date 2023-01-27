<?php
declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class FluxpayService implements PaymentInterface
{

  function __construct(
    private string $key,
    private string $secret,
    private string $auth_url,
  ){}

  public function authorize()
  {
    $token = Cache::remember(config('fluxpay.token'), config('fluxpay.token_expiry'), function () {
      $response = httpClient()
        ->withBasicAuth($this->key, $this->secret)
        ->post($this->auth_url, []);

      $result = (object) $response->json();
      return $result->token;

    });
  }

  public function charge(string $fullname, string $email, string $reference, int|string $amount, string $redirect_url): string
  {
    $this->authorize();
    $response = httpClient()
        ->withToken(Cache::get('fluxpay_token'))
        ->post(config('fluxpay.checkout_url'), [
          'amount' => $amount,
          'currency' => config('fluxpay.currency'),
          'payment_ref' => $reference,
          'flux_id' => config('fluxpay.id'),
          'buyer_email' => $email,
          'buyer_name' => $fullname,
          'payment_type' => config('fluxpay.payment_type'),
          'fee_bearer' => config('fluxpay.fee_bearer'),
          'redirect_url' => $redirect_url,
        ]);
        if (str($response->status())->startsWith('4') || str($response->status())->startsWith('5')) {
          throw new \App\Exceptions\PaymentException($response->body());
        }
        $paymentResponseObject = (object) $response->json();
        return $paymentResponseObject->link;
  }

  public function verify(\App\Models\Payment $payment) {

    // rehydrate the model instance
    $payment->refresh();

    $this->authorize();
    $response = httpClient()
      ->withToken(Cache::get('fluxpay_token'))
      ->get(config('fluxpay.verify_url') . $payment->transaction_reference)
      ->json();
      $paymentVerificationData = (object) $response;

    if ( !in_array($paymentVerificationData->status, ['PAID', 'INCOMPLETE'])  ) {
      return;
    }

    if ( !$this->isPaymentAvailable($payment) ) {
      return;
    }

    if ( $this->isPaymentCompleted($payment) ) {
      return;
    }

    if ( $this->amountChargedIsAtLeastPaymentAmount($payment, $paymentVerificationData->paid_amount) ) {
      $payment->update([
        'charged_amount' => $paymentVerificationData->paid_amount,
        'status' => \App\Enums\PaymentStatus::PAID()
      ]);

      \App\Jobs\UpdateTransactionStatus::dispatch($payment->transaction);
    }


    if ( $this->amountChargedIsLessThanPaymentAmount($payment, $paymentVerificationData->paid_amount) ) {
      $payment->update([
        'charged_amount' => $paymentVerificationData->paid_amount,
        'status' => \App\Enums\PaymentStatus::INCOMPLETE()
      ]);

      \App\Jobs\UpdateTransactionStatus::dispatch($payment->transaction);
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
