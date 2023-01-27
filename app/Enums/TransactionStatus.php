<?php
declare(strict_types=1);

namespace App\Enums;

use ArchTech\Enums\From;
use ArchTech\Enums\Names;
use ArchTech\Enums\InvokableCases;

enum TransactionStatus: int
{
  use InvokableCases, Names, From;

  case INITIATED = 0;
  case COMPLETED = 1;
  case INCOMPLETE = 2;
}
