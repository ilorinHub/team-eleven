<?php
declare(strict_types=1);

namespace App\Contracts;

interface TransactionReferenceInterface
{
    public function generate(): string;
}
