@extends('client.layout.master')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($cart as $productId => $item)
                               <tr id={{ $productId }}>
                                    <td class="shoping__cart__item">
                                        <img src="{{ $item['image'] ?? '' }}" alt="">
                                        <h5>{{ $item['name'] }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ${{ number_format($item['price'], 2) }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty"
                                            data-id="{{ $productId }}"
                                            data-url="{{ route('product.update-item-in-cart',['productId' => $productId]) }}"
                                            >
                                                <input class="qty" type="text" value="{{ $item['qty'] }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        ${{ number_format($item['qty'] * $item['price'], 2) }}
                                    </td>
                                    <td
                                    class="shoping__cart__item__close">
                                        <span data-id="{{ $productId }}"
                                         data-url="{{ route('product.delete-item-in-cart',['productId' => $productId]) }}"
                                            class="icon_close"></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$454.98</span></li>
                            <li>Total <span>$454.98</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('home-hero-banner'){
    <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
        <div class="hero__text">
            <span>FRUIT FRESH</span>
            <h2>Vegetable <br />100% Organic</h2>
            <p>Free Pickup and Delivery Available</p>
            <a href="#" class="primary-btn">SHOP NOW</a>
        </div>
    </div>
}

@endsection

@section('js-custom')
    <script>
        $(document).ready(function() {
            $('.icon_close').on('click', function() {
                var url = $(this).data('url');
                var id = $(this).data('id');
                $.ajax({
                    method: 'get', //method form
                    url: url, //action form
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                        });
                        $('tr#' + id).empty();
                    }
                });
            });
            $('.qtybtn').on('click',function(){
                var button = $(this);
                var id = button.parent().data('id');

                var qty = parseInt(button.siblings('qty').val());
                var url = button.parent().data('url');
                if(button.hasClass('inc')){
                    qty += 1;

                } else {
                    qty = (qty < 0) ? 0 : (qty -= 1);
                }
                url += "/" + qty;
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(response){
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                        });
                        $('tr#' + id).empty();
                    }
                });
            });
        });
    </script>
@endsection
