<?php $__env->startSection('content'); ?>

<section id="list-chefs-page" class="list-chefs">

    <search-chef></search-chef>

    
    <div class="filter"></div>

    <div class="chefs-list">
        <div class="container generic__wrapper">
            <div class="header mb-3">
                <div>
                    <h2>Chefs próximos a você</h2>
                </div>
            </div>      
        <?php if(session()->has('fail')): ?>
            <p class="text-danger"><?php echo e(session()->get('fail')); ?></p>
        <?php endif; ?>

        <?php if(isset($latitude)): ?>
            <list-chefs :latitude="<?php echo e($latitude); ?>" :longitude="<?php echo e($longitude); ?>"></list-chefs>
        <?php else: ?>
            <list-chefs></list-chefs>
        <?php endif; ?>
        </div>
    </div>


</section>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script>
        var ListChefsPage = new Vue({
            el: '#list-chefs-page',
            created() {

            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>