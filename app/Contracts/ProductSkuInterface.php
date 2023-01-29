<?php
declare(strict_types=1);

namespace App\Contracts;

interface ProductSkuInterface
{
    public function generate(): string;
}
