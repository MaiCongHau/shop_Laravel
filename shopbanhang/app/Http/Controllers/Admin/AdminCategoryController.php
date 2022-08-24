<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $data =[
            'categories'=> $categories 
        ];
        return view('admin.category.index', $data);
    }
    public function create()
    {
        $categories = new Category;
        return view('admin.category.add');
    }
    public function store(Request $request)
    {
        
        $categorie = new Category;
        $categorie->name =  $request->input('name');
        $categorie->save();
        return redirect()->route('admin.product.category');
    }
    
}
