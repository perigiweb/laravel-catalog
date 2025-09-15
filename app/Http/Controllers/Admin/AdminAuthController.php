<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller {

  public function index(Request $request)
  {
      return view('admin.login', [
        'pageTitle' => 'Login Admin'
      ]);
  }

  public function authenticate(Request $request){
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, (bool) $request->input('remember', false))) {
       return redirect()->intended(route('admin.dashboard'));
    }

    $notFoundMsg = 'The provided credentials do not match our records';

    return back()->withErrors([
        'message' => $notFoundMsg,
    ])->onlyInput('email');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect(route('admin.index'));
  }
}