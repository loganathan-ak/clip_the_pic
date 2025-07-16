<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{
    protected $fillable = [
        'order_id',
        'job_id',
        'image_path',
        'feedback',
    ];
    
}
