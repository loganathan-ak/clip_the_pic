<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Plans;
use App\Models\Orders;
use App\Models\CreditsUsage;
use Carbon\Carbon;


class ReportsControllers extends Controller
{
    
    public function index(Request $request)
    {
        $query = Transactions::query();
    
        // Date filters
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        } elseif ($request->filled('from_date')) {
            $query->where('created_at', '>=', Carbon::parse($request->from_date)->startOfDay());
        } elseif ($request->filled('to_date')) {
            $query->where('created_at', '<=', Carbon::parse($request->to_date)->endOfDay());
        }
    
        // User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
    
        // Clone the query before pagination for totals
        $totalsQuery = clone $query;
        $totalCredits = $totalsQuery->sum('credits_purchased');
        $totalAmount = $totalsQuery->sum('amount_paid');
    
        $transactions = $query->latest()->paginate(20);
        $users = User::where('role', 'subscriber')->get();
        $plans = Plans::all();
    
        return view('superadmin.transaction-report', compact('transactions', 'users', 'plans', 'totalCredits', 'totalAmount'));
    }
    



    public function jobsReport(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $userId = $request->get('user_id');
    
        $query = Orders::query();
    
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay(),
            ]);
        } elseif ($fromDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($fromDate));
        } elseif ($toDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($toDate));
        }
    
        if ($userId) {
            $query->where('created_by', $userId); // or 'user_id' if the field is named differently
        }
    
        $jobs = $query->with('subOrders')->latest()->get();
    
        $users = User::get();
        
        return view('superadmin.jobs-report', compact('jobs', 'users'));
    }
    


public function usageReport(Request $request)
{
    $query = CreditsUsage::query();

    $query->where(function ($q) use ($request) {
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $q->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay(),
            ]);
        } elseif ($request->filled('from_date')) {
            $q->where('created_at', '>=', Carbon::parse($request->from_date)->startOfDay());
        } elseif ($request->filled('to_date')) {
            $q->where('created_at', '<=', Carbon::parse($request->to_date)->endOfDay());
        }
    });

    $usages = $query->latest()->get();
    $orders = Orders::get();
    $totalCreditsUsed = $usages->sum('credits_used');

    return view('superadmin.credits-usage-report', compact('usages', 'orders', 'totalCreditsUsed'));
}

}
