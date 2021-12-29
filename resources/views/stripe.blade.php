@extends('layouts.app')
@section('content')
      <style type="text/css">
         .panel-title {
         display: inline;
         font-weight: bold;
         }
         .display-table {
         display: table;
         }
         .display-tr {
         display: table-row;
         }
         .display-td {
         display: table-cell;
         vertical-align: middle;
         width: 61%;
         }
      </style>
   </head>
   <body>
      <div class="container">
         <h1>Stripe Payment Page - HackTheStuff</h1>
         <div class="row">
            <div class="col-md-6 col-md-offset-3">
               <div class="panel panel-default credit-card-box">
                  <div class="panel-heading display-table" >
                     <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >
                            <button id="default_data">Add Default Test Data</button>
                        </div>
                     </div>
                  </div>
                  <div class="panel-body">
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                     <form
                        role="form"
                        action="/checkout/{{ $id }}"
                        method="post"
                        class="require-validation"
                        data-cc-on-file="false"
                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                        id="payment-form">
                     <!-- <form action="/add-to-chart/{{ $id }}" method="post"> -->
                        @csrf
                        <div class='form-row row'>
                           <div class='col-xs-12 form-group required'>
                              <label class='control-label'>Name on Card</label> <input
                                 class='form-control card_name' size='4' type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 form-group card required'>
                              <label class='control-label'>Card Number</label> <input
                                autocomplete='off' class='form-control card-number card_number' size='20'
                                type='text' name="card_number">
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'>CVC</label> <input autocomplete='off'
                                 class='form-control card-cvc card_cvc' placeholder='ex. 311' size='4'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Month</label> <input
                                 class='form-control card-expiry-month card_expiry_month' placeholder='MM' size='2'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Year</label> <input
                                 class='form-control card-expiry-year card_expiry_year' placeholder='YYYY' size='4'
                                 type='text'>
                           </div>

                        </div>
                        <div class='form-row row'>
                           <div class='col-md-12 error form-group hide'>
                              <div class='alert-danger alert'>Please correct the errors and try
                                 again.
                              </div>
                           </div>
                        </div>
                        <div class="percent_container"></div>
                        <div class="row">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now $<span id="price">{{ $price }}</span></button>
                           </div>
                        </div>
                     </form>
                    <hr>

                    <a href="/subscribetion/{{$id}}">
                        <i class="fa fa-rocket" aria-hidden="true"></i>
                        Create Subscribetion
                    </a>
                  </div>
               </div>
            </div>
        </div>
        <div class="row" style="position: absolute; top:200px;right:0px; text-align:center;">
            <h2>Use Coupon</h2>
            <ul>
                @foreach ($coupons as $k => $coupon)
                    <li class="precent_li">
                        <span>Percent Off {{ $coupon->percent_off }}%</span>
                        <span>Duration {{ $coupon->duration }}</span>
                        <input type="checkbox" value="{{$coupon->percent_off}}" name="percent_off" class="percent_off">
                    </li>
                @endforeach
            </ul>
            <div id="coupons"><!-- Append child for this div --></div>
        </div>
    </div>
    <script src="https://js.stripe.com/v2/"></script>
    <script>
            let selected = [];
            let percent = 0;
            let price = parseInt($('#price').text());
            localStorage.removeItem('ex_price');
            localStorage.setItem('ex_price', parseInt(price));

            $('.percent_off:not(:checked)').change(function(e){

                selected.push(e.target.value);


                if(selected.length === 1){
                    percent = parseInt(e.target.value);

                    price = price-price*percent/100;
                    $('#price').text(price);
                    $('#payment-form .percent_container').append('<input type="checkbox" value="'+percent+'" name="percent_off" class="percent_off" checked hidden>');
                }else if(selected.length > 1){
                    price = localStorage.getItem('ex_price');
                    percent = parseInt(e.target.value)-percent;
                    selected.forEach(val => {
                        percent+=parseInt(val);
                    });
                    price = price-price*percent/100;
                    $('#price').text(price);
                    $('#price').text(price);
                    $('#payment-form .percent_container').html("");
                    $('#payment-form .percent_container').append('<input type="checkbox" value="'+percent+'" name="percent_off" class="percent_off" checked hidden>');
                    localStorage.removeItem('ex_price');
                }else{
                    alert("===0");
                }
        });
    </script>
    <script type="text/javascript">
      $(function() {
         var $form = $(".require-validation");
         $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                  inputSelector = ['input[type=email]', 'input[type=password]',
                     'input[type=text]', 'input[type=file]',
                     'textarea'
                  ].join(', '),
                  $inputs = $form.find('.required').find(inputSelector),
                  $errorMessage = $form.find('div.error'),
                  valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                  var $input = $(el);
                  if ($input.val() === '') {
                     $input.parent().addClass('has-error');
                     $errorMessage.removeClass('hide');
                     e.preventDefault();
                  }
            });
            if (!$form.data('cc-on-file')) {
                  e.preventDefault();
                  Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                  Stripe.createToken({
                     number: $('.card-number').val(),
                     cvc: $('.card-cvc').val(),
                     exp_month: $('.card-expiry-month').val(),
                     exp_year: $('.card-expiry-year').val(),
                  }, stripeResponseHandler);
            }
         });
         function stripeResponseHandler(status, response) {
            if (response.error) {
               $('.error')
                  .removeClass('hide')
                  .find('.alert')
                  .text(response.error.message);
            } else {
               /* token contains id, last4, and card type */
               var token = response['id'];
               $form.find('input[type=text]').empty();
               $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
               $form.get(0).submit();
            }
         }
      });
   </script>
@endSection
