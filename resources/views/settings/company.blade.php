@extends('layouts.admin')
@section('page-title')
    {{__('Settings')}}
@endsection
@push('css-page')
    <link href="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script-page')
    <script>
        $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function () {
            var template = $("select[name='invoice_template']").val();
            var color = $("input[name='invoice_color']:checked").val();
            $('#invoice_frame').attr('src', '{{url('/invoices/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='proposal_template'], input[name='proposal_color']", function () {
            var template = $("select[name='proposal_template']").val();
            var color = $("input[name='proposal_color']:checked").val();
            $('#proposal_frame').attr('src', '{{url('/proposal/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='bill_template'], input[name='bill_color']", function () {
            var template = $("select[name='bill_template']").val();
            var color = $("input[name='bill_color']:checked").val();
            $('#bill_frame').attr('src', '{{url('/bill/preview')}}/' + template + '/' + color);
        });
    </script>
    <script src="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endpush
@php
    $logo=asset(Storage::url('uploads/logo/'));
$lang=\App\Utility::getValByName('default_language');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Settings')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Settings')}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4>{{__('Settings')}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="setting-tab">
                            <ul class="nav nav-pills mb-3" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="contact-tab4" data-toggle="tab" href="#site-setting" role="tab" aria-controls="" aria-selected="false">{{__('Site Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#company-setting" role="tab" aria-controls="" aria-selected="false">{{__('Company Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#email-setting" role="tab" aria-controls="" aria-selected="false">{{__('Email Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#system-setting" role="tab" aria-controls="" aria-selected="false">{{__('System Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#proposal-template-setting" role="tab" aria-controls="" aria-selected="false">{{__('Proposal Print Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#template-setting" role="tab" aria-controls="" aria-selected="false">{{__('Invoice Print Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#bill-template-setting" role="tab" aria-controls="" aria-selected="false">{{__('Bill Print Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab6" data-toggle="tab" href="#payment-setting" role="tab" aria-controls="" aria-selected="false">{{__('Payment Setting')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade fade show active" id="site-setting" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="company-setting-wrap">
                                        {{Form::model($settings,array('url'=>'systems','method'=>'POST','enctype' => "multipart/form-data"))}}
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h5>{{__('Logo')}}</h5>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="height: 150px;">
                                                                <img src="{{$logo.'/logo.png'}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="logo" id="logo">
                                                            </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 text-primary"> {{__('These Logo will appear on Bill and Invoice as well.')}}</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>{{__('Small Logo')}}</h5>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="height: 150px;">
                                                                <img src="{{$logo.'/small_logo.png'}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="small_logo" id="small_logo">
                                                            </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>{{__('Favicon')}}</h5>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="height: 150px;">
                                                                <img src="{{$logo.'/favicon.png'}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="favicon" id="favicon">
                                                            </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @error('logo')
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                     </span>
                                                    @enderror
                                                </div>
                                                <div class="row mt-20">
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('title_text',__('Title Text')) }}
                                                        {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                                        @error('title_text')
                                                        <span class="invalid-title_text" role="alert">
                                                             <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('footer_text',__('Footer Text')) }}
                                                        {{Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                                        @error('footer_text')
                                                        <span class="invalid-footer_text" role="alert">
                                                                 <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('default_language',__('Default Language')) }}
                                                        <div class="changeLanguage">
                                                            <select name="default_language" id="default_language" class="form-control selectric">
                                                                @foreach(\App\Utility::languages() as $language)
                                                                    <option @if($lang == $language) selected @endif value="{{$language }}">{{Str::upper($language)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane fade fade show" id="system-setting" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="company-setting-wrap">
                                        {{Form::model($settings,array('route'=>'system.settings','method'=>'post'))}}
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    {{Form::label('site_currency',__('Currency *')) }}
                                                    {{Form::text('site_currency',null,array('class'=>'form-control font-style'))}}
                                                    <small> {{__('Note: Add currency code as per three-letter ISO code.')}}<br> <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small> <br>
                                                    @error('site_currency')
                                                    <span class="invalid-site_currency" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('site_currency_symbol',__('Currency Symbol *')) }}
                                                    {{Form::text('site_currency_symbol',null,array('class'=>'form-control'))}}
                                                    @error('site_currency_symbol')
                                                    <span class="invalid-site_currency_symbol" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="example3cols3Input">{{__('Currency Symbol Position')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-radio mb-3">

                                                                    <input type="radio" id="customRadio5" name="site_currency_symbol_position" value="pre" class="custom-control-input" @if(@$settings['site_currency_symbol_position'] == 'pre') checked @endif>
                                                                    <label class="custom-control-label" for="customRadio5">{{__('Pre')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-radio mb-3">
                                                                    <input type="radio" id="customRadio6" name="site_currency_symbol_position" value="post" class="custom-control-input" @if(@$settings['site_currency_symbol_position'] == 'post') checked @endif>
                                                                    <label class="custom-control-label" for="customRadio6">{{__('Post')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="site_date_format" class="form-control-label">{{__('Date Format')}}</label>
                                                    <select type="text" name="site_date_format" class="form-control selectric" id="site_date_format">
                                                        <option value="M j, Y" @if(@$settings['site_date_format'] == 'M j, Y') selected="selected" @endif>Jan 1,2015</option>
                                                        <option value="d-m-Y" @if(@$settings['site_date_format'] == 'd-m-Y') selected="selected" @endif>d-m-y</option>
                                                        <option value="m-d-Y" @if(@$settings['site_date_format'] == 'm-d-Y') selected="selected" @endif>m-d-y</option>
                                                        <option value="Y-m-d" @if(@$settings['site_date_format'] == 'Y-m-d') selected="selected" @endif>y-m-d</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="site_time_format" class="form-control-label">{{__('Time Format')}}</label>
                                                    <select type="text" name="site_time_format" class="form-control selectric" id="site_time_format">
                                                        <option value="g:i A" @if(@$settings['site_time_format'] == 'g:i A') selected="selected" @endif>10:30 PM</option>
                                                        <option value="g:i a" @if(@$settings['site_time_format'] == 'g:i a') selected="selected" @endif>10:30 pm</option>
                                                        <option value="H:i" @if(@$settings['site_time_format'] == 'H:i') selected="selected" @endif>22:30</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('invoice_prefix',__('Invoice Prefix')) }}
                                                    {{Form::text('invoice_prefix',null,array('class'=>'form-control'))}}
                                                    @error('invoice_prefix')
                                                    <span class="invalid-invoice_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('proposal_prefix',__('Proposal Prefix')) }}
                                                    {{Form::text('proposal_prefix',null,array('class'=>'form-control'))}}
                                                    @error('proposal_prefix')
                                                    <span class="invalid-proposal_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('bill_prefix',__('Bill Prefix')) }}
                                                    {{Form::text('bill_prefix',null,array('class'=>'form-control'))}}
                                                    @error('bill_prefix')
                                                    <span class="invalid-bill_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('customer_prefix',__('Customer Prefix')) }}
                                                    {{Form::text('customer_prefix',null,array('class'=>'form-control'))}}
                                                    @error('customer_prefix')
                                                    <span class="invalid-customer_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('vender_prefix',__('Vender Prefix')) }}
                                                    {{Form::text('vender_prefix',null,array('class'=>'form-control'))}}
                                                    @error('vender_prefix')
                                                    <span class="invalid-vender_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6">
                                                    {{Form::label('footer_title',__('Invoice/Bill Footer Title')) }}
                                                    {{Form::text('footer_title',null,array('class'=>'form-control'))}}
                                                    @error('footer_title')
                                                    <span class="invalid-footer_title" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6">
                                                    {{Form::label('decimal_number',__('Decimal Number Format')) }}
                                                    {{Form::number('decimal_number', null, ['class'=>'form-control'])}}
                                                    @error('decimal_number')
                                                    <span class="invalid-decimal_number" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('footer_notes',__('Invoice/Bill Footer Notes')) }}
                                                    {{Form::textarea('footer_notes', null, ['class'=>'form-control','rows'=>'1'])}}
                                                    @error('footer_notes')
                                                    <span class="invalid-footer_notes" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('shipping_display',__('Proposal / Invoice / Bill Shipping Display')) }}
                                                    <label class="custom-switch mt-2">
                                                        <input type="checkbox" name="shipping_display" class="custom-switch-input" {{($settings['shipping_display']=='on')?'checked':''}}>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                    @error('shipping_display')
                                                    <span class="invalid-shipping_display" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="company-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="email-setting-wrap">
                                        <div class="row">
                                            {{Form::model($settings,array('route'=>'company.settings','method'=>'post'))}}
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_name *',__('Company Name *')) }}
                                                        {{Form::text('company_name',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_name')
                                                        <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_address',__('Address')) }}
                                                        {{Form::text('company_address',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_address')
                                                        <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_city',__('City')) }}
                                                        {{Form::text('company_city',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_city')
                                                        <span class="invalid-company_city" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_state',__('State')) }}
                                                        {{Form::text('company_state',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_state')
                                                        <span class="invalid-company_state" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_zipcode',__('Zip/Post Code')) }}
                                                        {{Form::text('company_zipcode',null,array('class'=>'form-control'))}}
                                                        @error('company_zipcode')
                                                        <span class="invalid-company_zipcode" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group  col-md-6">
                                                        {{Form::label('company_country',__('Country')) }}
                                                        {{Form::text('company_country',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_country')
                                                        <span class="invalid-company_country" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_telephone',__('Telephone')) }}
                                                        {{Form::text('company_telephone',null,array('class'=>'form-control'))}}
                                                        @error('company_telephone')
                                                        <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_email',__('System Email *')) }}
                                                        {{Form::text('company_email',null,array('class'=>'form-control'))}}
                                                        @error('company_email')
                                                        <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_email_from_name',__('Email (From Name) *')) }}
                                                        {{Form::text('company_email_from_name',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_email_from_name')
                                                        <span class="invalid-company_email_from_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('registration_number',__('Company Registration Number *')) }}
                                                        {{Form::text('registration_number',null,array('class'=>'form-control'))}}
                                                        @error('registration_number')
                                                        <span class="invalid-registration_number" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="custom-control custom-radio mb-3">
                                                                        <input type="radio" id="customRadio8" name="tax_type" value="VAT" class="custom-control-input" {{($settings['tax_type'] == 'VAT')?'checked':''}} >
                                                                        <label class="custom-control-label" for="customRadio8">{{__('VAT Number')}}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="custom-control custom-radio mb-3">
                                                                        <input type="radio" id="customRadio7" name="tax_type" value="GST" class="custom-control-input" {{($settings['tax_type'] == 'GST')?'checked':''}}>
                                                                        <label class="custom-control-label" for="customRadio7">{{__('GST Number')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{Form::text('vat_number',null,array('class'=>'form-control','placeholder'=>__('Enter VAT / GST Number')))}}
                                                            @error('vat_number')
                                                            <span class="invalid-vat_number" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card-footer text-right">
                                                {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                            </div>
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="email-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="email-setting-wrap">
                                        {{Form::open(array('route'=>'email.settings','method'=>'post'))}}
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_driver',__('Mail Driver')) }}
                                                {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                                @error('mail_driver')
                                                <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_host',__('Mail Host')) }}
                                                {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Driver')))}}
                                                @error('mail_host')
                                                <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_port',__('Mail Port')) }}
                                                {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                                @error('mail_port')
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_username',__('Mail Username')) }}
                                                {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                                @error('mail_username')
                                                <span class="invalid-mail_username" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_password',__('Mail Password')) }}
                                                {{Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                                @error('mail_password')
                                                <span class="invalid-mail_password" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_encryption',__('Mail Encryption')) }}
                                                {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                                @error('mail_encryption')
                                                <span class="invalid-mail_encryption" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_from_address',__('Mail From Address')) }}
                                                {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                                @error('mail_from_address')
                                                <span class="invalid-mail_from_address" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_from_name',__('Mail From Name')) }}
                                                {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                                @error('mail_from_name')
                                                <span class="invalid-mail_from_name" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 text-right mt-20">
                                                {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <a href="#" data-url="{{route('test.mail' )}}" data-ajax-popup="true" data-title="{{__('Send Test Mail')}}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Send Test Mail')}}
                                            </a>
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="proposal-template-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="{{route('proposal.template.setting')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="address">{{__('Proposal Template')}}</label>
                                                        <select class="form-control" name="proposal_template">
                                                            @foreach(Utility::templateData()['templates'] as $key => $template)
                                                                <option value="{{$key}}" {{(isset($settings['proposal_template']) && $settings['proposal_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Color Input')}}</label>
                                                        <div class="row gutters-xs">
                                                            @foreach(Utility::templateData()['colors'] as $key => $color)
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="proposal_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['proposal_color']) && $settings['proposal_color'] == $color) ? 'checked' : ''}}>
                                                                        <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        {{__('Save')}}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                @if(isset($settings['proposal_template']) && isset($settings['proposal_color']))
                                                    <iframe id="proposal_frame" class="w-100 h-1320" frameborder="0" src="{{route('proposal.preview',[$settings['proposal_template'],$settings['proposal_color']])}}"></iframe>
                                                @else
                                                    <iframe id="proposal_frame" class="w-100 h-1320" frameborder="0" src="{{route('proposal.preview',['template1','fffff'])}}"></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="template-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="{{route('template.setting')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="address">{{__('Invoice Template')}}</label>
                                                        <select class="form-control" name="invoice_template">
                                                            @foreach(Utility::templateData()['templates'] as $key => $template)
                                                                <option value="{{$key}}" {{(isset($settings['invoice_template']) && $settings['invoice_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Color Input')}}</label>
                                                        <div class="row gutters-xs">
                                                            @foreach(Utility::templateData()['colors'] as $key => $color)
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="invoice_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['invoice_color']) && $settings['invoice_color'] == $color) ? 'checked' : ''}}>
                                                                        <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        {{__('Save')}}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                @if(isset($settings['invoice_template']) && isset($settings['invoice_color']))
                                                    <iframe id="invoice_frame" class="w-100 h-1450" frameborder="0" src="{{route('invoice.preview',[$settings['invoice_template'],$settings['invoice_color']])}}"></iframe>
                                                @else
                                                    <iframe id="invoice_frame" class="w-100 h-1450" frameborder="0" src="{{route('invoice.preview',['template1','fffff'])}}"></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bill-template-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="{{route('bill.template.setting')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="address">{{__('Bill Template')}}</label>
                                                        <select class="form-control" name="bill_template">
                                                            @foreach(Utility::templateData()['templates'] as $key => $template)
                                                                <option value="{{$key}}" {{(isset($settings['bill_template']) && $settings['bill_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Color Input')}}</label>
                                                        <div class="row gutters-xs">
                                                            @foreach(Utility::templateData()['colors'] as $key => $color)
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="bill_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['bill_color']) && $settings['bill_color'] == $color) ? 'checked' : ''}}>
                                                                        <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        {{__('Save')}}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                @if(isset($settings['bill_template']) && isset($settings['bill_color']))
                                                    <iframe id="bill_frame" class="w-100 h-1450" frameborder="0" src="{{route('bill.preview',[$settings['bill_template'],$settings['bill_color']])}}"></iframe>
                                                @else
                                                    <iframe id="bill_frame" class="w-100 h-1450" frameborder="0" src="{{route('bill.preview',['template1','fffff'])}}"></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="payment-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="payment-setting-wrap">
                                                    {{Form::model($settings,['route'=>'company.payment.settings', 'method'=>'POST'])}}
                                                    <div class="form-text">
                                                        <h6>{{__("This detail will use for collect payment on invoice from clients. On invoice client will find out pay now button based on your below configuration.")}}</h6>
                                                    </div>
                                                    <div class="card-header border-bottom-0 pb-0">
                                                        <h5>{{ __('Stripe') }}</h5>
                                                    </div>
                                                    <div class="row card-body pb-0">
                                                        <div class="form-group col-md-12">
                                                            {{Form::label('is_enable_stripe',__('Enable Stripe'), ['class' => 'custom-toggle-btn']) }}
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="enable_stripe" class="custom-switch-input" {{ isset($settings['enable_stripe']) && $settings['enable_stripe'] == 'on' ? 'checked="checked"' : '' }}>
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            {{Form::label('stripe_key',__('Stripe Key')) }}
                                                            {{Form::text('stripe_key',(isset($settings['stripe_key'])?$settings['stripe_key']:''),['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])}}
                                                            @error('stripe_key')
                                                            <span class="invalid-stripe_key" role="alert">
                                                                 <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            {{Form::label('stripe_secret',__('Stripe Secret')) }}
                                                            {{Form::text('stripe_secret',(isset($settings['stripe_secret'])?$settings['stripe_secret']:''),['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])}}
                                                            @error('stripe_secret')
                                                            <span class="invalid-stripe_secret" role="alert">
                                                                 <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-header border-bottom-0 pb-0">
                                                        <h5>{{ __('Paypal') }}</h5>
                                                    </div>
                                                    <div class="row card-body pb-0">
                                                        <div class="form-group col-md-12">
                                                            {{Form::label('enable_stripe',__('Enable Paypal'), ['class' => 'custom-toggle-btn']) }}

                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="enable_paypal" class="custom-switch-input" {{  isset($settings['enable_paypal']) && $settings['enable_paypal'] == 'on' ? 'checked="checked"' : '' }}>
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="paypal_mode">{{ __('Paypal Mode') }}</label>
                                                            <div class="selectgroup w-50">
                                                                <label class="selectgroup-item">
                                                                    <input type="radio" name="paypal_mode" value="sandbox" class="selectgroup-input" {{ isset($settings['paypal_mode']) &&  $settings['paypal_mode'] == '' || isset($settings['paypal_mode']) && $settings['paypal_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                    <span class="selectgroup-button">{{ __('Sandbox') }}</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="radio" name="paypal_mode" value="live" class="selectgroup-input" {{ isset($settings['paypal_mode']) &&  $settings['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                    <span class="selectgroup-button">{{ __('Live') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="paypal_client_id">{{ __('Client ID') }}</label>
                                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{isset($settings['paypal_client_id'])?$settings['paypal_client_id']:''}}" placeholder="{{ __('Client ID') }}"/>
                                                            @if ($errors->has('paypal_client_id'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('paypal_client_id') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="paypal_secret_key">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="{{isset($settings['paypal_secret_key'])?$settings['paypal_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                            @if ($errors->has('paypal_secret_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('paypal_secret_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        {{Form::submit(__('Save Changes'),['class'=>'btn btn-primary'])}}
                                                    </div>
                                                    {{Form::close()}}
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
