<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invoice Create')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/jquery.repeater.min.js')); ?>"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function () {
                    $(this).slideDown();
                    var file_uploads = $(this).find('input.multi');
                    if (file_uploads.length) {
                        $(this).find('input.multi').MultiFile({
                            max: 3,
                            accept: 'png|jpg|jpeg',
                            max_size: 2048
                        });
                    }
                },
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalAmount').html(subTotal.toFixed(2));
                    }
                },
                ready: function (setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

        }

        $(document).on('change', '#customer', function () {
            $('#customer_detail').removeClass('d-none');
            $('#customer_detail').addClass('d-block');
            $('#customer-box').removeClass('d-block');
            $('#customer-box').addClass('d-none');
            var id = $(this).val();
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': id
                },
                cache: false,
                success: function (data) {
                    if (data != '') {
                        $('#customer_detail').html(data);
                    } else {
                        $('#customer-box').removeClass('d-none');
                        $('#customer-box').addClass('d-block');
                        $('#customer_detail').removeClass('d-block');
                        $('#customer_detail').addClass('d-none');
                    }
                },

            });
        });

        $(document).on('click', '#remove', function () {
            $('#customer-box').removeClass('d-none');
            $('#customer-box').addClass('d-block');
            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');
        })

        $(document).on('change', '.item', function () {
            var iteams_id = $(this).val();
            var url = $(this).data('url');
            var el = $(this);
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'product_id': iteams_id
                },
                cache: false,
                success: function (data) {
                    var item = JSON.parse(data);

                    $(el.parent().parent().find('.quantity')).val(1);
                    $(el.parent().parent().find('.price')).val(item.product.sale_price);
                    var taxes = '';
                    var tax = [];

                    var totalItemTaxRate = 0;
                    for (var i = 0; i < item.taxes.length; i++) {
                        taxes += '<span class="badge badge-primary mt-1">' + item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' + '</span>';
                        tax.push(item.taxes[i].id);
                        totalItemTaxRate += parseFloat(item.taxes[i].rate);
                    }

                    var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product.sale_price * 1));

                    $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                    $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                    $(el.parent().parent().find('.taxes')).html(taxes);
                    $(el.parent().parent().find('.tax')).val(tax);
                    $(el.parent().parent().find('.unit')).html(item.unit);
                    $(el.parent().parent().find('.discount')).val(0);
                    $(el.parent().parent().find('.amount')).html(item.totalAmount);


                    var inputs = $(".amount");
                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }
                    $('.subTotal').html(subTotal.toFixed(2));


                    var totalItemPrice = 0;
                    var priceInput = $('.price');
                    for (var j = 0; j < priceInput.length; j++) {
                        totalItemPrice += parseFloat(priceInput[j].value);
                    }

                    var totalItemTaxPrice = 0;
                    var itemTaxPriceInput = $('.itemTaxPrice');
                    for (var j = 0; j < itemTaxPriceInput.length; j++) {
                        totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                    }

                    $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                    $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));

                },
            });
        });

        $(document).on('keyup', '.quantity', function () {
            var quntityTotalTaxPrice = 0;

            var el = $(this).parent().parent().parent().parent();
            var quantity = $(this).val();
            var price = $(el.find('.price')).val();
            var discount = $(el.find('.discount')).val();

            var totalItemPrice = (quantity * price);
            var amount = (totalItemPrice);
            $(el.find('.amount')).html(amount);

            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));


            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var inputs = $(".amount");
            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }
            $('.subTotal').html(subTotal.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));

        })
        $(document).on('keyup', '.price', function () {
            var el = $(this).parent().parent().parent().parent();
            var price = $(this).val();
            var quantity = $(el.find('.quantity')).val();
            var discount = $(el.find('.discount')).val();
            var totalItemPrice = (quantity * price);

            var amount = (totalItemPrice);
            $(el.find('.amount')).html(amount);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));


            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var inputs = $(".amount");
            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.subTotal').html(subTotal.toFixed(2));
            $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));

        })

        $(document).on('keyup', '.discount', function () {
            var el = $(this).parent().parent().parent().parent();
            var discount = $(this).val();
            var price = $(el.find('.price')).val();

            var quantity = $(el.find('.quantity')).val();
            var totalItemPrice = (quantity * price);

            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));


            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemDiscountPrice = 0;
            var itemDiscountPriceInput = $('.discount');

            for (var k = 0; k < itemDiscountPriceInput.length; k++) {

                totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
            }

            var amount = (totalItemPrice);
            $(el.find('.amount')).html(amount);

            var inputs = $(".amount");
            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }
            $('.subTotal').html(subTotal.toFixed(2));
            $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal) - parseFloat(totalItemDiscountPrice) + parseFloat(totalItemTaxPrice)).toFixed(2));
        })

        var customerId = '<?php echo e($customerId); ?>';
        if (customerId > 0) {
            $('#customer').val(customerId).change();
        }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Invoice Create')); ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></div>
                <div class="breadcrumb-item"><a href="<?php echo e(route('invoice.index')); ?>"><?php echo e(__('Invoice')); ?></a></div>
                <div class="breadcrumb-item active"><?php echo e(__('create')); ?></div>
            </div>
        </div>
        <div class="section-body">
            <?php echo e(Form::open(array('url' => 'invoice'))); ?>

            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="customer-box">
                                        <div class="input-group">
                                            <?php echo e(Form::label('customer_id', __('Customer'))); ?>

                                            <?php echo e(Form::select('customer_id', $customers,$customerId, array('class' => 'form-control customer-sel font-style selectric','id'=>'customer','data-url'=>route('invoice.customer'),'required'=>'required'))); ?>

                                        </div>
                                    </div>
                                    <div id="customer_detail" class="d-none">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('issue_date', __('Issue Date'))); ?>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <?php echo e(Form::text('issue_date', '', array('class' => 'form-control datepicker','required'=>'required'))); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('due_date', __('Due Date'))); ?>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <?php echo e(Form::text('due_date', '', array('class' => 'form-control datepicker','required'=>'required'))); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('invoice_number', __('Invoice Number'))); ?>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-file"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" value="<?php echo e($invoice_number); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <?php echo e(Form::label('category_id', __('Category'))); ?>

                                                <?php echo e(Form::select('category_id', $category,null, array('class' => 'form-control customer-sel font-style selectric','required'=>'required'))); ?>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('ref_number', __('Ref Number'))); ?>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-joint"></i>
                                                        </div>
                                                    </div>
                                                    <?php echo e(Form::text('ref_number', '', array('class' => 'form-control'))); ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox mt-4">
                                                <input class="custom-control-input" type="checkbox" name="discount_apply" id="discount_apply">
                                                <label class="custom-control-label" for="discount_apply"><?php echo e(__('Discount Apply')); ?></label>
                                            </div>
                                        </div>
                                        <?php if(!$customFields->isEmpty()): ?>
                                            <div class="col-md-6">
                                                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                                    <?php echo $__env->make('customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card repeater">
                        <div class="card-header">
                            <h4><?php echo e(__('Product & Services')); ?></h4>
                            <div class="card-header-action">
                                <a href="#" data-repeater-create="" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#add-bank">
                                    <i class="fas fa-plus"></i><?php echo e(__('Add Item')); ?>

                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" data-repeater-list="items" id="sortable-table">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(__('Items')); ?></th>
                                        <th><?php echo e(__('Quantity')); ?></th>
                                        <th><?php echo e(__('Price')); ?> </th>
                                        <th><?php echo e(__('Tax')); ?> (%)</th>
                                        <th><?php echo e(__('Discount')); ?></th>
                                        <th class="text-right"><?php echo e(__('Amount')); ?> <br><small class="text-danger"><?php echo e(__('before tax & discount')); ?></small></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="ui-sortable" data-repeater-item>
                                    <tr>
                                        <td width="25%">
                                            <?php echo e(Form::select('item', $product_services,'', array('class' => 'form-control font-style item','data-url'=>route('proposal.product'),'required'=>'required'))); ?>

                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group colorpickerinput">
                                                    <?php echo e(Form::text('quantity','', array('class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required'))); ?>

                                                    <div class="input-group-append">
                                                        <div class="input-group-text unit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group colorpickerinput">
                                                    <?php echo e(Form::text('price','', array('class' => 'form-control price','required'=>'required','placeholder'=>__('Price'),'required'=>'required'))); ?>

                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <?php echo e(\Auth::user()->currencySymbol()); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group colorpickerinput">
                                                    <div class="taxes"></div>
                                                    <?php echo e(Form::hidden('tax','', array('class' => 'form-control tax'))); ?>

                                                    <?php echo e(Form::hidden('itemTaxPrice','', array('class' => 'form-control itemTaxPrice'))); ?>

                                                    <?php echo e(Form::hidden('itemTaxRate','', array('class' => 'form-control itemTaxRate'))); ?>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group colorpickerinput">
                                                    <?php echo e(Form::text('discount','', array('class' => 'form-control discount','required'=>'required','placeholder'=>__('Discount')))); ?>

                                                    <div class="input-group-append">

                                                        <div class="input-group-text">
                                                            <?php echo e(\Auth::user()->currencySymbol()); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right amount">
                                            0.00
                                        </td>
                                        <td>
                                            <a href="#" class="fas fa-trash" data-repeater-delete></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">   <?php echo e(Form::textarea('description', null, ['class'=>'form-control','rows'=>'2','placeholder'=>__('Description')])); ?></td>
                                        <td colspan="4"></td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td><strong><?php echo e(__('Sub Total')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                        <td class="text-right subTotal">0.00</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td><strong><?php echo e(__('Discount')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                        <td class="text-right totalDiscount">0.00</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td><strong><?php echo e(__('Tax')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                        <td class="text-right totalTax">0.00</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><strong><?php echo e(__('Total Amount')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                        <td class="text-right totalAmount"></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="<?php echo e(route('invoice.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                    <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary'))); ?>

                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </section>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/invoice/create.blade.php ENDPATH**/ ?>