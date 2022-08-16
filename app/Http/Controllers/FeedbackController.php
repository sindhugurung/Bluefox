<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks=feedback::all();
        return response()->json($feedbacks, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $feedback)
    {
        $feedback->validate([
            'data*.user_id' => 'required',
            'data*.order_id' => 'required',
            'data*.desc' => 'required',
            'data*.title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:5048'

        ]);
        // return $request;

        $feedback_data= json_decode($feedback->data);
        $file_feedback = $feedback->file('image');
        $filename = uniqid() . '.' . $file_feedback->extension();
        $file_feedback->storeAs('public/images/feedback_image', $filename);

        Feedback::create([
            'user_id' => $feedback_data->user_id,
            'order_id' => $feedback_data->order_id,
            'desc' => $feedback_data->desc,
            'title' => $feedback_data->title,
            'image' => $filename
        ]);

        $response = [
            "status" => true,
            "message" => "Feedback Added Successfully",

        ];

        return $response;
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
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $validation, $id)
    {
        
        $feedback = Feedback::find($id);
        $feedback->feedback_desc = $validation ? $validation->feedback_desc : $feedback->feedback_desc;
        
        $feedback->update();
        $errMessage = [
            "status" => false,
            "message" => "Update error"
        ];
        if (!$feedback) {
        return response()->json($errMessage, 404);
        }

        $successMessage = [
            "status" => true,
            "message" => "Updated Successfully"
        ];
        
        return response()->json($successMessage, 201);
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        if (!$feedback) {
            return response()->json(["message" => "Feedback not found"], 404);
        }
        $feedback->delete();
        $successResponse = ["message" => "Feedback deleted successfully"];
        return response()->json($successResponse, 200);
    
    }
}
