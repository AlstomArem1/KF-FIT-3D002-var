<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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

Route::get('test', function () {
    return view('test');
});

Route::get('test2', function () {
    return view('test2');
});

Route::get('Test', function () {
    echo "Hello Test";
});

Route::get('product', function (Request $request){
    echo "Product List" . $request->query('name');
});

Route::get('user/detail/{id}/{name?}',function($id, $name = ''){
    return "User detail: " . $id . $name;
});
