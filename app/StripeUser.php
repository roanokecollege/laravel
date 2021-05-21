<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class StripeUser extends Model
{
  use Billable;

  protected $table      = "cashier.users";
  protected $primaryKey = "rcid";
  public $incrementing  = false;

  public $with          = ["user"];

  public function user () {
    return $this->hasOne(\App\User::class, "RCID", "rcid");
  }
}
