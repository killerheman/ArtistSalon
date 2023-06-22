<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember_me))
        {
            $role = Auth::user()->roles[0]->name;
            session()->flash('success','Welcome'. $role .'!');
            return redirect()->route('admin.dashboard');
        }
        else {
            session()->flash('error','Invalid Username or Password !');
            return redirect('/admin');
        }
    }
}
