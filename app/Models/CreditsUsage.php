<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;

class CreditsUsage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'credits_used',
        'description',
        'status',
        'job_id',
        'for_each_credits',
    ];
    // In CreditsUsage.php
    public function parentOrder()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

}
