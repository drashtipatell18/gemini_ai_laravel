<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function Login(){
        return view('login');
    }

    // public function LoginStore(Request $request)
    // {
    //     // First check if user exists
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return back()->withErrors([
    //             'email' => 'No account found with this email address',
    //         ])->onlyInput('email');
    //     }

    //     // Then check password
    //     if (!Hash::check($request->password, $user->password)) {
    //         return back()->withErrors([
    //             'password' => 'The password you entered is incorrect',
    //         ])->onlyInput('email');
    //     }

    //     // If we get here, credentials are valid
    //     $auth = Auth::login($user);
    //     $request->session()->regenerate();

    //     return redirect()->intended('dashboard')->with('success', 'Login successful!')->with('auth', $auth);
    // }

    public function Signup(){
        return view('Signup');
    }

    public function SignupStore(Request $request)
    {
       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        // Redirect to dashboard or intended page
        return redirect()->route('index')->with('success', 'Account created successfully.');
    }

}
