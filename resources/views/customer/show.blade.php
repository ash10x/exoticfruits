@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Customer-Detail')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Customer')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('customer.index')}}">{{__('Customer')}}</a></div>
                <div class="breadcrumb-item">{{$customer->name}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4></h4>
                            <div class="card-header-action">
                                @can('create invoice')
                                    <a href="{{ route('invoice.create',$customer->id) }}" class="btn btn-sm  btn-info lift">
                                        <i class="fa fa-file"></i> {{__('Create Invoice')}}
                                    </a>
                                @endcan
                                @can('create proposal')
                                    <a href="{{ route('proposal.create',$customer->id) }}" class="btn btn-sm  btn-info lift">
                                        <i class="fa fa-file"></i> {{__('Create Proposal')}}
                                    </a>
                                @endcan
                                @can('edit customer')
                                    <a href="#!" class="btn btn-primary mr-1" data-size="2xl" data-url="{{ route('customer.edit',$customer['id']) }}" data-ajax-popup="true" data-title="{{__('Edit Customer')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endcan
                                @can('delete customer')
                                    <a href="#!" class="btn btn-danger " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{ $customer['id']}}').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['customer.destroy', $customer['id']],'id'=>'delete-form-'.$customer['id']]) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row custmer-detail-wrap">
                            <div class="col-md-4">
                                <h4 class="sub-title">{{__('Customer Info')}}</h4>
                                <address>
                                    {{$customer['name']}} <br>
                                    {{$customer['email']}} <br>
                                    {{$customer['contact']}} <br>
                                </address>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="sub-title">{{__('Billing Info')}}</h4>
                                        <address>
                                            {{$customer['billing_name']}} <br>
                                            {{$customer['billing_phone']}} <br>
                                            {{$customer['billing_address']}} <br>
                                            {{$customer['billing_zip']}} <br>
                                            {{$customer['billing_city'].', '. $customer['billing_state'] .', '.$customer['billing_country']}}
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="sub-title">{{__('Shipping Info')}}</h4>
                                        <address>
                                            {{$customer['shipping_name']}} <br>
                                            {{$customer['shipping_phone']}} <br>
                                            {{$customer['shipping_address']}} <br>
                                            {{$customer['shipping_zip']}} <br>
                                            {{$customer['shipping_city'].', '. $customer['billing_state'] .', '.$customer['billing_country']}}
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="sub-title">{{__('Company Info')}}</h4>
                        <div class="row custmer-detail-wrap">
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Customer Id')}}</strong>
                                    <span>{{AUth::user()->customerNumberFormat($customer['customer_id'])}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Date of Creation')}}</strong>
                                    <span>{{\Auth::user()->dateFormat($customer['created_at'])}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info font-style">
                                    <strong>{{__('Balance')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($customer['balance'])}}</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Overdue')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($customer->customerOverdue($customer['id']))}}</span>
                                </div>
                            </div>
                            @php
                                $totalInvoiceSum=$customer->customerTotalInvoiceSum($customer['id']);
                                $totalInvoice=$customer->customerTotalInvoice($customer['id']);
                                $averageSale=($totalInvoiceSum!=0)?$totalInvoiceSum/$totalInvoice:0;
                            @endphp
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Total Sum of Invoices')}}</strong>
                                    <span>{{\Auth::user()->priceFormat($totalInvoiceSum)}}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <strong>{{__('Quantity of Invoice')}}</strong>
                                    <span>{{$totalInvoice}}</span>
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
                        <h4>{{__('Proposal')}}</h4>
                    </div>
                    <div class="card-body">
                        <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-flush" id="dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th> {{__('Proposal')}}</th>
                                                <th> {{__('Issue Date')}}</th>
                                                <th> {{__('Amount')}}</th>
                                                <th> {{__('Status')}}</th>
                                                @if(Gate::check('edit proposal') || Gate::check('delete proposal') || Gate::check('show proposal'))
                                                    <th class="text-right"> {{__('Action')}}</th>
                                                @endif
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach ($customer->customerProposal($customer->id) as $proposal)
                                                <tr class="font-style">
                                                    <td>
                                                        @if(\Auth::guard('customer')->check())
                                                            <a class="btn btn-outline-primary" href="{{ route('customer.proposal.show',$proposal->id) }}">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}
                                                            </a>
                                                        @else
                                                            <a class="btn btn-outline-primary" href="{{ route('proposal.show',$proposal->id) }}">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>{{ Auth::user()->dateFormat($proposal->issue_date) }}</td>
                                                    <td>{{ Auth::user()->priceFormat($proposal->getTotal()) }}</td>
                                                    <td>
                                                        @if($proposal->status == 0)
                                                            <span class="badge badge-primary">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                        @elseif($proposal->status == 1)
                                                            <span class="badge badge-warning">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                        @elseif($proposal->status == 2)
                                                            <span class="badge badge-danger">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                        @elseif($proposal->status == 3)
                                                            <span class="badge badge-info">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                        @elseif($proposal->status == 4)
                                                            <span class="badge badge-success">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                        @endif
                                                    </td>
                                                    @if(Gate::check('edit proposal') || Gate::check('delete proposal') || Gate::check('show proposal'))
                                                        <td class="action text-right">
                                                            @can('convert invoice')
                                                                <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Convert to Invoice')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="You want to confirm convert to invoice. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('proposal-form-{{$proposal->id}}').submit();">
                                                                    <i class="fas fa-exchange-alt"></i>
                                                                    {!! Form::open(['method' => 'get', 'route' => ['proposal.convert', $proposal->id],'id'=>'proposal-form-'.$proposal->id]) !!}
                                                                    {!! Form::close() !!}
                                                                </a>
                                                            @endcan
                                                            @can('duplicate proposal')
                                                                <a href="#" class="btn btn-success btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Duplicate')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="You want to confirm duplicate this invoice. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('duplicate-form-{{$proposal->id}}').submit();">
                                                                    <i class="fas fa-copy"></i>
                                                                    {!! Form::open(['method' => 'get', 'route' => ['proposal.duplicate', $proposal->id],'id'=>'duplicate-form-'.$proposal->id]) !!}
                                                                    {!! Form::close() !!}
                                                                </a>
                                                            @endcan
                                                            @can('show proposal')
                                                                @if(\Auth::guard('customer')->check())
                                                                    <a href="{{ route('customer.proposal.show',$proposal->id) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('proposal.show',$proposal->id) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            @endcan
                                                            @can('edit proposal')
                                                                <a href="{{ route('proposal.edit',$proposal->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                            @endcan

                                                            @can('delete proposal')
                                                                <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$proposal->id}}').submit();">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['proposal.destroy', $proposal->id],'id'=>'delete-form-'.$proposal->id]) !!}
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
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Invoice')}}</h4>
                    </div>
                    <div class="card-body">
                        <div id="table-1_wrapper2" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-flush" id="dataTable2">
                                            <thead class="thead-light">
                                            <tr>

                                                <th> {{__('Invoice')}}</th>
                                                <th> {{__('Issue Date')}}</th>
                                                <th> {{__('Due Date')}}</th>
                                                <th> {{__('Due Amount')}}</th>
                                                <th> {{__('Status')}}</th>
                                                @if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                                    <th class="text-right"> {{__('Action')}}</th>
                                                @endif
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach ($customer->customerInvoice($customer->id) as $invoice)
                                                <tr class="font-style">
                                                    <td>
                                                        @if(\Auth::guard('customer')->check())
                                                            <a class="btn btn-outline-primary" href="{{ route('customer.invoice.show',$invoice->id) }}">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}
                                                            </a>
                                                        @else
                                                            <a class="btn btn-outline-primary" href="{{ route('invoice.show',$invoice->id) }}">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td>{{ \Auth::user()->dateFormat($invoice->issue_date) }}</td>
                                                    <td>
                                                        @if(($invoice->due_date < date('Y-m-d')))
                                                            <p class="text-danger"> {{ \Auth::user()->dateFormat($invoice->due_date) }}</p>
                                                        @else
                                                            {{ \Auth::user()->dateFormat($invoice->due_date) }}
                                                        @endif
                                                    </td>
                                                    <td>{{\Auth::user()->priceFormat($invoice->getDue())  }}</td>
                                                    <td>
                                                        @if($invoice->status == 0)
                                                            <span class="badge badge-primary">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 1)
                                                            <span class="badge badge-warning">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 2)
                                                            <span class="badge badge-danger">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 3)
                                                            <span class="badge badge-info">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 4)
                                                            <span class="badge badge-success">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                                        @endif
                                                    </td>
                                                    @if(Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                                        <td class="action text-right">
                                                            @can('duplicate invoice')
                                                                <a href="#" class="btn btn-success btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Duplicate')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="You want to confirm this action. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('duplicate-form-{{$invoice->id}}').submit();">
                                                                    <i class="fas fa-copy"></i>
                                                                    {!! Form::open(['method' => 'get', 'route' => ['invoice.duplicate', $invoice->id],'id'=>'duplicate-form-'.$invoice->id]) !!}
                                                                    {!! Form::close() !!}
                                                                </a>
                                                            @endcan
                                                            @can('show invoice')
                                                                @if(\Auth::guard('customer')->check())
                                                                    <a href="{{ route('customer.invoice.show',$invoice->id) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('invoice.show',$invoice->id) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            @endcan
                                                            @can('edit invoice')
                                                                <a href="{{ route('invoice.edit',$invoice->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                            @endcan
                                                            @can('delete invoice')
                                                                <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$invoice->id}}').submit();">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['invoice.destroy', $invoice->id],'id'=>'delete-form-'.$invoice->id]) !!}
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
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
