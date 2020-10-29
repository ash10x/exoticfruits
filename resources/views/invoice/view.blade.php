@extends('layouts.admin')
@section('page-title')
    {{__('Invoice Detail')}}
@endsection

@push('script-page')
    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">
            @if($invoice->getDue() > 0 &&  Utility::getValByName('enable_stripe') == 'on' && !empty(Utility::getValByName('stripe_key')) && !empty(Utility::getValByName('stripe_secret')))
        var stripe = Stripe('{{ Utility::getValByName('stripe_key') }}');
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    toastrs('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        @endif


    </script>

    <script>
        $(document).on('click', '#shipping', function () {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function (data) {
                    // console.log(data);
                }
            });
        })
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Invoice')}}</h1>
            <div class="section-header-breadcrumb">
                @if(\Auth::guard('customer')->check())
                    <div class="breadcrumb-item active"><a href="{{route('customer.dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('customer.invoice')}}">{{__('Invoice')}}</a></div>
                @else
                    <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('invoice.index')}}">{{__('Invoice')}}</a></div>
                @endif
                <div class="breadcrumb-item">{{\Auth::user()->invoiceNumberFormat($invoice->invoice_id)}}</div>
            </div>
        </div>
        @can('send invoice')
            @if($invoice->status!=4)
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Create Invoice')}}</h6>
                                        </span>
                                        @can('edit invoice')
                                            <a href="{{ route('invoice.edit',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Edit')}}
                                            </a>
                                        @endcan
                                    </div>
                                    <p>{{__('Status')}} : <a href="#">{{__('Created on ')}} {{\Auth::user()->dateFormat($invoice->issue_date)}} </a></p>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Send Invoice')}}</h6></span>
                                        @if($invoice->status!=0)
                                            <p>{{__('Status')}} : <a href="#">{{__('Sent on')}} {{\Auth::user()->dateFormat($invoice->send_date)}}  </a></p>
                                        @else
                                            @can('send invoice')
                                                <a href="{{ route('invoice.sent',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                    {{__('Mark Sent')}}
                                                </a>
                                            @endcan
                                            <p>{{__('Status')}} : <a href="#">{{__('Not Sent')}} </a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="far fa-money-bill-alt"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Get Paid')}}</h6></span>
                                    </div>
                                    @if($invoice->status!=0)
                                        @can('create payment invoice')
                                            <a href="#!" data-url="{{ route('invoice.payment',$invoice->id) }}" data-ajax-popup="true" data-title="{{__('Add Receipt')}}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Add Receipt')}}
                                            </a>
                                        @endcan
                                    @endif
                                    <p>{{__('Status')}} : <a href="#">{{__('Awaiting payment')}} </a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    @if(\Auth::user()->type=='company')
                        @if($invoice->status!=0)
                            <div class="row mb-10">
                                <div class="col-lg-12">
                                    <div class="text-right">
                                        @if(!empty($invoicePayment))
                                            <a href="#" data-url="{{ route('invoice.credit.note',$invoice->id) }}" data-ajax-popup="true" data-title="{{__('Add Credit Note')}}" data-toggle="tooltip" data-original-title="{{__('Credit Note')}}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Add Credit Note')}}
                                            </a>
                                        @endif
                                        @if($invoice->status!=4)
                                            <a href="{{ route('invoice.payment.reminder',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Receipt Reminder')}}
                                            </a>
                                        @endif
                                        <a href="{{ route('invoice.resent',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Resend Invoice')}}
                                        </a>
                                        <a href="{{ route('invoice.pdf', Crypt::encrypt($invoice->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Download')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row mb-10">
                            <div class="col-lg-12">
                                <div class="text-right">
                                    <a href="#" data-url="{{route('customer.invoice.send',$invoice->id)}}" data-ajax-popup="true" data-title="{{__('Send Invoice')}}" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Send Mail')}}
                                    </a>
                                    <a href="{{ route('invoice.pdf', Crypt::encrypt($invoice->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Download')}}
                                    </a>
                                    @if($invoice->getDue() > 0 && ((Utility::getValByName('is_enable_stripe') == 'on' && !empty(Utility::getValByName('stripe_key')) && !empty(Utility::getValByName('stripe_secret'))) || (Utility::getValByName('enable_paypal')== 'on' && !empty(Utility::getValByName('paypal_client_id')) && !empty(Utility::getValByName('paypal_secret_key')))))
                                        <div class="text-sm-right">
                                            <a href="#" data-toggle="modal" data-target="#paymentModal" class="btn btn-primary mr-1" type="button">
                                                <i class="mdi mdi-credit-card mr-1"></i> {{__('Pay Now')}}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>{{__('Invoice')}}</h2>
                                <div class="invoice-number">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                @if(!empty($customer->billing_name))
                                    <div class="col-md-6">
                                        <address class="font-style">
                                            <strong>{{__('Billed To')}}:</strong><br>
                                            {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                                            {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                                            {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                                            {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                                            {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?$customer->billing_state:'',', '}} {{!empty($customer->billing_country)?$customer->billing_country:''}}
                                        </address>
                                    </div>
                                @endif
                                @if(\Utility::getValByName('shipping_display')=='on')

                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>{{__('Shipped To')}}:</strong><br>
                                            {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                                            {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                                            {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                                            {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                                            {{!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '}} {{!empty($customer->shipping_state)?$customer->shipping_state:'' .', '}},{{!empty($customer->shipping_country)?$customer->shipping_country:''}}
                                        </address>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <address>
                                        <strong>{{__('Status')}}:</strong><br>
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
                                    </address>
                                </div>
                                <div class="col-md-4 text-md-center">
                                    <address>
                                        <strong>{{__('Issue Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($invoice->issue_date)}}<br><br>
                                    </address>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <address>
                                        <strong>{{__('Due Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($invoice->due_date)}}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{__('Product Summary')}}</div>
                            <p class="section-lead">{{__('All items here cannot be deleted.')}}</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>{{__('Product')}}</th>
                                        <th>{{__('Quantity')}}</th>
                                        <th>{{__('Rate')}}</th>
                                        <th>{{__('Tax')}}</th>
                                        <th>
                                            @if($invoice->discount_apply==1)
                                                {{__('Discount')}}
                                            @endif
                                        </th>
                                        <th class="text-right" width="12%">{{__('Price')}}<br><small class="text-danger">{{__('before tax & discount')}}</small></th>
                                    </tr>
                                    @php
                                        $totalQuantity=0;
                                        $totalRate=0;
                                        $totalTaxPrice=0;
                                        $totalDiscount=0;
                                        $taxesData=[];
                                    @endphp
                                    @foreach($iteams as $key =>$iteam)
                                        @php
                                            $taxes=\Utility::tax($iteam->tax);
                                            $totalQuantity+=$iteam->quantity;
                                            $totalRate+=$iteam->price;
                                            $totalDiscount+=$iteam->discount;
                                            foreach($taxes as $taxe){
                                                $taxDataPrice=\Utility::taxRate($taxe->rate,$iteam->price,$iteam->quantity);
                                                if (array_key_exists($taxe->name,$taxesData))
                                                {
                                                    $taxesData[$taxe->name] = $taxesData[$taxe->name]+$taxDataPrice;
                                                }
                                                else
                                                {
                                                    $taxesData[$taxe->name] = $taxDataPrice;
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{!empty($iteam->product())?$iteam->product()->name:''}}</td>
                                            <td>{{$iteam->quantity}}</td>
                                            <td>{{\Auth::user()->priceFormat($iteam->price)}}</td>
                                            <td>
                                                <table>
                                                    @php $totalTaxRate = 0;@endphp
                                                    @foreach($taxes as $tax)
                                                        @php
                                                            $taxPrice=\Utility::taxRate($tax->rate,$iteam->price,$iteam->quantity);
                                                            $totalTaxPrice+=$taxPrice;
                                                        @endphp
                                                        <tr>
                                                            <td>{{$tax->name .' ('.$tax->rate .'%)'}}</td>
                                                            <td>{{\Auth::user()->priceFormat($taxPrice)}}</td>
                                                        </tr>
                                                    @endforeach

                                                </table>
                                            </td>
                                            <td> @if($invoice->discount_apply==1)
                                                    {{\Auth::user()->priceFormat($iteam->discount)}}
                                                @endif
                                            </td>
                                            <td class="text-right">{{\Auth::user()->priceFormat(($iteam->price*$iteam->quantity))}}</td>

                                        </tr>

                                    @endforeach
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td><b>{{__('Total')}}</b></td>
                                        <td><b>{{$totalQuantity}}</b></td>
                                        <td><b>{{\Auth::user()->priceFormat($totalRate)}}</b></td>
                                        <td><b>{{\Auth::user()->priceFormat($totalTaxPrice)}}</b></td>
                                        <td>  @if($invoice->discount_apply==1)
                                                <b>{{\Auth::user()->priceFormat($totalDiscount)}}</b>
                                            @endif
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-right"><b>{{__('Sub Total')}}</b></td>
                                        <td class="text-right">{{\Auth::user()->priceFormat($invoice->getSubTotal())}}</td>
                                    </tr>
                                    @if($invoice->discount_apply==1)
                                        <tr>
                                            <td colspan="5"></td>
                                            <td class="text-right"><b>{{__('Discount')}}</b></td>
                                            <td class="text-right">{{\Auth::user()->priceFormat($invoice->getTotalDiscount())}}</td>
                                        </tr>
                                    @endif
                                    @if(!empty($taxesData))
                                        @foreach($taxesData as $taxName => $taxPrice)
                                            <tr>
                                                <td colspan="5"></td>
                                                <td class="text-right"><b>{{$taxName}}</b></td>
                                                <td class="text-right">{{ \Auth::user()->priceFormat($taxPrice) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-right"><b>{{__('Total')}}</b></td>
                                        <td class="text-right">{{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-right"><b>{{__('Paid')}}</b></td>
                                        <td class="text-right">{{\Auth::user()->priceFormat(($invoice->getTotal()-$invoice->getDue())-($invoice->invoiceTotalCreditNote()))}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-right"><b>{{__('Credit Note')}}</b></td>
                                        <td class="text-right">{{\Auth::user()->priceFormat(($invoice->invoiceTotalCreditNote()))}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-right"><b>{{__('Due')}}</b></td>
                                        <td class="text-right">{{\Auth::user()->priceFormat($invoice->getDue())}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{__('Receipt Summary')}}</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Amount')}}</th>
                                        <th>{{__('Payment Type')}}</th>
                                        <th>{{__('Account')}}</th>
                                        <th>{{__('Reference')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th>{{__('Receipt')}}</th>
                                        <th>{{__('OrderId')}}</th>
                                        @can('delete payment invoice')
                                            <th class="text-right">{{__('Action')}}</th>
                                        @endcan
                                    </tr>
                                    @foreach($invoice->payments as $key =>$payment)

                                        <tr>
                                            <td>{{\Auth::user()->dateFormat($payment->date)}}</td>
                                            <td>{{\Auth::user()->priceFormat($payment->amount)}}</td>
                                            <td>{{$payment->payment_type}}</td>
                                            <td>{{!empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:'--'}}</td>
                                            <td>{{!empty($payment->reference)?$payment->reference:'--'}}</td>
                                            <td>{{!empty($payment->description)?$payment->description:'--'}}</td>
                                            <td>@if(!empty($payment->receipt))<a href="{{$payment->receipt}}" target="_blank"> <i class="fas fa-file"></i></a>@else -- @endif</td>
                                            <td>{{!empty($payment->order_id)?$payment->order_id:'--'}}</td>
                                            @can('delete invoice product')
                                                <td class="text-right">

                                                    <a href="#!" class="btn btn-danger btn-action" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$payment->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'post', 'route' => ['invoice.payment.destroy',$invoice->id,$payment->id],'id'=>'delete-form-'.$payment->id]) !!}
                                                    {!! Form::close() !!}

                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{__('Credit Note Summary')}}</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>{{__('Date')}}</th>
                                        <th class="text-center">{{__('Amount')}}</th>
                                        <th class="text-center">{{__('Description')}}</th>
                                        @if(Gate::check('edit credit note') || Gate::check('delete credit note'))
                                            <th class="text-right">{{__('Action')}}</th>
                                        @endif
                                    </tr>
                                    @foreach($invoice->creditNote as $key =>$creditNote)
                                        <tr>
                                            <td>{{\Auth::user()->dateFormat($creditNote->date)}}</td>
                                            <td class="text-center">{{\Auth::user()->priceFormat($creditNote->amount)}}</td>
                                            <td class="text-center">{{$creditNote->description}}</td>
                                            <td class="text-right">
                                                @can('edit credit note')
                                                    <a data-url="{{ route('invoice.edit.credit.note',[$creditNote->invoice,$creditNote->id]) }}" data-ajax-popup="true" data-title="{{__('Add Credit Note')}}" data-toggle="tooltip" data-original-title="{{__('Credit Note')}}" href="#" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('delete credit note')
                                                    <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$creditNote->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => array('invoice.delete.credit.note', $creditNote->invoice,$creditNote->id),'id'=>'delete-form-'.$creditNote->id]) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @auth('customer')
        @if($invoice->getDue() > 0)
            <!-- Modal -->
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">{{ __('Add Payment') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            @if(Utility::getValByName('enable_stripe') == 'on' && Utility::getValByName('enable_paypal') == 'on')
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#stripe-payment" role="tab" aria-controls="stripe" aria-selected="true">{{ __('Stripe') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#paypal-payment" role="tab" aria-controls="paypal" aria-selected="false">{{ __('Paypal') }}</a>
                                    </li>
                                </ul>
                            @endif
                            <div class="tab-content">
                                @if(Utility::getValByName('enable_stripe') == 'on')
                                    <div class="tab-pane fade {{ ((Utility::getValByName('enable_stripe') == 'on' && Utility::getValByName('enable_paypal') == 'on') || Utility::getValByName('enable_stripe') == 'on') ? "show active" : "" }}" id="stripe-payment" role="tabpanel" aria-labelledby="stripe-payment">
                                        <form method="post" action="{{ route('customer.invoice.payment',$invoice->id) }}" class="require-validation" id="payment-form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="custom-radio">
                                                        <label class="font-16 font-weight-bold">{{__('Credit / Debit Card')}}</label>
                                                    </div>
                                                    <p class="mb-0 pt-1">{{__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')}}</p>
                                                </div>
                                                <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                                    <img src="{{asset('assets/img/payments/master.png')}}" height="24" alt="master-card-img">
                                                    <img src="{{asset('assets/img/payments/discover.png')}}" height="24" alt="discover-card-img">
                                                    <img src="{{asset('assets/img/payments/visa.png')}}" height="24" alt="visa-card-img">
                                                    <img src="{{asset('assets/img/payments/american express.png')}}" height="24" alt="american-express-card-img">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="card-name-on">{{__('Name on card')}}</label>
                                                        <input type="text" name="name" id="card-name-on" class="form-control required" placeholder="{{\Auth::user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div id="card-element">

                                                    </div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <br>
                                                    <label for="amount">{{ __('Amount') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend"><span class="input-group-text">{{ Utility::getValByName('site_currency') }}</span></span>
                                                        <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <button class="btn btn-primary" type="submit">{{ __('Make Payment') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                @if(Utility::getValByName('enable_paypal') == 'on')
                                    <div class="tab-pane fade {{ (Utility::getValByName('enable_stripe') != 'on' && Utility::getValByName('enable_paypal') == 'on') ? "show active" : "" }}" id="paypal-payment" role="tabpanel" aria-labelledby="paypal-payment">
                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form" action="{{ route('customer.pay.with.paypal',$invoice->id) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount">{{ __('Amount') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend"><span class="input-group-text">{{ Utility::getValByName('site_currency') }}</span></span>
                                                        <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">
                                                        @error('amount')
                                                        <span class="invalid-amount" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <button class="btn btn-primary" name="submit" type="submit">{{ __('Make Payment') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endsection
