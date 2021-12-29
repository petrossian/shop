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
         <h1>Stripe Subscription Page - HackTheStuff</h1>
         <div class="row">
            <div class="col-md-6 col-md-offset-3">
               <div class="panel panel-default credit-card-box">
                  <div class="panel-heading display-block" >
                     <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Select Plan</h3>
                     </div>
                  </div>
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                    <form
                        action="/subscribe/{{ $id }}"
                        method="post"
                    >
                        @csrf
                        <br>
                        <div class="container">
                            <div class="col-xs-12">
                                @if ($prices != [])
                                    <select class="custom-select" name="price_id">
                                        @foreach ($prices as $price)
                                            <option value="{{$price->id}}">{{$price->nickname}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <h4>closed for this event</h4>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">
                                    <i class="fa fa-rocket" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v2/"></script>

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
