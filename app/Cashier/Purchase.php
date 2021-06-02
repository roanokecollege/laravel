<?php

namespace App\Cashier;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "cashier.purchases";

    public function populateAttributes ($customer_id, $payment_intent_id, $charge_id,
                                        $charge_amount, $receipt_url, $user_rcid) {
      $this->customer_id       = $customer_id;
      $this->payment_intent_id = $payment_intent_id;
      $this->charge_id         = $charge_id;
      $this->charge_amount     = $charge_amount / 100.00;
      $this->receipt_url       = $receipt_url;
      $this->updated_by        = $user_rcid;
      if (empty($this->created_by)) {
        $this->created_by      = $user_rcid;
      }
    }

    public function items () {
      return $this->hasMany(\App\Cashier\PurchaseItem::class, "fkey_purchase_id", "id");
    }
}
