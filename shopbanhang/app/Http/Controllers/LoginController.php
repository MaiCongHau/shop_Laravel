<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->only(['email','password']); // có thể dùng giống thằng register 
        // ngoài ra ta còn phải có thêm 1 trường is_active nữa 
        // $credential['is_active'] =1 ; 
        if(!Auth::attempt($credential)) // thằng này nhận vào là array và dò lên database theo các key-value nhận dc
        {// nhưng sao nó biết zô thằng Customer mà dò, ta phải sửa cấu hình 
            $request->session()->put('error','Email hoặc mật khẩu không chính xác, bạn vui lòng nhập lại');
        }
        if(Auth()->user()->is_active == 0 )
        {
            Auth()->logout();
            $request->session()->put('error','Tài khoản chưa active nhé ');
            return redirect()->route('index');
        }
        $request->session()->put('success','Bạn đã Login thành công');
        return redirect()->route('index');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

}
