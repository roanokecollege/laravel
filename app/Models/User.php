<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Prefix;

class User extends Model
{

    protected $table = 'DataMart.dbo.view_PersonBasic';
    protected $primaryKey = 'RCID';
    public $incrementing = false;

    public function getDisplayNameAttribute() {
        if(isset($this->disallowed_prefix)) {
            return $this->rc_full_name;
        } else {
            return $this->Prefix . ' ' . $this->rc_full_name;
        }
    }

    public function disallowed_prefix() {
        return $this->hasOne(Prefix::class, 'prefix', 'Prefix');
    }
}
