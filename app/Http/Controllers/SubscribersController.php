<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class SubscribersController extends Controller
{
    public function updateStatus($id){
        $order = Orders::findOrFail($id);
        $order->status = 'Pending';
        $order->save();
        return redirect()->back();
    }
    
}
