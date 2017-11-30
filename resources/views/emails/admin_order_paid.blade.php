@component('mail::message')
<h3># Um novo pedido foi realizado</h3>

<h4><b>Dados do Vendedor:</b></h4>
<div>{{ $order->seller['user']['name'] }}</div>    
<div>Email: {{ $order->seller['user']['email'] }}</div>    
<div>Telefone: ({{ $order->seller['ddd'] }}) {{ $order->seller['phone'] }}</div>
<br>

<h4><b>Dados do comprador:</b></h4>
<div>{{ $order->buyer['name'] }}</div>    
<div>Email: {{ $order->buyer['email'] }}</div>    
<div>Telefone: ({{ $order->buyer['ddd'] }}) {{ $order->buyer['phone'] }}</div>
<br>

<h4><b>Detalhes do pedido:</b></h4>
<div>Status: {{ $order->status->formatted }}</div>
<div>ID: {{ $order->id }}</div>
<br>

<h5>Itens:</h5>
@foreach($order->items as $item)
<div>
Produto:<br>
{{ $item->name }}<br>
Quantidade: {{ $item->qty }}
<br><br>
</div>
@endforeach

<h5>Entrega:</h5>
<div>Dia: {{ $order->time }}</div>
<div>Endereço: {{ $address['address']}}, {{ $address['number'] }}</div>
@if($address['complement'])
<div>{{ $address['complement'] }}</div>
@endif
<div>{{ $address['neighborhood']}}, {{ $address['city'] }} - {{ $address['state'] }}</div>
<div>{{ $address['city'] }}</div>
<br>
<div>Latitude: {{ $address['latitude'] }}</div>
<div>Longitude: {{ $address['longitude'] }}</div>

{{-- {{ dd($order, $address) }} --}}
@endcomponent