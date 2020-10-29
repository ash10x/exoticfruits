<?php if(!empty($customer)): ?>
    <div class="row">
        <div class="col-md-5">
            <h6><?php echo e(__('Bill to')); ?></h6>
            <div class="bill-to">
                <address>
                    <span><?php echo e($customer['billing_name']); ?></span><br>
                    <span><?php echo e($customer['billing_phone']); ?></span><br>
                    <span><?php echo e($customer['billing_address']); ?></span><br>
                    <span><?php echo e($customer['billing_zip']); ?></span><br>
                    <span><?php echo e($customer['billing_country'] . ' , '.$customer['billing_city'].' , '.$customer['billing_state'].'.'); ?></span>
                </address>
            </div>
        </div>
        <div class="col-md-5">
            <h6><?php echo e(__('Ship to')); ?></h6>
            <div class="bill-to">
                <address>
                    <span><?php echo e($customer['shipping_name']); ?></span><br>
                    <span><?php echo e($customer['shipping_phone']); ?></span><br>
                    <span><?php echo e($customer['shipping_address']); ?></span><br>
                    <span><?php echo e($customer['shipping_zip']); ?></span><br>
                    <span><?php echo e($customer['shipping_country'] . ' , '.$customer['shipping_state'].' , '.$customer['shipping_city'].'.'); ?></span>
                </address>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove"><?php echo e(__(' Remove')); ?></a>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/exoticfruits/resources/views/invoice/customer_detail.blade.php ENDPATH**/ ?>