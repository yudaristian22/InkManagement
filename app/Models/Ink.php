<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ink extends Model
{
    protected $fillable = ['code', 'color', 'is_original', 'stock'];

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class);
    }
}
