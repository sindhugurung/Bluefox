<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;


class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries=delivery::all();
        return response()->json($deliveries, 201);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request-> validate([
            'location'=>'required',
            'charge'=>'required'
        ]);

        
        $delivery = Delivery::create([
            'location' => $request->location,
            'charge' => $request->charge
        ]);
        return $delivery;
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
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(["message" => "Delivery not found"], 404);
        }

        return response()->json($delivery, 200);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $delivery = Delivery::find($id);
        $delivery->location = $request->location ? $request->location : $delivery->location;
        $delivery->charge = $request ? $request->charge : $delivery->charge;
        $delivery->update();
        $errMessage = [
            "status" => false,
            "message" => "Update error"
        ];
        if (!$delivery) {
        return response()->json($errMessage, 404);
        }

        $successMessage = [
            "status" => true,
            "message" => "Updated Successfully"
        ];
        
        return response()->json($successMessage, 201);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        if (!$delivery) {
            return response()->json(["message" => "Delivery not found"], 404);
        }
        $delivery->delete();
        $successResponse = ["message" => "Delivery deleted successfully"];
        return response()->json($successResponse, 200);
    }
}
