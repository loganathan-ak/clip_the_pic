<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectzip extends Model
{
    protected $fillable = [
        'order_id',
        'job_id',
        'file_path',
    ];
}
