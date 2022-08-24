<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Transport;

class AddressController extends Controller
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
    public function show()
    {
        
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
    
    public function districts($province_id)
    {
    
        $districts = Province::find($province_id)->districts;
       
        $arrs = []; 
        foreach($districts as $district )
        {
            $arrs[] = ["id"=>$district->id,"name"=>$district->name];
        }
        echo json_encode($arrs);
    }

    public function wards($district_id)
    {
    
        $wards = District::find($district_id)->wards;
       
        $arrs = []; 
        foreach( $wards as  $ward )
        {
            $arrs[] = ["id"=>$ward->id,"name"=>$ward->name];
        }
        echo json_encode($arrs);
    }

    public function shippingFee($province_id)
    {
        $transport = Transport::where("province_id","=",$province_id)->first();
        echo $transport->price;
    }
}
