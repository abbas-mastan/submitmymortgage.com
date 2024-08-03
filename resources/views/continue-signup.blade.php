@extends('layouts.empty')
@section('head')
    <style>
        input[type="password"]::-webkit-input-placeholder {
            font-size: 70%;
        }
    </style>
@endsection
@section('content')
    <div class="mx-auto w-full flex justify-center">
        <form id="payment-form" class="border border-2 border-[#5d85ea] w-1/2 bg-white p-10"
            action="{{ url('continue-to-premium') }}" method="post">
            {{-- <div class="">
                <h3 class="text-center text-2xl">Your membership is expired!</h3>
            </div> --}}
            @include('parts.alerts')
            @csrf
            <div>
                <input id="discount_code" name="have_discount_code" class="h-25 me-2" style="width:20px" type="checkbox">
                <label for="discount_code">I have discount code</label>
            </div>
            <div class="hidden mt-3 discount justify-between items-center">
                <div class="border-b-0">
                    <label for="discount-code-input">
                        <span class="block">
                            Discount Code
                        </span>
                        <input id="discount-code-input" placeholder="" class="rounded inline mb-3" name="discount_code"
                            type="text" value="{{ old('discount_code') }}">
                        <button class="apply-discount rounded px-5 py-1 bg-[#5d85ea] text-white h-10">Apply</button>
                    </label><br>
                    <span class="text-red-700 pb-2 discount_code_error"></span>
                </div>
                <div class="me-3">
                    <div>Discount: <span class="discount_value"></span></div>
                    <div>Total: <span class="total">{{ auth()->user()->subscriptionDetails->plan_amount }}</span></div>
                </div>
            </div>
            <div class="mt-3 mx-auto ">
                <div class=" text-left mr-12">
                    <label class="text-black text-md xl:text-xl opacity-70">Enter Card Number</label>
                </div>
                <div class="border border-black border-1 rounded-lg py-2 bg-gray-300">
                    <div class="ps-2" id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display Element errors. -->
                    <div class="ps-2 text-red-700" id="card-errors" role="alert"></div>
                </div>
            </div>
            <p class="my-5">Why? We ask for a payment method so that your subscription and business can continue without
                interruption after your trial ends.</p>
            <div class="mt-5 flex justify-center">
                <button type="submit"
                    class="w-full bg-[#5d85ea] text-white text-md xl:text-xl border-2 rounded-lg  px-10 xl:px-12 py-2 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400">
                    Proceed
                </button>
            </div>
        </form>
        <!--Verically centered modal-->
    </div>
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd h-screen');
        });
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var price = "{{ auth()->user()->subscriptionDetails->plan_amount }}";
        $('.apply-discount').click(function(e) {
            e.preventDefault();
            var code = $('input[name=discount_code]').val();
            if (code < 1) {
                $('.discount_code_error').text('This field is required');
                return;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.discount_code_error').text('');
            $.ajax({
                type: 'GET',
                url: '/get-discount/' + code,
                success: function(response) {
                    if (response !== 'code-not-found') {
                        $('.discount_value').text(' ' + (response.discount_type ===
                            'fixed_amount' ?
                            '$' : '') + response.discount + (response
                            .discount_type !==
                            'fixed_amount' ? '%' : ''));
                        if (price && response.discount_type === 'fixed_amount') {
                            $('.total').text(' $' + (price - response.discount));
                        }
                        if (price && response.discount_type === 'percent') {
                            $('.total').text(' $' + (price - (price * response.discount /
                                100)));
                        }
                    } else {
                        $('.discount_value').text('');
                        $('.discount_code_error').text('Discount code not found.');
                    }
                },
                error: function(jqXHR, excption) {
                    console.log(excption);
                }
            });
        });
        $('#discount_code').change(function() {
            if ($(this).is(':checked')) {
                // Show the additional input field
                $('.discount').removeClass('hidden');
                $('.discount').addClass('flex');
            } else {
                // Hide the additional input field
                $('.discount').removeClass('flex');
                $('.discount').addClass('hidden');
            }
        });

        if('{{old("have_discount_code")}}'){
            $('#discount_code').prop('checked', true).change();
        }

        if (window.Stripe) {
            var stripe = Stripe("{{ env('STRIPE_PK') }}");
            var elements = stripe.elements();
            var card = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        fontWeight: '500',
                        fontSize: '17px',
                        fontFamily: 'Lexend, sans-serif',
                        '::placeholder': {
                            color: 'gray',
                        },
                    }
                }
            });
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors')
                displayError.textContent = event.error ? event.error.message : '';
            });
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', function(ev) {
                ev.preventDefault();
                $('.loader').removeClass('d-none');
                stripe.createToken(card).then(function(result) {
                    $('.loader').addClass('d-none');
                    validateFields();
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        if (validateFields()) {
                            // console.log(result.token);
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.card.id}" name="card">`
                            );
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.id}" name="stripeToken">`
                            );
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.card.last4}" name="card_no">`
                            );
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.card.brand}" name="brand">`
                            );
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.card.exp_month}" name="month">`
                            );
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.card.exp_year}" name="year">`
                            );
                            $('#payment-form').append(
                                `<input type="hidden" value="${result.token.card.name}" name="name">`
                            );
                            form.submit();
                        }
                    }
                });
            });

            function validateFields() {
                var isValid = true;
                if ($('#discount_code').is(':checked') && $('#discount-code-input').val() === '') {
                    $('.discount_code_error').text('This field is required');
                    isValid = false;
                }
                if ($('#discount_code').is(':checked') && $('.discount_code_error').text().length > 0) {
                    isValid = false;
                };
                return isValid; //
            }
        }
    </script>
@endsection
