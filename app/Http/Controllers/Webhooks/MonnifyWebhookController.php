<?php
declare(strict_types=1);

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonnifyWebhookController extends Controller
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
            $request->hasHeader('monnify-signature') &&
            $this->isValidSignature($request->header('monnify-signature'), $request->getContent())
        ) {
            $payload = (object) json_decode($request->getContent(), true);
            $transaction = (object) $payload->eventData;

            if ( $this->paymentIsAlreadyCompleted($transaction->paymentReference) ) {
                return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);
            }

            if ( $this->isSuccessfulCharge($payload) ) {
                // fetch the payment
                $payment = \App\Models\Payment::query()
                    ->whereTransactionReference($transaction->paymentReference)
                    ->firstOrFail();

                // update payment with transactionReference
                $payment->update([
                    'gateway_transation_identifier' => $transaction->transactionReference
                ]);
                // fire off the PaymentRecieved event
                \App\Events\PaymentRecieved::dispatch($payment);
                return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);

            }
        }
    }

    private function isValidSignature($request_signature, $request_content)
    {
        if ( $request_signature == hash_hmac('sha512', $request_content, config('monnify.secret_key')) ) {
            return true;
        }
        return false;

    }

    private function isSuccessfulCharge($payload)
    {
        return $payload->eventType === 'SUCCESSFUL_TRANSACTION';
    }


    private function paymentIsAlreadyCompleted($transaction_reference)
    {
        return null !== \App\Models\Payment::query()
            ->where('transaction_reference', $transaction_reference)
            ->whereStatus(\App\Enums\PaymentStatus::PAID)
            ->first();

    }
}
