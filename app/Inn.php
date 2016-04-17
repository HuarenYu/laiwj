<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inn extends Model
{

    public function host()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

}
