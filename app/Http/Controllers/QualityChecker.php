<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\BrandsProfile;
use App\Models\user;
use App\Models\CreditsUsage;
use App\Models\SubOrder;
use Illuminate\Support\Facades\Auth;

class QualityChecker extends Controller
{
    public function dashboard(){
        // $totalOrders = Orders::where('assigned_to', Auth::user()->id)->get()->count();
        // $completedOrders = Orders::where('assigned_to', Auth::user()->id)->where('status', 'Completed')->get()->count();
        // $pendingOrders = Orders::where('assigned_to', Auth::user()->id)->where('status', 'Pending')->get()->count();
        // $inProgress = Orders::where('assigned_to', Auth::user()->id)->where('status', 'In Progress')->get()->count();

        $totalOrders = SubOrder::where('assigned_to', Auth::user()->id)->get()->count();
        $completedOrders = SubOrder::where('assigned_to', Auth::user()->id)->where('status', 'Completed')->get()->count();
        $pendingOrders = SubOrder::where('assigned_to', Auth::user()->id)->where('status', 'Pending')->get()->count();
        $inProgress = SubOrder::where('assigned_to', Auth::user()->id)->where('status', 'In Progress')->get()->count();
        $qualityChecking = SubOrder::where('status', 'Quality Checking')->get()->count();
        return view('qualitychecker.qc-dashboard', compact('totalOrders', 'completedOrders', 'pendingOrders', 'qualityChecking'));
    }

    public function dashboardStatusJobs($status){
        if($status == 'Quality Checking'){
            $orders = SubOrder::where('status', $status)->get();
            return view( 'qualitychecker.quality-checkinglist', compact('orders'));
        }
        $orders = SubOrder::where('assigned_to', Auth::user()->id)->where('status', $status)->get();

        return view( 'qualitychecker.qc-orders', compact('orders'));
    }

    public function orders(){
        // $orders = Orders::where('assigned_to', Auth::user()->id)->whereNotIn('status', ['Quality Checking'])->get();

        $orders = SubOrder::where('assigned_to', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $users = User::get();
        return view('qualitychecker.qc-orders', compact('orders'  , 'users' ));
    }

    public function mainOrders(){
        $orders = Orders::where('status', '!=', 'Draft')->orderBy('created_at', 'desc')->paginate(15);
        $users = User::get();
        $credits = CreditsUsage::get();
        return view('qualitychecker.qc-main-order', compact('orders', 'users', 'credits'));
    }

    public function ordersEdit($id){
        // $order = Orders::find($id);
        $order = SubOrder::find($id);
        $brands = BrandsProfile::get();
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        $creditsUsage = CreditsUsage::where('order_id', $order->order_id)->first();
        $users = user::get();
        return view('qualitychecker.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins', 'creditsUsage', 'users'));
    }

    public function qclist(){
        // $orders = Orders::where('status', ['Quality Checking'])->get();
        $orders = SubOrder::whereIn('status', ['Quality Checking', 'Completed'])->orderBy('created_at', 'desc')
        ->orderBy('status')
        ->get();

        return view('qualitychecker.quality-checkinglist', compact('orders'));
    }


    public function updateOrder(Request $request, $id){
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed,Rejected,Quality Checking',
            'completed_time' => 'string',
        ]);
    
        $order = SubOrder::findOrFail($id);
        $order->status = $request->status;
        $order->completed_at = $request->completed_time;
        $order->save();
    
        return back()->with('success', 'Status updated successfully!');
    }

    public function viewOrder($id){

        $user = auth()->user();

        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();

        // Subscribers can only view their own orders
        // $order = Orders::where('id', $id)->where('assigned_to', $user->id)->firstOrFail();

        $order = SubOrder::where('id', $id)->where('assigned_to', $user->id)->firstOrFail();

        $creditsUsage = CreditsUsage::where('order_id', $order->order_id)->first();

        return view('qualitychecker.orders.view-order', compact('order', 'subscribers', 'admins', 'creditsUsage'));
        
    }

    public function viewQcorders($id){
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        
        // Subscribers can only view their own orders
        // $order = Orders::where('id', $id)->firstOrFail();
        $order = SubOrder::where('id', $id)->firstOrFail();
        $creditsUsage = CreditsUsage::where('order_id', $order->order_id)->first();
        
        return view('qualitychecker.view-qcorders.view_qcorders', compact('order', 'subscribers', 'admins', 'creditsUsage'));
    }


    public function viewMainJob($id){
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        $creditsUsage = CreditsUsage::where('order_id', $id)->first();
        $order = Orders::where('id', $id)->firstOrFail();
        return view('qualitychecker.main-job.view-main-job', compact('order', 'subscribers', 'admins', 'creditsUsage'));
    }

    public function ajaxSearchQcList(Request $request)
    {
        $jobname = $request->input('jobname');
    
        $orders = SubOrder::whereIn('status', ['Quality Checking', 'Completed'])
            ->when($jobname, function ($query, $jobname) {
                $query->where(function ($q) use ($jobname) {
                    $q->where('job_id', 'like', "%{$jobname}%")
                      ->orWhere('project_title', 'like', "%{$jobname}%")
                      ->orWhere('request_type', 'like', "%{$jobname}%");
                });
            })
            ->get()
            ->map(function ($order) {
                $order->assigned_to_name = optional(\App\Models\User::find($order->assigned_to))->name;
                return $order;
            });
    
        return response()->json(['orders' => $orders]);
    }


    public function ajaxSearchQcMainJob(Request $request)
    {
        $jobname = $request->input('jobname');
        $status = $request->input('status');
    
        $orders = Orders::query()
            ->when($jobname, function ($query, $jobname) {
                $query->where(function ($q) use ($jobname) {
                    $q->where('order_id', 'like', "%{$jobname}%")
                      ->orWhere('project_title', 'like', "%{$jobname}%")
                      ->orWhere('request_type', 'like', "%{$jobname}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->get();
    
        // Attach created_by name
        $orders->transform(function ($order) {
            $order->created_by_name = optional(User::find($order->created_by))->name;
            return $order;
        });

    $orders = $orders->map(function ($order) {
        $order->credits = CreditsUsage::where('order_id', $order->id)->value('credits_used') ?? 0;
        return $order;
    });
    
        return response()->json(['orders' => $orders]);
    }



public function ajaxSearchQcJob(Request $request){
    $jobname = $request->input('jobname');
    $status = $request->input('status');
    $userId = auth()->id();

    $orders = SubOrder::query()
        ->where('assigned_to', $userId)
        ->when($jobname, function ($query, $jobname) {
            $query->where(function ($q) use ($jobname) {
                $q->where('job_id', 'like', "%{$jobname}%")
                  ->orWhere('project_title', 'like', "%{$jobname}%");
            });
        })
        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->orderBy('id', 'desc')
        ->get();

    // ✅ Preload all users related to these orders
    $userIds = $orders->pluck('assigned_to')->filter()->unique();
    $users = \App\Models\User::whereIn('id', $userIds)->get(['id', 'name']);

    return response()->json([
        'orders' => $orders,
        'users' => $users,
    ]);
}


public function qcEditMainJob($id){
    $order = Orders::findOrFail($id);
    $brands = BrandsProfile::get();
    $admins = user::where('role', ['admin', 'qualitychecker'])->get();
    $subscribers = User::where('role', 'subscriber')->get();
    $creditsUsage = CreditsUsage::where('order_id', $id)->first();
    return view('qualitychecker.main-job.edit-main-job', compact('order', 'brands', 'admins', 'subscribers', 'creditsUsage'));
}


public function updateMainOrder(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:Pending,In Progress,Completed,Rejected,Quality Checking',
        'completed_time' => 'string',
    ]);

    $order = Orders::findOrFail($id);
    $order->status = $request->status;
    $order->completed_at = $request->completed_time;
    $order->save();

    return back()->with('success', 'Status updated successfully!');
}
    
    
}
