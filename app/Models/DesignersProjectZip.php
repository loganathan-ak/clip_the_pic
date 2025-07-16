<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignersProjectZip extends Model
{
    Protected $fillable = [
        'order_id',
        'job_id',
        'file_path',
    ];
}
