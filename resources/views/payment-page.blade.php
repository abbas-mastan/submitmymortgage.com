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
                <div class="border rounded-lg">
                    <div class="ps-2 " id="card-element">
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
        $(document).ready(function() {

            var stripe = Stripe("{{env(STRIPE_PK)}}");
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            const style = {
                hidePostalCode: true,
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '16px',
                    color: '#32325d',
                    lineHeight: '50px',
                    padding: '60px',
                },
            };

            // Create an instance of the card Element.
            const card = elements.create('card', {
                style
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
            // Create a token or display an error when the form is submitted.
            // Create a token or display an error when the form is submitted.
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const {
                    token,
                    error
                } = await stripe.createToken(card);

                if (error) {
                    // Inform the customer that there was an error.
                    const errorElement = document.getElementById(
                        'card-errors');
                    errorElement.textContent = error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(token);
                }
            });

            const stripeTokenHandler = (token) => {
                // Insert the token ID into the form so it gets submitted to the server
                const form = document.getElementById('payment-form');
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    </script>
@endsection
