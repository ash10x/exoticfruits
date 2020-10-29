@php
    $users=\Auth::user();
    $profile=asset(Storage::url('uploads/avatar/'));
    $logo=asset(Storage::url('uploads/logo/'));
    $currantLang = $users->currentLanguage();
    $languages=Utility::languages();
@endphp
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto search-element" method="post">
        <div class="easy-autocomplete" style="width: 0px;"><input type="hidden" name="_token" value="ifSnVqGphjkOu1aqYvyflvadZqTOLssR8oVLlL9q" id="eac-5343" style="" autocomplete="off">
            <div class="easy-autocomplete-container" id="eac-container-eac-5343">
                <ul></ul>
            </div>
        </div>
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">
        @if( Gate::check('create product & service') ||  Gate::check('create customer') ||  Gate::check('create vender')||  Gate::check('create proposal')||  Gate::check('create invoice')||  Gate::check('create bill') ||  Gate::check('create goal') ||  Gate::check('create bank account'))
            <li class="dropdown dropdown-list-toggle">
                <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle">
                    <i class="far fa-bookmark"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right custom-dropdown-menu">
                    <div class="row shortcuts px-4">
                        @if(Gate::check('create product & service'))
                            <a href="#" class="col-6 shortcut-item text-center" data-url="{{ route('productservice.create') }}" data-ajax-popup="true" data-title="{{__('Create New Product')}}">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                                  <i class="fas fa-shopping-cart custom-icon"></i>
                                </span><br>
                                <small class="h-font">{{__('Create New Product')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create customer'))
                            <a href="#!" class="col-6 shortcut-item text-center" data-size="2xl" data-url="{{ route('customer.create') }}" data-ajax-popup="true" data-title="{{__('Create New Customer')}}">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="far fa-user custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Customer')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create vender'))
                            <a href="#!" class="col-6 shortcut-item text-center" data-size="2xl" data-url="{{ route('vender.create') }}" data-ajax-popup="true" data-title="{{__('Create New Vendor')}}">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-sticky-note custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Vendor')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create proposal'))
                            <a href="{{ route('proposal.create',0) }}" class="col-6 shortcut-item text-center">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-file custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Proposal')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create invoice'))
                            <a href="{{ route('invoice.create',0) }}" class="col-6 shortcut-item text-center">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="far fa-money-bill-alt custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Invoice')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create bill'))
                            <a href="{{ route('bill.create',0) }}" class="col-6 shortcut-item text-center">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-money-bill-wave-alt custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Bill')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create bank account'))
                            <a href="#" class="col-6 shortcut-item text-center" data-url="{{ route('bank-account.create') }}" data-ajax-popup="true" data-title="{{__('Create New Account')}}">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fas fa-university custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Account')}}</small>
                            </a>
                        @endif
                        @if(Gate::check('create goal'))
                            <a href="#" class="col-6 shortcut-item text-center" data-url="{{ route('goal.create') }}" data-ajax-popup="true" data-title="{{__('Create New Goal')}}">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="fa fa-bullseye custom-icon"></i>
                        </span><br>
                                <small class="h-font">{{__('Create New Goal')}}</small>
                            </a>
                        @endif
                    </div>
                </div>
            </li>
        @endif

        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg language-dd"><i class="fas fa-language"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{__('Choose Language')}}
                </div>
                @can('create language')
                    <a href="{{route('manage.language',[$currantLang])}}" class="dropdown-item btn manage-language-btn">
                        <span> {{ __('Create & Customize') }}</span>
                    </a>
                @endcan
                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach($languages as $language)
                        @if(\Auth::guard('customer')->check())
                            <a href="{{route('customer.change.language',$language)}}" class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                                <span> {{Str::upper($language)}}</span>
                            </a>
                        @elseif(\Auth::guard('vender')->check())
                            <a href="{{route('vender.change.language',$language)}}" class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                                <span> {{Str::upper($language)}}</span>
                            </a>
                        @else
                            <a href="{{route('change.language',$language)}}" class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                                <span> {{Str::upper($language)}}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{(!empty($users->avatar)? $profile.'/'.$users->avatar : $profile.'/avatar.png')}}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{__('Hi')}}, {{\Auth::user()->name}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{__('Welcome!')}}</div>
                @if(\Auth::guard('customer')->check())
                    <a href="{{route('customer.profile')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> {{__('My profile')}}
                    </a>
                @elseif(\Auth::guard('vender')->check())
                    <a href="{{route('vender.profile')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> {{__('My profile')}}
                    </a>
                @else
                    <a href="{{route('profile')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> {{__('My profile')}}
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>{{__('Logout')}}</span>
                </a>
                @if(\Auth::guard('customer')->check())
                    <form id="frm-logout" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @else
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @endif
            </div>
        </li>

    </ul>
</nav>

