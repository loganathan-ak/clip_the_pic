<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BrandsProfile;
use App\Models\Orders;
use App\Models\SubOrder;
use App\Models\CreditsUsage;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\JobAssignedToQC;

class AdminController extends Controller
{
    public function adminViewOrders($id){
        
        $user = auth()->user();

        $brands = BrandsProfile::get();  

        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->get();

        // $order = Orders::findOrFail($id);

        $order = SubOrder::findOrFail($id);

        $creditsUsage = CreditsUsage::where('order_id', $order->order_id)->first();

        return view('designers&admin.orders.view-order', compact('order', 'brands', 'subscribers', 'admins', 'creditsUsage'));
        
    }

    public function adminEditOrders($id){

        $user = auth()->user();

        $brands = BrandsProfile::get();

        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->get();

        // $order = Orders::findOrFail($id);

        $order = SubOrder::findOrFail($id);

        $creditsUsage = CreditsUsage::where('order_id', $order->order_id)->first();

        return view('designers&admin.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins', 'creditsUsage'));
    
    }


    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed,Rejected,Quality Checking',
             // Validate completed_time only if status is 'Completed'
        'completed_time' => 'nullable|string|regex:/^-?(\d{2}):(\d{2}):(\d{2})$/',
        ]);
    
        $order = SubOrder::findOrFail($id);

        // Store the old status to check for changes
       $oldStatus = $order->status;

        $order->status = $request->status;
        

        // --- Logic for 'Completed' status transition ---
    // This block should only run when the status is *changed* to 'Completed'
    if ($request->status === 'Completed' && $oldStatus !== 'Completed') {
        $order->completed_at = $request->completed_time;
    }
    $order->save();
    
        // Only send mail if status is "Quality Checking"
        if ($request->status === 'Quality Checking') {
            $qc = User::where('role', 'qualitychecker')->first();
            if ($qc) {
                Mail::to($qc->email)->send(new JobAssignedToQC($order));
            }
        }
    
        return back()->with('success', 'Status updated successfully!');
    }
    


public function jobSearch(Request $request)
{
    $keyword = $request->get('jobname');

    $query = SubOrder::query();

    // Only fetch jobs assigned to the current user (designer)
    $query->where('assigned_to', Auth::user()->id);

    if ($keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('job_id', 'like', '%' . $keyword . '%')
              ->orWhere('project_title', 'like', '%' . $keyword . '%'); // assuming 'id' is used for Job ID
        });
    }

    $results = $query->latest()->get();
    $users = User::get();
    return response()->json([
        'orders' => $results,
        'users' => $users
    ]);
    
}



public function dashiboardOrdersLink($status){
    $currentUser = Auth::user()->id;
    $orders = SubOrder::where('assigned_to', $currentUser)->where('status', $status)->get();
    return view('designers&admin.orders', compact('orders'));
}


}
