@extends('front-pages.front-layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/origination.css') }}">
@endsection
@section('content')
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="heading-text">Transforming Mortgage Originations for Success</h1>
            <a href="#" class="cta-button" stlye="color: white !important;">Get Started</a>
        </div>
    </div>
    <div class="about-text">Our software offers a groundbreaking approach to mortgage originations, benefiting
        borrowers, underwriters, loan officers, and the overall bottom line of your company. Submit My Mortgage will
        completely alter the existing process you have, by enhancing efficiency and profitability for all stakeholders.
        Our goal is the same as yours – a better experience for more growth. There is a better way and Submit My
        Mortgage will give you and your team a strategic advantage.</div>

    <section class="why-we-care-section">

        <div class="text-image-section" id="image-on-right-desktop"> <!-- Add an ID to identify the section -->
            <div class="text-container">
                <h2 class="section-title">Enhanced Borrower Experience</h2>
                <p class="section-text">Our software provides borrowers with a seamless and transparent
                    origination process, enabling them to navigate their mortgage journey with ease and
                    confidence.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Borrowers:</h3>
                <p class="section-text">Enhanced communication, faster processing times, and a
                    user-friendly experience from application to closing.</p>
            </div>
            <div class="image-container">
                <img src="{{ asset('assets/borrowers.jpg') }}" alt="Image Description">
            </div>
        </div>

        <div class="text-image-section" id="image-on-mobile">
            <div class="image-container">
                <img src="{{ asset('assets/borrowers.jpg') }}" alt="Image Description">
            </div>
            <div class="text-container">
                <h2 class="section-title">Enhanced Borrower Experience</h2>
                <p class="section-text">Our software provides borrowers with a seamless and transparent origination
                    process, enabling them to navigate their mortgage journey with ease and confidence.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Borrowers:</h3>
                <p class="section-text">Enhanced communication, faster processing times, and a
                    user-friendly experience from application to closing.</p>
            </div>
        </div>

        <div class="text-image-section">
            <div class="image-container">
                <img src="{{ asset('assets/loan-officers.jpg') }}" alt="Image Description">
            </div>
            <div class="text-container">
                <h2 class="section-title">Empowered Underwriters and Loan Officers</h2>
                <p class="section-text">Empower underwriters and loan officers with advanced tools and
                    automation capabilities to streamline their tasks and make informed decisions for
                    efficient loan processing.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Underwriters and
                    Loan Officers:</h3>
                <p class="section-text">Increased productivity, reduced manual
                    tasks, and better risk assessment for improved decision-making.</p>
            </div>
        </div>


        <div class="text-image-section" id="image-on-right-desktop"> <!-- Add an ID to identify the section -->
            <div class="text-container">
                <h2 class="section-title">Boosting the Company's Bottom Line</h2>
                <p class="section-text">Our software revolutionizes mortgage originations, leading to cost
                    savings, faster turnarounds, and increased profitability for your company.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for the Company:</h3>
                <p class="section-text">Improved operational efficiency, reduced risks, and
                    enhanced customer satisfaction that positively impacts the bottom line.</p>
            </div>
            <div class="image-container">
                <img src="{{ asset('assets/bottom-line.jpg') }}" alt="Image Description">
            </div>
        </div>

        <div class="text-image-section" id="image-on-mobile">
            <div class="image-container">
                <img src="{{ asset('assets/bottom-line.jpg') }}" alt="Image Description">
            </div>
            <div class="text-container">
                <h2 class="section-title">Boosting the Company's Bottom Line</h2>
                <p class="section-text">Our software revolutionizes mortgage originations, leading to cost
                    savings, faster turnarounds, and increased profitability for your company.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for the Company:</h3>
                <p class="section-text">Improved operational efficiency, reduced risks, and
                    enhanced customer satisfaction that positively impacts the bottom line..</p>
            </div>

        </div>
    </section>
    <div class="hero-banner-3">
        <div class="hero-content-3">
            <h1>Experience the Advantage of Submit My Mortgage</h1>
            <p>From streamlined closing deals to enhanced borrower services, our software simplifies mortgage processes
                for companies and their employees.</p>
            <div class="button-box">
                @include('front-pages.trial-button')
            </div>
        </div>
    </div>
@endsection
