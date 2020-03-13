Hello <b>{{ $completedOrderMailSend->receiver_name }}</b>,

<p><strong>{{ $completedOrderMailSend->date }}</strong> - {{ $completedOrderMailSend->sender_message }}</p>

@foreach($completedOrderMailSend->order->products as $product)
  <li>{{ $product->name }} - Quantity: {{ $product->quantity }}</li>
@endforeach 
<p>Price: {{ $completedOrderMailSend->order->price }}

<p>Thank you!</p>