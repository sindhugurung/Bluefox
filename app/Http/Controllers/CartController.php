<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\RateList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request){
  
            $request->validate([
                'product_id'=>'required',
                'user_id'=>'required',
                'quantity'=>'required',
                'ord_type'=>'required']);

                $validation = Cart::where('user_id',Auth::id())->where('product_id',$request->product_id)->first();
                $user_type = User::with('type')->findOrFail($request->user_id);
                $iNorTen=DB::select('select i_normal from RateList where range_from>0 and range_to=<10');
                $iNorTwen=DB::select('select i_normal from RateList where range_from>10 and range_to=<20');
                $iNorThirty=DB::select('select i_normal from RateList where range_from>20 and range_to=<30');
                $iUrgTen=DB::select('select i_urgent from RateList where range_from>0 and range_to=<10');
                $iUrgTwen=DB::select('select i_urgent from RateList where range_from>10 and range_to=<20');
                $iUrgThirty=DB::select('select i_urgent from RateList where range_from>20 and range_to=<30');
                $cNorTen=DB::select('select c_normal from RateList where range_from>0 and range_to=<10');
                $cNorTwen=DB::select('select c_normal from RateList where range_from>10 and range_to=<20');
                $cNorThirty=DB::select('select c_normal from RateList where range_from>20 and range_to=<30');
                $cUrgTen=DB::select('select c_urgent from RateList where range_from>0 and range_to=<10');
                $cUrgTwen=DB::select('select c_urgent from RateList where range_from>10 and range_to=<20');
                $cUrgThirty=DB::select('select c_urgent from RateList where range_from>20 and range_to=<30');

                $quantity=$request['quantity'];
                if(!$validation){
                    if($user_type=="individual"){
                        $ord_type=$request['ord_type'];
                        if($ord_type=="normal"){
                            
                            if($quantity>=1 && $quantity<=10){
                                $price=$iNorTen;
                            }
                            elseif($quantity>10 && $quantity<=20){
                                $price=$iNorTwen;
                            }
                            elseif($quantity>20 && $quantity<=30){
                                $price=$iNorThirty;
                            }
                            $cart=Cart::create( [
                            "product_id"=> $request->product_id,
                            "user_id"=> $request->user_id,
                            "quantity"=> $request->quantity, 
                            "ord_type"=>$request->ord_type,
                            "rate"=>$request->quantity*$price
                        ]) ;
                        return redirect()->back()->with('success', 'Product added to cart successfully!');
                        }
                        elseif($ord_type=="urgent"){
                            if($quantity>=1 && $quantity<=10){
                                $price=$iUrgTen;
                            }
                            elseif($quantity>10 && $quantity<=20){
                                $price=$iUrgTwen;
                            }
                            elseif($quantity>20 && $quantity<=30){
                                $price=$iUrgThirty;
                            }
                            $cart=Cart::create( [
                                "product_id"=> $request->product_id,
                                "user_id"=> $request->user_id,
                                "quantity"=> $request->quantity,
                                "ord_type"=>$request->ord_type,
                                "rate"=>$request->quantity*$price
                            ]) ;
                            return redirect()->back()->with('success', 'Product added to cart successfully!');
                            
                    }
                }
                
                elseif($user_type=="corporate"){
                    $ord_type=$request['ord_type'];
                        if($ord_type=="normal"){
                            if($quantity>=1 && $quantity<=10){
                                $price=$cNorTen;
                            }
                            elseif($quantity>10 && $quantity<=20){
                                $price=$cNorTwen;
                            }
                            elseif($quantity>20 && $quantity<=30){
                                $price=$cNorThirty;
                            }
                            $cart=Cart::create( [
                            "product_id"=> $request->product_id,
                            "user_id"=> $request->user_id,
                            "quantity"=> $request->quantity, 
                            "ord_type"=>$request->ord_type,
                            "rate"=>$request->quantity*$price
                        ]) ;
                        return redirect()->back()->with('success', 'Product added to cart successfully!');
                        }
                        elseif($ord_type=="urgent"){
                            if($quantity>=1 && $quantity<=10){
                                $price=$cUrgTen;
                            }
                            elseif($quantity>10 && $quantity<=20){
                                $price=$cUrgTwen;
                            }
                            elseif($quantity>20 && $quantity<=30){
                                $price=$cUrgThirty;
                            }
                            $cart=Cart::create( [
                                "product_id"=> $request->product_id,
                                "user_id"=> $request->user_id,
                                "quantity"=> $request->quantity,
                                "ord_type"=>$request->ord_type,
                                "rate"=>$request->quantity*$price
                            ]) ;
                            return redirect()->back()->with('success', 'Product added to cart successfully!');
                            
                    }
                }
                else{
                    $errMessage = [
                        "status" => false,
                        "message" => "User not found"
                    ];
                    return response()->json($errMessage, 404);
                }

            }
        }
                
    
    public function update(Request $request, $id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $exist_quantity = $cartItem['quantity'];
            $quantity=$request['quantity'];
            $cartItem->quantity = $quantity+$exist_quantity;

             $cartItem->update();
        }else{
                $errMessage = [
                "status" => false,
                "message" => "Update error"
            ];
            return response()->json($errMessage, 404);
            }
    
            $successMessage = [
                "status" => true,
                "message" => "Updated Successfully"
            ];
            return response()->json($successMessage, 201);
       }
    
    
        //
      
        public function index()
        {
            $carts=Cart::all();
            return response()->json($carts, 201);
            //
        }
    
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(["message" => "Cart not found"], 404);
        }
        $cart->delete();
        $successResponse = ["message" => "Cart deleted successfully"];
        return response()->json($successResponse, 200);
    }
      
}
