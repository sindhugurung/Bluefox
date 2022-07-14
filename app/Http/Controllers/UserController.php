<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'type'=>'in:corporate,individual',
            'email'=>'required|email|unique:users',
            'mobile_number'=>'required|regex:/9[6-8]{1}[0-9]{8}/|digits:10|unique:users',
            'password'=>'required|min:8|max:16|confirmed',
            'status'=>'required',
            'is_admin'=>'required|boolean',
            
        ]);

       $user=User::create([
        'name'=>$request->name,
        'address'=>$request->address,
        'type'=>$request->type,
        'email'=>$request->email,
        'mobile_number'=>$request->mobile_number,
        'mobile_verified_code'=>rand(0000,9998),
        'password'=>Hash::make($request->password),
        'status'=>$request->status,
        'is_admin'=>$request->is_admin,
    ]);
        return $user;

    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Invalid username and password provided"], 404);
        }

        return $user->createToken($request->device_name)->plainTextToken;
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        return response()->json($user, 200);
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
        $request->validate([
            'mobile_number' => 'unique:users',
            'password' => 'min:8|max:16|confirmed',
            'email' => 'email|unique:users',
            'type' => 'in:corporate,individual',
            'is_admin' => 'boolean'
        ]);

        $user = User::find($id);
        $user->name = $request->name ? $request->name : $user->name;
        $user->mobile_number = $request->mobile_number ? $request->mobile_number : $user->mobile_number;
        $user->password = $request->password ? $request->Hash::make($request->password) : $user->password;
        $user->type = $request->type ? $request->type : $user->type;
        $user->is_admin = $request->is_admin ? $request->is_admin : $user->is_admin;
        $user->update();

        $errResponse = [
            "status" => false,
            "message" => "Update error"
        ];

        if (!$user) {
            return response()->json($errResponse, 404);
        }

        $successResponse = [
            "status" => true,
            "message" => "Updated Successfullyy"
        ];

        return response()->json($successResponse, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        $user->delete();
        $successResponse = ["message" => "User deleted successfully"];
        return response()->json($successResponse, 200);
    }
}