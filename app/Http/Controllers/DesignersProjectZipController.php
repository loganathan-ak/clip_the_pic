<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DesignersProjectZip;
use Illuminate\Support\Facades\Storage;

class DesignersProjectZipController extends Controller
{
    public function upload(Request $request)
{
    $request->validate([
        'order_id' => 'required|string',
        'job_id' => 'required|string',
        'project_zip' => 'required|mimes:zip|max:102400', // 100MB max
    ]);

    // Store the file
    $path = $request->file('project_zip')->store('designerszip', 'public');

    // Optional: Delete old zip if replacing
    DesignersProjectZip::where('order_id', $request->order_id)
        ->where('job_id', $request->job_id)
        ->delete();

    // Save record to DB
    DesignersProjectZip::create([
        'order_id' => $request->order_id,
        'job_id' => $request->job_id,
        'file_path' => $path,
    ]);

    return back()->with('success', 'ZIP file uploaded successfully.');
}

public function download($id)
{
    $zip = DesignersProjectZip::findOrFail($id);

    if (!Storage::disk('public')->exists($zip->file_path)) {
        return back()->with('error', 'File not found.');
    }

    return Storage::disk('public')->download($zip->file_path);
}
}
