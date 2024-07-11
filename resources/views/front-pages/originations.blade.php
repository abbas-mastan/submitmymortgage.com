@extends('front-pages.front-layout')
@section('css')
<style>
    html {
        font-family: Aileron !important;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
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

    .fade-anime {
        animation: fadeIn 3s;
    }

    .trial-button {
        background-color: #FF852F;
        font-size: 15px;
        padding: 1%;
        width: 33%;
        /* This duplicates the width property, consider removing one */
        margin-top: -3%;
    }

    .banner-container {
        margin: auto;
        max-width: 1550px;
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
        font-weight: bold;
    }

    .card-text {
        font-size: 14px;
    }

    .point {
        text-align: left;
    }

    .points {
        padding-bottom: 0% !important;
        padding-top: 5%;
    }

    .point-image-about {
        align-items: center;
        align-content: center;
    }

    .three-section-header {
        font-size: 20px;
    }

    .experience-submit {
        padding: 0% 35%;
    }

    .origination-banner {
        padding-right: 20%;
    }

    .origination-get-started {
        background-color: #4442AE;
        margin-top: -5%;
    }

    .custom-card-origination {
        position: relative;
        overflow: visible;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin: 5%;
    }

    .custom-card-origination .card-body {
        padding: 20px;
    }

    .custom-card-origination .icon-wrapper {
        position: absolute;
        top: 20px;
        right: 80px;
        padding: 10px;
        transform: translate(50%, -50%);
        z-index: 2;
    }

    .custom-card .card-body {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .card-container-origination {
        max-width: 800px;
        margin: 0 auto;
    }

    .read-more {
        background-color: black;
        border-radius: 7px;
        color: white;
        font-family: Aileron;
        padding: .5% 2%;
        text-align: center;
        display: block;
        margin: 20px auto;
    }

    .icon-text-section {
        text-align: center;
        color: black !important;
    }

    .paragraph-text {
        color: #7E8085 !important;
    }

    .header-f1 {
        color: #2A2A29;
        text-align: center !important;
    }

    .image-container {
        position: relative;
        overflow: hidden;
    }

    .half-out {
        right: -45%;
        width: 120%;
    }

    .icon-text-section {
        border-bottom: 2px solid #D8D8D8;
        padding-bottom: 5% !important;
    }

    .cta-container {
        display: flex;
        align-items: center;
    }

    .cta-container .get-started {
        width: auto;
    }

    .cta-container p {
        margin-left: 10px;
    }

    #firstHeroOriginations {
        background-image: url('https://submitmymortgage.com/assets/top-banner-originations.jpg');
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .more-than-a-software {
        text-align: center;
    }

    .more-than-software {
        color: #7E8085;
        font-size: 18px;
    }

    .individual {
        text-align: left !important;
        padding-top: 10%;
    }

    .individual img {
        padding-right: 2%;
    }

    .multi-text {
        padding-left: 10%;
        padding-right: 44%;
    }

    .tech-support {
        padding-left: 20%;
        text-align: right;
    }

    .blue-text {
        color: #2F5BEA;
    }

    .get-smm {
        background-color: transparent;
        border: 0;
        border-bottom: 2px solid #2F5BEA;
    }

    .cards-section {
        background-color: #F6F8F9;
        padding: 7% 0%;
        border-top: 10px solid #533FB6;
        border-bottom: 10px solid #533FB6;
        margin-top: 10%;
    }

    .thumbnail {
        width: 75%;
        text-align: right;
    }

    .manage-your-team {
        color: #7E8085;
        font-size: 18px;
    }

    .bottom-banner-h2 {
        font-size: 36px;
    }

    .right {
        text-align: left;
    }

    .bottom-row {
        margin: auto;
        max-width: 1800px;
    }

    .originations-bottom-banner {
        padding: 10% 0%;
    }

    .bottom-banner-text {
        padding-left: 20%;
    }

    .banner-graphic {
        padding-top: 5%;
    }

    .text-heading {
        padding: 0% 30%;
    }

    #firstHeroOriginations {
        margin-top: -5%;
    }

    .navbar {
        background-color: white !important;
    }

    .container {
        max-width: 1800px !important;
    }

    @media screen and (max-width: 991px) {

        .thumbnail {
            width: 100% !important;
        }

        .right {
            padding: 5% 10% !important;
        }

        .bottom-banner-text {
            padding: 0% 10% !important;
        }

        .multi-text {
            padding: 0% 10%;
        }

        .origination-banner {
            padding-right: 0% !important;
        }


        #firstHeroOriginations {
            background-image: none;
        }

        .top-banner-image {
            max-width: 100%;
        }

        .navbar-toggler,
        .navbar-nav {
            display: none !important;
        }

        .tech-support {
            padding-left: 0%;
            text-align: center;
        }

        .text-heading {
            padding: 0% 10%;
        }

        #HeroBanerText {
            padding-top: 10%;
            padding-left: 8%;
            padding-right: 8%;
        }

    }

    .modal-content {
        background-color: transparent !important;
        border: none !important;
    }
</style>
@endsection
@section('content')
<section class="hero-section" id="firstHeroOriginations">
        <div class="banner-container">
            <div class="row hero-row" id="firstHeroRow">
                <div class="col-lg-6 text-center mt-lg-5 banner-graphic">
                    <img class="top-banner-image" src="https://submitmymortgage.com/assets/originations-banner-pic.png"
                        alt="Icon 4">
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center px-lg-5" id="HeroBanerText">
                    <h1 class="hero-title mb-4 origination-banner" style="font-size: 40px; font-weight: bold;">Empowering
                        Mortgage Lenders and Banks for Success</h1>
                    <!-- <h2 style="font-size: 24px; padding-right: 20%;">Empowering Lenders and Streamlining Dreams by Closing More Deals</h2><br> -->
                    <p class="hero-paragraph" style="margin-bottom: 8%; padding-right: 50%;">Elevate Your Mortgage
                        Operations with Our Innovative Software Solutions</p>
                    <div class="cta-container d-flex align-items-center origination-trial-button">
                        <a href="https://submitmymortgage.com/trial"
                            class="origination-get-started btn btn-primary text-white text-decoration-none"
                            style="font-size: 20px;">
                            Start 14 Day Free Trial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="more-than-a-software">
        <div class="text-heading">
            <h3 class="more-than-software">More Than a Software</h3>
            <h1>There is a better way and Submit My Mortgage will give you that advantage.</h1>
        </div>
        <div class="row"> <!-- Added row class to create a flex container -->
            <div class="col-lg-6 mt-lg-5 tech-support">
                <img style="max-width: 98%;" src="https://submitmymortgage.com/assets/teech-suport-in-meeting.jpg"
                    alt="Image description">
            </div>
            <div class="col-lg-6 mt-lg-5"> <!-- Removed text-center class -->
                <div class="multi-text">
                    <div class="individual">
                        <h3><img src="https://submitmymortgage.com/assets/no-more-multiple-meetings.png">No More Multiple
                            Platforms</h3>
                        <p>Access your mortgage and banking business in one place. Every feature you need at your
                            fingertips.</p>
                    </div>
                    <div class="individual">
                        <h3><img src="https://submitmymortgage.com/assets/phone-icon.png">Live Call Support</h3>
                        <p>Contact us anytime from 8 am - 8 pm for instant real- life support. Our team will guide you every
                            step of the way. </p>
                    </div>
                    <div class="individual">
                        <h3><img src="https://submitmymortgage.com/assets/easy-setup.png">Easy Setup Process</h3>
                        <p>Join us and enjoy our user-friendly platform. Maximize the success of your whole mortgage
                            ecosystem with our powerful and easy to use software.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cards-section">
        <h2 style="text-align: center; padding-bottom: 5%; font-size: 40px;">Succeed With Submit Mortgage</h2>
        <div class="card-container-origination">

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="custom-card-origination">
                        <div class="card-body">
                            <img src="https://submitmymortgage.com/assets/one-platform-icon.png">
                            <h5 class="card-title">One Platform,<br><span class="blue-text">Solves Everything</span></h5>
                            <p class="card-text">Never lose out on a deal because of your process or current tools. Submit
                                My Mortgage (SMM) provides you with everything you need to succeed.</p>
                            <a href="/trial"><button class="get-smm">Get SMM Now →</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="custom-card-origination">
                        <div class="card-body">
                            <img src="https://submitmymortgage.com/assets/file-management-icon.png">
                            <h5 class="card-title">Fastest Management,<br><span class="blue-text">Easy to Organize</span>
                            </h5>
                            <p class="card-text">With our intuitive system, you can easily manage all files and team members
                                to complete your deals in record speed.</p>
                            <br>
                            <a href="/trial"><button class="get-smm">Find out more →</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="custom-card-origination">
                        <div class="card-body">
                            <img src="https://submitmymortgage.com/assets/one-platform-icon.png">
                            <h5 class="card-title">Get Notified,<br><span class="blue-text">Never Miss Out</span></h5>
                            <p class="card-text">Increase accuracy and decrease close times with our notification system.
                                Stay up -to - date every step of the way.</p>
                            <br>
                            <a href="/trial"><button class="get-smm">Get SMM Now →</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="custom-card-origination">
                        <div class="card-body">
                            <img src="https://submitmymortgage.com/assets/file-management-icon.png">
                            <h5 class="card-title">Customize the Workflow,<br><span class="blue-text">The Way You
                                    Like</span></h5>
                            <p class="card-text">Create custom flows with ease. Need any help, just call us. </p>
                            <br><br>
                            <a href="/trial"><button class="get-smm">Find out more →</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="originations-bottom-banner">
        <div class="container">
            <div class="row bottom-row">
                <div class="col-lg-6 mt-lg-5 bottom-banner-text">
                    <div class="bottom-text">
                        <h5 class="manage-your-team">Manage Your Team</h5>
                        <h2 class="bottom-banner-h2">Submit My Mortgage helps you to manage your team remotely</h2>
                        <p class="bottom-banner-p">Preview this video to learn how</p>
                        <!-- Replace anchor tag with a button and add an ID -->
                        <button class="video-btn get-smm" data-bs-toggle="modal" data-bs-target="#videoModal">Watch Video
                            →</button>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-5 right">
                    <img data-bs-toggle="modal" data-bs-target="#videoModal" class="video-btn thumbnail"
                        src="https://submitmymortgage.com/assets/submit-thumbnail.png" alt="Image description">
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
        // Wait for the document to load
        document.addEventListener('DOMContentLoaded', function() {
            // Select the button element
            // var openModalButton = document.getElementById('openVideoModal');

            // // Add click event listener to the button
            // openModalButton.addEventListener('click', function() {
            //     // Use Bootstrap's modal function to show the modal
            //     $('#videoModal').modal('show');
            // });
        });
    </script>
@endsection
