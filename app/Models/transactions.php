<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plans;

class Transactions extends Model
{

    protected $fillable = [
        'user_id',
        'plan_id',
        'credits_purchased',
        'amount_paid',
        'payment_method',
        'transaction_id',
    ];


    // In Transaction.php
    public function plan(){
        return $this->belongsTo(Plans::class);
    }

}
