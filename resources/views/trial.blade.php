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
            background: url("{{asset('assets/trialhero.jpg')}}") no-repeat;
            background-size: cover;
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
                    <form id="regForm" class="main-form require-validation" action="{{ route('stripePayment') }}"
                        role="form" method="post" class="require-validation" data-cc-on-file="false"
                        data-stripe-publishable-key="{{ env('STRIPE_PK') }}">
                        method="POST">
                        @csrf
                        <h4>Start Your 6 Week Free Trial!</h4>

                        <div class="tab">
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

                        </div>
                        <div class="tab">
                            <div class="form-inp-sec d-flex flex-column">
                                <div class="form-inp-div">
                                    <div class="form-inps">
                                        <label class="label1" for="">Email</label>
                                        <input type="email" class="input1" name=""
                                            placeholder="wnlgtzanrjvghpfufe@cwmxc.com" value="" id="">
                                    </div>
                                    <div class="form-inps">
                                        <input id="phone" class="input1" type="tel">
                                        <span id="valid-msg" class="hide">Valid</span>
                                        <span id="error-msg" class="hide">Invalid number</span>
                                    </div>
                                    <div class=" p-0">
                                        <div class="row w-100 ">
                                            <div class="col-lg-6 col-12 form-col">
                                                <div class="form-inp-row">
                                                    <label class="label1" for="">First Name</label>
                                                    <input class="input1" type="text" placeholder="First Name"
                                                        value="" name="" id="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 d-flex align-items-center">
                                                <div class="form-inp-row">
                                                    <label class="label1" for="">Last Name</label>

                                                    <input class="input1" type="text" placeholder="Last Name"
                                                        value="" name="" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-inp-div">
                                    <div class="form-inps">
                                        <label>Address</label>
                                        <input type="text" class="input1"
                                            placeholder="Apartment, building, floor (optional)" value=""
                                            name="" id="">
                                    </div>
                                    <div class="form-inps">
                                        <label for="">Country</label>
                                        <select name="" class="select1 form-select" id="">
                                            <option value="">United States</option>
                                            <option value="">United States</option>
                                            <option value="">United States</option>
                                        </select>

                                    </div>
                                    <div class="form-inps">
                                        <label for="">State</label>
                                        <select name="" class="select1 form-select" id="">
                                            <option value="">Alabama</option>
                                            <option value="">Alabama</option>
                                            <option value="">Alabama</option>
                                        </select>

                                    </div>
                                    <div class=" p-0">
                                        <div class="row w-100 ">
                                            <div class="col-lg-6 col-12 form-col">
                                                <div class="form-inp-row">
                                                    <input class="input1 city" type="text" placeholder="City"
                                                        value="" name="" id="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 d-flex align-items-center">
                                                <input class="input1 postal-code" type="number"
                                                    placeholder="Postal Code" value="" name="postal_code"
                                                    id="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-inp-div">

                                    <div class="form-inps flex-row card-inp">
                                        <i class="far fa-credit-card"></i>
                                        <input class="input1" placeholder="Card Number">
                                    </div>
                                    <div class=" p-0">
                                        <div class="row w-100 ">
                                            <div class="col-lg-6 col-12 form-col">
                                                <div class="form-inp-row">
                                                    {{-- <label class="label1" for="">First Name</label> --}}
                                                    <input class="input1 card-number card-date" type="text"
                                                        placeholder="MM / YY" value="" name=""
                                                        id="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 d-flex align-items-center">
                                                <input class="input1 card-number" type="text" placeholder="CVV"
                                                    value="" name="" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-last-p">
                                    <p>Why? We ask for a payment method so that your subscription and business
                                        can continue without
                                        interruption after your trial ends.</p>
                                </div>
                                <div class="form-last-btn-2">
                                    <button class="start-trial-button" type="submit">Start My Free Trial</button>
                                </div>


                            </div>
                        </div>

                        <!-- <div style="overflow: auto">
                                    <div style="float: right">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">
                                            Previous
                                        </button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)">
                                            Next
                                        </button>
                                    </div>
                                </div> -->
                        <!-- Circles which indicates the steps of the form: -->
                        <div style="text-align: center; margin-top: 40px; display: none">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
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
                <div class="col-12"><img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid" alt="">
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
    <script src="{{ asset('assets/trial/script.js') }}"></script>
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
                    errorMsg.removeClass("hide");
                }
            }
        });

        // on keyup / change flag: reset
        telInput.on("keyup change", reset);
    </script>
</body>

</html>
