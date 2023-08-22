<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function (){
   return view('test');
});

Route::get('test2', function (){
    return view('test2');
 });

//use Illuminate\Http\Request;
//http://127.0.0.1:8000/product?name=aaaa
Route::get('product', function (Request $request){
    echo 'Product List'. $request->query('name');
});

//http://127.0.0.1:8000/user/detail/13/ngyuyenvana
//http://127.0.0.1:8000/user/detail/13
Route::get('user/detail/{id}/{name?}', function ($id, $name = ''){
    return 'User detail : '.$id. $name;
});

Route::get('master', function (){
    return view('client.layout.master');
});

Route::get('home', function(){
    return view('client.pages.home');
});
// Route::get('product', function (){
//     return view('client.pages.product.list');
// });

// Route::get('blog/detail', function (){
//     return view('client.pages.blog.detail');
// });
