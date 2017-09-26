@extends('layouts.default')
@section('content')

<section id="show-order" class="addresses">
     <div class="container generic__wrapper">
        <div class="header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                @if(session()->has('error'))
                    <div class="card-block text-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                <h3>
                    <i class="fa fa-shopping" aria-hidden="true"></i> Pedido Nº <span class="badge badge-primary badge-pill">{{ $order->id}}</span>
                </h3>
            </div>
            <div>
                <a href="{{ route('orders.list') }}" class="btn btn-outline-primary"><i class="fa fa-arrow-circle-left"></i> Voltar</a>

            <!-- refazer pagamento -->
            @if($order['status'] === 'WAITING' || empty($order['payment']) )
                    <a href="{{ $order['_links']['checkout']['payCreditCard'] }}" class="btn btn-outline-primary">
                        Refazer Pagamento
                    </a>
                @endif

            <!-- cancela apenas compras pré autorizadas -->
            @if(!empty($order['payment']) && $order['payment']['status']['origin'] === "PRE_AUTHORIZED")
                    <a href="javascript:;" class="btn btn-outline-primary">
                        Cancelar Compra
                    </a>
                @endif
            </div>
        </div>
        <br>
         <div class="row">
             <div class="col-md-12">
                 <div class="card">
                     <div class="card-header">
                         <h3>Informações</h3>
                     </div>
                     <div class="card-block">

                         <div class="row">
                             @if(empty($order->payment))
                                 <div class="card-block">
                                     <p>Sem informações de pagamento, caso não tenha feito o pagamento você pode clicar no botão "Refazer Pagamento" que está logo acima;</p>
                                     <p>Caso tenha feito o pagamento, <a href="{{ $order['_links']['checkout']['payCheckout'] }}" target="_blank" class="btn-link">confira aqui</a> a situação do pedido.</p>
                                 </div>
                                 @else
                                 <table class="table table-stripped">
                                     <thead>
                                     <tr>
                                         <th>final <span class="badge badge-info">{{ $order['payment']['detail']['last'] }}</span></th>
                                         <th>Status Pedido :: Pagamento</th>
                                         <th>Criado em</th>
                                         <th>Última atualização</th>
                                         <th>Vendedor</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     <tr>
                                         <td>
                                             @if($order->payment['detail']['brand'] === 'MASTERCARD')
                                                 <i class="fa fa-2x fa-cc-mastercard"></i>
                                             @elseif($order->payment['detail']['brand'] === 'VISA')
                                                 <i class="fa fa-2x fa-cc-visa"></i>
                                             @else
                                                 <i class="fa fa-2x fa-credit-card"></i>
                                             @endif
                                             <span>R$ {{ $order['payment']['amount'] }}</span>
                                         </td>
                                         <td>
                                             {{ \App\Support\Moip\Utils::formatOrderStatus($order['status']) }}
                                             ::
                                             {{ $order['payment']['status']['formatted'] }}
                                         </td>
                                         <td>
                                             {{ \App\Support\Moip\Utils::formatDate($order['payment']['timestamps']['created_at'])->diffForHumans() }}
                                         </td>
                                         <td>
                                             {{ $order['payment']['timestamps']['updated_at'] }}
                                         </td>
                                         <td>
                                             <span class="badge badge-info">{{ $order->seller->user->name }}</span>
                                         </td>
                                     </tr>
                                     </tbody>
                                 </table>
                                 @endif
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <br>
         <!-- detalhes da compra -->
         @if($order->payment)
             <div class="row">
                 <div class="col-md-4">
                     <div class="card">
                         <div class="card-header">
                             <h3>Dados Entrega</h3>
                         </div>
                         <div class="card-block">
                             <table class="table table-stripped">
                                 <thead>
                                 <tr>
                                     <th>Dia</th>
                                     <td>{{ $order->address->fulldate }}</td>
                                 </tr>
                                 <tr>
                                     <th>Horário</th>
                                     <td>entre {{ $order->address->time->format('H:i A') }} à {{ $order->address->time->addMinutes(30)->format('H:i A') }}</td>
                                 </tr>
                                 </thead>
                             </table>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-8">
                     <div class="card">
                         <div class="card-header">
                             <h3>Detalhes da Compra</h3>
                         </div>
                         <div class="card-block">

                             <div class="row">
                                 <table class="table table-stripped">
                                     <thead>
                                     <tr>
                                         <th>Produto</th>
                                         <th>Descrição</th>
                                         <th>Quantidade</th>
                                         <th>Valor</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     @forelse($order['items'] as $item)
                                         <tr>
                                             <td>{{ $item['product'] }}</td>
                                             <td>{{ $item['detail']}}</td>
                                             <td>{{ $item['quantity'] }}x</td>
                                             <td>R$ {{ \App\Support\Moip\Utils::formatAmount($item['price']) }}</td>
                                         </tr>
                                     @empty
                                         <p>Não localizamos nenhum produto</p>
                                     @endforelse
                                     </tbody>
                                 </table>
                             </div>

                         </div>
                     </div>
                 </div>
             </div>
             @endif
         <!-- detalhes da compra -->
    </div>
</section>
@endsection