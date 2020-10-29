@extends('layouts.admin')
@section('page-title')
    {{__('Invoice Summary')}}
@endsection
@push('script-page')

    <script>
        var SalesChart = (function () {
            var $chart = $('#chart-sales');

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
                        labels: {!! json_encode($monthList) !!},
                        datasets: [{
                            label: 'Invoice',
                            data:{!! json_encode($invoiceTotal) !!},
                        }]
                    },
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();


    </script>

    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>

        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();

        }


        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: filename
                    },
                    {
                        extend: 'pdf',
                        title: filename
                    }, {
                        extend: 'print',
                        title: filename
                    }, {
                        extend: 'csv',
                        title: filename
                    }
                ]
            });
        });


    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Invoice Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Report')}}</div>
                <div class="breadcrumb-item">{{__('Invoice Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('report.invoice.summary'),'method' => 'GET')) }}
                            <div class="row">
                                <div class="col">
                                    <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('start_month', __('Start Month')) }}
                                    {{ Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:'', array('class' => 'form-control font-style')) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('end_month', __('End Month')) }}
                                    {{ Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:'', array('class' => 'form-control font-style')) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('customer', __('Customer')) }}
                                    {{ Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('status', __('Status')) }}
                                    {{ Form::select('status', [''=>'All']+$status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="col-auto apply-btn">
                                    {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                    <a href="{{route('report.invoice.summary')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
                                    <a href="#" onclick="saveAsPDF();" class="btn btn-icon icon-left btn-outline-info pdf-btn btn-sm" id="download-buttons">
                                        {{__('Download')}}
                                    </a>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div id="printableArea">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-wrap">
                                <div class="card-body">
                                    <input type="hidden" value="{{$filter['status'].' '.__('Invoice').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange'].' '.__('of').' '.$filter['customer']}}" id="filename">

                                    <div class="row">
                                        <div class="col">
                                            {{__('Report')}} : <h6>{{__('Invoice Summary')}}</h6>
                                        </div>
                                        @if($filter['customer']!= __('All'))
                                            <div class="col">
                                                {{__('Customer')}} : <h6>{{$filter['customer'] }}</h6>
                                            </div>
                                        @endif
                                        @if($filter['status']!= __('All'))
                                            <div class="col">
                                                {{__('Status')}} : <h6>{{$filter['status'] }}</h6>
                                            </div>
                                        @endif
                                        <div class="col">
                                            {{__('Duration')}} : <h6>{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{__('Total Invoice')}}</h4>
                                </div>
                            </div>
                            <div class="card-stats">
                                <div class="card-stats-title">
                                    <div class="progreess-status mt-2">
                                        <h6>
                                            <strong>{{Auth::user()->priceFormat($totalInvoice)}} </strong>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{__('Total Paid')}}</h4>
                                </div>
                            </div>
                            <div class="card-stats">
                                <div class="card-stats-title">
                                    <div class="progreess-status mt-2">
                                        <h6>
                                            <strong>{{Auth::user()->priceFormat($totalPaidInvoice)}} </strong>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{__('Total Due')}}</h4>
                                </div>
                            </div>
                            <div class="card-stats">
                                <div class="card-stats-title">
                                    <div class="progreess-status mt-2">
                                        <h6>
                                            <strong>{{Auth::user()->priceFormat($totalDueInvoice)}} </strong>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="invoice-container">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <ul class="nav nav-pills mb-3" id="myTab3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active btn-sm" id="profile-tab3" data-toggle="tab" href="#summary" role="tab" aria-controls="" aria-selected="false">{{__('Summary')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link btn-sm" id="contact-tab4" data-toggle="tab" href="#invoices" role="tab" aria-controls="" aria-selected="false">{{__('Invoices')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="tab-content" id="myTabContent2">
                                                    <div class="tab-pane fade fade" id="invoices" role="tabpanel" aria-labelledby="profile-tab3">
                                                        <table class="table table-flush" id="report-dataTable">
                                                            <thead class="thead-light">
                                                            <tr>
                                                                <th> {{__('Invoice')}}</th>
                                                                <th> {{__('Date')}}</th>
                                                                <th> {{__('Customer')}}</th>
                                                                <th> {{__('Category')}}</th>
                                                                <th> {{__('Status')}}</th>
                                                                <th> {{__('	Paid Amount')}}</th>
                                                                <th> {{__('Due Amount')}}</th>
                                                                <th> {{__('Payment Date')}}</th>
                                                                <th> {{__('Amount')}}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach ($invoices as $invoice)
                                                                <tr class="font-style">
                                                                    <td>
                                                                        <a class="btn btn-outline-primary" href="{{ route('invoice.show',$invoice->id) }}">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ \Auth::user()->dateFormat($invoice->send_date) }}</td>
                                                                    <td> {{!empty($invoice->customer)? $invoice->customer->name:'-' }} </td>
                                                                    <td>{{ !empty($invoice->category)?$invoice->category->name:'-'}}</td>
                                                                    <td>
                                                                        @if($invoice->status == 0)
                                                                            <b><span class="text-primary">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span></b>
                                                                        @elseif($invoice->status == 1)
                                                                            <b> <span class="text-warning">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span></b>
                                                                        @elseif($invoice->status == 2)
                                                                            <b> <span class="text-danger">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span></b>
                                                                        @elseif($invoice->status == 3)
                                                                            <b> <span class="text-info">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span></b>
                                                                        @elseif($invoice->status == 4)
                                                                            <b> <span class="text-success">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span></b>
                                                                        @endif
                                                                    </td>
                                                                    <td> {{\Auth::user()->priceFormat($invoice->getTotal()-$invoice->getDue())}}</td>
                                                                    <td> {{\Auth::user()->priceFormat($invoice->getDue())}}</td>
                                                                    <td>{{!empty($invoice->lastPayments)?\Auth::user()->dateFormat($invoice->lastPayments->date):'-'}}</td>
                                                                    <td> {{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade fade show active" id="summary" role="tabpanel" aria-labelledby="profile-tab3">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <canvas id="chart-sales" height="300"></canvas>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
