<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body style="font-family: Arial,Helvetica,sans-serif;font-size: 16px">
    @if($mailData['order'] == 'customer')
        <h2>Thanks for your order!!</h2>
        <h2>Your order ID is: #{{$mailData['order']->id}}</h2>
        @else
        <h2>You have received an order:</h2>
       <h2>Order ID: #{{$mailData['order']->id}}</h2>
    @endif

     <address>
         <strong>{{$mailData['order']->first_name.' '.$mailData['order']->last_name}}</strong><br>
         {{$mailData['order']->address}}<br>
         {{$mailData['order']->city->name}}, {{$mailData['order']->zip}}<br>
         Phone: {{$mailData['order']->mobile}}<br>
         Email: {{$mailData['order']->user->email}}
     </address>
<
<h2>Products </h2>
     <table cellpadding="3" cellspacing="3" border="0" width="700">
         <thead>
         <tr style="background:#CCC ">
             <th>Product</th>
             <th>Price</th>
             <th>Qty</th>
             <th>Total</th>
         </tr>
         </thead>
         <tbody>
         @foreach($mailData['order']->items as $orderItem)
             <tr>
                 <td>{{$orderItem->product->title}}</td>
                 <td>${{$orderItem->price}}</td>
                 <td>{{$orderItem->qty}}</td>
                 <td>${{$orderItem->total}}</td>
             </tr>
         @endforeach


         <tr>
             <th colspan="3" align="right">Subtotal:</th>
             <td>${{number_format($mailData['order']->subtotal,2)}}</td>
         </tr>
         <tr>
             <th colspan="3" align="right">Discount:</th>
             <td>${{number_format($mailData['order']->discount,2)}}</td>
         </tr>

         <tr>
             <th colspan="3" align="right">Shipping:</th>
             <td>${{number_format($mailData['order']->shipping,2)}}</td>
         </tr>
         <tr>
             <th colspan="3" align="right">Grand Total:</th>
             <td>${{number_format($mailData['order']->grand_total,2)}}</td>
         </tr>
         </tbody>
     </table>
</body>
</html>
