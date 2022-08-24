<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\Province;
use App\Models\Transport;
use App\Models\Ward;
use App\Models\Order_item;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
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
    public function create()
    {
        
        if(Auth::check()) // đã login
        {
            $customer =  Auth::user();
        }
        else{
            $customer = Customer::find(1); // để lấy trong database mặc định nếu ko đăng nhập tên là Nguyễn Văn A
        }

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
        
        return view('payment.checkout',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->created_date = date("Y-m-d H:i:s");
        $order->order_status_id = 1;
        $order->customer_id = Auth::user()->id;
        $order->shipping_fullname = $request->input('fullname'); // như $_POST
        $order->shipping_mobile = $request->input('mobile'); // như $_POST
        $order->payment_method = $request->input('payment_method'); // như $_POST
        $order->shipping_ward_id = $request->input('ward'); // như $_POST
        $order->shipping_housenumber_street = $request->input('address'); // như $_POST
        $province_id = Ward::find($order->shipping_ward_id)->district->province->id; // như $_POST
        $order->shipping_fee =  Transport::where('province_id','=',$province_id)->first()->price;
        $order->delivered_date = date("Y-m-d H:i:s",strtotime("+5 days"));
        $order->price_total = Cart::priceTotal(0,"","");
        $order->sub_total = Cart::subtotal(0,"","");
        $order->tax = Cart::tax(0,"","");
        $order->voucher_code= session()->pull('voucher_code'); // lấy giá trị cái mất luôn session
        $order->voucher_amount=session()->pull('voucher_amount');// lấy giá trị cái mất luôn session

        $order->discount_code = session()->pull("discount_code");// lấy giá trị cái mất luôn session

        $order->discount_amount = Cart::discount(0,"",""); // nhớ qua bên kia lưu xuống databse 
        $order->price_inc_tax_total = Cart::total(0,"","");
        $order->payment_total = $order->shipping_fee + Cart::total(0,"","") - $order->voucher_amount ;


        $order->save();
        $order_id = $order->id;
        foreach( Cart::content() as $items )
        {
            $order_items = new Order_item();
            $order_items->product_id = $items->id;
            $order_items->order_id =  $order_id;
            $order_items->qty= $items->qty;
            $order_items->unit_price =$items->price;
            $order_items->total_price =$items->qty * $items->price;
            $order_items->save();
        }
        session()->put("success","Bạn đã tạo đơn hàng thành công");

        if(Auth::check()) // kiểm tra đã đăng nhập rồi mới làm
        {
            $emailLogin = Auth::user()->email;
            Cart::restore($emailLogin);
        }
        Cart::destroy();
        return redirect()->route("product.index");  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
