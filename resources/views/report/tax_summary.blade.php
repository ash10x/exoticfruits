@extends('layouts.admin')
@section('page-title')
    {{__('Tax Summary')}}
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
            <h1>{{__('Tax Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Report')}}</div>
                <div class="breadcrumb-item">{{__('Tax Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(array('route' => array('report.tax.summary'),'method' => 'GET')) }}
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
                                    <a href="{{route('report.tax.summary')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                    <input type="hidden" value="{{__('Tax Summary').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">

                                    <div class="row">
                                        <div class="col">
                                            {{__('Report')}} : <h6>{{__('Tax Summary')}}</h6>
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
                                                    <table class="table table-flush border" id="dataTable-manual">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>{{__('Tax')}}</th>
                                                            @foreach($monthList as $month)
                                                                <th>{{$month}}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @forelse(array_keys($incomes) as $k=> $taxName)
                                                            <tr>
                                                                <td>{{$taxName}}</td>
                                                                @foreach(array_values($incomes)[$k] as $price)
                                                                    <td>{{\Auth::user()->priceFormat($price)}}</td>
                                                                @endforeach
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="13" class="text-center">{{__('Income tax not found')}}</td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-sm-12">
                                                    <h4>{{__('Expense')}}</h4>
                                                    <table class="table table-flush border" id="dataTable-manual">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>{{__('Tax')}}</th>
                                                            @foreach($monthList as $month)
                                                                <th>{{$month}}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @forelse(array_keys($expenses) as $k=> $taxName)
                                                            <tr>
                                                                <td>{{$taxName}}</td>
                                                                @foreach(array_values($expenses)[$k] as $price)
                                                                    <td>{{\Auth::user()->priceFormat($price)}}</td>
                                                                @endforeach
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="13" class="text-center">{{__('Expense tax not found')}}</td>
                                                            </tr>
                                                        @endforelse
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


