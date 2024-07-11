@extends('front-pages.front-layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/closing.css')}}">
@endsection
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        html {
            font-family: Aileron !important;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            width: 100%;
        }

        .banner {
            width: 100%;
            padding: 15% 35%;
            max-width: 1920px;
            /* height: 823px; */
            background-image: url('https://submitmymortgage.com/assets/top-closing-banner.jpg');
            background-position: center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: auto;
            /* padding: 20px; */
        }

        .banner h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .form-inline {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 600px;
        }

        .form-inline input {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-inline button {
            padding: 10px 20px;
            background-color: #2F5BEA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .computer-section {
            padding-top: 8% !important;
            width: 100%;
            max-width: 1400px;
            margin: auto;
            text-align: center;
            padding: 20px;
        }

        .computer-section-text {
            padding: 0% 5%;
        }

        .computer-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .left, .right {
            margin: auto;
            text-align: left;
            flex: 1;
        }

        .middle {
            flex: 2;
            text-align: center;
        }

        .benefits-for-user {
            padding-top: 25%;
            width: 100%;
            max-width: 1400px;
            margin: auto;
            padding: 20px;
        }

        .benefits-for-users {
            font-size: 2rem;
        }

        .image-container {
            text-align: center;
            padding: 20px;
        }

        .four-section {
            padding-top: 5%;
        }

        .computer-p {
            padding-bottom: 5%;
        }

        .bottom-sign-up {
            background-image: url('https://submitmymortgage.com/assets/closing-bottom.png'); 
            background-size: cover;
        }

        .text-container {
            padding: 20% 30%;
            text-align: center;
        }

        .sign-up-section {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        .title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .subtitle {
            font-size: 1rem;
            color: #777;
            margin-bottom: 30px;
        }

        .sign-up-form .input-group {
            position: relative;

        }

        .sign-up-form .input-group input {
            width: 100%;
            padding: 15px 20px;
            font-size: 30px;
            border: 1px solid #ddd;
            border-radius: 25px;
        }

        .sign-up-form .submit-button {
            width: 100%;
            padding: 15px 20px;
            font-size: 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

.container {
max-width: 1800px;
}

        .sign-up-form .submit-button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .navbar-toggler, .navbar-nav {
        display: none !important;
    }

            .left {
                padding-bottom: 5%;
            }

            .right {
                padding-top: 5%;
            }
            .bottom-sign-up {
                padding: 10%;
            }

            .banner {
                height: auto;
                padding: 30% 10%;
            }

            .banner h2 {
                font-size: 1.5rem;
            }

            .computer-section, .benefits-for-user {
                padding-top: 5%;
            }

            .computer-section-text, .text-container {
                padding: 0 10%;
            }

            .form-inline {
                flex-direction: column;
            }

            .form-inline input, .form-inline button {
                width: 100%;
                margin: 5px 0;
            }

            .benefits-for-users {
                font-size: 1.5rem;
            }

            .four-section .col-lg-3 {
                margin-bottom: 20px;
            }

            .computer-container {
                flex-direction: column;
            }

            .left, .middle, .right {
                flex: none;
                text-align: center;
            }

            .middle img {
                width: 100%;
                height: auto;
            }
        }

        .form-header {
font-weight: bold;
        }

.benefits-text{
    padding-top: 10%;
}

.top-button {
    font-size: 20px;
    color: white !important;
}

.top-button:hover {
    color: white !important;
}

.fourteen-trial:hover {
background: transparent;
border: 2px solid #2F5BEA;
}

.fourteen-trial:hover a.top-button {
color:  #2F5BEA !important;
}

    </style>
</head>
<body>
    <div class="banner">
        <h2 class="form-header">Seamlessly Close Deals Online with Submit My Mortgage</h2>
        <form class="form-inline">
            <button type="submit" class="fourteen-trial" class="btn"><a class="top-button" href="/trial">Start 14 Day Trial!</a></button>
        </form>
    </div>

    <section class="computer-section">
        <div class="computer-section-text">
            <h3 class="computer-heading">How Our System Helps You Close More Loans</h3>
            <p class="computer-p">Submit My Mortgage helps all parties in the mortgage ecosystem manage the closing process more efficiently leading to more closings. Our platform offers innovative signing and meeting tools that enable you to close loans online with ease and convenience.</p>
        </div>
        <div class="computer-container">
            <div class="left">
                <h2 style="font-size: 20px;"><img src="https://submitmymortgage.com/assets/check-mark.png"> Virtual Signing</h2>
                <p>Conduct secure and legally binding document signings online, eliminating the need for in-person meetings</p>
                <h2 style="font-size: 20px;"><img src="https://submitmymortgage.com/assets/check-mark.png"> Integrated Meeting Tools</h2>
                <p>Tailor verification workflows to fit your specific needs and requirements, saving you time and effort. </p>
            </div>
            <div class="middle">
                <img src="https://submitmymortgage.com/assets/laptop.png" class="img-fluid">
            </div>
            <div class="right">
                <h2 style="font-size: 20px;"><img src="https://submitmymortgage.com/assets/check-mark.png"> Document Management</h2>
                <p>Receive instant alerts and notifications for pending verifications, ensuring timely completion of tasks. </p>
                <h2 style="font-size: 20px;"><img src="https://submitmymortgage.com/assets/check-mark.png"> Secure Data Management </h2>
                <p>Rest assured that all data and information are securely managed and protected within our platform. </p>
            </div>
        </div>
    </section>

    <section class="benefits-for-user">
        <div class="row bottom-row">
            <div class="col-lg-6 mt-lg-5">
                <div class="benefits-text">
                    <h2 class="benefits-for-users">Benefits for Users</h2>
                    <p class="bottom-banner-p">Our software offers a groundbreaking approach to mortgage closings, benefiting borrowers, underwriters, loan officers, and the overall bottom line of your company. Submit My Mortgage will completely alter the existing process you have, by enhancing efficiency and profitability for all stakeholders. Our goal is the same as yours – a better experience for more growth.</p>
                </div>
            </div>
            <div class="col-lg-6 mt-lg-5 image-container">
                <img class="thumbnail img-fluid" src="https://submitmymortgage.com/assets/lower-image.jpg" alt="Image description">
            </div>
        </div>
        <div class="row four-section">
            <div class="col-lg-3">
                <h4>Effortless Verification</h4>
                <p>Close deals efficiently from anywhere, at any time, eliminating geographical barriers and delays in the closing process.</p>
            </div>
            <div class="col-lg-3">
                <h4>Enhanced Collaboration</h4>
                <p>Foster collaboration among all parties involved in the closing process, boosting communication and transparency.</p>
            </div>
            <div class="col-lg-3">
                <h4>Time and Cost Savings</h4>
                <p>Reduce the time and costs associated with traditional in-person closings, while increasing productivity, and deal turnaround time.</p>
            </div>
            <div class="col-lg-3">
                <h4>Increased Deal Flow</h4>
                <p>Close more deals faster by leveraging the convenience and accessibility of online closing tools.</p>
            </div>
        </div>
    </section>

    <section>
        <div class="bottom-sign-up">
            <div class="text-container">
                <h2 class="title">Experience the Advantage of Submit My Mortgage</h2>
                <p class="subtitle">From streamlined closing deals to enhanced borrower services, our software simplifies mortgage processes for companies and their employees.</p>
                <form class="sign-up-form">
                
                    <button type="submit" class="submit-button"><a href="https://submitmymortgage.com/trial" style="color: white !important;">Get 14 Day Free Trial</a></button>
</form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

@endsection