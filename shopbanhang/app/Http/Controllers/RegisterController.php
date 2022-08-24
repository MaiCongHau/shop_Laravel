<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    protected $messenger = [
        'required' => ':attribute không được để trống',
        'name.regex' => ':attribute không được chứa số hoặc ký tự đặc biệt',
        'password.regex' => ':attribute phải ít nhất 8 ký tự bao gồm chữ thường, chữ hoa, số và ký tự đặc biệt',
        'mobile.regex' => ':attribute phải bắt đầu là 0, có 9 hoặc 10 số theo sau',
        'email' => ':attribute phải là định dạng email.',
        'min' => ':attribute không được ít hơn :min ký tự',
        'max' => ':attribute không được lớn hơn :max ký tự',
        'unique' => ':attribute đã tồn tại',
        'same' => ':attribute phải trùng khớp với mật khẩu',
        'same' => ':attribute phải trùng khớp với mật khẩu',
        'g-recaptcha-response.required' => ':attribute phải được chọn',
     ];
  
     protected $customName = [
        'name' => 'Họ và tên',
        'password' => 'Mật khẩu',
        'mobile' => 'Số điện thoại',
        'email' => 'Email',
        'password_confirmation' => 'Nhập lại mật khẩu',
        'g-recaptcha-response' => 'Google reCAPTCHA'
     ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data)
    {
        $customer = [
            'name' => $data["name"],
            'mobile' => $data["mobile"],
            'email' => $data["email"],
            'password' => Hash::make($data["password"]), // hash password
            'is_active' => 0,
        ];
        Customer::create($customer);
        // gửi mail

        $cus = Customer::where('email','=',$data["email"])->first();
        $token= hash('sha256',$cus->email); // sinh ra token ngẫu nhiên dài 40 kí tự, lưu thằng này xuống database
        $link_reset = route('register.verify',['id'=>$cus->id,'token'=>$token]);

        // $input['email'] = $data["email"];
        $input['email'] = ['maiconghau263@gmail.com','haumaicong263@gmail.com'];
        $input['link_reset'] =  $link_reset;

        Mail::send('customer.activeAccount', $input, // View nhé
         
         function($message) use ($input) {
             $to = $input['email'] ;
             $message->to($to, 'Shopbanhang')->subject("Active Account")->from(env('MAIL_USERNAME'));
         });
         
         if (Mail::failures()) {
             //error
             session()->put("error","Email gửi ko thành công");
         }
         else {
             //success
             session()->put("success","Vui lòng kiểm tra email, để xác nhận active nhé");
         }

    }

    protected function validator(array $data)
    {
        $pattern = [
            'name' => 'required|regex:/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i|max:255',
            'email' => 'required|email|unique:customers|max:255',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
            'mobile' =>'required|min:10|max:11|regex:/^0([0-9]{9,9})$/',
            'g-recaptcha-response'=>'required|captcha'
        ];
         return Validator::make($data,$pattern ,$this->messenger,$this->customName);
         
    
    }


    public function register(Request $request)
    {
        //validate 
        $this->validator($request->all())->validate(); // cái message thông báo lỗi qua file layout/message nhé


        // $request->all() : là array
        $this->create($request->all());
        return redirect()->route("index");
    }
    
    public function exittingEmail(Request $request)
    {
        $name = $request->input('email');
        $customer=Customer::where('email',"=",$name)->get();
         // Tồn tại thì echo ra false, ko tồn tại cho phép tạo echo về true
        // echo "false";
        if($customer->count() >0)
        {
            echo "false";
        }
        else 
        {
            echo "true";
        }
       
    }

    public function verify($id,$token)
    {
        $customer = Customer::where('id','=',$id)->first();
        if(empty($customer))
        {
            session()->put("error","Email không tồn tại");
            return redirect()->route("index");
        }
        $token_compare=hash('sha256',$customer->email);
        if($token_compare != $token )
        {
            session()->put("error","Token sai nhé hihi");
            return redirect()->route("index");
        }
        $customer->is_active = 1;
        $customer->save();
        Auth::login($customer);
        session()->put("success","Bạn đã active tài khoản thành công");
        return redirect()->route("index");

    }
}
