<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

    if (Auth::attempt($credentials, $request->has('remember'))) {
           session()->flash('success', 'Welcome Back');
           return redirect()->route('users.show', [Auth::user()]);
           //Auth::user() - get the current and login user info
       } else {
           session()->flash('danger', 'Sorry! Please check your Login Info');
           return redirect()->back();
       }
    }

    public function destroy() {
        Auth::logout();
        session()->flash('success', 'Logout Successfully');
        return redirect('login');
    }
}