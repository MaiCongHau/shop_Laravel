<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Province;
use App\Models\Transport;

class CustomerController extends Controller
{
    public function show()
    {
        return view('customer.show');
    }
    public function update(Request $request)
    {
        $customer_email = Auth::user()->email; 
        $customer_name = $request->input('fullname');
        $customer_mobile = $request->input('mobile');
        $customer_password_new = $request->input('password');
        $customer_password_old = $request->input('old_password');
        $dbPassword = Auth::user()->password;
        if($customer_password_new)
        {
            if(!Hash::check($customer_password_old,$dbPassword))
            {
                session()->put('error','Mật khẩu hiện tại không đúng');
                return redirect()->route('customer.show');
            }
        }
    
        $data =[
            'name' => $customer_name,
            'mobile' =>$customer_mobile,
            'password'=>Hash::make($customer_password_new)
        ];
        Customer::where('email','=',$customer_email)->update($data);
        session()->put('success',"Bạn đã cập nhật thông tin người dùng mặc định thành công");
        return redirect()->route('customer.show');
    }

    public function address()
    {
        $customer = Auth::user();
        $districts = [];
        $wards = [];
        $selected_ward = $customer->ward;

        $selected_province_id = null;
        $selected_district_id = null;
        $selected_ward_id = null;
        $shipping_fee = 0;
        if (!empty($selected_ward)) {
            $selected_ward_id = $selected_ward->id;//  selected_ward_id là id của ward dùng đó so sánh để selected
            $selected_district = $selected_ward->district; // giống như z $customer->ward->district, thằng này là ward có rồi đổ ra district
           
            $selected_district_id = $selected_district->id;//selected_district_id là id của distric dùng đó so sánh để selected
            $selected_province =  $selected_district->province; //giống như z $customer->ward->district->province, thằng này lấy district từ trên đổ ra ward
            $selected_province_id = $selected_province->id; //selected_province_id là id của province
          
            $districts = $selected_province->districts; //  chọn province đổ ra distric dùng đó so sánh để selected
            $wards =  $selected_district->wards; //chọn district thì nó đổ ra ward

            $shipping_fee = Transport::where("province_id", $selected_province_id)->first()->price;
        }
        $provinces = Province::all();
        $data = [
            "customer" => $customer, 
            "provinces" => $provinces,
            "districts" => $districts,
            "wards" => $wards,
            "selected_province_id" => $selected_province_id,
            "selected_district_id" => $selected_district_id,
            "selected_ward_id" => $selected_ward_id,
            "shipping_fee" => $shipping_fee,
        ];
        $provinces = Province::all();
        return view('customer.address',$data);
    }
    
    public function Updateaddress(Request $request)
    {
        $customer_email = Auth::user()->email; 
        $customer_name = $request->input('fullname');
        $customer_mobile = $request->input('mobile');
        $customer_ward = $request->input('ward');
        $customer_address = $request->input('address');
        $data =[
            'name' => $customer_name,
            'mobile' =>$customer_mobile,
            'ward_id'=>$customer_ward,
            'housenumber_street'=>$customer_address 
        ];
        Customer::where('email','=',$customer_email)->update($data);
        session()->put('success',"Bạn đã thay đổi địa chỉ giao hàng mặc định thành công");
        return redirect()->route('customer.address');

    }

   
}
