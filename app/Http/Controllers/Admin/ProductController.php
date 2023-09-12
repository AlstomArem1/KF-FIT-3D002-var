<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = DB::table('products')->get();
        return view('admin.pages.product.list',['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $productCategories = DB::select('select * from product_categories where status = 1');
        return view('admin.pages.product.create',['productCategories' => $productCategories]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        //
        $check = DB::table('products')->insert([
            'name'=> $request->name,
            'slug'=> $request->slug,
            'price'=> $request->price,
            'discount_price'=> $request->discount_price,
            "information" => $request->information,
            "qty" => $request->qty,
            "shipping" => $request->shipping,
            "weight" =>  $request->weight,
            "status" =>  $request->status,
            "product_category_id_" =>  $request->product_category_id_,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);
        // dd($request->all());
        $message = $check ? 'tao san pha thanh cong' : 'tao san pha that bai';

        return redirect()->route('admin.product.index')->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function createSlug(Request $request)
    {
        // $name = $request->name;
        // $name = 'nguyen-van-a';
        //
        // dd($request->all());
        return response()->json(['slug' => Str::slug($request->name, '-')]);

    }
}
