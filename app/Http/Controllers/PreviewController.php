<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Preview;

class PreviewController extends Controller
{
 public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'job_id' => 'required|string|max:255',
            'image' => 'required|string', // Base64 image data
            'feedbacks' => 'required|json', // JSON string of annotations
        ]);

        try {
            // 1. Handle the image upload (base64 decode and save)
            $imageData = $request->input('image');
            // Remove "data:image/jpeg;base64," prefix
            $base64Image = Str::after($imageData, 'base64,');
            $decodedImage = base64_decode($base64Image);

            // Generate a unique filename
            $filename = 'previews/' . Str::uuid() . '.jpeg'; // Using UUID for uniqueness

            // Save the image to storage (e.g., storage/app/public/previews)
            Storage::disk('public')->put($filename, $decodedImage);

            // 2. Save data to the database
            $preview = Preview::create([
                'order_id' => $request->input('order_id'),
                'job_id' => $request->input('job_id'),
                'image_path' => $filename, // Store the path to the image
                'feedback' => $request->input('feedbacks'), // Store the JSON string
            ]);

            return response()->json([
                'message' => 'Preview saved successfully!',
                'preview' => $preview,
                'image_url' => Storage::url($filename) // Public URL to access the image
            ], 201); // 201 Created
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving preview: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Failed to save preview.', 'error' => $e->getMessage()], 500);
        }
    }



    public function fetch(Request $request)
{
    $orderId = $request->query('order_id');
    $jobId = $request->query('job_id');

    $previews = Preview::where('order_id', $orderId)
        ->where('job_id', $jobId)
        ->get();

    return response()->json($previews);
}

}




