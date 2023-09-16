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
       //Query Builder
       $products = DB::table('products')->orderBy('created_at', 'desc')->paginate(2);
       return view('admin.pages.product.list', ['products' => $products]);
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
        //move_uploaded_file('image',$path);
        // dd($request->file('image')->getClientOriginalName());
        // Tao hinh anh file
        if($request->hasFile('image')){
            $fileOriginalName = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileOriginalName, PATHINFO_FILENAME);
            $fileName .= '_'.time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $fileName);

        }

        $check = DB::table('products')->insert([
            "name" => $request->name,
            "slug" => $request->slug,
            "price" => $request->price,
            "discount_price" =>$request->discount_price,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "information" => $request->information,
            "qty" => $request->qty,
            "shipping" => $request->shipping,
            "weight" =>$request->weight,
            "status" => $request->status,
            "product_category_id" => $request->product_category_id,
            "image" => $fileName,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()

        ]);
        // dd($request->all());
        $message = $check ? 'tao san pham thanh cong' : 'tao san pham that bai';

        return redirect()->route('admin.product.index')->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = DB::table('products')->find($id);
        $productCategories = DB::table('product_category')->where('status','=',1)->get();
        return view('admin.pages.productCategory.detail',['product' => $product, 'productCategories' => $productCategories]);
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
        $product = DB::table('products')->find($id);
        $image = $product->image;
        if(!is_null($image) && file_exists('images/'.$image)){
            unlink('images/'.$image);
        }

        // $request = DB::table('products')->where('id','=',$id)->delete();
        $result = DB::table('products')->delete($id);
        $message = $result ? 'xoa san phan thanh cong' : 'xoa san phan that bai';
        //session flash
        return redirect()->route('admin.product.index')->with('message', $message);

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
