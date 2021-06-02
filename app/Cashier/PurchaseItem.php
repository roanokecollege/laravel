<?php

namespace App\Cashier;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table = "cashier.purchase_items";

    public function populateAttributes ($purchase_id, $price_id, $quantity, $user_id) {
      $this->fkey_purchase_id = $purchase_id;
      $this->fkey_price_id    = $price_id;
      $this->quantity         = $quantity;
      $this->updated_by       = $user_id;
      if (empty($this->created_by)) {
        $this->created_by     = $user_id;
      }
    }

    public function purchase () {
      return $this->belongsTo(Purchase::class, "fkey_purchase_id", "id");
    }

    public function price () {
      return $this->hasOne(Prices::class, "price_id", "fkey_price_id");
    }
}
