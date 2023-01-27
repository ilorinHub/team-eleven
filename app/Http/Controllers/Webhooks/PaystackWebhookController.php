<?php
declare(strict_types=1);

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaystackWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ( $this->isValidSignature(
            request()->server('HTTP_X_PAYSTACK_SIGNATURE'),
            $request->getContent())
        ) {
            $payload = (object) json_decode($request->getContent(), true);
            $transaction = (object) $payload->data;

            if ( $this->isSuccessfulCharge($payload) ) {
                // logger($request->getContent());
                try {
                    if ( $this->paymentIsAlreadyCompleted($transaction->reference)) {
                        return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);
                    }

                    // fetch the payment
                    $payment = \App\Models\Payment::query()
                        ->whereTransactionReference($transaction->reference)
                        ->firstOrFail();


                    // fire off the PaymentRecieved event
                    \App\Events\PaymentRecieved::dispatch($payment);
                    return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);

                } catch(\Throwable $throwable) {
                }
            }

        }

    }

    private function isValidSignature($request_signature, $request_content)
    {
        if ( $request_signature == hash_hmac('sha512', $request_content, config('paystack.secret_key')) ) {
            return true;
        }
        return false;

    }

    private function isSuccessfulCharge($payload)
    {
        return $payload->event === 'charge.success';
    }

    private function paymentIsAlreadyCompleted($transaction_reference)
    {
        return null !== \App\Models\Payment::query()
            ->where('transaction_reference', $transaction_reference)
            ->whereStatus(\App\Enums\PaymentStatus::PAID)
            ->first();

    }
}
