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
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* why choose us new section */
        .why-choose-new {
            padding-top: 80px;
        }

        .section-title {
            font-family: 'Lexend', sans-serif;
            font-size: 40px;
            margin-bottom: 40px;
        }

        .section-item {
            text-align: left;
        }

        .section-subtitle {
            font-family: 'Lexend', sans-serif;
            font-size: 25px;
            color: #a90d0e;
            margin-bottom: 20px;
        }

        .section-item ul {
            list-style: none;
            padding-left: 0;
        }

        .section-item ul li {
            margin-bottom: 10px;
        }

        /* Vertical Line */
        .vertical-line {
            border-left: 1px solid #000;
            height: 100%;
        }

        /* Second Hero Banner Section */
        .second-hero-banner {
            background-image: url('{{ asset('assets/second-hero.jpg') }}');
            background-size: cover;
            color: #000;
            /* Text color is black */
            border: 1px solid
        }

        .hero-title-2 {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000;
            /* Text color is black */
        }

        .hero-subtitle {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000;
            /* Text color is black */
        }

        .hero-paragraph-2 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #000;
            /* Text color is black */
        }

        .btn-primary-2 {
            background-color: #a90d0e;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            text-decoration: none;
            display: inline-block;
        }

        /* Split Section */
        .split-section {
            padding: 80px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .benefits-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .stats-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
            border-left: 1px solid #000;
        }

        .benefit-title {
            font-size: 35px;
            color: #a90d0e;
        }

        .benefit-text {
            font-size: 25px;
            color: #000;
        }

        .percentage-stat {
            font-size: 35px;
        }

        .stat {
            font-size: 25px;
            color: #a90d0e;
            padding: 15% 0;
            padding-left: 15%;
        }

        .calendly-badge-content {
            display: none !important;
        }



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

            .hero-section .hero-row .hero-paragraph {
                padding-bottom: 0px !important;
            }


        }

        @media only screen and (max-width: 767px) {
            #firstHeroText {
                background: linear-gradient(to right, transparent, white);
            }

            #firstHeroRow {
                padding-top: 100px;
                padding-bottom: 200px;
            }

            #firstHero {
                padding: 30% 0;
            }
        }



        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        /* Style for the three-column section */
        .three-column-section {
            display: flex;
            justify-content: space-between;
            padding: 0 8%;
            /* 8% padding on each side */
            margin-top: 50px;
            /* Adjust margin as needed */
        }

        /* Style for each column */
        .column {
            flex-basis: 18%;
            /* Adjust the width of each column */
            max-width: 18%;
            /* Ensure each column takes up 12% of the viewport */
            text-align: center;
            text-transform: uppercase;
        }

        /* Add margins to the first and third columns */
        .column:first-child {
            margin-left: 10%;
        }

        .column:last-child {
            margin-right: 10%;
        }

        /* Style for the column heading */
        .column-heading {
            font-size: 20px;
            color: #a90d0e;
            font-family: Montserrat, sans-serif;
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Style for the subheading */
        .subheading {
            font-size: 20px;
            color: #a90d0e;
            font-family: Montserrat, sans-serif;
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Style for the description */
        .description {
            font-size: 12px;
            color: black;
            font-family: Montserrat, sans-serif;
            line-height: 1;
            font-weight: 600;
        }

        .icon img {
            width: 70px;
            /* Set the width of the icon */
            height: auto;
            /* Maintain aspect ratio */
            margin-bottom: 20px;
            /* Adjust margin as needed */
        }

        .column-title h2 {
            font-family: Montserrat;
            text-align: center;
            color: #a90d0e;
            text-transform: Uppercase;
            font-weight: 600;
            font-size: 30px;
            padding-top: 4%;
        }

        .trial-button {
            padding: 2.5% 5%;
            background-color: #a90d0e;
            border: none;
        }

        .trial-button a {
            color: white;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .column-title {
                padding: 2.5% 5%;
            }

            /* Show each column stacked on top of each other */
            .three-column-section {
                margin-top: 0;
                flex-direction: column;
                padding: 0 10%;
                /* Remove padding on mobile */
            }

            /* Reset margins on columns for mobile */
            .column:first-child,
            .column:last-child {
                margin-left: 0;
                margin-right: 0;
            }

            /* Adjust width of columns for mobile */
            .column {
                flex-basis: 100%;
                max-width: 100%;
                margin-bottom: 20px;
                /* Add some space between stacked columns */
            }
        }

        /* Center the menu items horizontally between the logo and login button */
        .navbar-nav {
            font-family: Montserrat, sans-serif;
            font-size: 15px;
            padding: 0;
            color: black;
            text-decoration: uppercase;
        }

        .nav-link {
            color: black;
            text-transform: uppercase !important;
            font-weight: 600
        }

        .navbar-nav .nav-item {
            margin: 0 10px;
        }

        .navbar-brand,
        .navbar-nav,
        .ms-lg-auto {
            display: flex;
            align-items: center;
        }

        .ms-lg-auto {
            margin-left: auto;
        }

        @media (max-width: 991.98px) {

            /* Hide the navbar toggle button and menu items on mobile */
            .navbar-toggler,
            .navbar-nav {
                display: none;
            }

            /* Show login and register buttons on mobile */
            .d-lg-none {
                display: block !important;
            }

            #firstHero {
                /* Set the background image */
                background: url('{{ asset('assets/mobile-top-banner.jpg') }}') no-repeat !important;

                /* Ensure the background covers the entire element */
                background-size: cover !important;
                background-position: center;
            }
        }

        .hero-section {
            background: url('https://submitmymortgage.com/assets/homepage-top-banner-desktop.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .hero-section-2 {
            padding: 5%;
        }
    </style>
    @yield('css')
</head>

<body>
    <script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
    @include('front-pages.front-nav')
    <main>
        @yield('content')
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

    <script>
        // Function to open Calendly scheduling window
        function openCalendly() {
            Calendly.initPopupWidget({
                url: 'https://calendly.com/submitmymortgage/30min'
            });
            return false;
        }

        // Event listener to trigger openCalendly() when the button is clicked
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('requestDemoBtn').addEventListener('click', openCalendly);
        });
    </script>
    @yield('js')
</body>
</html>
