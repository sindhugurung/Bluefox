<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Cart;
use Session;

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
        $request->validate([
            'props*.name' => 'required|unique:banners|min:3|max:255',
            'props*.description' => 'required',
            'props*.title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:5048',
            'props*.category_id' => 'required'

        ]);
        // return $request;

        $product_data= json_decode($request->props);
        $file_product = $request->file('image');
        $filename = uniqid() . '.' . $file_product->extension();
        $file_product->storeAs('public/images/product_image', $filename);

        Product::create([
            'name' => $product_data->name,
            'description' => $product_data->description,
            'title' => $product_data->title,
            'image' => $filename,
            'category_id'=> $product_data->category_id
        ]);

        $response = [
            "status" => true,
            "message" => "Product Added Successfully",

        ];

        return $response;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function categories($id)
        {
            $category = Category::with('product')->find($id); 
            return response()->json($category, 200);
    
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


            $product = Product::find($id);
            $product->name = $request->name ? $request->name : $product->name;
            $product->description = $request->description ? $request->description : $product->description;
            $product->title = $request->title ? $request->title : $product->title;
            $product->category_id = $request->category_id ? $request->category_id : $product->category_id;
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
        $successResponse = ["message" => "Product deleted successfully"];
        return response()->json($successResponse, 200);
    }

    

}