@extends('layouts.admin')
@section('page-title')
    {{__('Expense Summary')}}
@endsection

@push('script-page')
    <script>
        var SalesChart = (function () {
            var $chart = $('#chart-sales');

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
                        labels: {!! json_encode($monthList) !!},
                        datasets: [{
                            label: 'Expense',
                            data:{!! json_encode($chartExpenseArr) !!},
                            borderColor: '#ff0000b8',
                            backgroundColor: '#ff0000b8',
                            fill: '!0',
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
        var year = '{{$currentYear}}';

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

    </script>

@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Expense Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Report')}}</div>
                <div class="breadcrumb-item">{{__('Expense Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('report.expense.summary'),'method' => 'GET')) }}
                            <div class="row">
                                <div class="col">
                                    <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('year', __('Year')) }}
                                    {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>

                                <div class="col-md-2">
                                    {{ Form::label('category', __('Category')) }}
                                    {{ Form::select('category',$category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('vender', __('Vendor')) }}
                                    {{ Form::select('vender',$vender,isset($_GET['vender'])?$_GET['vender']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>

                                <div class="col-auto apply-btn">
                                    {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                    <a href="{{route('report.expense.summary')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                    <input type="hidden" value="{{$filter['category'].' '.__('Expense Summary').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                                    <div class="row">
                                        <div class="col">
                                            {{__('Report')}} : <h6>{{__('Expense Summary')}}</h6>
                                        </div>
                                        @if($filter['category']!= __('All'))
                                            <div class="col">
                                                {{__('Category')}} : <h6>{{$filter['category'] }}</h6>
                                            </div>
                                        @endif
                                        @if($filter['vender']!= __('All'))
                                            <div class="col">
                                                {{__('Vendor')}} : <h6>{{$filter['vender'] }}</h6>
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
                    <div class="col-12" id="chart-container">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                        <div class="table-responsive">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <canvas id="chart-sales" height="300"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-body p-0">
                                    <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                        <div class="table-responsive">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-flush border font-style" id="dataTable-manual">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>{{__('Category')}}</th>
                                                            @foreach($monthList as $month)
                                                                <th>{{$month}}</th>
                                                            @endforeach
                                                        </tr>

                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Payment :')}}</h6></b></td>
                                                        </tr>
                                                        @foreach($expenseArr as $i=>$expense)
                                                            <tr>
                                                                <td>{{$expense['category']}}</td>
                                                                @foreach($expense['data'] as $j=>$data)
                                                                    <td>{{\Auth::user()->priceFormat($data)}}</td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Bill :')}}</h6></b></td>
                                                        </tr>
                                                        @foreach($billArray as $i=>$bill)
                                                            <tr>
                                                                <td>{{$bill['category']}}</td>
                                                                @foreach($bill['data'] as $j=>$data)
                                                                    <td>{{\Auth::user()->priceFormat($data)}}</td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Expense = Payment + Bill :')}}</h6></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{__('Total')}}</td>
                                                            @foreach($chartExpenseArr as $i=>$expense)
                                                                <td>{{\Auth::user()->priceFormat($expense)}}</td>
                                                            @endforeach
                                                        </tr>
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
        </div>
    </section>

@endsection


