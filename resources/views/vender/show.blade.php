@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Vendor-Detail')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Vendor')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('customer.index')}}">{{__('Vendor')}}</a></div>
                <div class="breadcrumb-item">{{$vendor->name}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4></h4>
                            <div class="card-header-action">
                                @can('create bill')
                                    <a href="{{ route('bill.create',$vendor->id) }}" class="btn btn-sm  btn-info lift">
                                        <i class="fa fa-file"></i> {{__('Create Bill')}}
                                    </a>
                                @endcan
                                @can('edit vender')
                                    <a href="#!" class="btn btn-primary mr-1" data-size="2xl" data-url="{{ route('vender.edit',$vendor['id']) }}" data-ajax-popup="true" data-title="{{__('Edit Vendor')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endcan
                                @can('delete vender')
                                    <a href="#!" class="btn btn-danger" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{ $vendor['id']}}').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['vender.destroy', $vendor['id']],'id'=>'delete-form-'.$vendor['id']]) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row custmer-detail-wrap">
                            <div class="col-md-4">
                                <h4 class="sub-title">{{__('Vendor Info')}}</h4>
                                <address>
                                    {{$vendor->name}} <br>
                                    {{$vendor->email}} <br>
                                    {{$vendor->contact}} <br>
                                </address>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="sub-title">{{__('Billing Info')}}</h4>
                                        <address>
                                            {{$vendor->billing_name}} <br>
                                            {{$vendor->billing_phone}} <br>
                                            {{$vendor->billing_address}} <br>
                                            {{$vendor->billing_zip}} <br>
                                            {{$vendor->billing_city.', '. $vendor->billing_state .', '.$vendor->billing_country}}
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="sub-title">{{__('Shipping Info')}}</h4>
                                        <address>
                                            {{$vendor->shipping_name}} <br>
                                            {{$vendor->shipping_phone}} <br>
                                            {{$vendor->shipping_address}} <br>
                                            {{$vendor->shipping_zip}} <br>
                                            {{$vendor->shipping_city.', '. $vendor->billing_state .', '.$vendor->billing_country}}
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="sub-title">{{__('Company Info')}}</h4>
                        <div class="row custmer-detail-wrap">
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Vendor Id')}}</strong>
                                    <span>{{\Auth::user()->venderNumberFormat($vendor->vender_id)}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Date of Creation')}}</strong>
                                    <span>{{\Auth::user()->dateFormat($vendor->created_at)}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info font-style">
                                    <strong>{{__('Balance')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($vendor->balance)}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Overdue')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($vendor->vendorOverdue($vendor->id))}}</span>
                                </div>
                            </div>
                            @php
                                $totalBillSum=$vendor->vendorTotalBillSum($vendor['id']);
                                $totalBill=$vendor->vendorTotalBill($vendor['id']);
                                $averageSale=($totalBillSum!=0)?$totalBillSum/$totalBill:0;
                            @endphp
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Total Sum of Bills')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($totalBillSum)}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Quantity of Bills')}}</strong>
                                    <span>{{$totalBill}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Average Sales')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($averageSale)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Bills')}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th> {{__('Bill')}}</th>
                                <th> {{__('Bill Date')}}</th>
                                <th> {{__('Due Date')}}</th>
                                <th> {{__('Due Amount')}}</th>
                                <th>{{__('Status')}}</th>
                                @if(Gate::check('edit bill') || Gate::check('delete bill') || Gate::check('show bill'))
                                    <th class="text-right"> {{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($vendor->vendorBill($vendor->id) as $bill)
                                <tr class="font-style">
                                    <td>
                                        @if(\Auth::guard('vender')->check())
                                            <a class="btn btn-outline-primary" href="{{ route('vender.bill.show',$bill->id) }}">{{ AUth::user()->billNumberFormat($bill->bill_id) }}
                                            </a>
                                        @else
                                            <a class="btn btn-outline-primary" href="{{ route('bill.show',$bill->id) }}">{{ AUth::user()->billNumberFormat($bill->bill_id) }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ Auth::user()->dateFormat($bill->bill_date) }}</td>
                                    <td>
                                        @if(($bill->due_date < date('Y-m-d')))
                                            <p class="text-danger"> {{ \Auth::user()->dateFormat($bill->due_date) }}</p>
                                        @else
                                            {{ \Auth::user()->dateFormat($bill->due_date) }}
                                        @endif
                                    </td>
                                    <td>{{\Auth::user()->priceFormat($bill->getDue())  }}</td>
                                    <td>
                                        @if($bill->status == 0)
                                            <span class="badge badge-primary">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 1)
                                            <span class="badge badge-warning">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 2)
                                            <span class="badge badge-danger">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 3)
                                            <span class="badge badge-info">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 4)
                                            <span class="badge badge-success">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @endif
                                    </td>
                                    @if(Gate::check('edit bill') || Gate::check('delete bill') || Gate::check('show bill'))
                                        <td class="action text-right">
                                            @can('duplicate bill')
                                                <a href="#" class="btn btn-success btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Duplicate')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="You want to confirm this action. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('duplicate-form-{{$bill->id}}').submit();">
                                                    <i class="fas fa-copy"></i>
                                                    {!! Form::open(['method' => 'get', 'route' => ['bill.duplicate', $bill->id],'id'=>'duplicate-form-'.$bill->id]) !!}
                                                    {!! Form::close() !!}
                                                </a>
                                            @endcan
                                            @can('show bill')
                                                @if(\Auth::guard('vender')->check())
                                                    <a href="{{ route('vender.bill.show',$bill->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('bill.show',$bill->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                            @can('edit bill')
                                                <a href="{{ route('bill.edit',$bill->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('delete bill')
                                                <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$bill->id}}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['bill.destroy', $bill->id],'id'=>'delete-form-'.$bill->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </section>
@endsection
