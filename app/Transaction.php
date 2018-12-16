<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function relTransactionHead()
    {
    	return $this->belongsto('App\TransactionHead','transactionhead_id','id');
    }

    public function relUser()
    {
    	return $this->belongsto('App\User','transaction_id','id');
    }
}
