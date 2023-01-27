<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Auth;
use App\Contracts\TransactionReferenceInterface;

class TestController extends Controller
{
    public function __invoke(PaymentInterface $payment, TransactionReferenceInterface $transactionReference) {
      if (!Auth::check()) throw new \Exception('No Authenticated user');
      try {
          DB::beginTransaction();
          $currentPayment = \App\Models\Payment::create([
            'user_id' => auth()->user()->id,
            'amount' => 700000,
            'transaction_reference' => $transactionReference->generate('TE'),
            'currency' => 'NGN',
          ]);
          $response = $payment->charge(
            fullname: auth()->user()->full_name,
            email: auth()->user()->email,
            reference: $currentPayment->transaction_reference,
            amount: 700000,
            redirect_url: 'http://laravel-blade.test/'
          );
          DB::commit();
          return $response;
      } catch(\Exception $e) {
        return $e;
          DB::rollback();

      }
    }
}
