@extends('front-pages.front-layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endsection
@section('content')
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="heading-text">Empowering Mortgage Lenders and Banks for Success</h1>
            <p class="subheading">Elevate Your Mortgage Operations with Our Innovative Software Solutions</p>
            <a href="#" class="cta-button" stlye="color: white !important;">Get Started</a>
        </div>
    </div>
    <div class="about-text">At Submit My Mortgage, we are dedicated to revolutionizing the mortgage industry through our
        cutting-edge software solutions. Our team works diligently to provide mortgage lenders and banks with the tools
        and support they need to enhance their operations and deliver unparalleled service to borrowers.
    </div>
    <div class="hero-banner-2">
        <div class="hero-content-2">
            <h1>Our Mission</h1>
            <p>Our mission is to empower mortgage lenders and banks with innovative technology that streamlines
                processes, improves efficiency, and ultimately leads to successful outcomes for borrowers. We believe
                that by equipping our clients with the best solutions, we can help them achieve their goals and make a
                positive impact on the lives of consumers.</p>
        </div>
    </div>
    <section class="commitment-section">
        <h2 class="section-heading">Our Commitment</h2>
        <div class="commitment-container">
            <div class="commitment-box">
                <div class="cbox-content">
                    <div class="cbox-title">
                        Enhanced Efficiency
                    </div>
                    <p class="cbox-text">
                        We are committed to helping our clients streamline their operations, reduce manual tasks, and
                        increase productivity. Our software is designed to optimize processes and workflows, allowing
                        lenders and banks to serve borrowers more effectively and efficiently.
                    </p>
                </div>
            </div>
            <div class="commitment-box">
                <div class="cbox-content">
                    <div class="cbox-title">
                        Customer-Centric Approach
                    </div>
                    <p class="cbox-text">
                        We prioritize the borrower experience by providing lenders and banks with tools that enhance
                        communication, transparency, and responsiveness. By putting consumers first, our clients can
                        build stronger relationships and drive positive outcomes for all parties involved.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="why-we-care-section">
        <h2 class="section-heading">Why We Care</h2>
        <div class="text-image-section" id="image-on-right-desktop"> <!-- Add an ID to identify the section -->
            <div class="text-container">
                <h2 class="section-title">Empowering Success</h2>
                <p class="section-text">We understand that the success of mortgage lenders and banks directly impacts
                    the lives of borrowers and consumers. By supporting our clients in achieving their business
                    objectives, we are contributing to the realization of homeownership dreams and financial stability
                    for individuals and families.</p>
            </div>
            <div class="image-container">
                <img src="{{ asset('assets/first-image.jpg') }}" alt="Image Description">
            </div>
        </div>
        <div class="text-image-section" id="image-on-right-mobile">
            <div class="image-container">
                <img src="{{ asset('assets/first-image.jpg') }}" alt="Image Description">
            </div>
            <div class="text-container">
                <h2 class="section-title">Empowering Success</h2>
                <p class="section-text">We understand that the success of mortgage lenders and banks directly impacts
                    the lives of borrowers and consumers. By supporting our clients in achieving their business
                    objectives, we are contributing to the realization of homeownership dreams and financial stability
                    for individuals and families.</p>
            </div>
        </div>
        <div class="text-image-section">
            <div class="image-container">
                <img src="{{ asset('assets/second-image.jpg') }}" alt="Image Description">

            </div>
            <div class="text-container">
                <h2 class="section-title">Driving Results</h2>
                <p class="section-text">A successful partnership with Submit My Mortgage translates into improved loan
                    origination processes, faster approvals, and better customer satisfaction. The ripple effect of
                    these achievements is felt by borrowers who experience a seamless and rewarding mortgage journey.
                </p>
            </div>
        </div>
        <div class="text-image-section" id="image-on-right-desktop"> <!-- Add an ID to identify the section -->
            <div class="text-container">
                <h2 class="section-title">Partner With Us for a Brighter Future</h2>
                <p class="section-text">Our team is always pushing the boundaries and looking for better ways to help
                    everyone in our ecosystem including borrowers, loan officers, underwriters, and their mortgage
                    companies. Partner with us and let’s create a better future.</p>
            </div>
            <div class="image-container">
                <img src="{{ asset('assets/first-image.jpg') }}" alt="Image Description">
            </div>
        </div>
        <div class="text-image-section" id="image-on-right-mobile">
            <div class="image-container">
                <img src="{{ asset('assets/first-image.jpg') }}" alt="Image Description">

            </div>
            <div class="text-container">
                <h2 class="section-title">Partner With Us for a Brighter Future</h2>
                <p class="section-text">Our team is always pushing the boundaries and looking for better ways to help
                    everyone in our ecosystem including borrowers, loan officers, underwriters, and their mortgage
                    companies. Partner with us and let’s create a better future.</p>
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
