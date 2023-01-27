<?php
declare(strict_types=1);

namespace App\Enums;

use ArchTech\Enums\From;
use ArchTech\Enums\Names;
use ArchTech\Enums\InvokableCases;

enum PaymentStatus: int
{
  use InvokableCases, Names, From;

  case INITIATED = 0;
  case PAID = 1;
  case INCOMPLETE = 2;
  case REJECTED = 3;
}
