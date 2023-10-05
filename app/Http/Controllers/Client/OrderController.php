<?php

namespace App\Http\Controllers\Client;

use App\Events\PlaceOrderSuccess;
use App\Http\Controllers\Controller;
use App\Mail\MailToAdmin;
use App\Mail\MailToCustomer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function placeOrder(Request $request){
        // Laravel Database Transaction
        try{
            DB::beginTransaction();
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->address = $request->address;
            $order->note = $request->notes;
            $order->status = Order::STATUS_PENDING;
            $order->save();


            $cart = session()->get('cart', []);
            $total = 0;
            foreach($cart as $productId => $item){
                $orderItems = new OrderItem;
                $orderItems->order_id = $order->id;
                $orderItems->product_id = $productId;
                $orderItems->product_name = $item['name'];
                $orderItems->product_price = $item['price'];
                $orderItems->qty = $item['qty'];
                $orderItems->save();
                $total += $item['price'] * $item['qty'];
            }

            $order->subtotal = $total;
            $order->total = $total;
            $order->save();//update id = 20

            // $orderPaymentMethod = new OrderPaymentMethod


            //Elaquent xet phpadmin =>http.checkout > orders


             //Eloquent - 1
            // $orderPaymentMethod = new OrderPaymentMethod;
            // $orderPaymentMethod->order_id  = $order->id;
            // $orderPaymentMethod->payment_provider = $request->payment_method;
            // $orderPaymentMethod->status = OrderPaymentMethod::STATUS_PENDING;
            // $orderPaymentMethod->total = $order->total; //$total
            // $orderPaymentMethod->save();

            //Eloquent -2 - Mass Assigament
            $orderPaymentMethod= OrderPaymentMethod::create([
                'order_id' => $order->id,
                'payment_provider' => $request->payment_method,
                'status' => OrderPaymentMethod::STATUS_PENDING,
                'total' => $order->total,
                'note' => 'TESTTTTTTTTTT',
            ]);
            $user = User::find(Auth::user()->id);
            $user->phone = $request->phone;
            $user->save();

            session()->put('cart',[]);

            DB::commit();

            event(new PlaceOrderSuccess($order, $user, $cart));

            //Send mail to customer to cofirm order
            //Mail::to(Auth::user()->email)->send(new MailToCustomer);
            //Send mail to admin to prepare




            return redirect()->route('home.index');
        }
        catch(\Exception $exception){
            dd($exception->getMessage());
            DB::rollBack();
        }
    }
}
