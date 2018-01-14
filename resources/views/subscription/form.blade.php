@extends('default')

@section('content')

    <div class="col-sm-8 col-sm-offset-2">


        {!! Form::open(['method'=>'POST','action'=>'SubscriptionController@store', 'files'=>true])!!}
        <span class="payment-errors"></span>
        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="group-form">
                    {!! Form::label('stripe_plan','Subscription plan:') !!}
                    {!! Form::select('stripe_plan', [""=>"Choose type",
                    "small"=>"Small",
                    "large"=>"Large"
                    ],null, ['class'=>'form-control','id'=>'chooseType']) !!}
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="col-sm-6">
            <div class="form-row">
                <label>
                    <span>Card Number</span>
                    <input type="text" size="20" data-stripe="number">
                </label>
            </div>
            </div>

            <div class="form-row">
                <div class="col-sm-12">
                    <div class="col-sm-3">
                        <label>
                            <span>Expiration (MM/YY)</span>
                            <input type="text" size="2" data-stripe="exp_month">
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <span> / </span>
                        <input type="text" size="2" data-stripe="exp_year">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-row">
                    <label>
                        <span>CVC</span>
                        <input type="text" size="4" data-stripe="cvc">
                    </label>
                </div>
            </div>

            <div class="col-sm-12">
                <input type="submit" class="submit" value="Submit Payment">
            </div>
            {!! Form::close() !!}
        </div>
        @endsection

        @section('scripts')


            <script src="//code.jquery.com/jquery-1.9.1.js"></script>
            <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
            <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
            <script type="text/javascript">
                Stripe.setPublishableKey('pk_test_TSGgkchoa9iQU4ZQ628a8Auz');
            </script>
            <script>
                $(function () {
                    var $form = $('#payment-form');
                    $form.submit(function (event) {
                        // Disable the submit button to prevent repeated clicks:
                        $form.find('.submit').prop('disabled', true);

                        // Request a token from Stripe:
                        Stripe.card.createToken($form, stripeResponseHandler);

                        // Prevent the form from being submitted:
                        return false;
                    });
                });

                function stripeResponseHandler(status, response) {
                    // Grab the form:
                    var $form = $('#payment-form');

                    if (response.error) { // Problem!

                        // Show the errors on the form:
                        $form.find('.payment-errors').text(response.error.message);
                        $form.find('.submit').prop('disabled', false); // Re-enable submission

                    } else { // Token was created!

                        // Get the token ID:
                        var token = response.id;

                        // Insert the token ID into the form so it gets submitted to the server:
                        $form.append($('<input type="hidden" name="stripeToken">').val(token));

                        // Submit the form:
                        $form.get(0).submit();
                    }
                };
            </script>

@endsection