<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invoice')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Invoice')); ?></h1>
            <div class="section-header-breadcrumb">
                <?php if(\Auth::guard('customer')->check()): ?>
                    <div class="breadcrumb-item active"><a href="<?php echo e(route('customer.dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <?php else: ?>
                    <div class="breadcrumb-item active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <?php endif; ?>
                <div class="breadcrumb-item"><?php echo e(__('Invoice')); ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4><?php echo e(__('Manage Invoice')); ?></h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-icon icon-left btn-primary"><i class="fas fa-filter"></i><?php echo e(__('Filter')); ?></a>
                                        <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown w-64 <?php echo e(isset($_GET['customer'])?'show':''); ?>">
                                            <?php if(!\Auth::guard('customer')->check()): ?>
                                                <?php echo e(Form::open(array('route' => array('invoice.index'),'method' => 'GET'))); ?>

                                            <?php else: ?>
                                                <?php echo e(Form::open(array('route' => array('customer.invoice'),'method' => 'GET'))); ?>

                                            <?php endif; ?>
                                            <?php if(!\Auth::guard('customer')->check()): ?>
                                                <div class="form-group">
                                                    <?php echo e(Form::label('customer', __('Customer'))); ?>

                                                    <?php echo e(Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-control font-style selectric'))); ?>

                                                </div>
                                            <?php endif; ?>
                                            <div class="form-group">
                                                <?php echo e(Form::label('issue_date', __('Date'))); ?>

                                                <?php echo e(Form::text('issue_date', isset($_GET['issue_date'])?$_GET['issue_date']:null, array('class' => 'form-control datepicker-range'))); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo e(Form::label('status', __('Status'))); ?>

                                                <?php echo e(Form::select('status', [''=>'All']+$status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control font-style selectric'))); ?>

                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary"><?php echo e(__('Search')); ?></button>
                                                <?php if(!\Auth::guard('customer')->check()): ?>
                                                    <a href="<?php echo e(route('invoice.index')); ?>" class="btn btn-danger"><?php echo e(__('Reset')); ?></a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('customer.invoice')); ?>" class="btn btn-danger"><?php echo e(__('Reset')); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create invoice')): ?>
                                        <a href="<?php echo e(route('invoice.create',0)); ?>" class="btn btn-icon icon-left btn-primary">
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
                                                    <tr>

                                                        <th> <?php echo e(__('Invoice')); ?></th>
                                                        <?php if(!\Auth::guard('customer')->check()): ?>
                                                            <th> <?php echo e(__('Customer')); ?></th>
                                                        <?php endif; ?>
                                                        <th> <?php echo e(__('Issue Date')); ?></th>
                                                        <th> <?php echo e(__('Due Date')); ?></th>
                                                        <th> <?php echo e(__('Due Amount')); ?></th>
                                                        <th> <?php echo e(__('Status')); ?></th>
                                                        <?php if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice')): ?>
                                                            <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="font-style">
                                                            <td>
                                                                <?php if(\Auth::guard('customer')->check()): ?>
                                                                    <a class="btn btn-outline-primary" href="<?php echo e(route('customer.invoice.show',$invoice->id)); ?>"><?php echo e(AUth::user()->invoiceNumberFormat($invoice->invoice_id)); ?>

                                                                    </a>
                                                                <?php else: ?>
                                                                    <a class="btn btn-outline-primary" href="<?php echo e(route('invoice.show',$invoice->id)); ?>"><?php echo e(AUth::user()->invoiceNumberFormat($invoice->invoice_id)); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <?php if(!\Auth::guard('customer')->check()): ?>
                                                                <td> <?php echo e(!empty($invoice->customer)? $invoice->customer->name:''); ?> </td>
                                                            <?php endif; ?>

                                                            <td><?php echo e(Auth::user()->dateFormat($invoice->issue_date)); ?></td>
                                                            <td>
                                                                <?php if(($invoice->due_date < date('Y-m-d'))): ?>
                                                                    <p class="text-danger"> <?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?></p>
                                                                <?php else: ?>
                                                                    <?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?>

                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo e(\Auth::user()->priceFormat($invoice->getDue())); ?></td>

                                                            <td>
                                                                <?php if($invoice->status == 0): ?>
                                                                    <span class="badge badge-primary"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                                                <?php elseif($invoice->status == 1): ?>
                                                                    <span class="badge badge-warning"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                                                <?php elseif($invoice->status == 2): ?>
                                                                    <span class="badge badge-danger"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                                                <?php elseif($invoice->status == 3): ?>
                                                                    <span class="badge badge-info"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                                                <?php elseif($invoice->status == 4): ?>
                                                                    <span class="badge badge-success"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <?php if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice')): ?>
                                                                <td class="action text-right">
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('duplicate invoice')): ?>
                                                                        <a href="#" class="btn btn-success btn-action mr-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Duplicate')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="You want to confirm this action. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('duplicate-form-<?php echo e($invoice->id); ?>').submit();">
                                                                            <i class="fas fa-copy"></i>
                                                                            <?php echo Form::open(['method' => 'get', 'route' => ['invoice.duplicate', $invoice->id],'id'=>'duplicate-form-'.$invoice->id]); ?>

                                                                            <?php echo Form::close(); ?>

                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show invoice')): ?>
                                                                        <?php if(\Auth::guard('customer')->check()): ?>
                                                                            <a href="<?php echo e(route('customer.invoice.show',$invoice->id)); ?>" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Detail')); ?>">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        <?php else: ?>
                                                                            <a href="<?php echo e(route('invoice.show',$invoice->id)); ?>" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Detail')); ?>">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit invoice')): ?>
                                                                        <a href="<?php echo e(route('invoice.edit',$invoice->id)); ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete invoice')): ?>
                                                                        <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($invoice->id); ?>').submit();">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['invoice.destroy', $invoice->id],'id'=>'delete-form-'.$invoice->id]); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/invoice/index.blade.php ENDPATH**/ ?>