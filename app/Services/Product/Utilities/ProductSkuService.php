<?php
declare(strict_types=1);

namespace App\Services\Product\Utilities;

use Illuminate\Support\Facades\DB;
use App\Contracts\ProductSkuInterface;

class ProductSkuService implements ProductSkuInterface
{
  public function generate(): string
  {
    $productSku = str(str()->random(4))->prepend('sku-')->value;

    if ( null !== DB::table('products')->whereSku($productSku)->first() ) {
      return $this->generate();
    }
    return $productSku;
  }
}
