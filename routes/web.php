<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\ProfileController;
use App\Mail\MailToCustomer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
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

// Route::get('/lg', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function(){


    //User
    Route::get('user', [UserController::class, 'index'])->name('user.list');

    //Product Category
    Route::get('product_category', [ProductCategoryController::class, 'index'])->name('productCategory.list');
    //Add
    Route::get('product_category/add', [ProductCategoryController::class, 'add'])->name('productCategory.add');
    //Store
    Route::post('product_category/store', [ProductCategoryController::class, 'store'])->name('productCategory.store');

    //Detail
    Route::get('product_category/{product_category}', [ProductCategoryController::class, 'detail'])->name('productCategory.detail');
    //Update
    Route::post('product_category/update/{product_category}', [ProductCategoryController::class, 'update'])->name('productCategory.update');
    //Delete
    Route::get('product_category/destroy/{product_category}', [ProductCategoryController::class, 'destroy'])->name('productCategory.destroy');

    //Product
    // Route::get('product', [ProductController::class, 'index'])->name('product.list');
    Route::resource('product', ProductController::class);
    // php artisan make:controller Admin/Productroller --resource
    Route::get('product/{product}/restore',[ProductController::class, 'restore'])->name('product.restore');
    Route::post('product/slug',[ProductController::class, 'createSlug'])->name('product.create.slug');
    Route::post('product/Ckeditor-upload-image',[ProductController::class, 'uploadImage'])->name('product.ckedit.upload.image');

     //Dashboard
     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route::get('test', function (){return '<h1>Test</h1>';})->middleware('auth.admin');

// Route::get('7up', function(){return '7up';});
// Route::get('chivas', function(){return 'chivas';})->middleware('age.18');

// //users -> add column DOB -> timestamp()

// Route::get('a', function(){
//     $product = \App\Models\Product::find(12);
//     dd($product);
// });


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::middleware('auth')->group(function(){
    Route::get('product/add-to-cart/{productId}', [CartController::class, 'AddToCart'])->name('product.add-to-cart');
    Route::get('product/delete-item-in-cart/{productId}', [CartController::class, 'DeleteItem'])->name('product.delete-item-in-cart');
    Route::get('product/update-item-in-cart/{productId}/{qty?}', [CartController::class, 'UpdateItem'])->name('product.update-item-in-cart');
    Route::get('cart', [CartController::class, 'indexCart'])->name('cart.index');
    Route::get('product/delete-item-in-cart', [CartController::class, 'emptyCart'])->name('product.delete-item-in-cart');
    Route::get('checkout', [CartController::class, 'checout'])->name('checkout');
    Route::post('placeorder',[OrderController::class, 'placeOrder'])->name('place-order');
    Route::get('vnpay-callback', [OrderController::class, 'vnpayCallback'])->name('vnpay-callback');




});

// Route::get('text-send-mail',function(){
// //use Illuminate\Support\Facades\Mail;
//    // Mail::to('thienthantoanthangnumber1@gmail.com')->send(new MailToCustomer);
// });
// Route::get('test', function(){
//     $order = Order::find(17);
//     $orderItems = $order->order_items;
//     $cart = [];

//     foreach($orderItems as $item){
//         $product = Product::find($item->product_id);
//         $imagesLink = is_null($product->image)
//         || !file_exists('images/' . $product->image)
//         ? 'https://phutungnhapkhauchinhhang.com/wp-content/uploads/2020/06/default-thumbnail.jpg'
//         : asset('images/' . $product->image);
//         $cart[$item->product_id] = [
//             'name' => $item->product_name,
//             'price' => $item->product_price,
//             'image' => $imagesLink,
//             'qty' => $item->qty
//         ];
//     }
//     dd($cart);
//     // dd(session()->get('cart', []));
//     dd($orderItems);
// });

Route::get('google-redirect',[GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('google-callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('test-send-sms', function(){
    // Your Account SID and Auth Token from console.twilio.com
    $sid = env('TWILIO_ACCOUNT_SID');
    $token = env('TWILIO_AUTH_TOKEN');
    $client = new Twilio\Rest\Client($sid, $token);

    // Use the Client to make requests to the Twilio REST API
    $client->messages->create(
        // The number you'd like to send the message to
        '+84388609749',
        [
            // A Twilio phone number you purchased at https://console.twilio.com
            'from' => env('TWILIO_PHONE_NUMBER'),
            // The body of the text message you'd like to send
            'body' => "Test Send SMS"
        ]
    );
});
