<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\SubOrder;
use App\Models\Transactions;
use App\Models\CreditsUsage;
use App\Models\Plans;
use Illuminate\Support\Facades\Hash;


class SuperadminController extends Controller
{

    public function createAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,superadmin,qualitychecker',
        ]);
    
        $latestId = User::max('obeth_id');
        $nextNumber = $latestId ? intval(str_replace('OBE-', '', $latestId)) + 1 : 1000;
    
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'obeth_id' => 'OBE-' . $nextNumber,
        ]);
    
        return redirect()->route('superadmin.admins')->with('success', 'Admin user created successfully.');
    }


    public function deleteAdmin($id)
    {
        $admin = User::where('id', $id)
                     ->whereIn('role', ['admin', 'superadmin'])
                     ->firstOrFail();
    
        $admin->delete();
    
        return redirect()->route('superadmin.admins')->with('success', 'Admin deleted successfully.');
    }
    
    public function updateOrder(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'request_type' => 'required|string',
            'other_request_type' => 'nullable|string',
            'instructions' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'colors' => 'nullable|string',
            'size' => 'nullable|string',
            'other_size' => 'nullable|string',
            'software' => 'nullable|string',
            'other_software' => 'nullable|string',
            'brand_profile_id' => 'nullable|exists:brands_profiles,id',
            'formats' => 'nullable|array',
            'pre_approve' => 'nullable|numeric|min:0',
            'reference_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,ai,psd,eps|max:10240',
            'rush' => 'nullable',
            'assigned_to' => 'nullable',
            'status' => 'string',
            'duration' => 'nullable|string',
        ]);
    
        $order = Orders::findOrFail($id);
    
        $rush = $request->has('rush') ? 1 : 0;
    
        // Handle file uploads (append to existing)
        $uploadedFiles = [];
        if ($request->hasFile('reference_files')) {
            foreach ($request->file('reference_files') as $file) {
                $uploadedFiles[] = [
                    'path' => $file->store('reference_files', 'public'),
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
    
            // Merge with existing reference files (if needed)
            if ($order->reference_files) {
                $existingFiles = json_decode($order->reference_files, true);
                $uploadedFiles = array_merge($existingFiles, $uploadedFiles);
            }
        }
    
        // Update order
        $order->update([
            'project_title' => $validated['title'],
            'request_type' => $validated['request_type'],
            'other_request_type' => $validated['other_request_type'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'colors' => $validated['colors'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'size' => $validated['size'] ?? null,
            'other_size' => $validated['other_size'] ?? null,
            'software' => $validated['software'] ?? null,
            'other_software' => $validated['other_software'] ?? null,
            'brands_profile_id' => $validated['brand_profile_id'],
            'formats' => isset($validated['formats']) ? json_encode($validated['formats']) : null,
            'pre_approve' => $validated['pre_approve'] ?? null,
            'reference_files' => !empty($uploadedFiles) ? json_encode($uploadedFiles) : $order->reference_files,
            'rush' => $rush,
            'assigned_to' => $validated['assigned_to'],
            'status' => $validated['status'],
        ]);

        $suborders = SubOrder::where('order_id', $order->id)->get();

        foreach($suborders as $suborder){
            $suborder->duration = $validated['duration'] ?? null;
            $suborder->save();
        }
    
        return redirect()->route('superadmin.orders')->with('success', 'Order updated successfully.');
    }
    

    public function updateAdminform($id){
        $admin = User::findOrFail($id);
        return view('superadmin.admins.edit-admin', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
{
    $admin = User::findOrFail($id); // Assuming you're using the User model

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        'password' => 'nullable|string|min:6',
        'role' => 'required|in:admin,superadmin,qualitychecker',
    ]);

    $admin->name = $validated['name'];
    $admin->email = $validated['email'];
    $admin->role = $validated['role'];

    // Update password only if filled
    if (!empty($validated['password'])) {
        $admin->password = bcrypt($validated['password']);
    }

    $admin->save();

    return redirect()->route('superadmin.admins')->with('success', 'Admin updated successfully.');
}

    public function reportsPage(){
        $transactionTotal = Transactions::sum('amount_paid');
        $totalOrders = Orders::get()->count();
        $totalCreditsUsed = CreditsUsage::get()->sum('credits_used');
        return view('superadmin.reports', compact('transactionTotal', 'totalOrders', 'totalCreditsUsed'));
    }


    public function searchEnquiry(Request $request)
    {
        $query = $request->input('query');
    
        $enquiries = Enquiry::where('name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%")
                            ->orWhere('phone', 'like', "%{$query}%")
                            ->get();
    
        return response()->json([
            'enquiries' => $enquiries,
        ]);
    }


    public function subOrders(){
        $orders = SubOrder::orderBy('created_at', 'desc')->get();
        $users = User::get();
        $credits = CreditsUsage::get();
        return view('superadmin.sub-orders', compact('orders', 'users', 'credits'));
    }

    public function viewsubOrdres($id){
        $order = SubOrder::findOrFail($id);
        $admins = User::get();
        $creditsUsage = CreditsUsage::where('order_id', $order->order_id)->first();
        return view('superadmin.sub-order.view-suborder', compact('order', 'admins', 'creditsUsage'));
    }
    
public function searchJob(Request $request)
{
    $query = Orders::query();

    // Apply job name filter
    if ($request->filled('jobname')) {
        $query->where(function ($q) use ($request) {
            $q->where('project_title', 'like', '%' . $request->jobname . '%')
              ->orWhere('order_id', 'like', '%' . $request->jobname . '%');
        });
    }

    // Apply status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // First, get the results
    $orders = $query->latest()->get();

    // Then map over the result to add credits
    $orders = $orders->map(function ($order) {
        $order->credits = CreditsUsage::where('order_id', $order->id)->value('credits_used') ?? 0;
        return $order;
    });

    return response()->json(['orders' => $orders]);
}
 


   public function searchsubJob(Request $request)
   {
       $query = SubOrder::with('assignedUser'); // eager load the user
   
       if ($request->filled('jobname')) {
           $query->where(function ($q) use ($request) {
               $q->where('project_title', 'like', '%' . $request->jobname . '%')
                 ->orWhere('job_id', 'like', '%' . $request->jobname . '%');
           });
       }
   
       if ($request->filled('status')) {
           $query->where('status', $request->status);
       }
   
       $orders = $query->latest()->get();
       $users = User::get();
   
       // Attach assigned_to_name manually
       $orders->each(function ($order) {
           $order->assigned_to_name = $order->assignedUser->name ?? null;
       });
   
       return response()->json([
           'orders' => $orders,
           'users' => $users
       ]);
   }
   


    public function superadminDashboardLink($status){
        $orders = Orders::where('status', $status)->get();
        $users = User::get();
        return view('superadmin.orders', compact('orders', 'users'));

    }



    public function Plans(){
        $plans = Plans::where('is_active', true)->get();
        return view('superadmin.plans', compact('plans') );
    }

}
