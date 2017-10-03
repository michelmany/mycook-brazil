<?php $__env->startSection('title', 'Registrar'); ?>
<?php $__env->startSection('content'); ?>

<section id="profile" class="profile">
    <div class="container generic__wrapper">
        <div class="header">
            <div>
                <h2><i class="fa fa-user" aria-hidden="true"></i> Meu perfil</h2>
                <h6>Edite seu perfil</h6>
            </div>
        </div>
        <hr>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>



        <div>
                <div class="row">

                    <div class="col-md-6">
                        <h5 class="mb-3 bg-faded p-3">Informações pessoais</h5>

                        <profile-dados :user="<?php echo e($user); ?>" :buyer="<?php echo e($buyer); ?>"></profile-dados>

                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3 bg-faded p-3">Senha</h5>

                        <profile-senha password-is-null="<?php echo e($passwordIsNull); ?>"></profile-senha>
                            
                    </div>

                </div><!-- /row -->


    </div><!-- /container -->
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        const profile = new Vue({
            el: '#profile'
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>