<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingDecals extends Model
{
    use SoftDeletes;

    protected $table = "StudentAffairsOperations.campus_safety.parking_decals";

    public function populateAttributes (Request $request, \App\User $user) {
      $this->rcid       = $user->RCID;
      $this->resident   = $request->resident == 1;
      $this->make       = $request->make;
      $this->model      = $request->model;
      $this->color      = $request->color;
      $this->year       = $request->year;
      $this->plate      = $request->plate;
      $this->state      = $request->state;
      $this->updated_by = $user->RCID;
      if (empty($this->created_by)) {
        $this->created_by = $user->RCID;
      }
    }
}
