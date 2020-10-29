<?php $__env->startSection('page-title'); ?>
    Create Credit-Note
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="section">

    <!-- Header of Section -->
    <div class="section-header">
        <h1>Create Credit-Note</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?php echo e(route('credit.note')); ?>">Credit-Note</a></div>
            <div class="breadcrumb-item active">Create</div>
        </div>
    </div>

    <!-- Body of Section -->
    <div class="section-body">
        <form action="" method="GET">

            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">

            <div class="form-group row col-md-3">
                <label for="invoice" style="margin-bottom:10px;font-size:13pt;">Invoice #</label>
                <select name="invoice" id="" class="form-control">
                    <option value="">Hello</option>
                </select>
                <div style="width:100%;padding:10px;background-color:#d6d6d3;margin-top:10px;">
                    <p>DUMMY INFO</p>
                    <p>DUMMY INFO</p>
                    <p>DUMMY INFO</p>
                </div>
            </div>

        </form>
    </div>

</div>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/creditNote/test.blade.php ENDPATH**/ ?>