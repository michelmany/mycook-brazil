<?php $__env->startSection('content'); ?>

<section id="single-chef-page" class="list-chefs">
    <section class="chef-header" style="background-color: white;">
        <div class="container generic__wrapper">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    <div class="chef-item__photo mr-3">
                        
                        <img class="rounded-circle" src="<?php echo e($seller->avatar_full_url); ?>" width="150" height="150" style="background-color: #E9EBEE;">
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <h3><?php echo e($seller->name); ?></h3>
                    <?php if($seller->distance): ?>
                        <div class="chef-item__distance"><small class="text-uppercase">A <?php echo e($seller->distance); ?> Km de distância</small></div>
                    <?php endif; ?>

                    <p>A casa aposta no conceito de gastrobar, ou seja, oferece uma boa gastronomia com toda a descontração de um bar. No cardápio assinado pelo chef Waldomiro Santos, que tem passagem pelo Bar des Arts e O Leopolldo, pratos com toque autoral como a picanha grelhada ao molho à base de creme de leite e shoyu com shiitake laminado, guarnecido de risoto do próprio molho.</p>
                </div>
                <div class="col-md-3 col-lg-4">
                    
                </div>
            </div>
        </div>

    </section>

    <div class="chefs-list">
        <div class="container generic__wrapper">
            <div class="header mb-3">
                <h2>Cardápio</h2>
            </div>
            <br>
            <single-chef :seller="<?php echo e($seller); ?>" :moip="<?php echo e($moipseller); ?>"></single-chef>
        </div>
    </div>

</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    var SingleChefsPage = new Vue({
        el: '#single-chef-page',
        data: {}
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>