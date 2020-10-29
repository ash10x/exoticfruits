@if(!empty($customer))
    <div class="row">
        <div class="col-md-5">
            <h6>{{__('Bill to')}}</h6>
            <div class="bill-to">
                <address>
                    <span>{{$customer['billing_name']}}</span><br>
                    <span>{{$customer['billing_phone']}}</span><br>
                    <span>{{$customer['billing_address']}}</span><br>
                    <span>{{$customer['billing_zip']}}</span><br>
                    <span>{{$customer['billing_country'] . ' , '.$customer['billing_city'].' , '.$customer['billing_state'].'.'}}</span>
                </address>
            </div>
        </div>
        <div class="col-md-5">
            <h6>{{__('Ship to')}}</h6>
            <div class="bill-to">
                <address>
                    <span>{{$customer['shipping_name']}}</span><br>
                    <span>{{$customer['shipping_phone']}}</span><br>
                    <span>{{$customer['shipping_address']}}</span><br>
                    <span>{{$customer['shipping_zip']}}</span><br>
                    <span>{{$customer['shipping_country'] . ' , '.$customer['shipping_state'].' , '.$customer['shipping_city'].'.'}}</span>
                </address>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove">{{__(' Remove')}}</a>
        </div>
    </div>
@endif
