<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['date', 'user_id', 'department_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class);
    }
}
