@extends('layouts.admin')
@section('page-title')
    {{__('Profit & Loss Summary')}}
@endsection
@push('script-page')
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
            <h1>{{__('Profit && Loss Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Report')}}</div>
                <div class="breadcrumb-item">{{__('Profit && Loss Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('report.profit.loss.summary'),'method' => 'GET')) }}
                            <div class="row">
                                <div class="col">
                                    <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('year', __('Year')) }}
                                    {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="col-auto apply-btn">
                                    {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                    <a href="{{route('report.profit.loss.summary')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                    <input type="hidden" value="{{__('Profit && Loss Summary').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">

                                    <div class="row">
                                        <div class="col">
                                            {{__('Report')}} : <h6>{{__('Profit && Loss Summary')}}</h6>
                                        </div>
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
                                                    <h4>{{__('Income')}}</h4>
                                                    <table class="table table-flush border font-style" id="dataTable-manual">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th width="25%">{{__('Category')}}</th>
                                                            @foreach($month as $m)
                                                                <th width="15%">{{$m}}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Revenue : ')}}</h6></b></td>
                                                        </tr>
                                                        @if(!empty($revenueIncomeArray))
                                                            @foreach($revenueIncomeArray as $i=>$revenue)
                                                                <tr>
                                                                    <td>{{$revenue['category']}}</td>
                                                                    @foreach($revenue['amount'] as $j=>$amount)
                                                                        <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endif

                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Invoice : ')}}</h6></b></td>
                                                        </tr>
                                                        @if(!empty($invoiceIncomeArray))
                                                            @foreach($invoiceIncomeArray as $i=>$invoice)
                                                                <tr>
                                                                    <td>{{$invoice['category']}}</td>
                                                                    @foreach($invoice['amount'] as $j=>$amount)
                                                                        <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table table-flush border" id="dataTable-manual">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="13"><b><h6>{{__('Total Income =  Revenue + Invoice ')}}</h6></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="25%">{{__('Total Income')}}</td>
                                                                        @foreach($totalIncome as $income)
                                                                            <td width="15%">{{\Auth::user()->priceFormat($income)}}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4>{{__('Expense')}}</h4>
                                                    <table class="table table-flush border font-style" id="dataTable-manual">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th width="25%">{{__('Category')}}</th>
                                                            @foreach($month as $m)
                                                                <th width="15%">{{$m}}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Payment : ')}}</h6></b></td>
                                                        </tr>
                                                        @if(!empty($expenseArray))
                                                            @foreach($expenseArray as $i=>$expense)
                                                                <tr>
                                                                    <td>{{$expense['category']}}</td>
                                                                    @foreach($expense['amount'] as $j=>$amount)
                                                                        <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        <tr>
                                                            <td colspan="13"><b><h6>{{__('Bill : ')}}</h6></b></td>
                                                        </tr>
                                                        @if(!empty($billExpenseArray))
                                                            @foreach($billExpenseArray as $i=>$bill)
                                                                <tr>
                                                                    <td>{{$bill['category']}}</td>
                                                                    @foreach($bill['amount'] as $j=>$amount)
                                                                        <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table table-flush border" id="dataTable-manual">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="13"><b><h6>{{__('Total Expense =  Payment + Bill ')}}</h6></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{__('Total Expenses')}}</td>
                                                                        @foreach($totalExpense as $expense)
                                                                            <td width="15%">{{\Auth::user()->priceFormat($expense)}}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table table-flush border" id="dataTable-manual">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="13"><b><h6>{{__('Net Profit = Total Income - Total Expense ')}}</h6></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="25%">{{__('Net Profit')}}</td>
                                                                        @foreach($netProfitArray as $i=>$profit)
                                                                            <td width="15%"> {{\Auth::user()->priceFormat($profit)}}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
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


