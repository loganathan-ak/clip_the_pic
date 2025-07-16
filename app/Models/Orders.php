<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_id',
        'project_title',
        'request_type',
        'sub_services',
        'duration',
        'instructions',
        'colors',
        'size',
        'other_size',
        'software',
        'other_software',
        'brands_profile_id',
        'formats',
        'pre_approve',
        'reference_files',
        'rush',
        'created_by',
        'obeth_id',
        'assigned_to',
        'status',
        'admin_notes',
        'completed_at',
    ];


    public function subOrders()
{
    return $this->hasMany(SubOrder::class, 'order_id');
}

    
}
