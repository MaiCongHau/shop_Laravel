<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if($id == 0)
        {
            $comments =Comment::all();
        }
        else
        {
            $comments =Comment::where('product_id','=',$id)->get();
        }
       
        $data =[
            'comments'=> $comments
        ];
        return view('admin.comment.index', $data);
    }
    public function delete($id)
    {
        $comments =Comment::where('id','=',$id);
        $comments->forceDelete();
        return  redirect()->route('admin.product.comment');
    }
}
