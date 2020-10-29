<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Product & Service Category')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Product-Service & Income-Expense Category')); ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <div class="breadcrumb-item"><?php echo e(__('Product & Service Category')); ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4><?php echo e(__('Manage Product-Service & Income-Expense Category')); ?></h4>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create constant category')): ?>
                                    <div class="col-auto">
                                        <a href="#" data-url="<?php echo e(route('product-category.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Category')); ?>" class="btn btn-icon icon-left btn-primary">
                                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                            <span class="btn-inner--text"> <?php echo e(__('Create')); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
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
                                                    <tr>
                                                        <th > <?php echo e(__('Category')); ?></th>
                                                        <th> <?php echo e(__('Type')); ?></th>
                                                        <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="font-style"><?php echo e($category->name); ?></td>
                                                            <td class="font-style">
                                                                <?php echo e(__(\App\ProductServiceCategory::$categoryType[$category->type])); ?>

                                                            </td>
                                                            <td class="action text-right">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit constant category')): ?>
                                                                    <a href="#" class="btn btn-primary btn-action mr-1" data-url="<?php echo e(route('product-category.edit',$category->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Product Category')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete constant category')): ?>
                                                                    <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($category->id); ?>').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['product-category.destroy', $category->id],'id'=>'delete-form-'.$category->id]); ?>

                                                                    <?php echo Form::close(); ?>

                                                                <?php endif; ?>
                                                            </td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/productServiceCategory/index.blade.php ENDPATH**/ ?>