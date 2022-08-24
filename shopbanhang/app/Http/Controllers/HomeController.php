<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViewProduct;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $featuredProducts = ViewProduct::orderBy("featured","DESC")->take(4)->get(); // lấy 4 thằng đầu, làm sp nỗi bật
        $lastestProducts = ViewProduct::orderBy("created_date","DESC")->take(4)->get(); // lấy 4 thằng đầu, làm sp nỗi bật
       
        $categories = Category::all();

        $categoryProducts=[];
        // cách bình thường 
        // foreach ($categories as $category) {
        //     $categoryView  = ViewProduct::where("category_id",$category->id)->take(4)->get();
        //     $categoryProducts[$category->name]=$categoryView;
        // }

        // cách dùng mối quan hệ 1-n
        foreach ($categories as $category) {
            $categoryProducts[$category->name]= $category->products->take(4);
            
            
        }
      
        $data = [
            "featuredProducts"=>$featuredProducts,
            "lastestProducts" => $lastestProducts,
            "categoryProducts" => $categoryProducts,
       
        ]; 
        return view('home.index',$data);
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
