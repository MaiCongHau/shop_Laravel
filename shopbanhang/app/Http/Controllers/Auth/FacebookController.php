<?php

namespace App\Http\Controllers\Auth;
use  App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
      try {
        $facebookCustomer = Socialite::driver('facebook')->user(); // thông tin người dùng trả về bởi google
        $existingEmail = Customer::where('facebook_id','=',  $facebookCustomer->getId())->orwhere('email','=',  $facebookCustomer->getEmail())->first();
        if(empty($existingEmail))
        {
          $customer = new Customer; 
          $customer->facebook_id =  $facebookCustomer->getId();
          $customer->name =   $facebookCustomer->getName();// có sẵn nhé
          $customer->email =    $facebookCustomer->getEmail();// có sẵn nhé
          $customer->is_active = 1; 
          $customer->save();
          Auth::login($customer); // hàm Auth::login này dùng để login vào 1 user đã có sẵn trong database 
        } 
        else{
          Auth::login($existingEmail);
        }
        return redirect()->route('index');

      } catch (\Throwable $th) {
        //throw $th;
      }
    }
}
