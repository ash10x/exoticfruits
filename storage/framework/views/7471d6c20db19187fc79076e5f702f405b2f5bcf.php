<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Tax Rate')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Tax Rate')); ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <div class="breadcrumb-item"><?php echo e(__('Tax Rate')); ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4><?php echo e(__('Manage Tax Rate')); ?></h4>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create constant tax')): ?>
                                    <div class="col-auto">
                                        <a href="#" data-url="<?php echo e(route('taxes.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create Tax Rate')); ?>" class="btn btn-icon icon-left btn-primary">
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

                                                        <th> <?php echo e(__('Tax Name')); ?></th>
                                                        <th> <?php echo e(__('Rate %')); ?></th>
                                                        <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="font-style">
                                                            <td><?php echo e($taxe->name); ?></td>
                                                            <td><?php echo e($taxe->rate); ?></td>
                                                            <td class="action text-right">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit constant tax')): ?>
                                                                    <a href="#!" class="btn btn-primary btn-action mr-1" data-url="<?php echo e(route('taxes.edit',$taxe->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Tax Rate')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete constant tax')): ?>
                                                                    <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($taxe->id); ?>').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['taxes.destroy', $taxe->id],'id'=>'delete-form-'.$taxe->id]); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/taxes/index.blade.php ENDPATH**/ ?>