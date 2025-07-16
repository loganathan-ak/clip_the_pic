<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectZip;
use Illuminate\Support\Facades\Storage;


class ProjectzipController extends Controller
{
    public function projectZip(Request $request)
{
    $request->validate([
        'project_zip' => 'required|mimes:zip|max:102400',
        'order_id' => 'required',
        'job_id' => 'required',
    ]);

    $existing = ProjectZip::where('order_id', $request->order_id)
                          ->where('job_id', $request->job_id)
                          ->first();

    // Delete old file if exists
    if ($existing && Storage::disk('public')->exists($existing->file_path)) {
        Storage::disk('public')->delete($existing->file_path);
    }

    // Upload new file
    $file = $request->file('project_zip');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('project_uploads', $filename, 'public');

    // Insert or update DB
    if ($existing) {
        $existing->file_path = $path;
        $existing->save();
    } else {
        ProjectZip::create([
            'order_id' => $request->order_id,
            'job_id' => $request->job_id,
            'file_path' => $path,
        ]);
    }

    return back()->with('success', 'ZIP file uploaded successfully.');
}


public function download($id)
{
    $zip = ProjectZip::findOrFail($id);

    if (!Storage::disk('public')->exists($zip->file_path)) {
        return back()->with('error', 'File not found.');
    }

    return Storage::disk('public')->download($zip->file_path);
}
}
