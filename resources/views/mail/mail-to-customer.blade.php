<h1>Order # {{ $order->id }}</h1>
Total : {{ $order->total }}
<table border="1" >
    <tr>
        <th>STT</th>
        <th>NameTT</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>

    </tr>
    @foreach ($order->order_items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->product_price }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ number_format($item->product_price * $item->qty, 2) }}</td>
        </tr>

    @endforeach
        <tr>
            <td colspan="5">Total : {{ number_format($order->total, 2) }}</td>
        </tr>
</table>

