<?php

namespace App\Http\Controllers;
use App\Models\BrandsProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BrandsProfileController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'brand_date' => 'required|date',
        'brand_name' => 'required|string|max:255',
        'industry' => 'required|string|max:255',
        'other_industry' => 'nullable|string|max:255',
        'web_address' => 'nullable|url|max:255',
        'brand_audience' => 'required|string|max:255',
        'brand_description' => 'nullable|string|max:255',
        'logo' => 'nullable|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
        'color_codes' => 'nullable|string|max:255',
        'fonts' => 'nullable|string|max:255',
        'brand_guide' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        'additional_assets' => 'nullable|file|mimes:pdf,doc,docx|max:10000',
    ]);

    $currentUser = auth()->user()->id; 
    $count = BrandsProfile::where('created_by', $currentUser)->count();



    if($count < 10){
    $brand = new BrandsProfile();
    $brand->brand_date = $request->brand_date;
    $brand->brand_name = $request->brand_name;
    $brand->industry = $request->industry;
    $brand->other_industry = $request->other_industry;
    $brand->web_address = $request->web_address;
    $brand->brand_audience = $request->brand_audience;
    $brand->brand_description = $request->brand_description;

    // File uploads
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $originalName = $file->getClientOriginalName(); // e.g., "logo.png"
    
        // Optional: sanitize the filename or prepend timestamp to avoid overwriting
        $filename = time() . '_' . $originalName;
    
        // Save with original filename in 'public/logos'
        $file->storeAs('logos', $filename, 'public');
    
        // Save the path in DB
        $brand->logo = 'logos/' . $filename;
    }
    

    if ($request->hasFile('brand_guide')) {
        $file = $request->file('brand_guide');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' .  $originalName;
        $file->storeAs('brand_guides', $filename, 'public');
        $brand->brand_guide = 'brand_guides/' . $filename;
    }
    
    if ($request->hasFile('additional_assets')) {
        $file = $request->file('additional_assets');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . $originalName;
        $file->storeAs('assets', $filename, 'public');
        $brand->additional_assets = 'assets/' . $filename;
    }
    

    $brand->color_codes = $request->color_codes;
    $brand->fonts = $request->fonts;
    $brand->created_by = Auth::id(); // or any other identifier you use
    $brand->save();

    return redirect()->route('brandprofile')->with('success', 'Brand profile created successfully.');

  }else{
    return redirect()->route('brandprofile')->with('alert', 'You have reached the maximum limit of 10 brand profiles.');
  }
}



public function updateBrand(Request $request, $id)
{
    $request->validate([
        'brand_date' => 'required|date',
        'brand_name' => 'required|string|max:255',
        'industry' => 'required|string|max:255',
        'other_industry' => 'nullable|string|max:255',
        'web_address' => 'nullable|url|max:255',
        'brand_audience' => 'required|string|max:255',
        'brand_description' => 'nullable|string|max:255',
        'logo' => 'nullable|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
        'color_codes' => 'nullable|string|max:255',
        'fonts' => 'nullable|string|max:255',
        'brand_guide' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        'additional_assets' => 'nullable|file|mimes:pdf,doc,docx|max:10000',
    ]);

    $brand = BrandsProfile::findOrFail($id);

    $brand->brand_date = $request->brand_date;
    $brand->brand_name = $request->brand_name;
    $brand->industry = $request->industry;
    $brand->other_industry = $request->other_industry;
    $brand->web_address = $request->web_address;
    $brand->brand_audience = $request->brand_audience;
    $brand->brand_description = $request->brand_description;
    $brand->color_codes = $request->color_codes;
    $brand->fonts = $request->fonts;

    // Replace logo
    if ($request->hasFile('logo')) {
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('logos', $filename, 'public');
        $brand->logo = 'logos/' . $filename;
    }

    // Replace brand guide
    if ($request->hasFile('brand_guide')) {
        if ($brand->brand_guide && Storage::disk('public')->exists($brand->brand_guide)) {
            Storage::disk('public')->delete($brand->brand_guide);
        }
        $file = $request->file('brand_guide');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('brand_guides', $filename, 'public');
        $brand->brand_guide = 'brand_guides/' . $filename;
    }

    // Replace additional assets
    if ($request->hasFile('additional_assets')) {
        if ($brand->additional_assets && Storage::disk('public')->exists($brand->additional_assets)) {
            Storage::disk('public')->delete($brand->additional_assets);
        }
        $file = $request->file('additional_assets');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('assets', $filename, 'public');
        $brand->additional_assets = 'assets/' . $filename;
    }

    $brand->save();

    return redirect()->route('brandprofile')->with('success', 'Brand profile updated successfully.');
}


public function deleteBrand($id){
    $brand = BrandsProfile::findOrFail($id);
    $brand->delete();
    return redirect()->route('brandprofile')->with('deleted', 'Brand profile deleted successfully.');
}



public function searchBrand(Request $request)
{
    $brands = BrandsProfile::where('created_by', auth()->id())
        ->where('brand_name', 'like', '%' . $request->brandname . '%')
        ->get();

    return response()->json([
        'brands' => $brands,
    ]);
}



}
