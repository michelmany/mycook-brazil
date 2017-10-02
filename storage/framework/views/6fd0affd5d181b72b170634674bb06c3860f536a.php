<?php $__env->startSection('title', 'Entre ou Cadastre-se'); ?>
<?php $__env->startSection('content'); ?>
    <section class="hero-pages"
        style="background-image: url('/assets/img/hero-01.jpg')">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto"><?php echo $__env->yieldContent('title'); ?></div>
        </div>
    </section>

    <div class="cadastro wrapper">

        <div class="container">

            <div class="row justify-content-md-center">
                <div class="col-md-6 col-lg-5 px-0 pb-3">
                    <div class="cadastro__headline text-center">
                        Quero me cadastrar
                    </div>
                    <div id="cadastro-form" class="cadastro__form-content">

                    <a href="<?php echo e(route('facebookAuth', 'facebook')); ?>" class="btn btn-facebook cadastro__button">
                        <i class="fa fa-facebook"></i> Cadastrar com facebook</a>
                    <button class="btn btn-email cadastro__button" v-on:click="show = !show">
                        <i class="fa fa-envelope-o"></i>Cadastrar com Email</button>

                        <?php if(count($errors) > 0): ?>
                            <div class="text-danger">
                                Validação falhou...
                            </div>
                        <?php endif; ?>

                        <transition name="slide-fade">
                            <div class="cadastrar__form-email mt-2 mb-3" <?php if(count($errors) === 0): ?> v-if="show" <?php endif; ?>>
                                <form action="<?php echo e(route('registerPost', compact('intended'))); ?>" method="post">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg input__entrar"
                                            name="name" required placeholder="Digite seu nome" value="<?php echo e(old('name')); ?>">
                                        <?php echo $__env->make('components.error', ['field'=>'name'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg input__entrar"
                                            name="email" required placeholder="Digite seu email" value="<?php echo e(old('email')); ?>">
                                        <?php echo $__env->make('components.error', ['field'=>'email'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg input__entrar"
                                            name="password" required placeholder="Digite sua senha mycook" value="<?php echo e(old('password')); ?>">
                                        <?php echo $__env->make('components.error', ['field'=>'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg input__entrar"
                                            name="confirm_password" required placeholder="Confirme sua senha" value="">
                                        <?php echo $__env->make('components.error', ['field'=>'password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg input__entrar"
                                            name="phone" required placeholder="Digite seu telefone" value="<?php echo e(old('phone')); ?>">
                                        <?php echo $__env->make('components.error', ['field'=>'phone'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="true" name="aceito-termos" checked>
                                            <?php echo $__env->make('components.error', ['field'=>'aceito-termos'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        </label>
                                        <span data-toggle="modal" data-target="#modalTermos" style="cursor: pointer">Li e aceito os termos de uso e as políticas de privacidade.</span>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-submit-green btn-lg" type="submit">Cadastrar</button>
                                    </div>
                                </form>
                            </div><!-- /cadastrar com email -->
                        </transition>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modal Termos -->
                <div class="modal fade" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#F95700">
                                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">TERMOS E CONDIÇÕES DE USO MYCOOK</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php echo $__env->make('./partials/termos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /modal -->

                <div class="col-md-6 col-lg-5 px-0 pt-3 pt-md-0 pt-sm-3">

                    <div class="cadastro__headline text-center">Já sou cadastrado</div>

                    <div class="cadastro__form-content">
                        <a href="<?php echo e(route('facebookAuth', 'facebook')); ?>" class="btn btn-facebook cadastro__button"><i class="fa fa-facebook"></i> Acessar com facebook</a>

                        <?php if(session('validation-error')): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i> <?php echo e(session('validation-error')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('login', compact('intended'))); ?>" method="post">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg input__entrar" name="email" value="<?php echo e(old('email')); ?>" required placeholder="Digite seu email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg input__entrar" name="password" required placeholder="Digite sua senha">
                            </div>
                            <div class="">
                                <button class="btn btn-submit-green btn-lg" type="submit">Entrar</button>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label cadastro__check-label">
                                    <input class="form-check-input" type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> Lembrar de mim
                                </label>
                            </div>

                        </form>
                    </div>
                    <!-- /form-content -->
                    
                </div>
            </div>

            <div class="line-vertical hidden-sm-down"></div>

        </div><!-- /container -->


    </div>
        


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
    const cadastroForm = new Vue({
        el: '#cadastro-form',
        data: {
            show:  false
        }
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>