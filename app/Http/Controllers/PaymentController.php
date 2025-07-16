<?php

namespace App\Http\Controllers;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Plans;
use App\Models\Transactions;

class PaymentController extends Controller
{


  public function createPayment(Request $request){
    // ✅ Validate required fields (if needed)
    $request->validate([
        'plan_id' => 'required|exists:plans,id',
    ]);

 
    $plan = \App\Models\Plans::findOrFail($request->plan_id);

    $plan = Plans::findOrFail($request->plan_id);
    session(['plan_id' => $request->plan_id]);

    // 🟦 Setup PayPal provider
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalToken = $provider->getAccessToken();

    // 🧾 Create PayPal Order
    $response = $provider->createOrder([
        "intent" => "CAPTURE",
        "purchase_units" => [
            [
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($plan->price, 2, '.', '')
                ]
            ]
        ],
        "application_context" => [
            "return_url" => route('paypal.success'),
            "cancel_url" => route('paypal.cancel'),
        ]
    ]);

    // 🔗 Redirect to PayPal approval URL
    if (isset($response['id']) && $response['status'] === 'CREATED') {
        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }
    }

    return redirect()->route('subscribers.dashboard')->with('error', 'Something went wrong. Please try again.');
   }





    public function paymentSuccess(Request $request){
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();
    $response = $provider->capturePaymentOrder($request->token);

    if ($response['status'] === 'COMPLETED') {

        $planId = session('plan_id'); // Store plan_id in session before redirecting
        $plan = Plans::findOrFail($planId);

        Transactions::create([
            'user_id' => auth()->id(),
            'plan_id' => $planId,
            'credits_purchased' => $plan->credits,
            'amount_paid' => $plan->price,
            'payment_method' => 'paypal',
            'transaction_id' => $response['id'],
        ]);

        // Optionally update user's credits
        auth()->user()->increment('credits', $plan->credits);

        // Store in DB or mark order as paid
        return redirect()->route('subscribers.dashboard')->with('success', 'Payment successful!');
    }

    return redirect()->route('subscribers.dashboard')->with('error', 'Payment failed.');
   }

    public function paymentCancel(){
    return redirect()->route('subscribers.dashboard')->with('error', 'Payment cancelled.');
  }



}
