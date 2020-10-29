<?php
    $logo=asset(Storage::url('uploads/logo/'));
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo e(route('dashboard')); ?>">
                <img class="img-fluid" src="<?php echo e($logo.'/logo.png'); ?> " alt="">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo e(route('dashboard')); ?>"> <img class="img-fluid" src="<?php echo e($logo.'/small_logo.png'); ?> " alt=""></a>
        </div>
        <ul class="sidebar-menu">

            <?php if(\Auth::guard('customer')->check()): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'customer.dashboard') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('customer.dashboard')); ?>"> <i class="fas fa-fire"></i> <span><?php echo e(__('Dashboard')); ?></span></a>
                </li>
            <?php elseif(\Auth::guard('vender')->check()): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'vender.dashboard') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('vender.dashboard')); ?>"> <i class="fas fa-fire"></i> <span><?php echo e(__('Dashboard')); ?></span></a>
                </li>
            <?php else: ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'dashboard') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('dashboard')); ?>"> <i class="fas fa-fire"></i> <span><?php echo e(__('Dashboard')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage customer proposal')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'customer.proposal' || Request::route()->getName() == 'customer.proposal.show') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('customer.proposal')); ?>"> <i class="fas fa-file"></i> <span><?php echo e(__('Proposal')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage customer invoice')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'customer.invoice' || Request::route()->getName() == 'customer.invoice.show') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('customer.invoice')); ?>"> <i class="fas fa-file"></i> <span><?php echo e(__('Invoice')); ?></span></a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage customer payment')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'customer.payment') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('customer.payment')); ?>"> <i class="far fa-money-bill-alt"></i> <span><?php echo e(__('Payment')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage customer transaction')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'customer.transaction') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('customer.transaction')); ?>"> <i class="fas fa-history"></i> <span><?php echo e(__('Transaction')); ?></span></a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage vender bill')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'vender.bill' || Request::route()->getName() == 'vender.bill.show') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('vender.bill')); ?>"> <i class="fas fa-file"></i> <span><?php echo e(__('Bill')); ?></span></a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage vender payment')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'vender.payment') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('vender.payment')); ?>"> <i class="far fa-money-bill-alt"></i> <span><?php echo e(__('Payment')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage vender transaction')): ?>
                <li class="dropdown <?php echo e((Request::route()->getName() == 'vender.transaction') ? ' active' : ''); ?> ">
                    <a class="nav-link" href="<?php echo e(route('vender.transaction')); ?>"> <i class="fas fa-history"></i> <span><?php echo e(__('Transaction')); ?></span></a>
                </li>
            <?php endif; ?>


            <?php if(\Auth::user()->type=='super admin'): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage user')): ?>
                    <li class="dropdown <?php echo e((Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit') ? ' active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('users.index')); ?>"> <i class="fas fa-columns"></i> <span><?php echo e(__('User')); ?></span></a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <?php if( Gate::check('manage user') || Gate::check('manage role')): ?>
                    <li class="dropdown <?php echo e((Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'permissions' )?' active':''); ?>">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span><?php echo e(__('Staff')); ?></span></a>
                        <ul class="dropdown-menu <?php echo e((Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'permissions')?'display:block':''); ?>">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage user')): ?>
                                <li class="<?php echo e((Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit') ? ' active' : ''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('users.index')); ?>"><?php echo e(__('User')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage role')): ?>
                                <li class="<?php echo e((Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit') ? ' active' : ''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Role')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>


            <?php if(Gate::check('manage product & service')): ?>
                <li class="<?php echo e((Request::segment(1) == 'productservice')?'active':''); ?>">
                    <a class="nav-link" href="<?php echo e(route('productservice.index')); ?>">
                        <i class="fas fa-shopping-cart"></i> <span><?php echo e(__('Product & Service')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage customer')): ?>
                <li class="<?php echo e((Request::segment(1) == 'customer')?'active':''); ?>">
                    <a class="nav-link" href="<?php echo e(route('customer.index')); ?>">
                        <i class="far fa-user"></i> <span><?php echo e(__('Customer')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage vender')): ?>
                <li class="<?php echo e((Request::segment(1) == 'vender')?'active':''); ?>">
                    <a class="nav-link" href="<?php echo e(route('vender.index')); ?>">
                        <i class="fas fa-sticky-note"></i> <span><?php echo e(__('Vendor')); ?></span></a>
                </li>
            <?php endif; ?>

            <?php if(Gate::check('manage proposal')): ?>
                <li class="<?php echo e((Request::segment(1) == 'proposal')?'active':''); ?>">
                    <a class="nav-link" href="<?php echo e(route('proposal.index')); ?>">
                        <i class="fas fa-file"></i> <span><?php echo e(__('Proposal')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if( Gate::check('manage bank account') ||  Gate::check('manage transfer')): ?>
                <li class="dropdown <?php echo e((Request::segment(1) == 'bank-account' || Request::segment(1) == 'transfer'  || Request::segment(1) == 'balance-sheet')?' active':''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-university"></i> <span><?php echo e(__('Banking')); ?></span></a>
                    <ul class="dropdown-menu <?php echo e((Request::segment(1) == 'bank-account' || Request::segment(1) == 'transfer')?'display:block':''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage bank account')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('bank-account.index')); ?>"><?php echo e(__('Account')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage transfer')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'transfer.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transfer.edit') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('transfer.index')); ?>"><?php echo e(__('Transfer')); ?></a>
                            </li>
                        <?php endif; ?>


                    </ul>
                </li>
            <?php endif; ?>
            <?php if( Gate::check('manage invoice') ||  Gate::check('manage revenue') ||  Gate::check('manage credit note')): ?>
                <li class="dropdown <?php echo e((Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')?' active':''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-money-bill-alt"></i> <span><?php echo e(__('Income')); ?></span></a>
                    <ul class="dropdown-menu <?php echo e((Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')?'display:block':''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage invoice')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('invoice.index')); ?>"><?php echo e(__('Invoice')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage revenue')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('revenue.index')); ?>"><?php echo e(__('Revenue')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage credit note')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'credit.note' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('credit.note')); ?>"><?php echo e(__('Credit Note')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if( Gate::check('manage bill')  ||  Gate::check('manage payment') ||  Gate::check('manage debit note')): ?>
                <li class="dropdown <?php echo e((Request::segment(1) == 'bill' || Request::segment(1) == 'payment'  || Request::segment(1) == 'debit-note')?' active':''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill-wave-alt"></i> <span><?php echo e(__('Expense')); ?></span></a>
                    <ul class="dropdown-menu <?php echo e((Request::segment(1) == 'invoice')?'display:block':''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage bill')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('bill.index')); ?>"><?php echo e(__('Bill')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage payment')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('payment.index')); ?>"><?php echo e(__('Payment')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage debit note')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'debit.note' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('debit.note')); ?>"><?php echo e(__('Debit Note')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage goal')): ?>
                <li class="<?php echo e((Request::segment(1) == 'goal')?'active':''); ?>">
                    <a class="nav-link" href="<?php echo e(route('goal.index')); ?>">
                        <i class="fa fa-bullseye"></i> <span><?php echo e(__('Goal')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage assets')): ?>
                <li class="<?php echo e((Request::segment(1) == 'account-assets')?'active':''); ?>">
                    <a class="nav-link" href="<?php echo e(route('account-assets.index')); ?>">
                        <i class="fa fa-calculator"></i> <span><?php echo e(__('Assets')); ?></span></a>
                </li>
            <?php endif; ?>
            <?php if( Gate::check('income report') || Gate::check('expense report') || Gate::check('income vs expense report') || Gate::check('tax report')  || Gate::check('loss & profit report') || Gate::check('invoice report') || Gate::check('bill report') || Gate::check('invoice report') ||  Gate::check('manage transaction')||  Gate::check('statement report')): ?>
                <li class="dropdown <?php echo e((Request::segment(1) == 'report' || Request::segment(1) == 'transaction')?' active':''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-area"></i> <span><?php echo e(__('Report')); ?></span></a>
                    <ul class="dropdown-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage transaction')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('transaction.index')); ?>"><?php echo e(__('Transaction')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('statement report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.account.statement') ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.account.statement')); ?>"><?php echo e(__('Account Statement')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.income.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.income.summary')); ?>"><?php echo e(__('Income Summary')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expense report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.expense.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.expense.summary')); ?>"><?php echo e(__('Expense Summary')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income vs expense report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.income.vs.expense.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.income.vs.expense.summary')); ?>"><?php echo e(__('Income VS Expense')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.tax.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.tax.summary')); ?>"><?php echo e(__('Tax Summary')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('loss & profit report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.profit.loss.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.profit.loss.summary')); ?>"><?php echo e(__('Profit & Loss')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoice report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.invoice.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.invoice.summary')); ?>"><?php echo e(__('Invoice Summary')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bill report')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'report.bill.summary' ) ? ' active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('report.bill.summary')); ?>"><?php echo e(__('Bill Summary')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>


            <?php if(Gate::check('manage constant tax') || Gate::check('manage constant category') ||Gate::check('manage constant unit') ||Gate::check('manage constant payment method') ||Gate::check('manage constant custom field')): ?>
                <li class="dropdown <?php echo e((Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field')? 'active':''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span><?php echo e(__('Constant')); ?></span></a>
                    <ul class="dropdown-menu <?php echo e((Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit'  || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field')? 'display:block':''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage constant tax')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'taxes.index' ) ? 'active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('taxes.index')); ?>"> <?php echo e(__('Taxes')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage constant category')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'product-category.index' ) ? 'active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('product-category.index')); ?>"> <?php echo e(__('Category')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage constant unit')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'product-unit.index' ) ? 'active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('product-unit.index')); ?>"> <?php echo e(__('Unit')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage constant custom field')): ?>
                            <li class="<?php echo e((Request::route()->getName() == 'custom-field.index' ) ? 'active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('custom-field.index')); ?>"> <?php echo e(__('Custom Field')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage company settings')): ?>
                <li class="<?php echo e((Request::route()->getName() == 'systems.index') ? ' active' : ''); ?>">
                    <a class="nav-link" href="<?php echo e(route('company.setting')); ?>"><i class="fas fa-sliders-h"></i> <span><?php echo e(__('Company Setting')); ?> </span></a>
                </li>
            <?php endif; ?>
        </ul>
    </aside>
</div>
<?php /**PATH /var/www/exoticfruits/resources/views/partials/admin/menu.blade.php ENDPATH**/ ?>