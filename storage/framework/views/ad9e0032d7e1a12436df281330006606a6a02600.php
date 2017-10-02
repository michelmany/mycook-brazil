<?php $__env->startSection('content'); ?>

<section id="orders" class="addresses">
    <div class="container generic__wrapper">
        <div class="header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fa fa-shopping" aria-hidden="true"></i> Meus Pedidos</h2>
                <h6>Acompanhe suas compras</h6>
            </div>
            <div>
                <a href="<?php echo e(url('lista-chefs')); ?>" class="btn btn-submit-orange mt-3 mb-3">
                    Nova Compra
                </a>    
            </div>
        </div>
        <hr>

        
        <list-orders></list-orders>

    </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        var orders = new Vue({
            el: '#orders',
            mounted() {
                console.log(Event)
            }
        });
    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>