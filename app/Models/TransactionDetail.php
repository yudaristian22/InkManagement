<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $filable = ['transaction_id', 'ink_id', 'quantity'];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function ink(){
        return $this->belongsTo(Ink::class);
    }
}
