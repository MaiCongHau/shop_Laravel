<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ViewProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryName = null, Request $request)
    {
        $conds = []; // dùng cái mảng này để khi có thêm điều kiện mới ta dễ tùy biến hơn
        $categoryId = null;
        if ($categoryName) {
            $temp = explode("-", $categoryName);
            $categoryId = array_pop($temp); // lấy "id"
            $conds[] = ["category_id", "=", $categoryId];
        }

        if ($request->has("price-range")) {
            $priceRange = $request->input("price-range");
            $temp = explode("-", $priceRange);
            $start = $temp[0];
            $end = $temp[1];
            $conds[] = ["sale_price", ">=", $start];
            if (is_numeric($end)) // trường hợp giá trên "1000000" thì thằng $end nó là chữ, nên nó éo match => nó lấy giá lớn hơn $start thôi
            {
                $conds[] = ["sale_price", "<=", $end];
            }
        }

        if ($request->has("search")) {
            $search = $request->input("search");
            $conds[] = ["name", "LIKE", "%$search%"];
           
        }

        $col = "name"; // mặc dịnh
        $sortType = "ASC"; // mặc định
        if ($request->has("sort")) {
            // sort=alpha-asc
            $sort = $request->input("sort");
            $temp = explode("-", $sort);
            $map = ["price" => "sale_price", "alpha" => "name", "created" => "created_date"];
            $sortType = $temp[1];
            $col = $map[$temp[0]];
        }

        $item_per_page = env("ITEM_PER_PAGE", 4); // ko có thì mặc định là 4
        $products = ViewProduct::where($conds)->orderBy("$col", "$sortType")->paginate($item_per_page)->withQueryString(); // thằng where này nó hỗ trợ dạng mảng luôn,

        $categories = Category::all();
        $data = [
            "products" => $products,
            "categories" => $categories,
            "categoryId" => $categoryId,
        ];

        return view('product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $temp = explode("-",$slug);
        $id = array_pop($temp); // tách dc "id"
       
        $products = ViewProduct::find($id); // Láy toàn bộ thông tin sản phẩm
        $categories = Category::all();
        $categoryId =  $products->category->id; //active danh mục sản phẩm 
    
        $data = [
            "categories"=>$categories,
            "categoryId"=>$categoryId,
            "products"=>$products
        ];
        return view('product.show',$data);
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
    public function search(Request $request)
    {   
      $search = $request->input("pattern123");
      $conds = [];
      $conds[] = ["name","LIKE","%$search%"];
      $products = ViewProduct::where($conds)->get();
      return view('product.search', ["products"=>$products]);
    }
}
