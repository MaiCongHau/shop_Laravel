<?php

namespace App\Http\Controllers\Auth;
use  App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
      try {
        $googleCustomer = Socialite::driver('google')->user(); // thông tin người dùng trả về bởi google
        $existingEmail = Customer::where('google_id','=', $googleCustomer->getId())->orwhere('email','=', $googleCustomer->getEmail())->first();
        if(empty($existingEmail))
        {
          $customer = new Customer; 
          $customer->google_id = $googleCustomer->getId();
          $customer->name =  $googleCustomer->getName();// có sẵn nhé
          $customer->email =   $googleCustomer->getEmail();// có sẵn nhé
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
