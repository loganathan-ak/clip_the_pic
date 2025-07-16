<?php

namespace App\Http\Controllers;
use App\Models\Plans;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plans::where('is_active', true)->orderBy('price')->get();
        return view('plans', compact('plans'));
    }

    public function edit($id)
{
    $plan = Plans::findOrFail($id);
    return view('superadmin.plans.edit-plan', compact('plan'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'credits' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'is_active' => 'nullable|boolean',
    ]);

    $plan = Plans::findOrFail($id);
    $plan->update([
        'name' => $validated['name'],
        'credits' => $validated['credits'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()->route('plans.list')->with('success', 'Plan updated successfully!');
}


public function create(){
    return view('superadmin.plans.create-plan');
}


public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'credits' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'is_active' => 'nullable|boolean',
    ]);

    Plans::create([
        'name' => $validated['name'],
        'credits' => $validated['credits'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()->route('plans.list')->with('success', 'Plan created successfully!');
}



public function destroy(Plans $plan)
{
    // Add authorization check here if needed, e.g., $this->authorize('delete', $plan);
    $plan->delete();
    return redirect()->route('plans.list')->with('success', 'Plan deleted successfully!');
}
}
