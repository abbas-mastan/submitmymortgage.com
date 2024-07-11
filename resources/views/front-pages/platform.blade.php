@extends('front-pages.front-layout')
@section('css')
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css');

        body {
            font-family: Aileron !important;
        }

        .trial-button {
            background-color: #FF852F;
            width: 50%;
            font-size: 15px;
            padding: 1%;
            width: 33%;
            margin-top: -3%;
        }

        .platform-container {
            padding: 8% 0%;
            max-width: 1550px;
        }


        @media (min-width: 1200px) {
            .modal-xl {
                --bs-modal-width: 80%;
            }
        }

        @media (min-width: 768px) {
            .modal-xl {
                --bs-modal-width: 80%;
            }
        }

        @media (min-width: 992px) {
            .col-lg-3.custom-width-16 {
                flex: 0 0 16%;
                max-width: 16%;
            }

            .modal-xl {
                --bs-modal-width: 80%;
            }
        }

      

        .full-screen-section {
            margin: 0;
            padding: 0;
        }

        .title {
            text-align: center;
            padding-right: 40%;
            font-family: Aileron;
            padding-bottom: 4%;
        }

        .subheading {
            font-family: Aileron;
            font-size: 26px;
            font-weight: 300;
            color: #707070;
        }

        .heading {
            font-weight: bold;
            font-size: 40px;
        }

        .cards {
            padding: 5% 0;
        }

        .card {
            padding: 5%;
        }

        .card-img-top {
            width: 20%;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .card-body {
            padding: 0 5%;
            text-align: center;
            font-family: Aileron;
        }

        .card-title {
            font-size: 20px;
            padding-top: 5%;
        }

        .card-text {
            font-size: 14px;
        }

        .why-choose {
            text-align: center;
        }

        .point {
            text-align: left;
        }

        .points {
            padding-bottom: 0% !important;
            padding-top: 5%;
        }

        .point-image-platform {
            max-width: 10%;
            align-items: center;
            align-content: center;
            padding-right: 2%;
        }

        .why-choose {
            padding: 5% 12% !important;
            margin-top: -10%;
        }

        .point-p {
            padding-top: 5%;
        }

        .carousel img {
            width: 70px;
            max-height: 70px;
            border-radius: 50%;
            margin-right: 1rem;
            overflow: hidden;
        }

        .carousel-inner {
            padding: 1em;
        }

        @media screen and (min-width: 576px) {
            .carousel-inner {
                display: flex;
                width: 90%;
                margin-inline: auto;
                padding: 1em 0;
                overflow: hidden;
            }

            .carousel-item {
                display: block;
                margin-right: 0;
                flex: 0 0 calc(100% / 2);
            }
        }

        @media screen and (min-width: 768px) {
            .carousel-item {
                display: block;
                margin-right: 0;
                flex: 0 0 calc(100% / 3);
            }
        }

        .carousel .card {
            margin: 0 0.5em;
            border: 0;
            filter: drop-shadow(20px 20px 20px rgb(0, 0, 0, .25));
        }

        .platform-text {
            text-align: center;
            font-size: 40px;
        }

        .header-sub {
            font-size: 18px;
            text-align: center;
            font-weight: 500;
        }

        .blue-text {
            color: #2F5BEA;
            padding-top: 5%;
        }

        .bottom-signup {
            background: url("{{ asset('assets/platform/bottom-banner.jpg') }}");
            padding: 15% 35%;
        }

        .email-form-header {
            color: white;
            text-align: center;
            font-size: 34px;
        }

        .email-text {
            color: white !important;
            text-align: center;
        }

        .platform-banner-f1 {
            background-size: contain;
            background: url("{{ asset('assets/platform/background-image.png') }}");
            text-align: center !important;
            padding: 8% !important;
            color: white !important;
            font-weight: bold !important;
            background-repeat: no-repeat !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        .email-input {
            padding: 1% 5%;
        }

        .get-started-btn {
            padding: 1% 4%;
            margin-left: -1%;
            background-color: white;
            border: 1px solid white;
            border-left: 1px solid grey;
        }

        .input-container {
            padding-top: 5%;
        }

        @media screen and (max-width: 768px) {
            .platform-banner-f1 {
                background-size: cover !important;
            }

            .blue-text {
                padding-top: 0% !important;
            }

            .point-p {
                padding-top: 0% !important;
            }

            .why-choose {
                padding: 10% !important;
            }

            .thumbnail {
                max-width: 100%;
            }

            .bottom-signup {
                padding: 10% !important;
            }

            .platform-banner-text {
                padding: 0% !important;
            }

            .performance-header {
                padding: 0% !important;
            }

            .point {
                padding-top: 10% !important;
            }

        }


        .get-started {
            background-color: white;
            padding: 2% 4%;
            border: 0px;
            color: #5d85ea;
            border-radius: 10px;
        }

        .get-started:hover {
            background-color: #5d85ea;
            padding: 2% 4%;
            border: 2px solid white;
            color: white;
            border-radius: 10px;
        }


        .get-started:hover a {
            color: white !important;
        }

        .platform-banner-text {
            padding: 0% 30%;
        }

        .performance-header {
            padding: 0% 20%;
        }

        .modal-content {
            background-color: transparent !important;
            border: none !important;
        }

        .custom-modal-size {
            width: 33%;
        }

        .custom-modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .platform-trial-button {
            color: #2F5BEA;
            font-size: 20px;
            font-family: Aileron !important;
            text-decoration: none !important;
            text-decoration: none;
        }

        .platform-trial-button:hover {
            color: #2F5BEA;
        }

        .thumbnail-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            text-align: center;
        }

        .thumbnail {
            max-width: 100%;
            height: auto;
        }

        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3em;
            color: #095CE5;
            /* Initial color of the play icon */
            cursor: pointer;
            background: rgba(255, 255, 255, 0.7);
            /* Initial background color with 70% opacity */
            border-radius: 50%;
            width: 80px;
            /* Adjust the size as needed */
            height: 80px;
            /* Ensure it's the same as width for a perfect circle */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s, color 0.3s;
        }

        .play-button:hover {
            background: #095CE5;
            /* Background color on hover */
            color: white;
            /* Color of the play icon on hover */
        }

        .img-fluid.thumbnail {
            max-width: 90% !important;
        }

        .video-container {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.781);
            z-index: 100;
        }

        .close {
            color: white;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <section class="platform-banner-f1" style="background-size: contain;">
        <div class="platform-banner-text">
            <h1 class="platform-text">Simplifying Mortgage Deals and Closing Processes</h1>
            <p class="header-sub">Simplicity Elevated: Your Superior Mortgage Solution</p><br>
            <button class="get-started"><a class="platform-trial-button" href="/trial">Get Started, It's Free</a></button>
        </div>
        <div class="thumbnail-container" style="position: relative; padding: 5%; text-align: center;">
            <img class="video-btn thumbnail img-fluid  w-100" src="{{ asset('assets/platform-image.png') }}"
                alt="Demo Thumbnail" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#videoModal">
            <div class="play-button video-btn" data-bs-toggle="modal" data-bs-target="#videoModal">
                &#9658; <!-- Play icon as a character -->
            </div>
        </div>
    </section>

    <section class="why-choose" style="color: #2C2E30 !important; margin-top: -15% !important;">
        <h2 class="subheading-performance"
            style="color: #7E8085; font-size: 20px; text-transform: uppercase; font-weight: 600;">Why Choose Submit My
            Mortgage</h2>
        <h1 style="color: #2C2E30; font-size: 40px; font-weight: bold;" class="performance-header">A simple, proven way to
            boost your team performance.</h1>
        <div class="points platform-container">
            <div class="row">
                <div class="col-sm-4 point">
                    <h3><img class="point-image-platform" src="{{ asset('assets/platform/streamlined.png') }}">Streamlined
                        Closing<br>Process</h3>
                    <p class="blue-text">Our software facilitates smoother and quicker closing deals, making the mortgage
                        process efficient and transparent. </p>
                    <p class="point-p"><b>Benefit for Borrowers:</b><br>Borrowers experience a hassle-free experience with
                        faster approval and simplified documentation processes. Now it had seen unable uneasy. Drawings can
                        followed by improved out sociable not. Earnestly so do instantly pretended.</p>
                </div>
                <div class="col-sm-4 point">
                    <h3><img class="point-image-platform" src="{{ asset('assets/platform/enhanced.png') }}">Enhanced
                        Borrower<br>Services</h3>
                    <p class="blue-text">Our platform offers borrowers streamlined access to vital loan information and
                        updates, enhancing their experience.</p>
                    <p class="point-p"><b>Benefits for Companies:</b><br>Companies can offer improved borrower experiences,
                        leading to increased customer satisfaction and loyalty.</p>
                </div>
                <div class="col-sm-4 point">
                    <h3><img class="point-image-platform"
                            src="{{ asset('assets/platform/project-management.png') }}">Project<br>Management</h3>
                    <p class="blue-text">Our software provides companies and employees with secure centralized access to all
                        loan-related information and documents. </p>
                    <p class="point-p"><b>Benefits for Company Employees:</b><br>Employees can easily track, manage, and
                        retrieve loan-related data, enhancing productivity and reducing errors in loan processing therefore
                        allowing enhancing overall company operations and loyalty.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="bottom-signup">
        <div>
            <h2 class="email-form-header">Try Submit My Mortgage for 14 days, for free!</h2>
            <p class="email-text">Submit My Mortgage has emerged as the preferred platform for borrowers and lenders
                worldwide, where their transactions thrive.</p>
            <div class="input-container" style="text-align: center;">
                <button class="get-started"><a class="platform-trial-button" href="/trial">Start 14 Day Trial</a></button>
            </div>
        </div>
    </section>


    <!-- Video Modal -->
    <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.9);" id="videoModal" tabindex="-1"
        aria-labelledby="videoModalLabel" aria-hidden="true">
        <button type="button"
            class="btn-close text-white ms-auto border border-white rounded-0 d-flex align-items-center justify-content-center p-2 m-3"
            style="background: none!important; border: 1px solid white!important;" data-bs-dismiss="modal"
            aria-label="Close">
            <i class="fa-solid fa-xmark text-white fs-3"></i>
        </button>
        <div class="modal-dialog modal-dialog-centered modal-xl my-0">
            <div class="modal-content w-100 bg-transparent border-0 rounded-0"
                style="width: 100%!important; height: auto!important; margin: 0!important;">
                <div class="modal-body bg-black p-0">
                    <video class="ratio ratio-16x9 fade-anime" poster="{{ asset('assets/play-thumbnail.jpg') }}" controls
                        muted>
                        <source src="{{ asset('assets/submit-my-mortgage-video_2.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // var video = $('#main-video')[0];
            // $('.video-btn').on('click', function(e) {
            //     e.preventDefault();
            //     video.pause();
            //     video.currentTime = 0;
            //     if ($('.video-modal').hasClass('d-none')) {
            //         $('.thumbnail-modal').removeClass('d-none');
            //     }
            //     $('.video-modal').toggleClass('d-none');
            // });

            // $('.thumbnail-modal').click(function(e) {
            //     e.preventDefault();
            //     $('.thumbnail-modal').addClass('d-none');
            //     video.play();
            // });

        });
    </script>
@endsection
