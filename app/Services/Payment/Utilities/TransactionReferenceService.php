<?php
declare(strict_types=1);

namespace App\Services\Payment\Utilities;

use App\Contracts\TransactionReferenceInterface;

class TransactionReferenceService implements TransactionReferenceInterface
{
  public function generate(string $prefix = null): string
  {
    if (! $prefix) {
      return str()->random(13);
    }
      return str(str()->random(13))
        ->prepend($prefix . '-')
        ->value();
  }
}
