<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    //
    public function index(){
        $products = Product::orderBy('created_at','desc')->limit(8)->get();
        return view('client.pages.home',['products' => $products]);
    }
}
