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
    <link rel="stylesheet" href="{{ asset('assets/trial/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/trial/phone.css') }}" />
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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">



    <style>
        .hero-section {
            background: url("{{ asset('assets/trialhero.jpg') }}") no-repeat;
            background-size: cover;
        }

        .error {
            color: #e03545;
        }

        .loader {
            float: right;
            width: 45px;
        }

        .team-size-button,
        .team-size-button:hover {
            background-color: #991b1b;
            padding: 12px 0;
            padding-top: 8px;
            width: 60%;
            display: block;
            justify-content: center;
            font-size: 20px;
            text-align: center;
            color: white;
            text-decoration: none;
        }

        .subs-plan,
        .subs-plan:hover {
            border-bottom: 2px solid #991b1b;
            text-decoration: none;
            color: black;
            cursor: pointer;
        }

        .monthly span:nth-child(3),
        .yearly span:nth-child(3) {
            color: #991b1b;
            font-size: 20px;
        }

        .monthly span:nth-child(2),
        .yearly span:nth-child(2) {
            font-size: 20px;
        }

        .monthly span:nth-child(3) span,
        .yearly span:nth-child(3) span {
            font-size: 16px;
        }

        .monthly label,
        .yearly label {
            border-bottom: 1px solid black;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
        }

        .modal-content {
            width: 660px !important;
            height: 450px !important;
        }

        .red {
            color: #991b1b;
        }
    </style>
</head>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid" alt="">
                </a>
                <!-- the button and ul menu are currently displayed none -->
                <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-5 d-none">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item d-block d-lg-none mt-4">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">LOGIN</a>
                            <a href="#" class="btn btn-secondary ms-2" type="button">REGISTER</a>
                        </li>
                    </ul>
                </div>
                <div class="ms-lg-5">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary ms-2" type="button">REGISTER</a>
                </div>
            </div>
        </nav>
    </header>
    <main>

        <!-- hero section -->
        <section class="hero-section">
            <div class="container">
                <div class="row hero-row">
                    <div class="col-12">
                        <p class="hero-title text-white mb-4 fw-normal lh-sm">Submit My Mortgage helps you compete
                            with<br> big banks
                            without having a big bank team.</p>
                    </div>
                    <!-- <div class="col"></div> -->
                </div>
            </div>
        </section>
        <!-- our key features -->
        <section class="container-fluid" style="background-color: #991b1b">
            <div class="container py-5 ">
                <div class="row text-center text-white gap-5 gap-md-0">
                    <div class="col-md-4">
                        <h4>
                            Increase in deal<br> closes:
                        </h4>
                        <h1>Up to 75%</h1>
                    </div>
                    <div class="col-md-4">
                        <h4>
                            Acceleration in loan <br>approval speed:
                        </h4>
                        <h1>Up to 50%</h1>
                    </div>
                    <div class="col-md-4">
                        <h4>
                            Enhance productivity <br>and efficiency:
                        </h4>
                        <h1>Guaranteed</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- get mortgage approval faster! -->
        <section class="containter-fluid trial-form" style="padding: 250px 0px">
            <div class="container align-content-center" style="height: 100%">
                <div class="multi-form bg-white shadow-sm">
                    <form id="payment-form" class="main-form require-validation" action="{{ route('stripePayment') }}"
                        method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered px-5 py-2">
                                <div class="modal-content rounded-0">
                                    <div class="border-0 text-center p-3 pb-0">
                                        <button type="button" class="btn-close float-end fs-6"
                                            data-bs-dismiss="modal" aria-label="Close"></button><br>
                                        <h3 class="text-center m-0" id="exampleModalLabel" style="  color: #991b1b;">
                                            Select a Plan
                                        </h3>
                                        <div class="d-flex justify-content-center gap-3 mt-3">
                                            <a class="subs-plan monthly-btn fs-5 px-2">Monthly</a>
                                            <a class="subs-plan yearly-btn fs-5 px-2">Yearly<span
                                                    style="font-size: 14px"> (Save
                                                    25%)</span></a>
                                        </div>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <div class="col-12 d-flex flex-column align-items-center p-3 pb-0 pt-0">
                                            <div style="border: 1px solid black"
                                                class="table table-border text-center">
                                                <div class="monthly">
                                                    <label for="monthly-plan-1">
                                                        <input type="radio" hidden name="monthly-plan"
                                                            value="monthly-plan-1" id="monthly-plan-1">
                                                        <span>1-2 People</span>
                                                        <span>$500/<span>Month</span></span>
                                                    </label>

                                                    <label for="monthly-plan-2">
                                                        <input type="radio" hidden name="monthly-plan"
                                                            value="monthly-plan-2" id="monthly-plan-2">
                                                        <span>3-5 People</span>
                                                        <span>$1000/<span>Month</span></span>
                                                    </label>
                                                    <label for="monthly-plan-3">
                                                        <input type="radio" hidden name="monthly-plan"
                                                            value="monthly-plan-3" id="monthly-plan-3">
                                                        <span>6-10 People</span>
                                                        <span>$1500/<span>Month</span></span>
                                                    </label>
                                                    <label for="monthly-plan-4">
                                                        <input type="radio" hidden name="monthly-plan"
                                                            value="monthly-plan-4" id="monthly-plan-4">
                                                        <span>11-15 People</span>
                                                        <span>$2000/<span>Month</span></span>
                                                    </label>
                                                    <label for="monthly-plan-5">
                                                        <input type="radio" hidden name="monthly-plan"
                                                            value="monthly-plan-5" id="monthly-plan-5">
                                                        <span>16-20 People</span>
                                                        <span>$2500/<span>Month</span></span>
                                                    </label>
                                                    <label class="border-0" for="monthly-plan-6">
                                                        <input type="radio" hidden name="monthly-plan"
                                                            value="monthly-plan-6" id="monthly-plan-6">
                                                        <span>21+ People</span>
                                                        <span class="fs-6">Request Custom Quote</span>
                                                    </label>
                                                </div>
                                                <div class="yearly">
                                                    <label for="yearly-plan-1">
                                                        <input type="radio" hidden name="yearly-plan"
                                                            value="yearly-plan-1" id="yearly-plan-1">
                                                        <span>1-2 People</span>
                                                        <span>$4,500/<span>Year</span>
                                                        </span>
                                                    </label>
                                                    <label for="yearly-plan-2">
                                                        <input type="radio" hidden name="yearly-plan"
                                                            value="yearly-plan-2" id="yearly-plan-2">
                                                        <span>3-5 People</span>
                                                        <span>$9,000/<span>Year</span>
                                                        </span>
                                                    </label>
                                                    <label for="yearly-plan-3">
                                                        <input type="radio" hidden name="yearly-plan"
                                                            value="yearly-plan-3" id="yearly-plan-3">
                                                        <span>6-10 People</span>
                                                        <span>$13,500/<span>Year</span>
                                                    </label>
                                                    </td>
                                                    <label for="yearly-plan-4">
                                                        <input type="radio" hidden name="yearly-plan"
                                                            value="yearly-plan-4" id="yearly-plan-4">
                                                        <span>11-15 People</span>
                                                        <span>$18,000/<span>Year</span>
                                                    </label>
                                                    </td>
                                                    <label for="yearly-plan-5">
                                                        <input type="radio" hidden name="yearly-plan"
                                                            value="yearly-plan-5" id="yearly-plan-5">
                                                        <span>16-20 People</span>
                                                        <span>$22,500/<span>Year</span>
                                                    </label>
                                                    </td>
                                                    <label class="border-0" for="yearly-plan-6">
                                                        <input type="radio" hidden name="yearly-plan"
                                                            value="yearly-plan-6" id="yearly-plan-6">
                                                        <span>21+ People</span>
                                                        <span class="fs-6">Request Custom Quote</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <h4>Start Your 6 Week Free Trial!</h4>
                        @if (session()->has('stripe_error'))
                            <div class="text-danger text-center my-3 fs-2">{{ session('stripe_error') }}</div>
                        @endif
                        {{-- <div class="tab">
                            <div class="form-inp-sec d-flex flex-column">
                                <div class="form-inp">
                                    <label class="labels" for="">Full Name</label>
                                    <input type="text" class="inputs" placeholder="Full Name" required
                                        name="name" id="">
                                </div>
                                <div class="form-inp">
                                    <label for="" class="labels">Email Address</label>
                                    <input type="text" class="inputs" placeholder="Email Adddress" required
                                        name="email" id="">
                                </div>
                                <div class="form-inp">
                                    <label for="" class="labels">Company Name</label>
                                    <select name="" name="company_name" id=""
                                        class="selects form-select">
                                        <option value="">Company Name</option>
                                        <option value="">Company Name</option>
                                        <option value="">Company Name</option>
                                    </select>
                                </div>
                                <div class="form-btn">
                                    <button type="button" id="nextBtn" class="btn btn-outline-primary px-5"
                                        onclick="nextPrev(1)">Next</button>
                                </div>
                            </div>

                        </div> --}}
                        <div class="">
                            <div class="form-inp-sec d-flex flex-column">
                                <div class="form-inp-div">
                                    <div class="form-inps">
                                        <label class="label1" for="">Email</label>
                                        <input type="email" class="input1" name="email"
                                            value="{{ session()->has('user_data') ? session('user_data')['email'] : '' }}"
                                            placeholder="wnlgtzanrjvghpfufe@cwmxc.com" id="">
                                        <span class="error email_error"></span>
                                    </div>
                                    <div class="form-inps">
                                        <input id="phone" name="phone" class="input1"
                                            value="{{ session()->has('user_data') ? session('user_data')['phone'] : '' }}"
                                            type="tel">
                                        {{-- <span id="valid-msg" class="hide">Valid</span>
                                        <span id="error-msg" class="hide">Invalid number</span> --}}
                                        <span class="error phone_error"></span>
                                    </div>
                                    <div class=" p-0">
                                        <div class="row w-100 ">
                                            <div class="col-lg-6 col-12 form-col">
                                                <div class="form-inp-row">
                                                    <label class="label1" for="">First Name</label>
                                                    <input class="input1" type="text" placeholder="First Name"
                                                        value="{{ session()->has('user_data') ? session('user_data')['first_name'] : '' }}"
                                                        name="first_name" id="">
                                                    <span class="error first_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 d-flex align-items-center">
                                                <div class="form-inp-row">
                                                    <label class="label1" for="">Last Name</label>

                                                    <input class="input1" type="text" placeholder="Last Name"
                                                        value="{{ session()->has('user_data') ? session('user_data')['last_name'] : '' }}"
                                                        name="last_name" id="">
                                                    <span class="error last_name_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="d-flex flex-column align-items-center">
                                        <h2 class="text-center red">{{ session()->has('user_data') ? session('user_data')['team_size'] : 'What Size is Your Team?' }}</h2>
                                        <a type="button" class="team-size-button selectTeamSize"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">Selct Team
                                            Size</a>
                                        <span class="error team_size_error"></span>
                                        <input type="hidden" name="team_size"
                                            value="{{ session()->has('user_data') ? session('user_data')['team_size'] : '' }}">
                                    </div>
                                    <div class="d-flex flex-column align-items-center mt-4">
                                        <h2 class="text-center red">When you want to Do your
                                            training?</h2>
                                        <a href="#"
                                            class="team-size-button text-white text-decoration-none">Selct a Date</a>
                                    </div>

                                </div>
                                <div class="form-inp-div">
                                    <div class="form-inps">
                                        <label>Address</label>
                                        <input type="text" class="input1"
                                            placeholder="Apartment, building, floor (optional)"
                                            value="{{ session()->has('user_data') ? session('user_data')['address'] : '' }}"
                                            name="address" id="">
                                        <span class="error address_error"></span>
                                    </div>
                                    <div class="form-inps">
                                        <label for="">Country</label>
                                        <select name="country" class="select1 form-select" id="country">
                                            <option class="text-secondary" selected value="">Select Country
                                            </option>
                                        </select>
                                        <span class="error country_error"></span>
                                    </div>
                                    <div class="form-inps">
                                        <label for="">State</label>
                                        <select name="state" class="select1 form-select" id="state">
                                            <option selected value="">Select State</option>
                                        </select>
                                        <span class="error state_error"></span>
                                    </div>
                                    <div class=" p-0">
                                        <div class="row w-100 ">
                                            <div class="col-lg-6 col-12 form-col">
                                                <div class="form-inp-row">
                                                    <input class="input1 city" type="text" placeholder="City"
                                                        value="{{ session()->has('user_data') ? session('user_data')['city'] : '' }}"
                                                        name="city" id="">
                                                    <span class="error city_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 d-flex align-items-center">
                                                <div class="form-inp-row">
                                                    <input class="input1 postal-code" type="number"
                                                        placeholder="Postal Code"
                                                        value="{{ session()->has('user_data') ? session('user_data')['postal_code'] : '' }}"
                                                        name="postal_code" id="">
                                                    <span class="error postal_code_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-inp-div stripe-div py-3">
                                    <div class="ps-2 " id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>

                                    <!-- Used to display Element errors. -->
                                    <div class="ps-2 text-danger" id="card-errors" role="alert"></div>
                                </div>
                                <div class="form-last-p">
                                    <p>Why? We ask for a payment method so that your subscription and business
                                        can continue without
                                        interruption after your trial ends.</p>
                                </div>
                                <div class="form-last-btn-2">
                                    <button class="start-trial-button" type="submit">Start My Free Trial
                                        <img class="loader d-none" src="{{ asset('assets/trial/loader.svg') }}"
                                            alt="asdf">
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <!-- why choose us footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid"
                        alt="">
                </div>
                <!-- footer -->
                <div class="col-12 footer">
                    <a href="/privacy-policy">Privacy Policy</a>
                    <br><br>
                    <p>Copyright to www.submitmymortgage.com {{ date('Y') }}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
    <script>
        $(document).ready(function() {
            $('.card-date').on('keyup', function(e) {
                e.preventDefault();
                var cardDate = $(this).val();
                if (cardDate > 0 && cardDate > 1) {
                    $(this).val(0 + cardDate + '/');
                }
            });
        });
    </script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
    {{-- <script src="{{ asset('assets/trial/script.js') }}"></script> --}}
    <script>
        var telInput = $("#phone"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // initialise plugin
        telInput.intlTelInput({

            allowExtensions: true,
            formatOnDisplay: true,
            autoFormat: true,
            autoHideDialCode: true,
            autoPlaceholder: true,
            defaultCountry: "us",
            ipinfoToken: "yolo",

            nationalMode: false,
            numberType: "MOBILE",
            //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            preferredCountries: ['sa', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
            preventInvalidNumbers: true,
            separateDialCode: false,
            initialCountry: "us",
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
        });

        var reset = function() {
            telInput.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };

        // on blur: validate
        telInput.blur(function() {
            reset();
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    validMsg.removeClass("hide");
                } else {
                    telInput.addClass("error");
                    errorMsg.addClass("text-danger");
                    errorMsg.removeClass("hide");
                }
            }
        });

        // on keyup / change flag: reset
        telInput.on("keyup change", reset);
    </script>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
            @if (session()->has('user_data'))
                var country = {!! json_encode(session('user_data')['country'] ?? '') !!};
                var state = {!! json_encode(session('user_data')['state'] ?? '') !!};

                // Select the corresponding options in the country and state select elements
                if (country) {
                    updateSelectedOption('country', country);
                }

                function updateSelectedOption(selectName, value) {
                    $(`select[name="${selectName}"]`).val(value).trigger('change');
                    // $('#payment-form').submit();
                }
                if (state) {
                    updateSelectedOption('state', state);
                    triggerAjax();
                }
            @endif

            $($('input[name=monthly-plan]')).click(function(e) {
                e.preventDefault();
                var monthly = $(this).parent().text();
                $('input[name=team_size]').val(($(this).val()));
                $('.btn-close').click();
                $('.selectTeamSize').text(monthly);
            });
            $($('input[name=yearly-plan]')).click(function(e) {
                e.preventDefault();
                var yearly = $(this).parent().text();
                $('input[name=team_size]').val(($(this).val()));
                $('.btn-close').click();
                $('.selectTeamSize').text(yearly);

            });

            $('.yearly-btn').addClass('border-bottom-0');
            $('.yearly').addClass('d-none');
            $('.yearly-btn').click(function(e) {
                e.preventDefault();
                $('.yearly-btn').removeClass('border-bottom-0');
                $('.monthly-btn').addClass('border-bottom-0');
                $('.monthly').addClass('d-none');
                $('.yearly').removeClass('d-none');

            });
            $('.monthly-btn').click(function(e) {
                e.preventDefault();
                $('.yearly-btn').addClass('border-bottom-0');
                $('.yearly').addClass('d-none');
                $('.monthly-btn').removeClass('border-bottom-0');
                $('.monthly').removeClass('d-none');
            });


            var paymentForm = $('#payment-form');
            $('#payment-form').on('submit', function(e) {
                e.preventDefault();
                if (validateFields()) {
                    triggerAjax();
                }
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
                },
            };

            // Create an instance of the card Element.
            const card = elements.create('card', {
                hidePostalCode:true,
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
                    const errorElement = document.getElementById(
                        'card-errors');
                    // Send the token to your server.
                    errorElement.textContent = '';
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
                if (validateFields()) {
                    form.submit();
                }
            }
        });

        function triggerAjax() {
            $('.loader').removeClass('d-none');
            $('.start-trial-button').attr('disabled', true);
            var paymentForm = $('#payment-form');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: paymentForm.attr('method'),
                url: paymentForm.attr('action'),
                data: paymentForm.serialize(),
                success: function(response) {
                    $('.loader').addClass('d-none');
                    $('.start-trial-button').removeAttr('disabled');
                    if (response !== 'success') {
                        $.each(response, function(indexInArray, error) {
                            $('.' + indexInArray + '_error').text('');
                            $('.' + indexInArray + '_error').text(response[
                                indexInArray]);
                        });
                    } else {
                        $('.stripe-div').removeClass('d-none');
                        $('.form-last-p').removeClass('d-none');
                    }
                }
            });
        }


        function validateFields() {
            $('.email_error').empty();
            $('.phone_error').empty();
            $('.first_name_error').empty();
            $('.last_name_error').empty();
            $('.address_error').empty();
            $('.country_error').empty();
            $('.state_error').empty();
            $('.city_error').empty();
            $('.postal_code_error').empty();
            $('.team_size_error').empty();
            var isValid = true; // Set a flag to track validation status
            var msg = 'This field is required';
            console.log($('input[name=team_size]').val());
            if ($('input[name=team_size]').val() === '') {

                $('.team_size_error').text('Please select your team size.');
                isValid = false; // Set flag to false if validation fails
            }
            if ($('input[name=email]').val() === '') {
                $('.email_error').text(msg);
                isValid = false; // Set flag to false if validation fails
            }
            if ($('input[name=phone]').val() === '') {
                $('.phone_error').text(msg);
                isValid = false; // Set flag to false if validation fails
            }
            if ($('input[name=first_name]').val() === '') {
                $('.first_name_error').text(msg);
                isValid = false;
            }
            if ($('input[name=last_name]').val() === '') {
                $('.last_name_error').text(msg);
                isValid = false;
            }
            if ($('input[name=address]').val() === '') {
                $('.address_error').text(msg);
                isValid = false;
            }
            if ($('select[name=country]').val() == -1) {
                $('.country_error').text(msg);
                isValid = false;
            }
            if ($('select[name=state]').val() === '') {
                $('.state_error').text(msg);
                isValid = false;
            }
            if ($('input[name=city]').val() === '') {
                $('.city_error').text(msg);
                isValid = false;
            }
            if ($('input[name=postal_code]').val() === '') {
                $('.postal_code_error').text(msg);
                isValid = false;
            }

            return isValid; //
        }
    </script>
    <script src="{{ asset('js/country_with_state.js') }}"></script>
</body>

</html>
