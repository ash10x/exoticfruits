<?php echo e(Form::open(array('url' => 'productservice'))); ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo e(Form::label('name', __('Name'))); ?>

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-address-card"></i>
                    </div>
                </div>
                <?php echo e(Form::text('name', '', array('class' => 'form-control','required'=>'required'))); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo e(Form::label('sku', __('SKU'))); ?>

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                <?php echo e(Form::text('sku', '', array('class' => 'form-control','required'=>'required'))); ?>

            </div>
        </div>
    </div>
    <div class="form-group  col-md-12">
        <?php echo e(Form::label('description', __('Description'))); ?>

        <?php echo Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']); ?>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo e(Form::label('sale_price', __('Sale Price'))); ?>

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="far fa-money-bill-alt"></i>
                    </div>
                </div>
                <?php echo e(Form::number('sale_price', '', array('class' => 'form-control','required'=>'required','step'=>'0.01'))); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo e(Form::label('purchase_price', __('Purchase Price'))); ?>

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="far fa-money-bill-alt"></i>
                    </div>
                </div>
                <?php echo e(Form::number('purchase_price', '', array('class' => 'form-control','required'=>'required','step'=>'0.01'))); ?>

            </div>
        </div>
    </div>

    <div class="form-group  col-md-6">
        <?php echo e(Form::label('tax_id', __('Tax'))); ?>

        <?php echo e(Form::select('tax_id[]', $tax,null, array('class' => 'form-control font-style selectric','multiple','required'=>'required'))); ?>


    </div>
    <div class="form-group  col-md-6">
        <?php echo e(Form::label('category_id', __('Category'))); ?>

        <?php echo e(Form::select('category_id', $category,null, array('class' => 'form-control font-style selectric','required'=>'required'))); ?>

    </div>
    <div class="form-group  col-md-6">
        <?php echo e(Form::label('unit_id', __('Unit'))); ?>

        <?php echo e(Form::select('unit_id', $unit,null, array('class' => 'form-control font-style selectric','required'=>'required'))); ?>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="d-block"><?php echo e(__('Type')); ?></label>
            <div class="row">
                <div class="col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="customRadio5" name="type" value="product" checked="checked" onclick="hide_show(this)">
                        <label class="custom-control-label" for="customRadio5"><?php echo e(__('Product')); ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="customRadio6" name="type" value="service" onclick="hide_show(this)">
                        <label class="custom-control-label" for="customRadio6"><?php echo e(__('Service')); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!$customFields->isEmpty()): ?>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                <?php echo $__env->make('customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary'))); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/exoticfruits/resources/views/productservice/create.blade.php ENDPATH**/ ?>