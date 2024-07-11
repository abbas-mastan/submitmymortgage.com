@extends('layouts.empty')
@section('head')
    <style>
        input[type="password"]::-webkit-input-placeholder {
            font-size: 70%;
        }
    </style>
@endsection
@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Split Screen Example</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Aileron !important;
        }

        .left {
        background-image: url('{{ asset("assets/login-background.png") }}') !important;
        background-position: bottom;
        background-repeat: no-repeat;
            background-color: #5D86EA;
        }

        .right {
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 80%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input[type="text"], 
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .form-p-tags {
font-size: 12px;
        }

        .welcome {
            font-size: 40px;
        }

        .sign-in-text {
            color: white;
padding: 50% 30% 0% 30%;

        }

        .welcome {
            font-weight: bold;
        }

        .form-container h3 {
    text-align: left !important;
    margin-bottom: 20px;
}

.bg-blue {
background-color: #5D86EA !important;
}

.mt-5.button {
    margin-top: 0px !important;
}

    </style>
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-6 left">
                <div class="sign-in-text">
                <h2 class="welcome">Welcome to Submit My Mortgage</h2>
                <p>We’re here to make your life easier.<br>Discover our efficient solutions and simplify your business.</p>
    </div>
            </div>
            <div class="col-6 right">
                <div class="form-container">
                    <h3>Sign In</3>
                    <p class="form-p-tags">Enter your email and password to login to your account.</p>
                    <form action="{{ url('/do-login') }}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="username" class="text-md xl:text-xl opacity-70">Username/Email</label>
                </div>
                <div class="mt-2">
                    <input type="email"
                        class=" text-md xl:text-lg rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="email" id="username" placeholder="&nbsp;&nbsp;Username">
                </div>
            </div>
    
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-md xl:text-xl opacity-70">Password</label>
                </div>
                
                <div class="mt-2">
                    <input type="password"
                        class="xl:text-xl   text-md rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password" id="password" placeholder="&nbsp;&nbsp;***********">
                </div>
            </div>
            <div class="mt-5 button flex justify-center">
                <button type="submit"
                    class="sign-in-button text-md xl:text-xl bg-blue border-2 rounded-md px-10 xl:px-12 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                    Sign In
                </button>
            </div>
            <div class="flex mt-5 align-left">
                <input type="checkbox" class="mt-1" name="remember" id="remember"> <label for="remember"
                    class="text-md xl:text-xl opacity-70">Remember me</label>
            </div>
            <div class="flex mt-3">
                <a href="{{ url('/forgot-password') }}" class="text-md xl:text-xl opacity-70 underline">
                    Forgot Password?
                </a>
            </div>
            <div class="flex mt-3 ">
                    <a href="{{ url('/register') }}">
                        <button type="button"
                            class="text-md  xl:text-xl rounded-md bg-transparent border-2 border-white px-4 xl:px-4 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            Register Here
                        </button>
                    </a>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
</body>

                    <!-- Modal body
                    <div class="relative">
                        <video class="w-[100%]" width="650" height="550" controls autoplay>
                            <source src="video.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
@endsection

@section('foot')
    {{-- <script src="https://cdn.tailwindcss.com/3.2.4"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/tw-elements@1.0.0-beta2/dist/js/tw-elements.umd.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd h-screen');
        });
    </script>
@endsection
