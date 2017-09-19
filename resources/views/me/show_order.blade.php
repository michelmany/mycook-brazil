@extends('layouts.default')
@section('content')

<section id="show-order" class="addresses">
     <div class="container generic__wrapper">
        <div class="header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2>
                    <i class="fa fa-shopping" aria-hidden="true"></i> Pedido Nº <span class="badge badge-primary badge-pill">{{ $order->ownId}} </span>
                </h2>
            </div>
            <div>
                <a href="{{ route('orders.list') }}" class="btn btn-outline-primary"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
                
                <!-- refazer pagamento -->
                @if($order->status->origin === 'WAITING' || $order->payment->status->origin === 'WAITING')
                    <a href="{{ $order->_links->checkout }}" class="btn btn-outline-primary">
                        Refazer Pagamento
                    </a>
                    @endif
                <!-- cancela apenas compras pré autorizadas -->
                @if($order->payment->status->origin === "PRE_AUTHORIZED")
                    <a href="javascript:;" class="btn btn-outline-primary">
                        Cancelar Compra
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Informações</h3>
                    </div>
                    <div class="card-block">

                        <div class="row">
                            <table class="table table-stripped">
                                <thead>
                                <tr>
                                    @if($order->payment->detail->type === 'CREDIT_CARD')
                                        <th>final <span class="badge badge-info">{{ $order->payment->detail->last }}</span></th>
                                    @else
                                        <th>#</th>
                                    @endif
                                    <th>Status Pedido / Pagamento</th>
                                    <th>Criado em</th>
                                    <th>Vendedor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        @if($order->payment->detail->type === 'CREDIT_CARD')
                                            <i class="fa fa-2x fa-credit-card"></i>
                                            <span>R$ {{ $order->payment->amount }}</span>
                                            @else
                                            <i class="fa fa-2x {{ $order->payment->detail->type === 'BOLETO' ? 'fa-barcode' : ''}}" aria-hidden="true"></i>
                                            <span>R$ {{ $order->payment->amount }}</span>
                                            @endif
                                    </td>
                                    <td>
                                        {{ $order->status->formatted }}
                                        /
                                        {{ $order->payment->status->formatted }}
                                    </td>
                                    <td>
                                        {{ $order->payment->timestamps->created_at }}
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $order->chef->name }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- detalhes da compra -->
        <div class="row">
             <div class="col-md-4">
                 <div class="card">
                     <div class="card-header">
                         <h3>Dados Entrega</h3>
                     </div>
                     <div class="card-block">
                         @if($order->courier)
                             <table class="table table-stripped">
                                 <thead>
                                 <tr>
                                     <th>Dia da Entrega</th>
                                     <th>Hora</th>
                                 </tr>
                                 <tr>
                                     <th>{{ $order->courier->fulldate }}</th>
                                     <th>{{ \Carbon\Carbon::parse($order->courier->time)->format('H:i A') }}</th>
                                 </tr>
                                 </thead>
                             </table>
                             @else
                             <p class="text-info">Sem informações de Entrega</p>
                             @endif
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
                                 @forelse($order->items as $item)
                                     <tr>
                                         <td>{{ $item->name }}</td>
                                         <td>{{ $item->detail}}</td>
                                         <td>{{ $item->qty }}x</td>
                                         <td>R$ {{ $item->price }}</td>
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
        <!-- detalhes da compra -->
    </div>
</section>
@endsection