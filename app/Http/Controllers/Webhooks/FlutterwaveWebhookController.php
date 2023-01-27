<?php
declare(strict_types=1);

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlutterwaveWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (
          $request->hasHeader('verif-hash') &&
          $this->isValidSignature($request->header('verif-hash'))
        ) {
            $transaction = (object) json_decode($request->getContent(), true);
            if ( $this->paymentIsAlreadyCompleted($transaction->txRef) ) {
                return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);
            }

            if ( $this->isSuccessfulCharge($transaction) ) {
                // fetch the payment
                $payment = \App\Models\Payment::query()
                    ->whereTransactionReference($transaction->txRef)
                    ->firstOrFail();
                // fire off the PaymentRecieved event
                \App\Events\PaymentRecieved::dispatch($payment);
                return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);

            }
        }
    }

    private function isValidSignature($request_signature)
    {
        if ( $request_signature === config('flutterwave.webhook_secret_hash') ) {
            return true;
        }
        return false;

    }

    private function isSuccessfulCharge($transaction) : bool
    {
        return $transaction->status === 'successful';
    }

    private function paymentIsAlreadyCompleted($transaction_reference)
    {
        return null !== \App\Models\Payment::query()
            ->where('transaction_reference', $transaction_reference)
            ->whereStatus(\App\Enums\PaymentStatus::PAID)
            ->first();

    }
}
