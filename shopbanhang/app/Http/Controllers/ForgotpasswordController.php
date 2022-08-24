<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
class ForgotpasswordController extends Controller
{
    //
    public function sendResetLinkEmail(Request $request)
    {
       $email = $request->email;
       $token= hash('sha256',Str::random(40)); // sinh ra token ngẫu nhiên dài 40 kí tự, lưu thằng này xuống database
       $link_reset = route('password.reset',['token'=>$token,'email'=>$email]);
       $customer = Customer::where('email','=',$email)->first();
       $customer->reset_token = $token;
       $customer->save();

       $input = $request->all();
       $input['link_reset'] =  $link_reset;
       Mail::send('forgotpassword.reset', $input, //forgotpassword.reset: cái này là view nhé
        
        function($message) use ($input) {
            $to = $input['email'] ;
            $message->to($to, 'Shopbanhang')->subject("Reset Password")->replyTo($input["email"])->from(env('MAIL_USERNAME'));
        });
        
        if (Mail::failures()) {
            //error
            session()->put("error","Email gửi ko thành công");
        }
        else {
            //success
            session()->put("success","Vui lòng kiểm tra email nhé");
        }
        return redirect()->route('index');
    }
}
