<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
    //
    public function show()
    {
        return view('contact.show');
    }
    public function sendEmail(Request $request)
    {
        $input = $request->all();
       
        Mail::send('contact.sendemail', $input, //contact.sendmail: cái này là view nhé
        
        function($message) use ($input) {
            $to = env('MAIL_USERNAME');
            $message->to($to, 'Shopbanhang')->subject("Shopbanhang: Customer contact {$input['fullname']}")->replyTo($input["email"])->from($input["email"]);
        });
        
        if (Mail::failures()) {
            //error
            echo 'Không thể gởi mail. Vui lòng liên hệ với admin';
        }
        else {
            //success
            echo 'Đã gởi mail thành công';
        }
    }
  
}
