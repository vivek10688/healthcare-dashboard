<!DOCTYPE html>
<html>
<head>
    <title>Order Placed</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Hi {{ $order->user->name }},</p>
    <p>Your order #{{ $order->id }} has been placed successfully.</p>
    <p>Details:</p>
    <ul>
        <li>Product: {{ $order->product->name }}</li>
        <li>Quantity: {{ $order->quantity }}</li>
        <li>Total Amount: ${{ number_format($order->total_amount, 2) }}</li>
    </ul>
    <p>Thank you for your order!</p>
</body>
</html>
