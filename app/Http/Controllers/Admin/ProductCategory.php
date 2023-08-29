<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Controller
{
    //
    public function index(){
        $productCategories = DB::select('select * from product_categories');
        return view('admin.pages.productCategory.list', ['productCategories' => $productCategories]);

        // return view('admin.pages.productCategory.list', compact($productCategories));
        // return view('admin.pages.productCategory.list')->with('productCategories', $productCategories);

    }
    public function add(){
        return view('admin.pages.productCategory.create');
    }
    public function store(Request $request){

        $request->validate([
            'name' => 'required|min:3|max:255|unique:product_categories,name',
            'status' => 'required'
        ],

        [
            'name.required' => 'Ten buoc phai nhap!',
            'name.min' => 'Ten phai tren 3 ky tu',
            'name.max' => 'Ten phai duoi 255 ky tu',
            'status.required' => 'Trang thai buoi phai chon!'
        ]);
        $bool = DB::insert('INSERT into product_categories(name, status, created_at, updated_at) values (?, ?, ?, ?)', [
            $request->name,
            $request->status,
            Carbon::now()->addDay(999)->addMonth()->addYear(),
            Carbon::now()
        ]);
        // dd('thanh cong');
        // dd($request->all());
        // $name = $request->name;
        // $status = $request->status;

        $message = $bool ? 'thanh cong' : 'that bai';

        //Session flash
        return redirect()->route('admin.productCategory.list')->with('message',$message);
    }
    public function detail(){
        dd(1);
    }
}
