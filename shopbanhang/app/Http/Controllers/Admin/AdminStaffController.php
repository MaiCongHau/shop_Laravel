<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Staff_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs =Staff::all();
        $data =[
            'staffs'=>$staffs
        ];
        return view('admin.staff.index', $data);
    }

    public function delete($id)
    {
        $user = Auth::user();
        if($user->can('staff',Staff::class))
        {
            Staff_role::where('staff_id','=',$id)->forceDelete();
            Staff::find($id)->forceDelete();
            return redirect()->route('admin.product.staff');
        }
        return redirect()->route('admin.product.staff');
    }
    
}
