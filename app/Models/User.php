<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $table = 'DataMart.dbo.view_PersonBasic';
    protected $primaryKey = 'RCID';
    public $incrementing = false;

    public function getDisplayNameAttribute() {
        $from_name = $this->FirstName;

        if (isset($this->Nickname) && ! is_null($this->Nickname)) {
            $from_name = $this->Nickname;
        }

        $from_name .= ' '.$this->LastName;

        return $from_name;
    }
}
