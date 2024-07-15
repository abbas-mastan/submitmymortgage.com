@extends('front-pages.front-layout')
@section('css')
    <style>
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

        .banner-container {
            padding: 8% 0%;
            max-width: 1400px;
            margin: auto;
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
            /* padding: 0; */
            background-color: #f4f2f5 !important;
            background: url('{{ asset('assets/ornament.png') }}') no-repeat center center;
            background-size: cover;
            background-position: center;
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
            padding: 5% 20px;
        }

        .card {
            padding: 5%;
        }

        .card-img-top {
            width: 20% !important;
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
            text-align: left;
            font-size: 14px;
        }

        .why-choose {
            padding: 5% 22%;
            text-align: center;
            background: url('{{ asset('assets/grey-background.jpg') }}');
            background-size: cover !important;
            background-repeat: no-repeat !important;
        }

        .point {
            text-align: left;
        }

        .points {
            padding-bottom: 0% !important;
            padding-top: 5%;
        }

        .point-image {
            max-width: 10%;
            align-items: center;
            align-content: center;
        }


        .point-p {
            padding-top: 5%;
        }

        .carousel img {
            width: 70px !important;
            max-height: 70px !important;
            border-radius: 50% !important;
            margin-right: 1rem !important;
            overflow: hidden !important;
        }

        .carousel-inner {
            padding: 1em;
        }

        @media screen and (min-width: 576px) {
            .carousel-inner {
                display: flex;
                width: 90% !important;
                margin-inline: auto !important;
                padding: 1em 0 !important;
                overflow: hidden !important;
            }

            .carousel-item {
                display: block;
                margin-right: 0 !important;
                flex: 0 0 calc(100% / 2) !important;
            }
        }

        @media screen and (min-width: 768px) {
            .carousel-item {
                display: block;
                margin-right: 0 !important;
                flex: 0 0 calc(100% / 3) !important;
            }
        }

        .carousel .card {
            margin: 0 0.5em !important;
            border: 0 !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 3rem !important;
            height: 3rem !important;
            background-color: grey !important;
            border-radius: 50% !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
        }

        .shadow-sm {
            drop-shadow(5px 5px);
        }

        @media screen and (max-width: 991px) {

            .navbar-toggler,
            .navbar-nav {
                display: none !important;
            }

            .why-choose {
                padding: 10% !important;
            }

            .img-fluid {
                max-width: 100% !important;
            }

            .center-text {
                text-align: left !important;
                padding-top: 5%;
            }

            #firstHeroText {
                padding-bottom: 5%;
            }

            .hero-row {
                padding: 0% 5%;
            }

            .title {
                padding-right: 0px;
            }

            .card {
                margin: 0% 5%;
            }

            .performance-header {
                padding: 0% !important;
                text-align: left !important;
                ;
            }

            .subheading-performance {
                text-align: left !important;
            }
        }

        .hero-section-home {
            background: url('{{ asset('assets/top-banner-background.jpg') }}') no-repeat center center;
            background-size: cover;
            background-position: center;
        }

        .hero-section-two {
            background: url('{{ asset('assets/laptop-background.jpg') }}') no-repeat center center;
            background-size: cover;
            background-position: center;

        }

        .hero-section-bottom {
            background: url("{{ asset('assets/bottom-background.jpg') }}") no-repeat center center;
            background-size: cover;
            background-position: center;
        }

        .active .card {
            background-color: #0076FF;
            color: white;
        }

        .active .text-secondary {
            color: white !important;
        }

        .center-text {
            text-align: center;
        }


        .container {
            max-width: 1800px !important;
            margin: 0 auto;
        }

        .btn-secondary {
            color: #2559F5 !important;
            background-color: transparent !important;
            border: 2px solid #2559F5 !important;
            padding: 0.5rem 1.50rem !important;
        }

        .border {
            border: 2px solid #2559F5 !important;
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

        .fade-anime {
            animation: fadeIn 3s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .pt-2 {
            text-align: left !important;
        }
    </style>
@endsection
@section('content')
    <!-- <div class="video-modal d-none">
                        <div class="d-flex flex-column video-container">
                            <div class="d-flex justify-content-end pe-5 close video-btn fs-1">
                                <span style="rotate:45deg;">
                                    +
                                </span>
                            </div>
                            <div class="d-flex justify-content-center">
                                <video id="main-video" class="position-absolute" style="    width: 92rem;
    height: 53rem;" controls>
                                    <source src="{{ asset('assets/submit-my-mortgage-video_2.mp4') }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <img class="thumbnail  position-absolute" style="z-index:900;    width: 92rem;
    height: 53rem;" src="{{ asset('assets/play-thumbnail.jpg') }}" alt="">
                            </div>
                        </div>
                    </div> -->
    </div>
    <section class="hero-section-home">
        <div class="banner-container">
            <div class="row hero-row" id="firstHeroRow">
                <div class="col-lg-6 d-flex flex-column justify-content-center px-lg-5" id="firstHeroText">
                    <h1 class="hero-title mb-4">Revolutionize Mortgage Lending with Submit My Mortgage</h1>
                    <p class="hero-paragraph" style="margin-bottom: 8%;">Streamline verification of mortgage
                        documents and shorten
                        processing<br class="d-none d-md-block" />
                        times, enforce standardization and compliance, and improve<br class="d-none d-md-block" />
                        productivity and customer satisfaction.</p>
                    <a href="/trial" class="trial-button btn btn-primary text-white text-decoration-none">
                        Start 14 Day Free Trial
                    </a>
                </div>
                <div class="col-lg-6 center-text mt-lg-5">
                    <img src="{{ asset('assets/play-thumbnail.jpg') }}" class="video-btn img-fluid full-width w-100"
                        alt="Demo Thumbnail" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#videoModal">
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid full-screen-section cards">
        <div class="title">
            <h2 class="subheading">Change Your Perspective, Change Your Business:</h2>
            <h1 class="heading">A New Era Of Mortgage Management</h1>
        </div>

        <div class="row justify-content-around">
            <div class="col-lg-3 custom-width-16 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/first-icon.png') }}" class="card-img-top" alt="Card image 1"
                        style="width: 20% !important;">
                    <div class="card-body">
                        <h5 class="card-title">Precision</h5>
                        <p class="card-text">Experience an error reduction of 95%. Ensuring precise document management and
                            compliance at every step.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 custom-width-16 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/second-icon.png') }}" class="card-img-top" alt="Card image 2">
                    <div class="card-body">
                        <h5 class="card-title">Efficiency</h5>
                        <p class="card-text">Boost your lending efficiency by up to 40%. Ensuring quicker turnarounds on
                            loan applications. </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 custom-width-16 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/third-icon.png') }}" class="card-img-top" alt="Card image 3">
                    <div class="card-body">
                        <h5 class="card-title">Competitive</h5>
                        <p class="card-text">Stay ahead in the market with our cutting-edge technology. Leading to minimum
                            30% increase in closed loans compared to traditional systems.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 custom-width-16 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/fourth-icon.png') }}" class="card-img-top" alt="Card image 4">
                    <div class="card-body">
                        <h5 class="card-title">Transparency</h5>
                        <p class="card-text">Experience unmatched transparency on our platform, connecting borrowers and
                            lenders seamlessly with clear communication and full disclosure, fostering trust and confidence
                            in every transaction.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="hero-section-two">
        <div class="banner-container">
            <div class="row hero-row">
                <div class="col-lg-6 text-center mt-lg-5">
                    <img src="{{ asset('assets/laptop-bottom-section.png') }}" class="img-fluid">
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center px-lg-5" id="firstHeroText">
                    <h1 class="hero-title mb-4" style="font-size: 40px;">Mortgage Documents Verification</h1>
                    <h2 style="font-size: 24px; padding-right: 20%;">Empowering Lenders and Streamlining Dreams by Closing
                        More Deals</h2><br>
                    <p class="hero-paragraph" style="margin-bottom: 8%;">Submit My Mortgage is the ultimate solution for
                        banks and lenders, designed to transform the mortgage process, from loan preapproval to seamless
                        closing. Discover a new era of speed, precision, and unparalleled customer satisfaction.</p>
                    <a href="/trial" class="trial-button btn btn-primary text-white text-decoration-none">
                        Start 14 Day Free Trial
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="why-choose">
        <h2 class="subheading-performance"
            style="color: #7E8085; font-size: 20px; text-transform: uppercase; font-weight: 600;">Why Choose Submit My
            Mortgage</h2>
        <h1 style="color: white; font-size: 40px; font-weight: bold; padding: 0% 20%;" class="performance-header">A simple,
            proven way to boost your team performance.</h1>
        <div class="points banner-container">
            <div class="row">
                <div class="col-sm-4 point" style="color: white;">
                    <h3><img class="point-image" src="{{ asset('assets/point-1.png') }}"> Notifications</h3>
                    <p class="point-p">Our real-time Notifications feature ensures instant updates for all team members and
                        borrowers, accelerating decision-making by 40% with actionable alerts. By engaging clients promptly,
                        we boost close rates and foster efficient collaboration.</p>
                </div>
                <div class="col-sm-4 point" style="color: white;">
                    <h3><img class="point-image" src="{{ asset('assets/point-2.png') }}"> Communication</h3>
                    <p class="point-p">Our client communication tools are designed to foster transparent and efficient
                        communication, enhancing collaboration between lenders and borrowers. With real-time messaging and
                        updates, we aim to minimize delays, ensuring that all parties involved are well-informed and able to
                        work together seamlessly.</p>
                </div>
                <div class="col-sm-4 point" style="color: white;">
                    <h3><img class="point-image" src="{{ asset('assets/point-3.png') }}"> Notifications</h3>
                    <p class="point-p">Our Streamlined Document Management tools simplify the complexities of document
                        handling by centralizing and organizing all necessary documents securely. With our intuitive system,
                        we ensure a smooth and compliant process, allowing users to efficiently manage their documents with
                        ease and confidence.</p>
                </div>
            </div>
        </div>
    </section>
    <section style="background-color: #ffffff; padding-bottom: 5%; padding-top: 1%;">
        <div style="text-align: center; padding-top: 5%;">
            <h2 style="font-weight: bold;">Testimonials</h2>
            <p style="font-size: 20px;">See what people have to say about us</p>
        </div>
        <div class="container-fluid bg-body-tertiary py-3">
            <div id="testimonialCarousel" class="carousel">
                <div class="carousel-inner d-flex flex-wrap">
                    <div class="carousel-item active d-flex align-items-stretch">
                        <div class="card shadow-sm rounded-3 flex-fill">
                            <div class="quotes display-2 text-body-tertiary">
                                <i class="bi bi-quote"></i>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text flex-grow-1">"I've been using Submit My mortgage for several years now
                                    and I'm incredibly impressed by it's capabilities. As a loan broker, I rely on
                                    efficiency and accuracy to serve my clients and this product delivers on all ends. My
                                    team is updated on every step of the loan process—from application, submission to
                                    closing, to maximize our close rates."</p>
                                <div class="d-flex align-items-center pt-2">
                                    <img src="https://codingyaar.com/wp-content/uploads/square-headshot-1.png"
                                        alt="bootstrap testimonial carousel slider 2">
                                    <div>
                                        <h5 class="card-title fw-bold">Jane Doe</h5>
                                        <span class="text-secondary">CEO, Example Company</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item d-flex align-items-stretch">
                        <div class="card shadow-sm rounded-3 flex-fill">
                            <div class="quotes display-2 text-body-tertiary">
                                <i class="bi bi-quote"></i>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text flex-grow-1">"As a company agent, this platform saved me time and
                                    effort. Real-time updates and streamlined communication made the process much smoother.
                                    It made my job so much easier and allowed me to verify documents in a fraction of the
                                    time it would have taken me before."</p>
                                <div class="d-flex align-items-center pt-2">
                                    <img src="https://codingyaar.com/wp-content/uploads/square-headshot-2.png"
                                        alt="bootstrap testimonial carousel slider 2">
                                    <div>
                                        <h5 class="card-title fw-bold">June Doe</h5>
                                        <span class="text-secondary">CEO, Example Company</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item d-flex align-items-stretch">
                        <div class="card shadow-sm rounded-3 flex-fill">
                            <div class="quotes display-2 text-body-tertiary">
                                <i class="bi bi-quote"></i>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text flex-grow-1">"I've been in the mortgage industry for over a decade, and
                                    I can confidently say that Submit my Mortgage has revolutionized the way we do business.
                                    The platform not only streamlines the entire loan process, but also significantly
                                    improves our closing rates. The real-time notifications keep everyone in the loop, and
                                    the customized alerts ensures that nothing falls through the cracks."</p>
                                <div class="d-flex align-items-center pt-2">
                                    <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg"
                                        alt="bootstrap testimonial carousel slider 2">
                                    <div>
                                        <h5 class="card-title fw-bold">John Doe</h5>
                                        <span class="text-secondary">CEO, Example Company</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section class="hero-section-bottom">
        <div class="banner-container">
            <div class="row hero-row">
                <div class="col-lg-6 d-flex flex-column justify-content-center px-lg-5" id="firstHeroText">
                    <h1 class="hero-title mb-4" style="font-size: 40px;">Get mortgage approval faster!</h1>
                    <br>
                    <p class="hero-paragraph" style="margin-bottom: 8%;">With our mortgage document verification dashboard
                        system, you can get mortgage approval faster. Say goodbye to long wait times and hello to a
                        hassle-free mortgage approval process with us!</p>
                </div>
                <div class="col-lg-6 text-center mt-lg-5">
                    <img src="{{ asset('assets/loan-approved-icon.png') }}" class="img-fluid">
                </div>
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
            const multipleItemCarousel = $("#testimonialCarousel");

            if (window.matchMedia("(min-width: 576px)").matches) {
                const carousel = new bootstrap.Carousel(document.getElementById('testimonialCarousel'), {
                    interval: false
                });

                var carouselWidth = $(".carousel-inner")[0].scrollWidth;
                var cardWidth = $(".carousel-item").width();
                var scrollPosition = 0;

                $(".carousel-control-next").on("click", function() {
                    if (scrollPosition < carouselWidth - cardWidth * 3) {
                        scrollPosition += cardWidth;
                        $(".carousel-inner").animate({
                            scrollLeft: scrollPosition
                        }, 800);
                    }
                });

                $(".carousel-control-prev").on("click", function() {
                    if (scrollPosition > 0) {
                        scrollPosition -= cardWidth;
                        $(".carousel-inner").animate({
                            scrollLeft: scrollPosition
                        }, 800);
                    }
                });
            } else {
                multipleItemCarousel.addClass("slide");
            }
        });
    </script>
@endsection
