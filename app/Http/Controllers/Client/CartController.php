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
        $total_price = $this->calculateTotalPrice($cart);
        $total_items = count($cart);

        // dd(session()->get('cart'));
        return response()->json([
            'message' => 'Add product to Cart success',
            'total_price' => $total_price,
            'total_items' => $total_items
        ]);
    }
    public function calculateTotalPrice($cart):float{
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    public function indexCart(){
        $cart = session()->get('cart') ?? [];
        return view('client.pages.cart',['cart' => $cart]);
    }

    public function DeleteItem($productId){
        $cart = session()->get('cart',[]);
        if(array_key_exists($productId, $cart)){
            unset($cart[$productId]);
            session()->put('cart',$cart);

        }
        return response()->json(['message' => 'Deleta item success']);
    }

    public function UpdateItem($productId, $qty){
        $cart = session()->get('cart',[]);
        if(array_key_exists($productId, $cart)){
            $cart[$productId]['qty'] = $qty;
            session()->put('cart', $cart);

        }
        $total_price = $this->calculateTotalPrice($cart);
        $total_items = count($cart);
        return response()->json([
            'message' => 'Update item success',
            'total_price' => $total_price,
            'total_items' => $total_items
        ]);
    }
    public function emptyCart(){
       session()->get('cart',[]);
       return response()->json([
        'message' => 'Cart item success',
        'total_price' => 0,
        'total_items' => 0
        ]);
    }
    public function checout(){
        $cart = session()->get('cart',[]);
        return view('client.pages.checkout',['cart' => $cart]);
    }
}
