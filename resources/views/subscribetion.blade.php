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
         <h1>Stripe Subscription</h1>
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
                        action="/subscribe/{{ $id }}"
                        method="post"
                        class="require-validation"
                        data-cc-on-file="false"
                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                        id="payment-form">
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
                              <label class='control-label'>Copupon Id</label> <input
                                 class='form-control card-expiry-year card_expiry_year' placeholder='YYYY' size='4'
                                 type='text' id="coupon_id">
                           </div>

                        </div>
                        <div class='form-row row'>
                           <div class='col-md-12 error form-group hide'>
                              <div class='alert-danger alert'>Please correct the errors and try
                                 again.
                              </div>
                           </div>
                        </div>
                        <div class="price">
                            <p>Select Plane</p>
                            <select name="price_id" class="form-control">
                                @foreach ($prices as $price)
                                    <option value="{{ $price->id }}">{{ $price->nickname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Go</button>
                           </div>
                        </div>
                    </form>
               </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v2/"></script>
    <script>
        let couponId = "";
        document.getElementById('coupon_id').addEventListener('input', (event) => {
            couponId = event.target.value;
            console.log(couponId);
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
