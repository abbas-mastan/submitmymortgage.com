@extends('front-pages.front-layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/closing.css')}}">
@endsection
@section('content')
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="heading-text">Seamlessly Close Deals Online with Submit My Mortgage</h1>
            <p class="subheading">Elevate Your Closing Process with Our Integrated Signing and Meeting Tools</p>
            <a href="#" class="cta-button" stlye="color: white !important;">Get Started</a>
        </div>
    </div>
    <div class="about-text">Submit My Mortgage helps all parties in the mortgage ecosystem manage the closing process
        more efficiently leading to more closings. Our platform offers innovative signing and meeting tools that enable
        you to close loans online with ease and convenience.
    </div>
    <h2 class="section-heading">Key Features</h2>
    <section class="four-columns-section">
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/virtual-signing.png') }}" alt="Icon 1"></div>
            <h3 class="heading">Virtual<br>Signing</h3>
            <p class="text">Conduct secure and legally binding document signings online, eliminating the need for
                in-person meetings.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/integrating-meeting-tools.png') }}" alt="Icon 2"></div>
            <h3 class="heading">Integrated Meeting<br>Tools</h3>
            <p class="text">Tailor verification workflows to fit your specific needs and requirements, saving you time
                and effort.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/document-management.png') }}" alt="Icon 3"></div>
            <h3 class="heading">Document<br>Management</h3>
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
    <h2 class="section-heading">Benefits for Users</h2>
    <section class="four-columns-section">
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/effortless-closings.png') }}" alt="Icon 1"></div>
            <h3 class="heading">Effortless<br>Verification</h3>
            <p class="text">Close deals efficiently from anywhere, at any time, eliminating geographical barriers and
                delays in the closing process.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/enhanced-collab.png') }}" alt="Icon 2"></div>
            <h3 class="heading">Enhanced<br>Collaboration</h3>
            <p class="text">Foster collaboration among all parties involved in the closing process, boosting
                communication and transparency.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/time-and-cost-savings.png') }}" alt="Icon 3"></div>
            <h3 class="heading">Time and<br>Cost Savings</h3>
            <p class="text">Reduce the time and costs associated with traditional in-person closings, while increasing
                productivity and deal turnaround time.</p>
        </div>
        <div class="column">
            <div class="icon"><img src="{{ asset('assets/increased-deal-flow.png') }}" alt="Icon 4"></div>
            <h3 class="heading">Increased<br>Deal Flow</h3>
            <p class="text">Close more deals faster by leveraging the convenience and accessibility of online closing
                tools.
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