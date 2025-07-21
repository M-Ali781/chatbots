<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomAuthController extends Controller
{
  public function showLoginSignup()
  {
    return view('content.authentications.auth-login-signup-combined');
  }

  public function handleLoginSignup(Request $request)
  {
    if ($request->form_type === 'login') {
      // Gestion du LOGIN
      $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
      ]);

      if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        $userId = Auth::id();
        return redirect()->route('client.dashboard.with.id', ['id' => $userId])
          ->with('success', 'You are logged in.');
      }

      return back()->withErrors([
        'login_error' => 'Invalid email or password.',
      ])->onlyInput('email');
    }

    // Gestion du SIGN UP
    if ($request->form_type === 'signup') {
      $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:8', 'confirmed'],
      ]);

      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);

      Auth::login($user);

      return redirect()->route('client.dashboard.with.id', ['id' => $user->id])
        ->with('success', 'Account created and logged in!');
    }

    return back()->withErrors(['form_error' => 'Invalid form submission.']);
  }
}
