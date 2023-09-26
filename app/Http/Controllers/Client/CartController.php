<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function AddToCart($productId){

        $product = Product::find($productId);

        $cart = session()->get('cart') ?? [];
        $imagesLink = is_null($product->image) || !file_exists('images/' . $product->image)
        ? 'https://phutungnhapkhauchinhhang.com/wp-content/uploads/2020/06/default-thumbnail.jpg'
        : asset('images/' . $product->image);
        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $imagesLink,
            'qty' => ($cart[$productId]['qty'] ?? 0) + 1
        ];
        session()->put('cart',$cart);
        // dd(session()->get('cart'));
        return response()->json(['message' => 'Add product to Cart success']);

    }
    public function indexCart(){
        $cart = session()->get('cart') ?? [];
        return view('client.pages.cart',['cart' => $cart]);
    }
}
