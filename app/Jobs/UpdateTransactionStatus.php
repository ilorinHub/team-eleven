<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class UpdateTransactionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private \App\Models\Transaction $transaction)
    {}

    public function middleware()
    {
        return [new WithoutOverlapping($this->transaction->id)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transaction = $this->transaction
        ->loadSum(
          'payments as total_charged_amount',
          'charged_amount'
        );
        if ($transaction->total_charged_amount >= $transaction->amount) {
          $transaction->update([
            'status' => \App\Enums\TransactionStatus::COMPLETED()
          ]);
        }

        if ($transaction->total_charged_amount < $transaction->amount) {
          $transaction->update([
            'status' => \App\Enums\TransactionStatus::INCOMPLETE()
          ]);
        }
    }
}
