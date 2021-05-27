<?php

namespace App\Cashier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prices extends Model
{
    use SoftDeletes;

    public $table = "cashier.prices";

    protected static function boot () {
  		parent::boot();

  		static::addGlobalScope('sorted', function (Builder $builder) {
  			$builder->orderBy("price", "DESC")->orderBy("name");
  		});
  	}

    public function item () {
      return $this->belongsTo(\App\Cashier\Items::class, "fkey_product_id", "id");
    }
}
