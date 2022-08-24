<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class ResetpasswordController extends Controller
{
    public function showResetForm($token,Request $request)
    {
        $email = $request->email; 
        $data = [
            'email' =>$email,
            'token' => $token
        ];
        return view('resetpassword.reset',$data);
    }

    public function reset(Request $request)
    {
        $email = $request->email;
        $token = $request->reset_token;
        $customer = Customer::where('email','=',$email)->first();
        if(empty($customer))
        {
            session()->put('error',"Invalid email");
            return redirect()->route('index');
        }
        if($customer->reset_token == $token)
        {
            $re_password = $request->password;
            $customer->password = Hash::make($re_password);
            $customer->reset_token = null;
            $customer->save();
            session()->put('success',"Đã cập nhật password thành công");
        }
        else
        {
            session()->put('error',"Invalid token");
        }
        return redirect()->route('index');
    }
}
