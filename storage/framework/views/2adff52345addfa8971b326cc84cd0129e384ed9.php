<?php
    $profile=asset(Storage::url('uploads/avatar/'));
?>
<?php $__env->startPush('script-page'); ?>
    <script>

        $(document).on('click', '#billing_data', function () {
            $("[name='shipping_name']").val($("[name='billing_name']").val());
            $("[name='shipping_country']").val($("[name='billing_country']").val());
            $("[name='shipping_state']").val($("[name='billing_state']").val());
            $("[name='shipping_city']").val($("[name='billing_city']").val());
            $("[name='shipping_phone']").val($("[name='billing_phone']").val());
            $("[name='shipping_zip']").val($("[name='billing_zip']").val());
            $("[name='shipping_address']").val($("[name='billing_address']").val());
        })

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Customer')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Customer')); ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <div class="breadcrumb-item"><?php echo e(__('Customer')); ?></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4><?php echo e(__('Manage Customer')); ?></h4>
                            <div class="card-header-action">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create customer')): ?>
                                    <a href="#" data-size="2xl" data-url="<?php echo e(route('customer.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Customer')); ?>" class="btn btn-icon icon-left btn-primary commonModal">
                                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                        <span class="btn-inner--text"> <?php echo e(__('Create')); ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-flush" id="dataTable">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th> <?php echo e(__('Name')); ?></th>
                                                    <th> <?php echo e(__('Contact')); ?></th>
                                                    <th> <?php echo e(__('Email')); ?></th>
                                                    <th> <?php echo e(__('Balance')); ?></th>
                                                    <th class="text-right"><?php echo e(__('Action')); ?></th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="cust_tr" id="cust_detail" data-url="<?php echo e(route('customer.show',$customer['id'])); ?>" data-id="<?php echo e($customer['id']); ?>">
                                                        <td>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show customer')): ?>
                                                                <a href="<?php echo e(route('customer.show',$customer['id'])); ?>" class="btn btn-outline-primary">
                                                                    <?php echo e(AUth::user()->customerNumberFormat($customer['customer_id'])); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <a href="#" class="btn btn-outline-primary">
                                                                    <?php echo e(AUth::user()->customerNumberFormat($customer['customer_id'])); ?>

                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="font-style"><?php echo e($customer['name']); ?></td>
                                                        <td><?php echo e($customer['contact']); ?></td>
                                                        <td><?php echo e($customer['email']); ?></td>
                                                        <td><?php echo e(\Auth::user()->priceFormat($customer['balance'])); ?></td>
                                                        <td class="text-right">
                                                            <?php if($customer['is_active']==0): ?>
                                                                <i class="fa fa-lock" title="Inactive"></i>
                                                            <?php else: ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show customer')): ?>
                                                                    <a href="<?php echo e(route('customer.show',$customer['id'])); ?>" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit customer')): ?>
                                                                    <a href="#!" class="btn btn-primary btn-action mr-1" data-size="2xl" data-url="<?php echo e(route('customer.edit',$customer['id'])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Customer')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete customer')): ?>
                                                                    <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($customer['id']); ?>').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['customer.destroy', $customer['id']],'id'=>'delete-form-'.$customer['id']]); ?>

                                                                    <?php echo Form::close(); ?>

                                                                <?php endif; ?>
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
                            <div class="col-md-6 d-none" id="customer_details">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/customer/index.blade.php ENDPATH**/ ?>