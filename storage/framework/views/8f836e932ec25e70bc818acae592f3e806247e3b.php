<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
            <?php if(\Auth::user()->can('show dashboard')): ?>
        var SalesChart = (function () {
                var $chart = $('#cash-flow');

                function init($this) {
                    var salesChart = new Chart($this, {
                        type: 'line',
                        options: {
                            scales: {
                                yAxes: [{
                                    gridLines: {
                                        color: Charts.colors.gray[200],
                                        zeroLineColor: Charts.colors.gray[200]
                                    },
                                    ticks: {}
                                }]
                            }
                        },
                        data: {
                            labels: <?php echo json_encode($incExpLineChartData['day']); ?>,
                            datasets: <?php echo json_encode($incExpLineChartData['incExpArr']); ?>


                        },
                    });
                    $this.data('chart', salesChart);
                };
                if ($chart.length) {
                    init($chart);
                }
            })();
        var SalesChart = (function () {
            var $chart = $('#incExpBarChart');

            function init($this) {
                var salesChart = new Chart($this, {
                    type: 'bar',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    color: Charts.colors.gray[200],
                                    zeroLineColor: Charts.colors.gray[200]
                                },
                                ticks: {}
                            }]
                        }
                    },
                    data: {
                        labels: <?php echo json_encode($incExpBarChartData['month']); ?>,
                        datasets: <?php echo json_encode($incExpBarChartData['incExpArr']); ?>

                    },
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();

        var DoughnutChart = (function () {
            var $chart = $('#chart-doughnut-income');

            function init($this) {
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };
                var doughnutChart = new Chart($this, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: <?php echo json_encode($incomeCatAmount); ?>,
                            backgroundColor: <?php echo json_encode($incomeCategoryColor); ?>,
                        }],
                        labels: <?php echo json_encode($incomeCategory); ?>,
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
                $this.data('chart', doughnutChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
        var DoughnutChart = (function () {
            var $chart = $('#chart-doughnut-expense');

            function init($this) {
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };
                var doughnutChart = new Chart($this, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: <?php echo json_encode($expenseCatAmount); ?>,
                            backgroundColor: <?php echo json_encode($expenseCategoryColor); ?>,
                        }],
                        labels: <?php echo json_encode($expenseCategory); ?>,
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
                $this.data('chart', doughnutChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="section-header">
            <h1><?php echo e(__('Dashboard')); ?></h1>
        </div>
        <?php if(\Auth::user()->can('show dashboard')): ?>
            <?php if(\Auth::user()->type=='company'): ?>
                <div class="row">
                    <?php if($constant['taxes']<=0): ?>
                        <div class="col-3">
                            <div class="alert alert-danger">
                                <?php echo e(__('Please add constant taxes. ')); ?><a href="<?php echo e(route('taxes.index')); ?>"><b><?php echo e(__('click here')); ?></b></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($constant['category']<=0): ?>
                        <div class="col-3">
                            <div class="alert alert-danger">
                                <?php echo e(__('Please add constant category. ')); ?><a href="<?php echo e(route('product-category.index')); ?>"><b><?php echo e(__('click here')); ?></b></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($constant['units']<=0): ?>
                        <div class="col-3">
                            <div class="alert alert-danger">
                                <?php echo e(__('Please add constant unit. ')); ?><a href="<?php echo e(route('product-unit.index')); ?>"><b><?php echo e(__('click here')); ?></b></a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($constant['bankAccount']<=0): ?>
                        <div class="col-3">
                            <div class="alert alert-danger">
                                <?php echo e(__('Please create bank account. ')); ?><a href="<?php echo e(route('bank-account.index')); ?>"><b><?php echo e(__('click here')); ?></b></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4><?php echo e(__('TOTAL CUSTOMERS')); ?></h4>
                            </div>
                            <div class="card-body">
                                <?php echo e(\Auth::user()->countCustomers()); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4><?php echo e(__('TOTAL VENDORS')); ?></h4>
                            </div>
                            <div class="card-body">
                                <?php echo e(\Auth::user()->countVenders()); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-money-bill-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4><?php echo e(__('TOTAL INVOICES')); ?></h4>
                            </div>
                            <div class="card-body">
                                <?php echo e(\Auth::user()->countInvoices()); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-money-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4><?php echo e(__('TOTAL BILLS')); ?></h4>
                            </div>
                            <div class="card-body">
                                <?php echo e(\Auth::user()->countBills()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Income Vs Expense')); ?></h4>

                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-right"><?php echo e(\Auth::user()->priceFormat(\Auth::user()->todayIncome())); ?></div>
                                        <div class="media-title"><a href="#"><?php echo e(__('Income Today')); ?></a></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-right"><?php echo e(\Auth::user()->priceFormat(\Auth::user()->todayExpense())); ?></div>
                                        <div class="media-title"><a href="#"><?php echo e(__('Expense Today')); ?></a></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-right"><?php echo e(\Auth::user()->priceFormat(\Auth::user()->incomeCurrentMonth())); ?></div>
                                        <div class="media-title"><a href="#"><?php echo e(__('Income This Month')); ?></a></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-right"><?php echo e(\Auth::user()->priceFormat(\Auth::user()->expenseCurrentMonth())); ?></div>
                                        <div class="media-title"><a href="#"><?php echo e(__('Expense This Month')); ?></a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Cashflow')); ?></h4>
                            <div class="card-header-action">
                                <h4><?php echo e(__('Last 15 days')); ?></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="cash-flow" class="chartjs-render-monitor" height="210"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Income & Expense')); ?></h4>
                            <div class="card-header-action">
                                <h4><?php echo e(__('Current year').' - '.$currentYear); ?></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="incExpBarChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><?php echo e(__('Income By Category')); ?></h4>
                                    <div class="card-header-action">
                                        <h4><?php echo e(__('Current year').' - '.$currentYear); ?></h4>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <?php $__empty_1 = true; $__currentLoopData = $incomeCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="text-right mt-10">
                                            <span class="graph-label" style="background-color: <?php echo e($incomeCategoryColor[$key]); ?>"><?php echo e($category); ?></span>
                                            <span><?php echo e(\Auth::user()->priceFormat($incomeCatAmount[$key])); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="text-center">
                                            <h6><?php echo e(__('there is no income by category')); ?></h6>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <canvas id="chart-doughnut-income" height="182"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><?php echo e(__('Expense By Category')); ?></h4>
                                    <div class="card-header-action">
                                        <h4><?php echo e(__('Current year').' - '.$currentYear); ?></h4>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <?php $__empty_1 = true; $__currentLoopData = $expenseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="text-right mt-10">
                                            <span class="graph-label" style="background-color: <?php echo e($expenseCategoryColor[$key]); ?>"><?php echo e($category); ?></span>
                                            <span><?php echo e(\Auth::user()->priceFormat($expenseCatAmount[$key])); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="text-center">
                                            <h6><?php echo e(__('there is no expense by category')); ?></h6>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <canvas id="chart-doughnut-expense" height="182"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Latest Income')); ?></h4>
                            <div class="card-header-action">
                                <a href="<?php echo e(route('revenue.index')); ?>" class="btn btn-primary"><?php echo e(__('View All')); ?></a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Customer')); ?></th>
                                        <th><?php echo e(__('Amount Due')); ?></th>
                                        <th><?php echo e(__('Description')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $latestIncome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="font-style">
                                            <td><?php echo e(\Auth::user()->dateFormat($income->date)); ?></td>
                                            <td><?php echo e(!empty($income->customer)?$income->customer->name:''); ?></td>
                                            <td><?php echo e(\Auth::user()->priceFormat($income->amount)); ?></td>
                                            <td><?php echo e($income->description); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="text-center">
                                                    <h6><?php echo e(__('there is no latest income')); ?></h6>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Latest Expense')); ?></h4>
                            <div class="card-header-action">
                                <a href="<?php echo e(route('payment.index')); ?>" class="btn btn-primary"><?php echo e(__('View All')); ?></a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Vendor')); ?></th>
                                        <th><?php echo e(__('Amount Due')); ?></th>
                                        <th><?php echo e(__('Description')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $latestExpense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="font-style">
                                            <td><?php echo e(\Auth::user()->dateFormat($expense->date)); ?></td>
                                            <td><?php echo e(!empty($expense->vender)?$expense->vender->name:''); ?></td>
                                            <td><?php echo e(\Auth::user()->priceFormat($expense->amount)); ?></td>
                                            <td><?php echo e($expense->description); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="text-center">
                                                    <h6><?php echo e(__('there is no latest expense')); ?></h6>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Account Balance')); ?></h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(__('Bank')); ?></th>
                                        <th><?php echo e(__('Holder Name')); ?></th>
                                        <th><?php echo e(__('Balance')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $bankAccountDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="font-style">
                                            <td><?php echo e($bankAccount->bank_name); ?></td>
                                            <td><?php echo e($bankAccount->holder_name); ?></td>
                                            <td><?php echo e(\Auth::user()->priceFormat($bankAccount->opening_balance)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="text-center">
                                                    <h6><?php echo e(__('there is no account balance')); ?></h6>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Invoices')); ?></h4>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card-header">
                                    <h6><b><?php echo e(__('Weekly Statistics')); ?></b></h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border">
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($weeklyInvoice['invoiceTotal'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Invoice Generated')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($weeklyInvoice['invoicePaid'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Paid')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($weeklyInvoice['invoiceDue'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Due')); ?></a></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-header">
                                    <h6><b><?php echo e(__('Monthly Statistics')); ?></b></h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border">
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($monthlyInvoice['invoiceTotal'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Invoice Generated')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($monthlyInvoice['invoicePaid'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Paid')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($monthlyInvoice['invoiceDue'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Due')); ?></a></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6><b><?php echo e(__('Recent Invoices')); ?></b></h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Customer')); ?></th>
                                        <th><?php echo e(__('Issue Date')); ?></th>
                                        <th><?php echo e(__('Due Date')); ?></th>
                                        <th><?php echo e(__('Amount')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="font-style">
                                            <td><?php echo e(\Auth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></td>
                                            <td><?php echo e(!empty($invoice->customer)? $invoice->customer->name:''); ?> </td>
                                            <td><?php echo e(Auth::user()->dateFormat($invoice->issue_date)); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($invoice->due_date)); ?></td>
                                            <td><?php echo e(\Auth::user()->priceFormat($invoice->getTotal())); ?></td>
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
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6">
                                                <div class="text-center">
                                                    <h6><?php echo e(__('there is no recent invoice')); ?></h6>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Bills')); ?></h4>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card-header">
                                    <h6><b><?php echo e(__('Weekly Statistics')); ?></b></h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border">
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($weeklyBill['billTotal'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Bill Generated')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($weeklyBill['billPaid'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Paid')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($weeklyBill['billDue'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Due')); ?></a></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-header">
                                    <h6><b><?php echo e(__('Monthly Statistics')); ?></b></h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border">
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($monthlyBill['billTotal'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Bill Generated')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($monthlyBill['billPaid'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Paid')); ?></a></div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-right"><?php echo e(\Auth::user()->priceFormat($monthlyBill['billDue'])); ?></div>
                                                <div class="media-title"><a href="#"><?php echo e(__('Total Due')); ?></a></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <h6><b><?php echo e(__('Recent Bills')); ?></b></h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Vendor')); ?></th>
                                            <th><?php echo e(__('Bill Date')); ?></th>
                                            <th><?php echo e(__('Due Date')); ?></th>
                                            <th><?php echo e(__('Amount')); ?></th>
                                            <th><?php echo e(__('Status')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $recentBill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="font-style">
                                                <td><?php echo e(\Auth::user()->billNumberFormat($bill->bill_id)); ?></td>
                                                <td><?php echo e(!empty($bill->vender)? $bill->vender->name:''); ?> </td>
                                                <td><?php echo e(Auth::user()->dateFormat($bill->bill_date)); ?></td>
                                                <td><?php echo e(Auth::user()->dateFormat($bill->due_date)); ?></td>
                                                <td><?php echo e(\Auth::user()->priceFormat($bill->getTotal())); ?></td>
                                                <td>
                                                    <?php if($bill->status == 0): ?>
                                                        <span class="badge badge-primary"><?php echo e(__(\App\Bill::$statues[$bill->status])); ?></span>
                                                    <?php elseif($bill->status == 1): ?>
                                                        <span class="badge badge-warning"><?php echo e(__(\App\Bill::$statues[$bill->status])); ?></span>
                                                    <?php elseif($bill->status == 2): ?>
                                                        <span class="badge badge-danger"><?php echo e(__(\App\Bill::$statues[$bill->status])); ?></span>
                                                    <?php elseif($bill->status == 3): ?>
                                                        <span class="badge badge-info"><?php echo e(__(\App\Bill::$statues[$bill->status])); ?></span>
                                                    <?php elseif($bill->status == 4): ?>
                                                        <span class="badge badge-success"><?php echo e(__(\App\Bill::$statues[$bill->status])); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="text-center">
                                                        <h6><?php echo e(__('there is no recent bill')); ?></h6>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Goal')); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php $__empty_1 = true; $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $total= $goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['total'];
                                $percentage=$goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'];
                                ?>
                                <div class="col-12">
                                    <div class="card card-statistic-1 card-statistic-2">
                                        <div class="card-wrap">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <div class="card-header">
                                                        <h4><?php echo e(__('Name')); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php echo e($goal->name); ?>

                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <div class="card-header">
                                                        <h4><?php echo e(__('Type')); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php echo e(__(\App\Goal::$goalType[$goal->type])); ?>

                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="card-header">
                                                        <h4><?php echo e(__('Duration')); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php echo e($goal->from .' To '.$goal->to); ?>

                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-5">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <?php echo e(\Auth::user()->priceFormat($total).' of '. \Auth::user()->priceFormat($goal->amount)); ?>

                                                            </div>
                                                            <div class="col-auto">
                                                                <?php echo e(number_format($percentage, \Utility::getValByName('decimal_number'), '.', '')); ?>%
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width:<?php echo e(number_format($goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'], \Utility::getValByName('decimal_number'), '.', '')); ?>%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="text-center">
                                            <h6><?php echo e(__('there is no goal')); ?></h6>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-danger"><?php echo e(__('Permission Denied')); ?></h4>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/exoticfruits/resources/views/dashboard/index.blade.php ENDPATH**/ ?>