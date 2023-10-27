@extends('layouts.empty')
@section('head')
    <style>
        input[type="password"]::-webkit-input-placeholder {
            font-size: 70%;
        }
    </style>
@endsection
@section('content')
    <div class="mx-auto w-full sm:w-1/2 md:w-1/3 mt-28 mb-10">
        <div class="">
            <h1 class="xl:text-3xl text-2xl uppercase text-center font-bold text-white">
                Welcome To <br> Submit My Mortgage
            </h1>
        </div>
        <div class="text-center mt-5">
            <span class="text-lg xl:text-2xl text-white">
                Sign up / Login
            </span>
        </div>
        <form action="{{ url('/do-login') }}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="username" class="text-white text-md xl:text-xl opacity-70">Username/Email</label>
                </div>
                <div class="mt-2">
                    <input type="email"
                        class=" text-md xl:text-lg rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="email" id="username" placeholder="&nbsp;&nbsp;Username">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-white text-md xl:text-xl opacity-70">Password</label>
                </div>
                <div class="mt-2">
                    <input type="password"
                        class="xl:text-xl   text-md rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password" id="password" placeholder="&nbsp;&nbsp;***********">
                </div>
            </div>
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4">
                    <input type="checkbox" class=" " name="remember" id="remember"> <label for="remember"
                        class="text-white text-md xl:text-xl opacity-70">Remember me</label>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 pl-5">
                    <a href="{{ url('/forgot-password') }}" class="text-white text-md xl:text-xl opacity-70 underline">
                        Forgot Password?
                    </a>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit"
                        class="  text-md xl:text-xl  border-2 border-white rounded-md bg-white px-10 xl:px-12 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        Sign In
                    </button>
                </div>
            </div>
            <div class="mt-2  grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <a href="{{ url('/register') }}">
                        <button type="button"
                            class="  text-md  xl:text-xl text-white rounded-md bg-transparent border-2 border-white px-4 xl:px-4 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            Register Here
                        </button>
                    </a>
                </div>
            </div>
        </form>
        <footer style="margin-top:239px">
            <a href="/privacy-policy" class="border p-2 bg-gray-300">Privacy Policy</a>
            <button data-te-toggle="modal" data-te-target="#exampleModalCenter" data-te-ripple-init
                data-te-ripple-color="light" type="button" class="border p-1 bg-gray-300">Demo Video</a>
        </footer>
        <!--Verically centered modal-->
        <div data-te-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true"
            role="dialog">
            <div data-te-modal-dialog-ref
                class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md">
                        <!--Modal title-->
                        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                            id="exampleModalScrollableLabel">
                        </h5>
                        <!--Close button-->
                        <button type="button"
                            class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-te-modal-dismiss aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!--Modal body-->
                    <div class="relative">
                        <video class="w-[100%]" width="650" height="550" controls autoplay>
                            <source src="video.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot')
    <script src="https://cdn.tailwindcss.com/3.2.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@1.0.0-beta2/dist/js/tw-elements.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd');
        });
    </script>
@endsection
