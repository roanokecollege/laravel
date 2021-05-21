<?php

namespace App\Cashier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Prices extends Model
{
    public $table = "cashier.prices";

    protected static function boot () {
  		parent::boot();

  		static::addGlobalScope('sorted', function (Builder $builder) {
  			$builder->orderBy("price", "DESC")->orderBy("name");
  		});
  	}

    public function item () {
      $this->belongsTo(\App\Cashier\Items::class, "id", "fkey_product_id");
    }
}
