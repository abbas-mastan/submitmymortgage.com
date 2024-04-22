@extends('layouts.empty')
@section('head')
    <style>
        input[type="password"]::-webkit-input-placeholder {
            font-size: 70%;
        }
    </style>
@endsection
@section('content')
    <div class="bg-white rounded-md p-5">
        @isset($msg_trial)
            <div class="bg-green-300 text-green-800 px-5 py-2 text-normal text-center">
                {!! $msg_trial !!}
            </div>
        @endisset
        <form id="payment-form" class="main-form require-validation" action="{{ route('stripePayment') }}" method="post">
            <div class="form-inp-div stripe-div d-none">
                <div class="ps-2 " id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display Element errors. -->
                <div class="ps-2 text-danger" id="card-errors" role="alert"></div>
            </div>
        </form>
        <div class="flex justify-between align-items-center mt-5">
            <a href="/continue-to-premium" class="px-4 py-1.5 text-white bg-blue-500">Yes</a>
            <a href="/logout" class="px-4 py-1.5 text-white bg-red-500">NO</a>
        </div>
    </div>
@endsection
@section('foot')
    <script src="https://cdn.tailwindcss.com/3.2.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@1.0.0-beta2/dist/js/tw-elements.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('h-[100vh] bg-gradient-to-b from-gradientStart to-gradientEnd');
        });
    </script>
@endsection
