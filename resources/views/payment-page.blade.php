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
        <form id="payment-form" class="w-2/3 bg-white p-10" action="{{ url('continue-to-premium') }}" method="post">
            <div class="">
                <h3 class="text-center text-2xl">Your membership is expired!</h3>
            </div>
            @include('parts.alerts')
            @csrf
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label class="text-black text-md xl:text-xl opacity-70">Enter Card Number</label>
                </div>
                <div class="border rounded-lg py-2">
                    <div class="ps-2  " id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display Element errors. -->
                    <div class="ps-2 text-danger" id="card-errors" role="alert"></div>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit"
                        class="bg-gradient-to-b text-white text-md xl:text-xl  border-2 border-white rounded-md bg-white px-10 xl:px-12 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        Proceed
                    </button>
                </div>
            </div>
        </form>
        <!--Verically centered modal-->
    </div>
@endsection
@section('foot')
    <script src="https://cdn.tailwindcss.com/3.2.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@1.0.0-beta2/dist/js/tw-elements.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd h-screen');
        });
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
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
                            color: '#c7bbbb',
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
                
                return true; //
            }
        }
    </script>
@endsection
