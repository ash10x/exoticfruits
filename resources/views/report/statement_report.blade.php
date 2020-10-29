@extends('layouts.admin')
@section('page-title')
    {{__('Account Statement Summary')}}
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/jspdf.min.js') }} "></script>
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
            <h1>{{__('Account Statement Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Report')}}</div>
                <div class="breadcrumb-item">{{__('Account Statement Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('report.account.statement'),'method'=>'get')) }}
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
                                    {{ Form::label('type', __('Type')) }}
                                    {{ Form::select('type',$types,isset($_GET['type'])?$_GET['type']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>

                                <div class="col-auto apply-btn">
                                    {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                    <a href="{{route('report.account.statement')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                    <input type="hidden" value="{{__('Account Statement').' '.$filter['type'].' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">

                                    <div class="row">
                                        <div class="col">
                                            {{__('Report')}} : <h6>{{__('Account Statement Summary')}}</h6>
                                        </div>
                                        @if($filter['account']!=__('All'))
                                            <div class="col">
                                                {{__('Account')}} : <h6>{{$filter['account'] }}</h6>
                                            </div>
                                        @endif
                                        @if($filter['type']!=__('All'))
                                            <div class="col">
                                                {{__('Type')}} : <h6>{{$filter['type'] }}</h6>
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
                @if(!empty($reportData['revenueAccounts']))
                    <div class="row">
                        @foreach($reportData['revenueAccounts'] as $account)
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
                @endif

                @if(!empty($reportData['paymentAccounts']))
                    <div class="row">
                        @foreach($reportData['paymentAccounts'] as $account)
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
                @endif
            </div>

            <div class="row">
                <div class="col-12" id="statement-container">
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
                                                        <th> {{__('Description')}}</th>
                                                        <th> {{__('Amount')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($reportData['revenues']))
                                                        @foreach ($reportData['revenues'] as $revenue)
                                                            <tr class="font-style">
                                                                <td>{{ Auth::user()->dateFormat($revenue->date) }}</td>
                                                                <td>{{ Auth::user()->priceFormat($revenue->amount) }}</td>
                                                                <td> {{!empty($revenue->description)?$revenue->description:'-'}} </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    @if(!empty($reportData['payments']))
                                                        @foreach ($reportData['payments'] as $payments)
                                                            <tr class="font-style">
                                                                <td>{{ Auth::user()->dateFormat($payments->date) }}</td>
                                                                <td>{{ Auth::user()->priceFormat($payments->amount) }}</td>
                                                                <td> {{!empty($payments->description)?$payments->description:'-'}} </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
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
