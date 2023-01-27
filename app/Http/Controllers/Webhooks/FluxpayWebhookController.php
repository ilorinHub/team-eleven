<?php
declare(strict_types=1);

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FluxpayWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $response = $this->isValidSignature($request);
            $payload = collect($response);
            $transaction = (object) collect($response)['data'];

            if ( $this->paymentIsAlreadyCompleted($transaction->ref) ) {
                return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);
            }


            if ($this->isSuccessfulCharge($payload)) {
                // fetch the payment
                $payment = \App\Models\Payment::query()
                    ->whereTransactionReference($transaction->ref)
                    ->firstOrFail();
                // fire off the PaymentRecieved event
                \App\Events\PaymentRecieved::dispatch($payment);
                return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);

            }

            // takes care of payment.charge.expired and payment.charge.rejected events implicitly
            return new \Illuminate\Http\Response('OK', \Symfony\Component\HttpFoundation\Response::HTTP_OK);



        } catch (\Svix\Exception\WebhookVerificationException $e){
            logger($e);
        }
    }

    private function isValidSignature(Request $request)
    {
        $headers = [
            'svix-id'  => $request->header('svix-id'),
            'svix-timestamp' => $request->header('svix-timestamp'),
            'svix-signature' => $request->header('svix-signature')
        ];
        $wh = new \Svix\Webhook(config('fluxpay.signing_secret'));
        return $wh->verify($request->getContent(), $headers);
    }

    private function isSuccessfulCharge($payload) : bool
    {
        return in_array($payload['event'], ['payment.charge.complete', 'payment.charge.incomplete']);
    }

    private function paymentIsAlreadyCompleted($transaction_reference) : bool
    {
        return null !== \App\Models\Payment::query()
            ->where('transaction_reference', $transaction_reference)
            ->whereStatus(\App\Enums\PaymentStatus::PAID)
            ->first();

    }
}
