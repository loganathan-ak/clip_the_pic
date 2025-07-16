<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\CreditsUsage;
use Mail;
use App\Mail\JobCreatedMail;
use App\Mail\JobCreatedForAdminMail;


class OrdersController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'request_type' => 'required|string',
        'sub_services' => 'required|string',
        'instructions' => 'nullable|string',
        'colors' => 'nullable|string',
        'size' => 'nullable|string',
        'other_size' => 'nullable|string',
        'duration' => 'required|string',
        'software' => 'nullable|string',
        'other_software' => 'nullable|string',
        'brand_profile_id' => 'nullable|exists:brands_profiles,id',
        // 'formats' => 'nullable|array',
        'formats' => 'nullable|string',
        // 'pre_approve' => 'nullable|numeric|min:0',
        'reference_files.*' => 'nullable|file|mimes:jpg,jpeg,png,ai,psd,eps,svg,webp|max:10240',
        'rush' => 'nullable',
        'status' => 'nullable|string',
    ]);

   $rush = $request->has('rush') ? 1 : 0;

    $uploadedFiles = [];

    if ($request->hasFile('reference_files')) {
        foreach ($request->file('reference_files') as $file) {
            $originalName = $file->getClientOriginalName(); // e.g. design1.png
            $extension = $file->getClientOriginalExtension();

            // Optionally preserve the original name
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $storedPath = $file->storeAs('reference_files', $filename . '.' . $extension, 'public');

            $uploadedFiles[] = [
                'path' => $storedPath,
                'original_name' => $originalName,
            ];
        }
    }


   

    // Create order
    $order = Orders::create([
        'project_title' => $validated['title'],
        'request_type' => $validated['request_type'],
        'sub_services' => $validated['sub_services'],
        'instructions' => $validated['instructions'] ?? null,
        'colors' => $validated['colors'] ?? null,
        'size' => $validated['size'] ?? null,
        'other_size' => $validated['other_size'] ?? null,
        'duration' => $validated['duration'] ?? null,
        'software' => $validated['software'] ?? null,
        'other_software' => $validated['other_software'] ?? null,
        'brands_profile_id' => $validated['brand_profile_id'],
        'formats' => isset($validated['formats']) ? json_encode($validated['formats']) : null,
        'pre_approve' =>  null,
        'reference_files' => !empty($uploadedFiles) ? json_encode($uploadedFiles) : null,
        'rush' => $rush,
        'created_by' => Auth::id(),
        'obeth_id' => null, // Auto generate unique ID
        'status' => $validated['status'],
    ]);

      // Step 2: Generate unique order_id like JOB-101
      $lastOrder = Orders::whereNotNull('order_id')->orderByDesc('id')->first();
      $lastNumber = 100; // start from 101
  
      if ($lastOrder && preg_match('/JOB-(\d+)/', $lastOrder->order_id, $matches)) {
          $lastNumber = (int)$matches[1];
      }
  
      $newOrderId = 'JOB-' . ($lastNumber + 1);
  
      $order->order_id = $newOrderId;
      $order->save();

      Alert::success('Success', 'Job ID : ' . $order->order_id . ' created successfully.');

    Mail::to(Auth::user()->email)->send(new JobcreatedMail($order));

    $admin = User::where('role', 'superadmin')->first();

    if ($admin) {
        Mail::to($admin->email)->send(new JobCreatedForAdminMail($order));
    }

    return redirect()->route('requests')->with('success', 'Order created successfully.');
}



public function searchJob(Request $request)
{
    $query = Orders::where('created_by', auth()->id());

    if ($request->filled('jobname')) {
        $query->where(function ($q) use ($request) {
            $q->where('project_title', 'like', '%' . $request->jobname . '%')
              ->orWhere('order_id', 'like', '%' . $request->jobname . '%');
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $orders = $query->latest()->get();

    // Get only credits that match returned orders
    $orderIds = $orders->pluck('id');
    $credits = CreditsUsage::whereIn('order_id', $orderIds)->get();

    return response()->json([
        'orders' => $orders,
        'credits' => $credits,
    ]);
}






}
