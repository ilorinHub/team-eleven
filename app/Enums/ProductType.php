<?php
declare(strict_types=1);

namespace App\Enums;

use ArchTech\Enums\From;
use ArchTech\Enums\Names;
use ArchTech\Enums\InvokableCases;

enum ProductType: string
{
  use InvokableCases, Names, From;

  case ACCESSORIES = 'accessories';
  case FABRICS = 'fabrics';
  case GARMENT = 'garment';
  case OUTFIT = 'outfit';

}
