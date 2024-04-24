<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Documents</title>
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
        .modal-content {
            width: 660px !important;
            height: 424px !important;
        }

        @media only screen and (max-width: 768px) {
            .modal-content {
                margin: -80px !important;
                width: 660px !important;
                height: 424px !important;
            }
        }

        @media only screen and (max-width: 425px) {
            .modal-content {
                margin: 0 !important;
                width: 412px !important;
                height: 231px !important;
            }
        }

        @media only screen and (max-width: 375px) {
            .modal-content {
                position: relative;
                width: 365px !important;
                margin: -2px !important;
            }
        }
    </style>
</head>
</head>

<body>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always"
                    allow="autoplay"></iframe> --}}
                <video muted autoplay src="demo.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
    </div>
    <header class="sticky-top bg-white">
        <nav class="navbar navbar-expand-lg bg-white py-4">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                    </ul>
                    <div class="ms-lg-5">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">LOGIN</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary ms-2" type="button">REGISTER</a>
                    </div>
                </div>
            </div>
        </nav>
        {{-- <nav class="navbar navbar-expand-lg py-4">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid" alt="">
                </a>
                <!-- the button and ul menu are currently displayed none -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
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
        </nav> --}}
    </header>
    <main>
        <!-- hero section -->
        <section class="hero-section">
            <div class="container">
                <div class="row hero-row">
                    <div class="col-xl-7 col-xxl-6">
                        <h1 class="hero-title mb-4">Mortgage Documents Verification</h1>
                        <p class="hero-paragraph">Streamline verification of mortgage documents and shorten
                            processing<br class="d-none d-md-block" />
                            times, enforce standardization and compliance, and improve<br class="d-none d-md-block" />
                            productivity and customer satisfaction.</p>
                        <button
                            class="video-btn btn btn-outline-primary body-btns d-flex justify-content-center align-items-center"
                            type="button" data-src="demo.mp4" data-bs-toggle="modal" data-bs-target="#myModal">
                            WATCH DEMO
                            <img width="12" src="{{ asset('assets/demo.png') }}" class="ms-2 img-fluid"
                                alt="">
                        </button>
                    </div>
                    <!-- <div class="col"></div> -->
                </div>
            </div>
        </section>
        <!-- our key features -->
        <section class="key-features">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 left-side align-self-center">
                        <img src="{{ asset('assets/key-features/key-features.png') }}" class="img-fluid"
                            alt="">
                    </div>
                    <div class="col-md-7 right-side ps-lg-5">
                        <h2 class="text-title mb-4">Our Key Features</h2>
                        <p>
                            By using our platform, you can save time and effort, while ensuring the security and
                            accuracy of your documents. Here are the key features:
                        </p>
                        <ul class="key-features-list">
                            <li>
                                <img src="{{ asset('assets/key-features/list-icons.png') }}"
                                    class="img-fluid list-icon" alt="">
                                Easy document upload.
                            </li>
                            <li>
                                <img src="{{ asset('assets/key-features/list-icons.png') }}"
                                    class="img-fluid list-icon" alt="">
                                Real-time verification status updates.
                            </li>
                            <li>
                                <img src="{{ asset('assets/key-features/list-icons.png') }}"
                                    class="img-fluid list-icon" alt="">
                                Secure document storage.
                            </li>
                            <li>
                                <img src="{{ asset('assets/key-features/list-icons.png') }}"
                                    class="img-fluid list-icon" alt="">Streamlined communication with our
                                team.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- why choose Us -->
        <section class="why-choose-us">
            <div class="container">
                <!-- top -->
                <div class="row why-choose-us-top">
                    <div class="col-md-7 why-choose-us-top-left pe-md-5 order-2 order-md-1">
                        <h2 class="text-title mb-4">Why Choose Us</h2>
                        <p class="mt-3">Whether you are a homeowner looking to submit your documents for mortgage
                            approval or a
                            company agent
                            tasked with verifying those documents, our platform provides a seamless and efficient
                            solution.
                        </p>
                        <p class="mt-3">
                            Our mission is to make the mortgage document verification process as stress-free and
                            efficient as
                            possible. With our user-friendly platform and dedicated team of experts, we aim to provide a
                            seamless experience for all of our users.</p>
                    </div>
                    <div class="col-md-5 why-choose-us-top-right order-1 order-md-2 align-self-center">
                        <img src="{{ asset('assets/why-choose-us/why-choose-us.png') }}" class="img-fluid"
                            alt="">
                    </div>
                </div>
            </div>
        </section>
        <!-- see what our customers say -->
        <section class="customers-review">
            <div class="container">
                <div class="row">
                    <h2 class="text-title text-center">
                        See What our Customers Say
                    </h2>
                    <div class="col-12 reviews mt-md-5">
                        <div class="owl-carousel owl-theme">
                            <div class="item each-review-card">
                                <div class="stars">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                </div>
                                <p>
                                    "As a company agent, this platform saved me time and effort. Real-time updates and
                                    streamlined communication made the process much smoother. It made my job so much
                                    easier and allowed me to verify documents in a fraction of the time it would have
                                    taken me before."
                                </p>
                                <span class="author"> ~ John Doe ~ </span>
                            </div>
                            <div class="item each-review-card">
                                <div class="stars">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                </div>
                                <p>
                                    "As a company agent, this platform saved me time and effort. Real-time updates and
                                    streamlined communication made the process much smoother. It made my job so much
                                    easier and allowed me to verify documents in a fraction of the time it would have
                                    taken me before."
                                </p>
                                <span class="author"> ~ John Doe ~ </span>
                            </div>
                            <div class="item each-review-card">
                                <div class="stars">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                </div>
                                <p>
                                    "As a company agent, this platform saved me time and effort. Real-time updates and
                                    streamlined communication made the process much smoother. It made my job so much
                                    easier and allowed me to verify documents in a fraction of the time it would have
                                    taken me before."
                                </p>
                                <span class="author"> ~ John Doe ~ </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- get mortgage approval faster! -->
        <section class="get-mortgage mb-5">
            <div class="container">
                <div class="row">
                    <!-- left side -->
                    <div class="col-xl-5">
                        <h2 class="text-title mb-4">Get mortgage approval faster!</h2>
                        <p class="mt-2">With our mortgage document verification dashboard system, you can get
                            mortgage
                            approval
                            faster. Say goodbye to long wait times and hello to a hassle-free mortgage approval process
                            with us!</p>
                        <a href="{{ route('register') }}" class="btn btn-primary text-uppercase mt-4 body-btns">Get
                            Started</a>
                    </div>
                    <!-- right side -->
                    <div class="col-xl-7 right"></div>
                </div>
            </div>
        </section>
        <section class="mt-5">
            <div class="container">
                <div class="row">
                    <!-- left side -->
                    <div class="col-xl-12 left">
                        <h2 class="text-title mb-4" id="disclosure">Disclosure</h2>
                        <p class="mt-2">We value your privacy and take the protection of your information seriously.
                            Our app complies with the Google API Services User Data Policy, including the Limited Use
                            requirements for Restricted and Sensitive Scopes. For more information, please visit the <a
                                href="https://developers.google.com/terms/api-services-user-data-policy">Google API
                                Services User Data Policy</a>. </p>
                    </div>
                    <!-- right side -->
                </div>
            </div>
        </section>
    </main>
    <!-- why choose us footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid"
                        alt=""></div>
                <!-- footer -->
                <div class="col-12 footer">
                    <a href="/privacy-policy">Privacy Policy</a>
                    <br><br>
                    <p>Copyright to www.submitmymortgage.com {{ date('Y') }}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- owl carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- owl carousel -->
    <script>
        $('.owl-carousel').owlCarousel({
            // loop: true,
            // autoplay: true,
            margin: 15,
            nav: true,
            items: 2,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                992: {
                    items: 2
                }
            }
        })
    </script>
    {{-- video demo modal  --}}
    <script>
        $(document).ready(function() {
            // Gets the video src from the data-src on each button
            var $videoSrc;
            $('.video-btn').click(function() {
                $videoSrc = $(this).data("src");
                $('#video').attr('width', '650');
                $('#video').attr('height', '560');
                console.log($videoSrc);
            });
            // when the modal is opened autoplay it  
            $('#myModal').on('shown.bs.modal', function(e) {
                // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
                $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
            })
            // stop playing the youtube video when I close the modal
            $('#myModal').on('hide.bs.modal', function(e) {
                // a poor man's stop video
                $("#video").attr('src', $videoSrc);
            })
        });
    </script>
</body>

</html>
