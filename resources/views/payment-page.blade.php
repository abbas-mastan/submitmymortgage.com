<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Documents</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" /> --}}

    <!-- ----------------------------- -->
    <!-- -------------------------------------------------- -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
        media="screen">


    <!-- fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- custom css -->



    <style>
        body {
            background-color: red;
        }

        .error {
            color: #991b1b;
        }

        .loader {
            float: right;
            width: 45px;
        }

        .container {
            align-items: center;
            /* Center vertically */
            justify-content: center;
            /* Center horizontally */
            min-height: 100vh;
            /* Full height of viewport */
        }
    </style>
</head>

<body>
    <!-- get mortgage approval faster! -->
    <div class="container align-content-center" style="height: 100%">
        <div class="row multi-form bg-white shadow-lg mt-5 p-5">
            <h3 class="text-center">Your membership is expired!</h3>
            @if ($msg_error)
            <span class="text-danger mb-3">
                {{$msg_error}} 
            </span>
            @endif
            <form id="payment-form" class="main-form col-12" action="{{ url('continue-stripe-payment') }}" method="post">
                @csrf
                @if (session()->has('stripe_error'))
                    <div class="text-danger text-center my-3 fs-2">{{ session('stripe_error') }}</div>
                @endif

                <div class="form-inp-div stripe-div mb-3 border">
                    <div class="ps-2 " id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display Element errors. -->
                    <div class="ps-2 text-danger" id="card-errors" role="alert"></div>
                </div>
                <div class="form-last-btn-2">
                    <button class="start-trial-button btn btn-danger" type="submit">Start My Free Trial
                        <img class="loader d-none" src="{{ asset('assets/trial/loader.svg') }}" alt="asdf">
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {

            var paymentForm = $('#payment-form');
            $('#payment-form input,#payment-form select,#payment-form').on('keyup change submit', function(e) {
                e.preventDefault();
                triggerAjax();
            });
            var stripe = Stripe(
                'pk_test_51P6SBB09tId2vnnuXxFipyFJCk9XyEXZCBEUVfdRAbL09wiReraeAoKNNk3SfOq8rvlxMoNJwCIw1diOzwWmapRU00hyZJU7QX'
            );
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            const style = {
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
</body>

</html>
