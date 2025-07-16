<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandsProfile;
use App\Models\Orders;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\Transactions;
use App\Models\CreditsUsage;
use App\Models\SubOrder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod; 


class RouteController extends Controller
{
    public function home() {
        $ordersCount = Orders::where('created_by', Auth::id())->get()->count();
        $brandsCount = BrandsProfile::where('created_by', Auth::id())->get()->count();
        $currentUserCredits = Auth::user()->credits;
        $completedProjects = Orders::where('created_by', Auth::id())->where('status', 'Completed')->get()->count();
        $transactions = Transactions::where('user_id', Auth::id())->latest()->limit(3)->get();
        $completed = Orders::where('created_by', Auth::id())->where('status', 'completed')->count();
        $inProgress = Orders::where('created_by', Auth::id())->where('status', 'in progress')->count();
        $qualityChecking = Orders::where('created_by', Auth::id())->where('status', 'quality checking')->count();
        $pending = Orders::where('created_by', Auth::id())->where('status', 'pending')->count();
        $totalCreditsUsage = Auth::user()->getUsages()->sum('credits_used');

        $currentUser = Auth::user()->id;
        $orders = Orders::where('created_by', $currentUser)->whereIn('status', ['Pending', 'In Progress'])->get();
        $users = User::get();

        return view('subscribers.dashboard', compact( 'users', 'orders', 'currentUserCredits', 'totalCreditsUsage', 'brandsCount', 'ordersCount', 'completedProjects', 'transactions', 'completed', 'inProgress', 'pending', 'qualityChecking'));
    }

    public function billing() {
        $transactions = Transactions::where('user_id', Auth::id())->get();
        return view('subscribers.billing', compact('transactions'));
    }
    

    public function brandProfile(){
        $currentUser = auth()->user()->id; 
        $brands = BrandsProfile::where('created_by', $currentUser)->get();
        $count = BrandsProfile::where('created_by', $currentUser)->count();

        return view('subscribers.brandprofile', compact('brands', 'currentUser', 'count'));
    }

    public function viewBrand($id){
        $brand = BrandsProfile::findOrFail($id);
        return view('subscribers.branddetails.view-brand', compact('brand'));
    }

    public function editBrand($id){
        $brand = BrandsProfile::findOrFail($id);
        return view('subscribers.branddetails.edit-brand', compact('brand'));
    }

    public function brandForm() {
        return view('subscribers.branddetails.add-brand');
    }

    public function profile() {
        return view('subscribers.profile');
    }

    public function designBrief() {
        return view('subscribers.designbrief');
    }

    public function revisionTool() {
        return view('subscribers.revisiontool');
    }

    public function helpCenter() {
        return view('subscribers.helpcenter');
    }

    public function requests() {
        $currentUser = Auth::user()->id;
        $currentUserCredits = Auth::user()->credits;
        $orders = Orders::where('created_by', $currentUser)->orderBy('created_at', 'desc')->get();
        $completedOrders = Orders::where('created_by', $currentUser)->where('status', 'completed')->count();
        $credits = CreditsUsage::get();
        return view('subscribers.requests', compact('orders', 'currentUserCredits', 'completedOrders', 'credits'));
    }

    public function addOrder() {
        $currentUser = auth()->user()->id; 
        $brands = BrandsProfile::where('created_by', $currentUser)->get();  
        return view('subscribers.orders.add-order', compact('brands'));
    }

    public function viewOrder($id)
    {
        $user = auth()->user();
        $subscribers = User::where('role', 'subscriber')->get();
        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        $creditsUsage = CreditsUsage::where('order_id', $id)->first();
        // Superadmin can view all orders
        if ($user->role === 'superadmin') {
            $order = Orders::findOrFail($id);
            return view('subscribers.orders.view-order', compact('order', 'subscribers', 'admins', 'creditsUsage'));
        }
    
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)->where('created_by', $user->id)->firstOrFail();
    
        return view('subscribers.orders.view-order', compact('order', 'subscribers', 'admins', 'creditsUsage'));
    }


    public function editOrder($id)
    {
        $user = auth()->user();

        $brands = BrandsProfile::get();  
        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->get();
        // Superadmin can view all orders
        if ($user->role === 'superadmin') {
            $order = Orders::findOrFail($id);
            return view('superadmin.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins'));
        }
    
        // Subscribers can only view their own orders
        $order = Orders::where('id', $id)->where('created_by', $user->id)->firstOrFail();
    
        return view('subscribers.orders.edit-order', compact('order', 'brands'));
    }
    
    public function usage(Request $request) {
        $currentUser = (int) Auth::user()->id;
        $query = CreditsUsage::where('user_id', $currentUser);
    
        $from = $request->filled('from_date') ? Carbon::parse($request->from_date)->startOfDay() : null;
        $to = $request->filled('to_date') ? Carbon::parse($request->to_date)->endOfDay() : null;
    
        // Use OR logic for filtering
        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        } elseif ($from) {
            $query->where('created_at', '>=', $from);
        } elseif ($to) {
            $query->where('created_at', '<=', $to);
        }
    
        $usages = $query->get();
        $orders = Orders::where('created_by', $currentUser)->get();
    
        return view('subscribers.usage', compact('usages', 'orders'));
    }

    public function users() {
        return view('subscribers.users');
    }


    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }



    public function superadminDashboard() {
        $ordersCount = Orders::get()->count();
        $adminsCount = User::where('role', 'admin')->orWhere('role', 'qualitychecker')->count();
        $subscribersCount = User::where('role', 'subscriber')->count();
        $completedProjects = Orders::where('status', 'completed')->count();
        $transactions = Transactions::latest()->take(7)->get();
        $todayTotal = Transactions::whereDate('created_at', Carbon::today())->sum('amount_paid');
        $totalSales = Transactions::get()->sum('amount_paid');


         // Weekly Sales Chart (7-day line chart)
    $startDate = now()->subDays(6);
    $weeklyData = Transactions::whereBetween('created_at', [$startDate, now()])
        ->selectRaw('DATE(created_at) as date, SUM(amount_paid) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $weeklySales = [];
    $weeklyLabels = [];
    $startDate = Carbon::now()->subDays(6);
    $dates = CarbonPeriod::create($startDate, Carbon::now());


    foreach ($dates as $date) {
        $label = $date->format('D'); // e.g., Mon, Tue...
        $daily = $weeklyData->firstWhere('date', $date->format('Y-m-d'));
        $weeklyLabels[] = $label;
        $weeklySales[] = $daily ? $daily->total : 0;
    }


        return view('superadmin.superadmin-dashboard', compact('ordersCount', 'completedProjects', 'adminsCount', 'subscribersCount', 'transactions', 'todayTotal', 'totalSales', 'weeklyLabels', 'weeklySales'));
    }


    public function superadminOrders() {
        $orders = Orders::where('status', '!=', 'Draft')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        $users = User::get();
        $credits = CreditsUsage::get();
        return view('superadmin.orders', compact('orders', 'users', 'credits'));
    }
    

    public function superadminSubscribers(Request $request)
    {
        $query = User::where('role', 'subscriber');
    
        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('id', $request->user_id);
        }
    
        // Filter by from_date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // Filter by to_date
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $subscribers = $query->get();
        $users = User::where('role', 'subscriber')->get(); // for dropdown
    
        return view('superadmin.subscribers', compact('subscribers','users'));
    }
    

    public function adminsList(){
        $admins = User::where('role', 'admin')->orWhere('role', 'superadmin')->orWhere('role', 'qualitychecker')->get();
        return view('superadmin.admins', compact('admins'));
    }


    public function addAdminForm(){
        return view('superadmin.admins.add-admin');
    }


    public function adminDashboard()
    {
        $userId = Auth::user()->id;
    
        $totalOrders = SubOrder::where('assigned_to', $userId)->count();
        $completedOrders = SubOrder::where('status', 'Completed')->where('assigned_to', $userId)->count();
        $pendingOrders = SubOrder::whereIn('status', ['Pending', 'In Progress'])->where('assigned_to', $userId)->count();
        $rejectedOrders = SubOrder::where('status', 'Rejected')->where('assigned_to', $userId)->count();
    
        $orders = SubOrder::where('assigned_to', $userId)
            ->whereIn('status', ['Pending', 'In Progress'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        $users = User::all();
    
        return view('designers&admin.admin-dashboard', compact(
            'totalOrders',
            'completedOrders',
            'rejectedOrders',
            'pendingOrders',
            'orders',
            'users'
        ));
    }
    

    public function adminOrders(){
        $currentUser = Auth::user()->id;
        $orders = Orders::where('assigned_to', $currentUser)->orderBy('created_at', 'desc')->get();
        $users = User::get();
        return view( 'designers&admin.orders', compact( 'orders' , 'users' ) );
    }

    public function adminsubOrders(){
        $currentUser = Auth::user()->id;
        $orders = SubOrder::where('assigned_to', $currentUser)->orderBy('created_at', 'desc')->get();
        $users = User::get();
        return view( 'designers&admin.orders' , compact( 'orders' , 'users' ) );
    }

    public function superadminEnquires() {
        $enquiries = Enquiry::get();
        return view('superadmin.enquires', compact('enquiries'));
    }


}
