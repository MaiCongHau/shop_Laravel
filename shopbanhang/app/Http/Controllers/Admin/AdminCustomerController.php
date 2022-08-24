<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $customers = Customer::all();
        $data=[
            'customers' =>$customers
        ];        
        return view('admin.customer.index', $data);
    }
    public function create()
    {
        $wards = Ward::all();
        $districts = District::all();
        $provinces = Province::all();

        $data = [
            'provinces' => $provinces,
            'districts' => $districts,
            'wards' => $wards,
        ];     
        return view('admin.customer.add', $data);
    }
    public function store(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->input('fullname');
        $customer->password = Hash::make($request->input('password'));
        $customer->mobile = $request->input('mobile');
        $customer->email = $request->input('email');
        $customer->ward_id = $request->input('ward');
        $customer->shipping_name = $request->input('shipping_name');
        $customer->shipping_mobile = $request->input('shipping_mobile');
        $customer->housenumber_street = $request->input('housenumumber_street');
        $customer->is_active = $request->input('active'); 
        $customer->save();   
        return redirect()->route('admin.product.customer.create');
    }
    public function district($province_id)
    {
        $districts = Province::find($province_id)->districts;
        $arr =[] ;
        foreach($districts as $district)
        {
            $arr[] = ['id'=>$district->id,'name'=>$district->name];
        }
        echo json_encode($arr);
    }

    public function ward($district_id)
    {
        $wards = District::find($district_id)->wards;
        $arr =[] ;
        foreach($wards as $ward)
        {
            $arr[] = ['id'=>$ward->id,'name'=>$ward->name];
        }
        echo json_encode($arr);
    }
    public function delete($id)
    {
        Customer::find($id)->forceDelete(); 
        return redirect()->route('admin.product.customer');
    }

}
