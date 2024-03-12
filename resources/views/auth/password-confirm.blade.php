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
                Verify that <br> it's you
            </h1>
        </div>
        <form action="{{ url(getRoutePrefix().'/confirm-password') }}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
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
                <div class="col-span-4 ml-1 ">
                    <button type="submit"
                        class="  text-md xl:text-xl  border-2 border-white rounded-md bg-white px-10 xl:px-12 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        Verify
                    </button>
                </div>
            </div>
        </form>
        <!--Verically centered modal-->
    </div>
@endsection
@section('foot')
    <script src="https://cdn.tailwindcss.com/3.2.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@1.0.0-beta2/dist/js/tw-elements.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd h-screen');
        });
    </script>
@endsection
