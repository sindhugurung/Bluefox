<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
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

    public function create(Request $request)
    {
        $request->  validate([
            'name' =>'required',
            'description'=>'required',
            'title'=>'required',
            // 'image'=>'required',
            'price'=>'required',
            
        ]);

            $product= Product::create([
                'name'=> $request ->name,
                'description'=>$request->description,
                'title'=>$request->title,
                'image'=>$request->image,   
                'price'=>$request->price,
                'category_id'=>$request->category_id
            ]);


        return $product;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function categories($id)
        {
            $category = Category::with('product')->find($id); 
    
            return view('products.categories')->with('products', $category);
        }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->  validate([
            'name' =>'required',
            'description'=>'required',
            'title'=>'required',
            // 'image'=>'required',
            'price'=>'required']);

            $product = Product::find($id);
            $product->name = $request->name ? $request->name : $product->name;
            $product->description = $request->description ? $request->description : $product->description;
            $product->title = $request->title ? $request->title : $product->title;
            $product->price = $request->price ? $request->price : $product->price;
            $product->update();
    
            $errResponse = [
                "status" => false,
                "message" => "Update error"
            ];
    
            if (!$product) {
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }
        $product->delete();
        $successResponse = ["message" => "User deleted successfully"];
        return response()->json($successResponse, 200);
    }
}
