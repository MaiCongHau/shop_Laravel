<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViewProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;

class CartController extends Controller
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
    public function create($product_id,$qty)
    {
        //
        $this->restorecartFromDB();
        $product = ViewProduct::find($product_id);
        // cấu trúc của thằng Cart nó là như vậy, thư viện viết như z đừng sửa, nhưng mà bây giờ cấu trúc của nó thiếu mục image thì mình dùng option để làm phần image này
        Cart::add(['id' => $product_id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->price,'weight' => 0,'options' => ['image' => $product->featured_image]]);
        $this->storecartIntoDB();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');
        $this->create( $product_id, $qty ); // là cái dữ liệu của sản phẩm đã dc lưu trong thằng Cart::content(), và nhiệm vụ của mình là lấy thằng Cart::content() này và hiễn thị nó ra 
        $this->display();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        // Cart::destroy();
        // $this-> restorecartFromDB();
        // $items = Cart::content();
        // $this->storecartIntoDB();
        
        var_dump( Cart::content() );
    }
    protected function display()
    {
        $result = [];
        $result['count']=Cart::count();
        $result['subtotal']=Cart::subtotal();
        $result['items']=view("layout.cartItem")->render(); // nó lấy dữ liệu thằng Cart::content() xong rồi hiễn thị ra 
        echo json_encode($result);
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
    public function update($rowId, $qty)
    {
        //
        $this->restorecartFromDB();
        Cart::update($rowId,$qty);
        $this->display();
        $this->storecartIntoDB();
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

    public function delete($rowId)
    {   
        $this->restorecartFromDB();
        Cart::remove($rowId);
        $this->display();
        $this->storecartIntoDB();
    }

    protected function storecartIntoDB()
    {
        if(Auth::check()) // kiểm tra đã đăng nhập rồi mới làm
        {
            $emailLogin = Auth::user()->email;
            Cart::store($emailLogin);
        }
        
    }

    protected function restorecartFromDB()
    {
        if(Auth::check()) // kiểm tra đã đăng nhập rồi mới làm
        {
            $emailLogin = Auth::user()->email;
            Cart::restore($emailLogin);
        }
    }

    public function discount(Request $request)
    {
        $discount_code = $request->input("discount-code");
        
        $discount = Discount::where("code","=",$discount_code)->first();
        if($discount)
        {
            $discount_amount = $discount->discount_amount;
            $this->restorecartFromDB(); // nhớ lưu xuống database
            Cart::setGlobalDiscount($discount_amount); // theo %
            $this->storecartIntoDB(); // nhớ lưu xuống database
            $request->session()->forget("error_discount_code"); // xóa session
        }else
        {
            $this->restorecartFromDB(); // nhớ lưu xuống database
            Cart::setGlobalDiscount(0); // theo %
            $this->storecartIntoDB();// nhớ lưu xuống database
            $request->session()->put("error_discount_code","Mã giảm giá không hợp lệ");
        }

        $request->session()->put("discount_code", $discount_code);
        return redirect()->route("payment.create"); 
    }

    public function voucher(Request $request)
    {
        $voucher_code = $request->input("voucher-code");
        $conds =[]; 
        $conds[] = ["code","=",$voucher_code];
        $conds[] = ["is_fixed","=",1];
        $voucher = Discount::where($conds)->first();
        if($voucher)
        {
            $request->session()->put("voucher_amount", $voucher->discount_amount); // lấy số tiền giảm giá
            $request->session()->forget("error_voucher_code"); // xóa session
        }else
        {
            $request->session()->put("voucher_amount", 0); // lấy số tiền giảm giá
            $request->session()->put("error_voucher_code","Mã giảm giá không hợp lệ");
        }

        $request->session()->put("voucher_code", $voucher_code);
       
        return redirect()->route("payment.create"); 
    }

}
