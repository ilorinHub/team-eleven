<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\PaymentRecieved;
use App\Contracts\PaymentInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyPayment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private readonly PaymentInterface $payment
    ){}

    /**
     * Handle the event.
     *
     * @param  \App\Events\PaymentRecieved  $event
     * @return void
     */
    public function handle(PaymentRecieved $event)
    {
        $this->payment->verify($event->payment);
    }
}
