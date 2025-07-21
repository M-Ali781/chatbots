<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // ✅ À ajouter
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
  public function showLoginForm()
  {
    return view('content.authentications.admin-login-signup');
  }

  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
      return redirect()->intended('/admin/users');
    }

    return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();
    return redirect('/admin/login');
  }
}
