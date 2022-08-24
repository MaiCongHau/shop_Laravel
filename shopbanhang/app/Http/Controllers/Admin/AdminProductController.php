<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ViewProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('image')) {
            echo "file hình ảnh bị lỗi";
            exit;
        }
        // lưu hình
        $fileName = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs(
            'images',
            $fileName,
            'shop'
        );
        // // đẩy thông tin lên database
        $products = new Product;
        $products->name = $request->input('name');
        $products->price = $request->input('wholesale-price');
        $products->inventory_qty = $request->input('inventory-number');
        $products->category_id = $request->input('category');
        $products->description = $request->input('description');
        $products->created_date = date('Y-m-d H:i:s');
        $products->brand_id = 1;
        $products->featured_image = $fileName;
        $products->save();

        return redirect()->route('admin.product.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $products = ViewProduct::all();
        $data = [
            'products' => $products,
        ];
        return view('admin.product.index', $data);
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
    public function delete($id)
    {
        
        try {
            $product = Product::where('id', '=', $id)->first();
            $fileName =  $product->featured_image;
            Storage::disk('shop')->delete("images/{$fileName}");//trong file
            $product->forceDelete(); //trong database
            return redirect()->route('admin.product.show');
        } catch (\Throwable $th) {
            echo "Bạn vui lòng làm rỗng bảng order trước khi xóa nhé";
        }
       
    }
}
