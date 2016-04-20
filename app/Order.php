<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function inn()
    {
        return $this->belongsTo('App\Inn', 'inn_id');
    }

}
