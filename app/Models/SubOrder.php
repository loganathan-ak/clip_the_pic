<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    protected $fillable = [
        'order_id',
        'credits_bd_id',
        'job_id',
        'project_title',
        'request_type',
        'sub_services',
        'duration',
        'instructions',
        'colors',
        'size',
        'other_size',
        'formats',
        'reference_files',
        'assigned_to',
        'status',
        'admin_notes',
    ];


    public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

}
