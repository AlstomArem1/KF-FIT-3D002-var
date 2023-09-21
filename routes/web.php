<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductCategoryController;

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::prefix('admin')->name('admin.')->group(function(){


    //User
    Route::get('user', [UserController::class, 'index'])->name('user.list');

    //Product Category
    Route::get('product_category', [ProductCategoryController::class, 'index'])->name('productCategory.list');
    //Add
    Route::get('product_category/add', [ProductCategoryController::class, 'add'])->name('productCategory.add');
    //Store
    Route::post('product_category/store', [ProductCategoryController::class, 'store'])->name('productCategory.store');

    //Detail
    Route::get('product_category/{id}', [ProductCategoryController::class, 'detail'])->name('productCategory.detail');
    //Update
    Route::post('product_category/update/{id}', [ProductCategoryController::class, 'update'])->name('productCategory.update');
    //Delete
    Route::get('product_category/destroy/{id}', [ProductCategoryController::class, 'destroy'])->name('productCategory.destroy');

    //Product
    // Route::get('product', [ProductController::class, 'index'])->name('product.list');
    Route::resource('product', ProductController::class);
    // php artisan make:controller Admin/Productroller --resource

    Route::post('product/slug',[ProductController::class, 'createSlug'])->name('product.create.slug');

    Route::post('product/{product}/restore',[ProductController::class, 'restore'])->name('product.restore');

    Route::post('product/Ckeditor-upload-image',[ProductController::class, 'uploadImage'])->name('product.ckedit.upload.image');
});

Route::get('test', function (){return '<h1>Test</h1>';})->middleware('auth.admin');

Route::get('7up', function(){return '7up';});
Route::get('chivas', function(){return 'chivas';})->middleware('age.18');

//users -> add column DOB -> timestamp()

Route::get('a', function(){
    $product = \App\Models\Product::find(12);
    dd($product);
});
