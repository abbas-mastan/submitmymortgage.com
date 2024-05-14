@extends('layouts.empty')
@section('content')
    <div class="container">
        <div class="row justify-content-center flex flex-col justify-center items-center h-screen">
            <div class="text-3xl mb-10 text-white">{{ __('Verify Your Email Address') }}</div>
            <div class="bg-gray-100 p-4 rounded-md shadow-2xl">
                @if (session()->has('msg_info'))
                    <div class="p-4 bg-green-100 text-green-800 rounded-md mb-4">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                <p>
                    Please check your email for a verification link.
                </p>
                <br>
                <form class="flex justify-between" action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button class="bg-green-100 text-green-700 px-4 py-1.5 rounded-md"
                        type="submit">{{ __('Request another link') }}</button>
                    <a href="{{ url('logout') }}"
                        class="bg-gray-500 text-white px-4 py-1.5 rounded-md">{{ __('Logout') }}</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd');
        });
    </script>
@endsection
