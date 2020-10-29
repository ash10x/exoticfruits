<?php
    $users=\Auth::user();
    $profile=asset(Storage::url('uploads/avatar/'));
    $logo=asset(Storage::url('uploads/logo/'));
    $currantLang = $users->currentLanguage();
    $languages=Utility::languages();
?>
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto search-element" method="post">
        <div class="easy-autocomplete" style="width: 0px;"><input type="hidden" name="_token" value="ifSnVqGphjkOu1aqYvyflvadZqTOLssR8oVLlL9q" id="eac-5343" style="" autocomplete="off">
            <div class="easy-autocomplete-container" id="eac-container-eac-5343">
                <ul></ul>
            </div>
        </div>
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">
        <?php if( Gate::check('create product & service') ||  Gate::check('create customer') ||  Gate::check('create vender')||  Gate::check('create proposal')||  Gate::check('create invoice')||  Gate::check('create bill') ||  Gate::check('create goal') ||  Gate::check('create bank account')): ?>
            <li class="dropdown dropdown-list-toggle">
                <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle">
                    <i class="far fa-bookmark"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right custom-dropdown-menu">
                    <div class="row shortcuts px-4">
                        <?php if(Gate::check('create product & service')): ?>
                            <a href="#" class="col-6 shortcut-item text-center" data-url="<?php echo e(route('productservice.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Product')); ?>">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                                  <i class="fas fa-shopping-cart custom-icon"></i>
                                </span><br>
                                <small class="h-font"><?php echo e(__('Create New Product')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create customer')): ?>
                            <a href="#!" class="col-6 shortcut-item text-center" data-size="2xl" data-url="<?php echo e(route('customer.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Customer')); ?>">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="far fa-user custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Customer')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create vender')): ?>
                            <a href="#!" class="col-6 shortcut-item text-center" data-size="2xl" data-url="<?php echo e(route('vender.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Vendor')); ?>">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-sticky-note custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Vendor')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create proposal')): ?>
                            <a href="<?php echo e(route('proposal.create',0)); ?>" class="col-6 shortcut-item text-center">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-file custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Proposal')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create invoice')): ?>
                            <a href="<?php echo e(route('invoice.create',0)); ?>" class="col-6 shortcut-item text-center">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="far fa-money-bill-alt custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Invoice')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create bill')): ?>
                            <a href="<?php echo e(route('bill.create',0)); ?>" class="col-6 shortcut-item text-center">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-money-bill-wave-alt custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Bill')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create bank account')): ?>
                            <a href="#" class="col-6 shortcut-item text-center" data-url="<?php echo e(route('bank-account.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Account')); ?>">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-university custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Account')); ?></small>
                            </a>
                        <?php endif; ?>
                        <?php if(Gate::check('create goal')): ?>
                            <a href="#" class="col-6 shortcut-item text-center" data-url="<?php echo e(route('goal.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Goal')); ?>">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fa fa-bullseye custom-icon"></i>
                        </span><br>
                                <small class="h-font"><?php echo e(__('Create New Goal')); ?></small>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg language-dd"><i class="fas fa-language"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header"><?php echo e(__('Choose Language')); ?>

                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create language')): ?>
                    <a href="<?php echo e(route('manage.language',[$currantLang])); ?>" class="dropdown-item btn manage-language-btn">
                        <span> <?php echo e(__('Create & Customize')); ?></span>
                    </a>
                <?php endif; ?>
                <div class="dropdown-list-content dropdown-list-icons">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Auth::guard('customer')->check()): ?>
                            <a href="<?php echo e(route('customer.change.language',$language)); ?>" class="dropdown-item dropdown-item-unread <?php if($language == $currantLang): ?> active-language <?php endif; ?>">
                                <span> <?php echo e(Str::upper($language)); ?></span>
                            </a>
                        <?php elseif(\Auth::guard('vender')->check()): ?>
                            <a href="<?php echo e(route('vender.change.language',$language)); ?>" class="dropdown-item dropdown-item-unread <?php if($language == $currantLang): ?> active-language <?php endif; ?>">
                                <span> <?php echo e(Str::upper($language)); ?></span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('change.language',$language)); ?>" class="dropdown-item dropdown-item-unread <?php if($language == $currantLang): ?> active-language <?php endif; ?>">
                                <span> <?php echo e(Str::upper($language)); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?php echo e((!empty($users->avatar)? $profile.'/'.$users->avatar : $profile.'/avatar.png')); ?>" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block"><?php echo e(__('Hi')); ?>, <?php echo e(\Auth::user()->name); ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title"><?php echo e(__('Welcome!')); ?></div>
                <?php if(\Auth::guard('customer')->check()): ?>
                    <a href="<?php echo e(route('customer.profile')); ?>" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> <?php echo e(__('My profile')); ?>

                    </a>
                <?php elseif(\Auth::guard('vender')->check()): ?>
                    <a href="<?php echo e(route('vender.profile')); ?>" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> <?php echo e(__('My profile')); ?>

                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('profile')); ?>" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> <?php echo e(__('My profile')); ?>

                    </a>
                <?php endif; ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span><?php echo e(__('Logout')); ?></span>
                </a>
                <?php if(\Auth::guard('customer')->check()): ?>
                    <form id="frm-logout" action="<?php echo e(route('customer.logout')); ?>" method="POST" style="display: none;">
                        <?php echo e(csrf_field()); ?>

                    </form>
                <?php else: ?>
                    <form id="frm-logout" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo e(csrf_field()); ?>

                    </form>
                <?php endif; ?>
            </div>
        </li>

    </ul>
</nav>

<?php /**PATH /var/www/exoticfruits/resources/views/partials/admin/header.blade.php ENDPATH**/ ?>