<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditsUsage;
use App\Models\Orders;
use App\Models\SubOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mail;
use App\Mail\JobAssignedToDesignerMail;
use RealRashid\SweetAlert\Facades\Alert;


class CreditsUsageController extends Controller
{
    use SoftDeletes;

public function store(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'complexity' => 'required|array',
    ]);

    $order = Orders::findOrFail($request->order_id);

    $complexities = $request->input('complexity');
    $customCredits = $request->input('custom_credits', []);
    $designer = $request->input('designer', []);
    $totalCredits = 0;
    $imageDescriptions = [];
   

    $creditValues = [
        'S' => ['label' => 'Simple', 'credits' => 5],
        'M' => ['label' => 'Medium', 'credits' => 10],
        'C' => ['label' => 'Complex', 'credits' => 15],
        'SC' => ['label' => 'Super Complex', 'credits' => 20],
    ];

    $images = json_decode($order->reference_files, true); // array of images

    $duration = $order->duration ?? 18; // Default to standard delivery time if not set

    foreach ($complexities as $index => $value) {
        if ($value === 'custom') {
            $credits = isset($customCredits[$index]) ? (int)$customCredits[$index] : 0;
            $label = "Custom";
        } else {
            $credits = $creditValues[$value]['credits'] ?? 0;
            $label = $creditValues[$value]['label'] ?? 'Unknown';
        }


    // ⬇️ Additional or Discount logic based on duration
    $forEachCredits = 0;
    if ($duration <= 1) {
        $forEachCredits = 5;
    } elseif ($duration <= 2) {
        $forEachCredits = 4;
    } elseif ($duration <= 4) {
        $forEachCredits = 3;
    } elseif ($duration <= 8) {
        $forEachCredits = 2;
    } elseif ($duration <= 12) {
        $forEachCredits = 1;
    } elseif ($duration == 18) {
        $forEachCredits = 0; // Standard
    } elseif ($duration == 24) {
        $forEachCredits = -0.05 * $credits;
    } elseif ($duration == 48) {
        $forEachCredits = -0.06 * $credits;
    } elseif ($duration == 72) {
        $forEachCredits = -0.07 * $credits;
    } elseif ($duration == 96) {
        $forEachCredits = -0.08 * $credits;
    } elseif ($duration == 120) {
        $forEachCredits = -0.09 * $credits;
    } elseif ($duration == 144) {
        $forEachCredits = -0.10 * $credits;
    } elseif ($duration == 168) {
        $forEachCredits = -0.11 * $credits;
    } elseif ($duration == 192) {
        $forEachCredits = -0.12 * $credits;
    }

    
        $totalCredits += $credits + $forEachCredits;
    
        $imageDescriptions[] = [
            'path' => $images[$index]['path'] ?? '',
            'original_name' => $images[$index]['original_name'] ?? 'Image',
            'credits' => $credits,
            'label' => $label,
            'designer_id' => $designer[$index] ?? null, // new line
            'each_credits' => $forEachCredits,
        ];
    }
    

    $credits = CreditsUsage::create([
        'user_id' => $order->created_by,
        'order_id' => $order->id,
        'job_id' => $order->order_id,
        'credits_used' => $totalCredits,
        'description' => json_encode($imageDescriptions),
        'status' => 'pending',
        'for_each_credits' => $forEachCredits,
    ]);

////////////////////////////////////////

    // // 1. Group images by designer
    // $groupedByDesigner = [];

    // foreach ($imageDescriptions as $img) {
    //     $designerId = $img['designer_id'];
    //     if (!$designerId) continue; // Skip if no designer selected

    //     $groupedByDesigner[$designerId][] = $img;
    // }

    // // 2. Create sub_orders for each designer
    // $subOrderIndex = 1;

    // foreach ($groupedByDesigner as $designerId => $imagesGroup) {
    //     $imagePaths = array_map(fn($img) => $img['path'], $imagesGroup);

    //     SubOrder::create([
    //         'order_id' => $order->id,
    //         'credits_bd_id' => $credits->id,
    //         'job_id' => $order->order_id,
    //         'project_title' => $order->project_title,
    //         'request_type' => $order->request_type,
    //         'sub_services' => $order->sub_services,
    //         'duration' => $order->duration,
    //         'instructions' => $order->instructions,
    //         'admin_notes' => $order->admin_notes,
    //         'colors' => $order->colors,
    //         'size' => $order->size,
    //         'other_size' => $order->other_size,
    //         'formats' => $order->formats,
    //         'reference_files' => json_encode($imagePaths),
    //         'assigned_to' => $designerId,
    //         'status' => 'pending',
    //     ]);

    //     $subOrderIndex++;
    // }

///////////////////////////////////////////

      $order->status="Quoted";
      $order->save();


    return back()->with('success', 'Credits usage with image details submitted.');
}



public function approve(Orders $order)
{
    // 1. Check if credits usage exists
    $creditsUsage = CreditsUsage::where('order_id', $order->id)->first();

    if (!$creditsUsage) {
        return back()->with('error', 'No credits usage found for this order.');
    }

    // 2. Only allow the creator or superadmin to approve
    if (auth()->id() !== $order->created_by && auth()->user()->role !== 'superadmin') {
        abort(403);
    }

    // 3. Fetch user who placed the order
    $user = User::find($order->created_by);

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    // 4. Check credit balance
    if ($user->credits < $creditsUsage->credits_used) {

        Alert::alert('Insufficient Credits', 'You do not have enough credits to perform this action.', 'warning');
        return back()->with('error', 'Insufficient credits.');
    }

    // 5. Deduct credits and mark as approved
    $user->credits -= $creditsUsage->credits_used;
    $user->save();
    
    $order = Orders::findOrFail($order->id);
    $order->status = 'Quote Approved';
    $order->save();

    $creditsUsage->status = 'approved';
    $creditsUsage->save();
    Alert::success('Quote Accepted Successfully', 'Your action was completed.');

    // 6. Notify designers assigned to suborders
    $suborders = SubOrder::where('job_id', $order->order_id)->get();

    foreach ($suborders as $suborder) {
        if ($suborder->assigned_to) {
            $designer = User::find($suborder->assigned_to);

            if ($designer && $designer->email) {
                Mail::to($designer->email)->send(new JobAssignedToDesignerMail($suborder));
            }
        }
    }

    return back()->with('success', "Ratings approved. {$creditsUsage->credits_used} credits deducted from {$user->name}.");
}

public function destroy(CreditsUsage $usage)
{
    $user = auth()->user();
    $isSuperAdmin = $user && $user->role === 'superadmin';

    if ($user->id !== $usage->user_id && !$isSuperAdmin) {
        abort(403);
    }

    $usage->delete(); // ✅ delete the model directly

    return back()->with('success', 'Rating deleted successfully.');
}



public function requote($orderId){
     // 1. Check if credits usage exists
     $creditsUsage = CreditsUsage::where('order_id', $orderId)->first();
     $orderStatus = Orders::where('id', $orderId)->first();

     $orderStatus->status = 'Requote';
     $orderStatus->save();

     $creditsUsage->status = 'requote';
     $creditsUsage->save();
     
    return back()->with('success', 'Requote request send successfully.');
}



public function update(Request $request, $id)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'complexity' => 'required|array',
    ]);

    $creditsUsage = CreditsUsage::findOrFail($id);
    $order = Orders::findOrFail($request->order_id);

    $complexities = $request->input('complexity');
    $customCredits = $request->input('custom_credits', []);
    $designer = $request->input('designer', []);
    $totalCredits = 0;
    $imageDescriptions = [];

    $creditValues = [
        'S' => ['label' => 'Simple', 'credits' => 5],
        'M' => ['label' => 'Medium', 'credits' => 10],
        'C' => ['label' => 'Complex', 'credits' => 15],
        'SC' => ['label' => 'Super Complex', 'credits' => 20],
    ];

    $images = json_decode($order->reference_files, true) ?? [];

    $duration = $order->duration ?? 18;

    foreach ($complexities as $index => $value) {
        if ($value === 'custom') {
            $credits = isset($customCredits[$index]) ? (int)$customCredits[$index] : 0;
            $label = "Custom";
        } else {
            $credits = $creditValues[$value]['credits'] ?? 0;
            $label = $creditValues[$value]['label'] ?? 'Unknown';
        }

        // Duration-based adjustment
        $forEachCredits = 0;
        if ($duration <= 1) {
            $forEachCredits = 5;
        } elseif ($duration <= 2) {
            $forEachCredits = 4;
        } elseif ($duration <= 4) {
            $forEachCredits = 3;
        } elseif ($duration <= 8) {
            $forEachCredits = 2;
        } elseif ($duration <= 12) {
            $forEachCredits = 1;
        } elseif ($duration == 18) {
            $forEachCredits = 0;
        } elseif ($duration == 24) {
            $forEachCredits = -0.05 * $credits;
        } elseif ($duration == 48) {
            $forEachCredits = -0.06 * $credits;
        } elseif ($duration == 72) {
            $forEachCredits = -0.07 * $credits;
        } elseif ($duration == 96) {
            $forEachCredits = -0.08 * $credits;
        } elseif ($duration == 120) {
            $forEachCredits = -0.09 * $credits;
        } elseif ($duration == 144) {
            $forEachCredits = -0.10 * $credits;
        } elseif ($duration == 168) {
            $forEachCredits = -0.11 * $credits;
        } elseif ($duration == 192) {
            $forEachCredits = -0.12 * $credits;
        }

        $totalCredits += $credits + $forEachCredits;

        $imageDescriptions[] = [
            'path' => $images[$index]['path'] ?? '',
            'original_name' => $images[$index]['original_name'] ?? 'Image',
            'credits' => $credits,
            'label' => $label,
            'designer_id' => $designer[$index] ?? null,
            'each_credits' => $forEachCredits,
        ];
    }

    // Update CreditsUsage
    $creditsUsage->update([
        'credits_used' => round($totalCredits, 2),
        'description' => json_encode($imageDescriptions),
        'status' => 'pending',
        'for_each_credits' => $forEachCredits,
    ]);

    // Update order status
    $order->status = "Quoted";
    $order->save();

    return back()->with('success', 'Credits usage successfully updated.');
}





}
