@extends('layouts.admin')
@section('page-title')
    {{__('Transaction Summary')}}
@endsection
@push('script-page')
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
                jsPDF: {unit: 'in', format: 'A4'}
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
            <h1>{{__('Transaction Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Report')}}</div>
                <div class="breadcrumb-item">{{__('Transaction Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('transaction.index'),'method'=>'get')) }}
                            <div class="row">
                                <div class="col">
                                    <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                </div>
                                <div class="col-md-2">
                                    {{Form::label('start_month',__('Start Month'))}}
                                    {{Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:date('Y-m'),array('class'=>'form-control'))}}
                                </div>
                                <div class="col-md-2">
                                    {{Form::label('end_month',__('End Month'))}}
                                    {{Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:date('Y-m', strtotime("-5 month")),array('class'=>'form-control'))}}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('account', __('Account')) }}
                                    {{ Form::select('account', $account,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control selectric')) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::label('category', __('Category')) }}
                                    {{ Form::select('category', $category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control selectric')) }}
                                </div>

                                <div class="col-auto apply-btn">
                                    {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                    <a href="{{route('transaction.index')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                    <input type="hidden" value="{{$filter['category'].' '.__('Category').' '.__('Transaction').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">

                                    <div class="row">
                                        <div class="col">
                                            {{__('Report')}} : <h6>{{__('Transaction Summary')}}</h6>
                                        </div>
                                        @if($filter['account']!= __('All'))
                                            <div class="col">
                                                {{__('Account')}} : <h6>{{$filter['account'] }}</h6>
                                            </div>
                                        @endif
                                        @if($filter['category']!= __('All'))
                                            <div class="col">
                                                {{__('Category')}} : <h6>{{$filter['category'] }}</h6>
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
                    @foreach($accounts as $account)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-wrap">
                                    <div class="card-header">
                                        @if($account->holder_name =='Cash')
                                            <h4>{{$account->holder_name}}</h4>
                                        @elseif(empty($account->holder_name))
                                            <h4>{{__('Stripe / Paypal')}}</h4>
                                        @else
                                            <h4>{{$account->holder_name.' - '.$account->bank_name}}</h4>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-stats">
                                    <div class="card-stats-title">
                                        <div class="progreess-status mt-2">
                                            <h6>
                                                <strong>{{\Auth::user()->priceFormat($account->total)}} </strong>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-flush" id="report-dataTable">
                                                    <thead class="thead-light">
                                                    <tr>

                                                        <th> {{__('Date')}}</th>
                                                        <th> {{__('Account')}}</th>
                                                        <th> {{__('Type')}}</th>
                                                        <th> {{__('Category')}}</th>
                                                        <th> {{__('Description')}}</th>
                                                        <th class="text-right"> {{__('Amount')}}</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach ($transactions as $transaction)
                                                        <tr class="font-style">
                                                            <td>{{ \Auth::user()->dateFormat($transaction->date)}}</td>
                                                            <td>
                                                                @if(!empty($transaction->bankAccount()) && $transaction->bankAccount()->holder_name=='Cash')
                                                                    {{$transaction->bankAccount()->holder_name}}
                                                                @else
                                                                    {{!empty($transaction->bankAccount())?$transaction->bankAccount()->bank_name.' '.$transaction->bankAccount()->holder_name:'-'}}
                                                                @endif
                                                            </td>

                                                            <td class="font-style">{{  $transaction->type}}</td>
                                                            <td class="font-style">{{  $transaction->category}}</td>
                                                            <td>{{  !empty($transaction->description)?$transaction->description:'-'}}</td>
                                                            <td class="text-right">{{\Auth::user()->priceFormat($transaction->amount)}}</td>
                                                        </tr>
                                                    @endforeach
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
    </section>
@endsection
