@extends('front-pages.front-layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/verification.css') }}">
@endsection
@section('content')
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="heading-text">Empowering Mortgage Lenders and Banks for Success</h1>
            <p class="subheading">Elevate Your Mortgage Operations with Our Innovative Software Solutions</p>
            <a href="#" class="cta-button" stlye="color: white !important;">Get Started</a>
        </div>
    </div>
    <div class="about-text">Submit My Mortgage redefines how verifications are conducted. Our platform is designed to
        make your job easier by streamlining verification processes and offering a seamless experience for users.
    </div>
    <h2 class="section-heading">Key Features</h2>
    <section class="four-columns-section">
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/effortless-verification-icon.png') }}" alt="Icon 1"></div>
            <h3 class="heading">Effortless<br>Verification</h3>
            <p class="text">Our platform simplifies the verification process, allowing you to verify information
                quickly and accurately.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/customized-workflows.png') }}" alt="Icon 2"></div>
            <h3 class="heading">Customized<br>Worflows</h3>
            <p class="text">Tailor verification workflows to fit your specific needs and requirements, saving you time
                and effort.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/automated-notifications.png') }}" alt="Icon 3"></div>
            <h3 class="heading">Automated<br>Notifications</h3>
            <p class="text">Receive instant alerts and notifications for pending verifications, ensuring timely
                completion of tasks.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/secure-data-management.png') }}" alt="Icon 4"></div>
            <h3 class="heading">Secure Data<br>Management</h3>
            <p class="text">Rest assured that all data and information are securely managed and protected within our
                platform.
            </p>
        </div>
    </section>
    <section class="four-columns-section">
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/time-saving-efficency.png') }}" alt="Icon 1"></div>
            <h3 class="heading">Effortless<br>Verification</h3>
            <p class="text">With our platform, complete verifications in a fraction of the time it traditionally
                takes, optimizing your workflow and productivity.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/targeted.png') }}" alt="Icon 2"></div>
            <h3 class="heading">Customized<br>Worflows</h3>
            <p class="text">Reduce errors and inaccuracies through automated verification processes, ensuring reliable
                results every time.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/improved-ux.png') }}" alt="Icon 3"></div>
            <h3 class="heading">Automated<br>Notifications</h3>
            <p class="text">Enjoy a user-friendly interface that simplifies the verification process, making it
                intuitive and easy to navigate.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/cost-effective.png') }}" alt="Icon 4"></div>
            <h3 class="heading">Secure Data<br>Management</h3>
            <p class="text">Save on operational costs and resources by utilizing our platform for efficient
                verifications.
            </p>
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