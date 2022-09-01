<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
  
            $request->validate([
                'product_id'=>'required',
                'user_id'=>'required',
                'quantity'=>'required']);


                $validation = Cart::where('user_id',Auth::id())->where('product_id',$request->product_id)->first();

                if(!$validation){

                    $cart=Cart::create( [
                        "product_id"=> $request->product_id,
                        "user_id"=> $request->user_id,
                        "quantity"=> $request->quantity
                      ]) ;
                      return redirect()->back()->with('success', 'Product added to cart successfully!');
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
