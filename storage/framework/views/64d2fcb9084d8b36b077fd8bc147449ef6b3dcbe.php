<?php echo e(Form::open(array('url' => 'product-category'))); ?>

<div class="row">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('name', __('Category Name'))); ?>

        <?php echo e(Form::text('name', '', array('class' => 'form-control','required'=>'required'))); ?>

    </div>
    <div class="form-group  col-md-12">
        <div class="input-group">
            <?php echo e(Form::label('type', __('Category Type'))); ?>

            <?php echo e(Form::select('type',$types,null, array('class' => 'form-control customer-sel font-style selectric ','required'=>'required'))); ?>

        </div>
    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('color', __('Category Color'))); ?>

        <?php echo e(Form::text('color', '', array('class' => 'form-control jscolor','required'=>'required'))); ?>

        <p class="small"><?php echo e(__('For chart representation')); ?></p>
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary'))); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH /var/www/exoticfruits/resources/views/productServiceCategory/create.blade.php ENDPATH**/ ?>