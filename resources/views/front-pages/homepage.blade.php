@extends('front-pages.front-layout')
@section('content')
        <!-- hero section -->
        <section class="hero-section" id="firstHero">
            <div class="container">
                <div class="row hero-row" id="firstHeroRow">
                    <div class="col-xl-7 col-xxl-6" id="firstHeroText">
                        <h1 class="hero-title mb-4">Revolutionize Mortgage Lending with Submit My Mortgage</h1>
                        <p class="hero-paragraph" style="margin-bottom: 8%;">Streamline verification of mortgage
                            documents and shorten
                            processing<br class="d-none d-md-block" />
                            times, enforce standardization and compliance, and improve<br class="d-none d-md-block" />
                            productivity and customer satisfaction.</p>
                        <a href="/trial" class="trial-button text-white text-decoration-none">
                            Start 7 Day Free Trial
                        </a>
                    </div>
                    <!-- <div class="col"></div> -->
                </div>
            </div>
        </section>
        <div class="column-title">
            <h2>
                <span style="font-size: 20px !important;">Change Your Perspective, Change Your Business:</span><br>
                <span>A New Era of Mortgage Management</span>
            </h2>
        </div><br>
        <section class="three-column-section">
            <div class="column">
                <h2 class="column-heading">+40% in<br>efficiency</h2>
                <div class="icon"><img src="{{ asset('assets/efficiency-icon.png') }}" alt="Icon 1"></div>
                <h3 class="subheading">Efficiency</h3>
                <p class="description">Boost your lending efficiency by up to 40%, ensuring quicker turnarounds on loan
                    applications.</p>
            </div>
            <div class="column">
                <h2 class="column-heading">+95% in error reduction</h2>
                <div class="icon"><img src="{{ asset('assets/precision-icon.png') }}" alt="Icon 2"></div>
                <h3 class="subheading">Precision</h3>
                <p class="description">Experience an error reduction of 95%, ensuring precise document management and
                    compliance at every step.</p>
            </div>
            <div class="column">
                <h2 class="column-heading">+30% increase in closed loans</h2>
                <div class="icon"><img src="{{ asset('assets/competitive-icon.png') }}" alt="Icon 3"></div>
                <h3 class="subheading">Competitive</h3>
                <p class="description">Stay ahead in the market with our cutting-edge technology, leading to a minimum
                    30% increase in closed loans compared to traditional systems.</p>
            </div>
        </section>
        <br><br>


        <!-- Second Hero Banner Section -->
        <section class="hero-section-2 second-hero-banner" style="border: 1px solid black;">
            <div class="container">
                <div class="row hero-row">
                    <div class="col-md-6">
                        <h1 class="hero-title-2 main-heading">Mortgage Documents Verification</h1>
                        <h2 class="hero-subtitle sub-heading">Empowering Lenders and Streamlining Dreams by Closing More
                            Deals</h2>
                        <p class="hero-paragraph hero-text">Submit My Mortgage is the ultimate solution for banks and
                            lenders, designed to transform the mortgage process, from loan preapproval to seamless
                            closing. Discover a new era of speed, precision, and unparalleled customer satisfaction.</p>
                        <!-- Use an event listener to trigger openCalendly() once the page is fully loaded -->
                        <a href="#" id="requestDemoBtn" class="btn btn-primary-2">Request a Demo</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Calendly badge widget begin -->
        <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
        <script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
        <script type="text/javascript">
            window.onload = function() {
                Calendly.initBadgeWidget({
                    url: 'https://calendly.com/submitmymortgage/30min',
                    text: 'Schedule time with me',
                    color: '#0069ff',
                    textColor: '#ffffff',
                    branding: true
                });
            }
        </script>
        <!-- Calendly badge widget end -->

        <!-- why choose us new -->
        <div class="column-title">
            <h2>Why Choose Us</h2>
        </div>
        <section class="three-column-section">
            <div class="column">
                <div class="icon"><img src="{{ asset('assets/instant-preapproval.png') }}" alt="Icon 1"></div>
                <h3 class="subheading">Instant Loan<br>Approval</h3>
                <p class="description">Accelerate the journey from application to approval<br><br>
                    Provide borrowers with swift and accurate preapproval decisions<br><br>
                    Boost customer satisfaction with lightning-fast responses.</p>
            </div>
            <div class="column">
                <div class="icon"><img src="{{ asset('assets/document-management.png') }}" alt="Icon 2"></div>
                <h3 class="subheading">streamlined Document Management:</h3>
                <p class="description">Simplify the complexities of document handling.<br><br>
                    Centralize and organize all necessary documents securely.<br><br>
                    Ensure a smooth and compliant process with our intuitive system.</p>
            </div>
            <div class="column">
                <div class="icon"><img src="https://submitmymortgage.com/assets/client-communication.png"
                        alt="Icon 3"></div>
                <h3 class="subheading">Client<br>Communication Tools</h3>
                <p class="description">Foster transparent and efficient communication.<br><br>
                    Enhance collaboration between lenders and borrowers.<br><br>
                    Minimize delays with real-time messaging and updates.
                </p>
            </div>
        </section>
        <!-- see what our customers say -->
        <section class="customers-review" style="margin-top: 100px !important;">
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

                    <div class="col-xl-12 left" style="padding-top: 10%;">
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
   @endsection