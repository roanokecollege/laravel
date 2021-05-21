<?php

namespace App\Cashier;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public $table        = "cashier.items";

    public function prices () {
      return $this->hasMany(\App\Cashier\Prices::class, "fkey_product_id", "id");
    }
}
