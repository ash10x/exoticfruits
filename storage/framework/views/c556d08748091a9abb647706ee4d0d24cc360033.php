<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Product & Service')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Product & Service')); ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <div class="breadcrumb-item"><?php echo e(__('Product & Service')); ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4><?php echo e(__('Manage Product & Service')); ?></h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-icon icon-left btn-primary">
                                            <i class="fas fa-filter"></i><?php echo e(__('Filter')); ?>

                                        </a>
                                        <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown <?php echo e(isset($_GET['category'])?'show':''); ?>">
                                            <?php echo e(Form::open(array('route' => array('productservice.index'),'method' => 'GET'))); ?>

                                            <div class="form-group">
                                                <?php echo e(Form::label('category', __('Category'))); ?>

                                                <?php echo e(Form::select('category', $category,null, array('class' => 'form-control font-style selectric','required'=>'required'))); ?>

                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary"><?php echo e(__('Search')); ?></button>
                                                <a href="<?php echo e(route('productservice.index')); ?>" class="btn btn-danger"><?php echo e(__('Reset')); ?></a>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create product & service')): ?>
                                        <a href="#" data-url="<?php echo e(route('productservice.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Product')); ?>" class="btn btn-icon icon-left btn-primary">
                                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                            <span class="btn-inner--text"> <?php echo e(__('Create')); ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-flush" id="dataTable">
                                                    <thead class="thead-light">
                                                    <tr role="row">
                                                        <th><?php echo e(__('Name')); ?></th>
                                                        <th> <?php echo e(__('Sku')); ?></th>
                                                        <th><?php echo e(__('Sale Price')); ?></th>
                                                        <th><?php echo e(__('Purchase Price')); ?></th>
                                                        <th><?php echo e(__('Tax')); ?></th>
                                                        <th><?php echo e(__('Category')); ?></th>
                                                        <th> <?php echo e(__('Unit')); ?></th>
                                                        <th><?php echo e(__('Type')); ?></th>
                                                        <th><?php echo e(__('Description')); ?></th>
                                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php $__currentLoopData = $productServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="font-style">
                                                            <td><?php echo e($productService->name); ?></td>
                                                            <td><?php echo e($productService->sku); ?></td>
                                                            <td><?php echo e(\Auth::user()->priceFormat($productService->sale_price)); ?></td>
                                                            <td><?php echo e(\Auth::user()->priceFormat($productService->purchase_price )); ?></td>
                                                            <td>
                                                                <?php
                                                                    $taxes=\Utility::tax($productService->tax_id);
                                                                ?>

                                                                <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php echo e(!empty($tax)?$tax->name:''); ?><br>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </td>
                                                            <td><?php echo e(!empty($productService->category)?$productService->category->name:''); ?></td>
                                                            <td><?php echo e(!empty($productService->unit())?$productService->unit()->name:''); ?></td>
                                                            <td><?php echo e($productService->type); ?></td>
                                                            <td><?php echo e($productService->description); ?></td>

                                                            <?php if(Gate::check('edit product & service') || Gate::check('delete product & service')): ?>
                                                                <td class="action text-right">
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit product & service')): ?>
                                                                        <a href="#" class="btn btn-primary btn-action mr-1" data-url="<?php echo e(route('productservice.edit',$productService->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Product Service')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete product & service')): ?>
                                                                        <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($productService->id); ?>').submit();">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['productservice.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]); ?>

                                                                        <?php echo Form::close(); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/productservice/index.blade.php ENDPATH**/ ?>