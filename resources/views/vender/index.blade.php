@extends('layouts.admin')
@php
    $profile=asset(Storage::url('uploads/avatar/'));
@endphp
@push('script-page')
    <script>

        $(document).on('click', '#billing_data', function () {
            $("[name='shipping_name']").val($("[name='billing_name']").val());
            $("[name='shipping_country']").val($("[name='billing_country']").val());
            $("[name='shipping_state']").val($("[name='billing_state']").val());
            $("[name='shipping_city']").val($("[name='billing_city']").val());
            $("[name='shipping_phone']").val($("[name='billing_phone']").val());
            $("[name='shipping_zip']").val($("[name='billing_zip']").val());
            $("[name='shipping_address']").val($("[name='billing_address']").val());
        })

    </script>
@endpush
@section('page-title')
    {{__('Vendor')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Vendor')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Vendor')}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4>{{__('Manage Vendor')}}</h4>
                            <div class="card-header-action">
                                @can('create vender')
                                    <a href="#" data-size="2xl" data-url="{{ route('vender.create') }}" data-ajax-popup="true" data-title="{{__('Create New Vendor')}}" class="btn btn-icon icon-left btn-primary commonModal">
                                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                        <span class="btn-inner--text"> {{__('Create')}}</span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-flush" id="dataTable">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th> {{__('Name')}}</th>
                                                    <th> {{__('Contact')}}</th>
                                                    <th> {{__('Email')}}</th>
                                                    <th> {{__('Balance')}}</th>
                                                    <th class="text-right">{{__('Action')}}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach ($venders as $k=>$Vender)
                                                    <tr class="cust_tr" id="vend_detail">
                                                        <td>
                                                            @can('show vender')
                                                                <a href="{{ route('vender.show',$Vender['id']) }}" class="btn btn-outline-primary"> {{ AUth::user()->venderNumberFormat($Vender['vender_id']) }}
                                                                </a>
                                                            @else
                                                                <a href="#" class="btn btn-outline-primary"> {{ AUth::user()->venderNumberFormat($Vender['vender_id']) }}
                                                                </a>
                                                            @endcan

                                                        </td>
                                                        <td>{{$Vender['name']}}</td>
                                                        <td>{{$Vender['contact']}}</td>
                                                        <td>{{$Vender['email']}}</td>
                                                        <td>{{\Auth::user()->priceFormat($Vender['balance'])}}</td>
                                                        <td class="text-right">
                                                            @if($Vender['is_active']==0)
                                                                <i class="fa fa-lock" title="Inactive"></i>
                                                            @else
                                                                @can('show vender')
                                                                    <a href="{{ route('vender.show',$Vender['id']) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('edit vender')
                                                                    <a href="#!" class="btn btn-primary btn-action mr-1" data-size="2xl" data-url="{{ route('vender.edit',$Vender['id']) }}" data-ajax-popup="true" data-title="{{__('Edit Vendor')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete vender')
                                                                    <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{ $Vender['id']}}').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['vender.destroy', $Vender['id']],'id'=>'delete-form-'.$Vender['id']]) !!}
                                                                    {!! Form::close() !!}
                                                                @endcan
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="customer_details">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
