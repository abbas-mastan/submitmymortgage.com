@extends('front-pages.front-layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/platform.css') }}">
@endsection
@section('content')
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="heading-text">Simplifying Mortgage Deals and Closing Processes</h1>
            <!-- <p class="subheading">Elevate Your Mortgage Operations with Our Innovative Software Solutions</p> -->
            <a href="#" class="cta-button" style="color: white !important;">Get Started</a>
        </div>
    </div>
    <section class="why-we-care-section">
        <div class="text-image-section" id="image-on-right-desktop"> <!-- Add an ID to identify the section -->
            <div class="text-container">
                <h2 class="section-title">Streamlined Closing Process</h2>
                <p class="section-text">Our software facilitates smoother and quicker closing deals, making the mortgage
                    process efficient and transparent.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Borrowers:</h3>
                <p class="section-text">Borrowers experience a hassle-free experience with faster approval and
                    simplified documentation processes.</p>
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
                <h2 class="section-title">Streamlined Closing Process</h2>
                <p class="section-text">Our software facilitates smoother and quicker closing deals, making the mortgage
                    process efficient and transparent.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Borrowers:</h3>
                <p class="section-text">Borrowers experience a hassle-free experience with faster approval and
                    simplified documentation processes.</p>
            </div>
        </div>
        <div class="text-image-section">
            <div class="image-container">
                <img src="{{ asset('assets/second-image.jpg') }}" alt="Image Description">
            </div>
            <div class="text-container">
                <h2 class="section-title">Enhanced Borrower Services</h2>
                <p class="section-text">Borrowers benefit from our software's streamlined services, providing them with
                    easy access to important loan-related information and updates.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Companies:</h3>
                <p class="section-text">Companies can offer improved borrower experiences, leading to increased customer
                    satisfaction and loyalty.</p>
            </div>
        </div>
        <div class="text-image-section" id="image-on-right-desktop"> <!-- Add an ID to identify the section -->
            <div class="text-container">
                <h2 class="section-title">Centralized Loan Management System</h2>
                <p class="section-text">With our software, companies and employees gain access to a centralized system
                    where all loan-related information and documents are stored securely.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Company Employees:
                </h3>
                <p class="section-text">Employees can easily track, manage, and retrieve loan-related data, enhancing
                    productivity and reducing errors in loan processing therefore allowing enhancing overall company
                    operations.and loyalty.</p>
            </div>
            <div class="image-container">
                <img src="{{ asset('assets/centralized-loan.jpg') }}" alt="Image Description">
            </div>
        </div>
        <div class="text-image-section" id="image-on-right-mobile">
            <div class="image-container">
                <img src="{{ asset('assets/centralized-loan.jpg') }}" alt="Image Description">
            </div>
            <div class="text-container">
                <h2 class="section-title">Centralized Loan Management System</h2>
                <p class="section-text">With our software, companies and employees gain access to a centralized system
                    where all loan-related information and documents are stored securely.</p>
                <h3 style="font-family: Montserrat; padding-top: 2%; font-size: 15px;">Benefits for Company Employees:
                </h3>
                <p class="section-text">Employees can easily track, manage, and retrieve loan-related data, enhancing
                    productivity and reducing errors in loan processing therefore allowing enhancing overall company
                    operations.and loyalty.</p>
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
