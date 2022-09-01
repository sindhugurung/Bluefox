<?php

namespace App\Http\Controllers;

use App\Models\RateList;
use Illuminate\Http\Request;

class RateListController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $price =RateList::all();

        return response()->json($price, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)

    {
        // return "bibek";
        $request->validate([
            'quantity'=>'required',
            'normal_price'=>'required',
            'urgent_price'=>'required',
            'product_id'=>'required',
            'discount'=>''

        ]);
        // return "bibek";

        $price = RateList::create([
            'quantity'=> $request -> quantity,
            'normal_price'=>$request -> normal_price,
            'urgent_price'=>$request->urgent_price,
            'product_id'=>$request->product_id,
            'discount'=>$request->discount,
        ]);
        return $price;
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
     * @param  \App\Models\RateList  $rateList
     * @return \Illuminate\Http\Response
     */
    public function show(RateList $rateList, $id)
    {$price =RateList ::find($id);
        // CorporateRateList

        if (!$price) {
            return response()->json(["message" => " not found"], 404);
        }

        return response()->json($price, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RateList  $rateList
     * @return \Illuminate\Http\Response
     */
    public function edit(RateList $rateList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RateList  $rateList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {




        $price               = RateList::find($id);
        $price->quantity         = $request->quantity ? $request->quantity : $price->name;
        $price->normal_price        = $request->normal_price ? $request->normal_price : $price->normal_price;
        $price->urgent_price       = $request->urgent_price ? $request->urgent_price : $price->urgent_price;
        $price->product_id       = $request->product_id ? $request->product_id : $price->product_id;
         $price->update();

        $errResponse = [
            "status" => false,
            "message" => "Update error"
        ];

        if (!$price) {
            return response()->json($errResponse, 404);
        }

        $successResponse = [
            "status" => true,
            "message" => "Updated Successfully"
        ];

        return response()->json($successResponse, 201);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RateList  $rateList
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $price = RateList::find($id);
        if (!$price) {
            return response()->json(["message" => "rate list not found"], 404);
        }
        $price->delete();
        $successResponse = ["message" => "Rate List deleted successfully"];
        return response()->json($successResponse, 200);
    }

}
