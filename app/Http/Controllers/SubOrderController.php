<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\SubOrder;
use App\Models\CreditsUsage; // Make sure to import this if not already
use Illuminate\Http\Request;

class SubOrderController extends Controller
{
    public function store(Request $request, $orderId)
    {
        // No need to validate 'selected' as it's not directly submitted.
        // We'll rely on 'process_image' and 'designer'
        $request->validate([
            'designer' => 'required|array',
            'designer.*' => 'nullable|exists:users,id', // Validate each designer ID
            'file_path' => 'required|array',
            'original_name' => 'required|array',
            'credits' => 'required|array',
            'process_image' => 'required|array', // Ensure this array is present
            'process_image.*' => 'in:0,1', // Ensure values are 0 or 1
        ]);

        $order = Orders::findOrFail($orderId);
        $creditsUsage = CreditsUsage::where('order_id', $orderId)->firstOrFail();

        // Group images by designer ID
        $groupedImages = [];

        foreach ($request->process_image as $index => $shouldProcess) {
            // Only process if the hidden input 'process_image' for this index is '1'
            // AND a designer is actually selected for this image.
            $designerId = $request->designer[$index] ?? null;

            if ($shouldProcess == '1' && $designerId) {
                $groupedImages[$designerId][] = [
                    'path' => $request->file_path[$index],
                    'original_name' => $request->original_name[$index],
                    'credits' => $request->credits[$index],
                ];
            }
        }

        if (empty($groupedImages)) {
            return redirect()->back()->with('error', 'No images selected or no designers assigned for selected images.')->withInput();
        }

        foreach ($groupedImages as $designerId => $images) {
            $subOrder = new SubOrder();
            $subOrder->credits_bd_id = $creditsUsage->id;
            $subOrder->order_id = $order->id;
            $subOrder->job_id = $order->order_id;
            $subOrder->project_title = $order->project_title;
            $subOrder->request_type = $order->request_type;

            $subOrder->sub_services = $order->sub_services;
            $subOrder->duration = $order->duration;
            $subOrder->instructions = $order->instructions;
            $subOrder->admin_notes = $order->admin_notes;
            $subOrder->colors = $order->colors;
            $subOrder->size = $order->size;
            $subOrder->other_size = $order->other_size;
            $subOrder->formats = $order->formats;

            $subOrder->reference_files = json_encode($images);
            $subOrder->assigned_to = $designerId;
            $subOrder->status = 'pending';

            $subOrder->save();
        }

        return redirect()->back()->with('success', 'Sub orders created by designer successfully.');
    }
}