<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $casts = [
      'status' => \App\Enums\PaymentStatus::class || 'integer',
    ];

    public static function booted()
    {
        static::creating(function(Payment $payment) {
            $payment->gateway = config('payment.provider');
        });
    }

    public function user() : BelongsTo
    {
      return $this->belongsTo(User::class);
    }
}
