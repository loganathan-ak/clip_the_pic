<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendGeneratedPassword;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ForgotPassword;

class Authentication extends Controller
{

    // public function userRegister(Request $request)
    // {
    //     // Validate the incoming request data
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|confirmed|min:6',
    //     ]);
    //     $latestId = User::max('obeth_id');
    //     $nextNumber = $latestId ? intval(str_replace('OBE-', '', $latestId)) + 1 : 1000;
    //     // Create the new user record
    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']), // Make sure to hash the password
    //         'obeth_id' => 'OBE-' . $nextNumber,
    //     ]);
    
    //     // Optionally log the user in after registration (if needed)
    //     // Auth::login($user);
    
    //     return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    // }

    public function userRegister(Request $request)
{
    $step = $request->input('step');

    if ($step === 'start') {
        // Step 1 validation
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
        ]);

        $generatedPassword = Str::random(8);

        // Store info in session
        Session::put('pending_user', [
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'password' => $generatedPassword,
        ]);

        // Send email
        Mail::to($request->email)->send(new SendGeneratedPassword($generatedPassword));

        return redirect()->back()->with([
            'step' => 'verify',
            'email' => $request->email,
        ]);
    }

    if ($step === 'confirm') {
        $request->validate(['entered_password' => 'required|string']);
    
        $data = Session::get('pending_user');
    
        if (!$data || $request->entered_password !== $data['password']) {
            return redirect()->back()->withErrors(['entered_password' => 'Incorrect password.'])->with('step', 'verify');
        }
    
        // ✅ Create new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile_number'],
            'password' => Hash::make($data['password']),
            'role' => 'subscriber',
        ]);
    
        // ✅ Clear session
        Session::forget('pending_user');
    
        // ✅ Auto-login
        Auth::login($user);
    
        // ✅ Redirect to subscriber dashboard
        return redirect()->route('subscribers.dashboard')->with('success', 'Registered successfully!');
    }
    
    return redirect()->route('register');
}


    public function userLogin(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // no 'confirmed' here for login
        ]);
    
        // Attempt to log the user in with the validated credentials
        if (Auth::attempt([
            'email' => $validated['email'], 
            'password' => $validated['password']
        ])) {
            $request->session()->regenerate();

                $user = Auth::user();

                // Redirect based on role
                if ($user->role === 'superadmin') {
                    return redirect()->route('superadmin.dashboard');
                } elseif ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'qualitychecker') {
                    return redirect()->route('qc.dashboard');
                }  else {
                    return redirect()->route('subscribers.dashboard'); // For subscriber or default
                }
        }

        // If authentication fails, return back with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function userLogout(Request $request) {
        Auth::logout();
        return redirect('/login');
      }


    public function forgotPassword(){
        return view('auth.forgot-password');
    }


    public function sendNewPassword(Request $request)
    {
        // 1. Validate the email: Ensures it's required, a valid email format, and exists in the users table.
        $request->validate(['email' => 'required|email|exists:users,email']);

        // 2. Find the user by their email address.
        $user = User::where('email', $request->email)->first();

        // Fallback check: If the user is somehow not found (though 'exists' validation should prevent this),
        // redirect back with an error.
        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // 3. Generate a new, random, and strong password.
        // Str::random(12) creates a 12-character alphanumeric string. You can adjust the length.
        $newPassword = Str::random(6);

        // 4. Hash the new password and save it to the user's record in the database.
        // It's crucial to always hash passwords before storing them.
        $user->password = Hash::make($newPassword);
        $user->save(); // Save the updated user record to the database.

        // 5. Send the new password to the user's email using Laravel's Mail Facade and your Mailable class.
        try {
            // Ensure your mail settings are correctly configured in your .env file
            // (e.g., MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD).
            Mail::to($user->email)->send(new ForgotPassword($user, $newPassword));
        } catch (\Exception $e) {
            // If there's an error sending the email (e.g., mail server issues),
            // log the error for debugging and inform the user.
            \Log::error('Failed to send new password email: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Could not send the new password email. Please try again later.']);
        }

        // 6. Redirect the user to the login page with a success message.
        // They will then use the newly received password to log in.
        return redirect()->route('login')->with('status', 'A new password has been sent to your email address. Please check your inbox and spam folder.');
    }
}
