<?php $__env->startSection('content'); ?>

<section id="show-order" class="addresses">
     <div class="container generic__wrapper">
        <div class="header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <?php if(session()->has('error')): ?>
                    <div class="card-block text-danger">
                        <?php echo e(session()->get('error')); ?>

                    </div>
                    <?php endif; ?>
                <h3>
                    <i class="fa fa-shopping" aria-hidden="true"></i> Pedido Nº <span class="badge badge-primary badge-pill"><?php echo e($order->id); ?></span>
                </h3>
            </div>
            <div>
                <a href="<?php echo e(route('orders.list')); ?>" class="btn btn-outline-primary"><i class="fa fa-arrow-circle-left"></i> Voltar</a>

            <!-- refazer pagamento -->
            <?php if($order['status'] === 'WAITING' || empty($order['payment']) ): ?>
                    <a href="<?php echo e($order['_links']['checkout']['payCreditCard']); ?>" class="btn btn-outline-primary">
                        Refazer Pagamento
                    </a>
                <?php endif; ?>

            <!-- cancela apenas compras pré autorizadas -->
            <?php if(!empty($order['payment']) && $order['payment']['status']['origin'] === "PRE_AUTHORIZED"): ?>
                    <a href="javascript:;" class="btn btn-outline-primary">
                        Cancelar Compra
                    </a>
                <?php endif; ?>
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
                             <?php if(empty($order->payment)): ?>
                                 <div class="card-block">
                                     <p>Sem informações de pagamento, caso não tenha feito o pagamento você pode clicar no botão "Refazer Pagamento" que está logo acima;</p>
                                     <p>Caso tenha feito o pagamento, <a href="<?php echo e($order['_links']['checkout']['payCheckout']); ?>" target="_blank" class="btn-link">confira aqui</a> a situação do pedido.</p>
                                 </div>
                                 <?php else: ?>
                                 <table class="table table-stripped">
                                     <thead>
                                     <tr>
                                         <th>final <span class="badge badge-info"><?php echo e($order['payment']['detail']['last']); ?></span></th>
                                         <th>Status Pedido :: Pagamento</th>
                                         <th>Criado em</th>
                                         <th>Última atualização</th>
                                         <th>Vendedor</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     <tr>
                                         <td>
                                             <?php if($order->payment['detail']['brand'] === 'MASTERCARD'): ?>
                                                 <i class="fa fa-2x fa-cc-mastercard"></i>
                                             <?php elseif($order->payment['detail']['brand'] === 'VISA'): ?>
                                                 <i class="fa fa-2x fa-cc-visa"></i>
                                             <?php else: ?>
                                                 <i class="fa fa-2x fa-credit-card"></i>
                                             <?php endif; ?>
                                             <span>R$ <?php echo e($order['payment']['amount']); ?></span>
                                         </td>
                                         <td>
                                             <?php echo e(\App\Support\Moip\Utils::formatOrderStatus($order['status'])); ?>

                                             ::
                                             <?php echo e($order['payment']['status']['formatted']); ?>

                                         </td>
                                         <td>
                                             <?php echo e($order->created_at->diffForHumans()); ?>

                                             <!-- <?php echo e(\App\Support\Moip\Utils::formatDate($order['payment']['timestamps']['created_at'])->diffForHumans()); ?> -->
                                         </td>
                                         <td>
                                             <?php echo e($order['payment']['timestamps']['updated_at']); ?>

                                         </td>
                                         <td>
                                             <span class="badge badge-info"><?php echo e($order->seller->user->name); ?></span>
                                         </td>
                                     </tr>
                                     </tbody>
                                 </table>
                                 <?php endif; ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <br>
         <!-- detalhes da compra -->
         <?php if($order->payment): ?>
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
                                     <td><?php echo e($order->address->fulldate); ?> / <?php echo e($order->address->day); ?></td>
                                 </tr>
                                 <tr>
                                     <th>Horário</th>
                                     <td>entre <?php echo e($order->address->time->format('H:i A')); ?> à <?php echo e($order->address->time->addMinutes(30)->format('H:i A')); ?></td>
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
                                     <?php $__empty_1 = true; $__currentLoopData = $order['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                         <tr>
                                             <td><?php echo e($item['product']); ?></td>
                                             <td><?php echo e($item['detail']); ?></td>
                                             <td><?php echo e($item['quantity']); ?>x</td>
                                             <td>R$ <?php echo e(\App\Support\Moip\Utils::formatAmount($item['price'])); ?></td>
                                         </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                         <p>Não localizamos nenhum produto</p>
                                     <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>

                         </div>
                     </div>
                 </div>
             </div>
             <?php endif; ?>
         <!-- detalhes da compra -->
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>