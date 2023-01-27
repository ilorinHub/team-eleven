<?php
declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Contracts\Currency;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class MonnifyService extends Currency implements PaymentInterface
{

  function __construct(
    private string $api_key,
    private string $secret_key,
    private string $auth_url,
  ){}

  public function authorize()
  {
    $token = Cache::remember(config('monnify.token'), config('monnify.token_expiry'), function () {
      $response = httpClient()
        ->withBasicAuth($this->api_key, $this->secret_key)
        ->post($this->auth_url, []);

      $result = (object) $response->json();
      return $result->responseBody['accessToken'];

    });
  }

  public function charge(string $fullname, string $email, string $reference, int|string $amount, string $redirect_url)
  {
    $this->authorize();
    $response = httpClient()
        ->withToken(Cache::get('monnify_token'))
        ->post(config('monnify.initialize_url'), [
          'amount' => $this->toCurrenyUnit($amount),
          'customerName' => $fullname,
          'customerEmail' => $email,
          'currencyCode' => config('monnify.currency_code'),
          'contractCode' => config('monnify.contract_code'),
          'paymentReference' => $reference,
          'redirectUrl' => $redirect_url,
          'paymentMethods' => [
              'CARD',
              'ACCOUNT_TRANSFER'
            ],
        ]);
        if (str($response->status())->startsWith('4') || str($response->status())->startsWith('5')) {
          throw new \App\Exceptions\PaymentException($response->body());
        }
        $paymentResponseObject = (object) $response->json();
        return $paymentResponseObject->responseBody['checkoutUrl'];
  }

  public function verify(\App\Models\Payment $payment)
  {
    // rehydrate the model instance
    $payment->refresh();

    $this->authorize();
    $response = (object) httpClient()
      ->withToken(Cache::get('monnify_token'))
      ->get(config('monnify.verify_url') . urlencode($payment->gateway_transation_identifier))
      ->json();

      $paymentVerificationData = (object) $response->responseBody;

      if ( !in_array($paymentVerificationData->paymentStatus, ['PAID', 'OVERPAID', 'PARTIALLY_PAID']) ) {
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


      if ( $this->amountChargedIsAtLeastPaymentAmount($payment, $paymentVerificationData->amountPaid) ) {
        $payment->update([
          'charged_amount' => $this->toCurrenySubUnit($paymentVerificationData->amountPaid),
          'status' => \App\Enums\PaymentStatus::PAID()
        ]);
      }


      if ( $this->amountChargedIsLessThanPaymentAmount($payment, $paymentVerificationData->amountPaid) ) {
        $payment->update([
          'charged_amount' => $this->toCurrenySubUnit($paymentVerificationData->amountPaid),
          'status' => \App\Enums\PaymentStatus::INCOMPLETE()
        ]);
      }
  }

  private function isExpectedCurrency(\App\Models\Payment $payment, string $currency) : bool
  {
    return $payment->currency === $currency;
  }

  private function isPaymentAvailable(\App\Models\Payment $payment) : bool
  {
    return null !== $payment;
  }

  private function isPaymentCompleted(\App\Models\Payment $payment) : bool
  {
    return $payment->status === \App\Enums\PaymentStatus::PAID();
  }

  private function amountChargedIsAtLeastPaymentAmount(\App\Models\Payment $payment, string $amount_charged) : bool
  {
    return $this->toCurrenySubUnit($amount_charged) >= $payment->amount;
  }

  private function amountChargedIsLessThanPaymentAmount(\App\Models\Payment $payment, string $amount_charged) : bool
  {
    return $this->toCurrenySubUnit($amount_charged) < $payment->amount;
  }
}
