<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Credit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#invoice', function () {

            var invoice_id = $(this).val();
            var url = "<?php echo e(route('invoice.get')); ?>";

            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                data: {
                    'invoice_id': invoice_id,

                },
                success: function (data) {
                    $('#amount').val(data)
                },

            });

        })
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Credit Note')); ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <div class="breadcrumb-item"><?php echo e(__('Credit Note')); ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4><?php echo e(__('Manage Credit Note')); ?></h4>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create credit note')): ?>
                                    <!-- data-url="<?php echo e(route('invoice.custom.credit.note')); ?>" -->
                                    <a href="<?php echo e(route('creditnote.test')); ?>"  data-ajax-popup="true" data-title="<?php echo e(__('Create New Credit Note')); ?>" class="btn btn-icon icon-left btn-primary">
                                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                        <span class="btn-inner--text"> <?php echo e(__('Create')); ?></span>
                                    </a>
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
                                                        <th> <?php echo e(__('Invoice')); ?></th>
                                                        <th> <?php echo e(__('Customer')); ?></th>
                                                        <th> <?php echo e(__('Date')); ?></th>
                                                        <th> <?php echo e(__('Amount')); ?></th>
                                                        <th> <?php echo e(__('Description')); ?></th>
                                                        <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(!empty($invoice->creditNote)): ?>
                                                            <?php $__currentLoopData = $invoice->creditNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $creditNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="font-style">
                                                                    <td>
                                                                        <a class="btn btn-outline-primary" href="<?php echo e(route('invoice.show',$creditNote->invoice)); ?>"><?php echo e(AUth::user()->invoiceNumberFormat($creditNote->invoice)); ?>

                                                                        </a>
                                                                    </td>
                                                                    <td><?php echo e((!empty($invoice->customer)?$invoice->customer->name:'-')); ?></td>
                                                                    <td><?php echo e(Auth::user()->dateFormat($creditNote->date)); ?></td>
                                                                    <td><?php echo e(Auth::user()->priceFormat($creditNote->amount)); ?></td>
                                                                    <td><?php echo e(!empty($creditNote->description)?$creditNote->description:'-'); ?></td>
                                                                    <td class="text-right">
                                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit credit note')): ?>
                                                                            <a data-url="<?php echo e(route('invoice.edit.credit.note',[$creditNote->invoice,$creditNote->id])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Credit Note')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Credit Note')); ?>" href="#" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                                <i class="fas fa-pencil-alt"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete credit note')): ?>
                                                                            <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($creditNote->id); ?>').submit();">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                            <?php echo Form::open(['method' => 'DELETE', 'route' => array('invoice.delete.credit.note', $creditNote->invoice,$creditNote->id),'id'=>'delete-form-'.$creditNote->id]); ?>

                                                                            <?php echo Form::close(); ?>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/creditNote/index.blade.php ENDPATH**/ ?>