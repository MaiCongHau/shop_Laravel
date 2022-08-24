<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login.form');
    }
    public function login(Request $request)
    {    
        $credentials = $request->only(['username', 'password']);
        if (!Auth::guard('admin')->attempt($credentials)) {
            $request->session()->put('error', 'Username hoặc password không đúng, vui lòng nhập lại');
            return redirect()->route('admin.login.form');
        }
        if(Auth::guard('admin')->user()->is_active == 0 )
        {
            Auth::guard('admin')->logout();
            $request->session()->put('error', 'Tài khoản chưa active nhé');
            return redirect()->route('admin.login.form');
        }
        return redirect()->route('dashboard');
    }   

    public function logout()
    {
        
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.form');
      
    }

}
