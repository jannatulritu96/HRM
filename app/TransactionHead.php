<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHead extends Model
{
    public function relTransaction()
    {
    	return $this->hasMany('App\Transaction','transactionhead_id','id');
    }
}
