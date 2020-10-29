<?php echo e(Form::open(array('url' => 'product-unit'))); ?>

<div class="row">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('name', __('Unit Name'))); ?>

        <?php echo e(Form::text('name', '', array('class' => 'form-control','required'=>'required'))); ?>

        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-name" role="alert">
        <strong class="text-danger"><?php echo e($message); ?></strong>
    </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary'))); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/exoticfruits/resources/views/productServiceUnit/create.blade.php ENDPATH**/ ?>