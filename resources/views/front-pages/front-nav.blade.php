<header>
    <nav class="navbar navbar-expand-lg py-4" style="padding-left: 1.5%;">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/logo/logo.svg') }}" class="img-fluid" alt="">
            </a>
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 d-lg-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/platform">Platform</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/verification">Verification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/origination">Origination</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/closing">Closing</a>
                </li>
            </ul>
            <div class="ms-lg-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">LOGIN</a>
                <a href="{{ route('register') }}" class="btn btn-secondary ms-2" type="button">REGISTER</a>
            </div>
        </div>
    </nav>
</header>