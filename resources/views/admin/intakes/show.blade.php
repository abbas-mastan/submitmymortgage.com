@extends('layouts.app')
@section('head')
    <style>
        input[type=text]:focus {
            margin-bottom: 2px;
        }

        textarea:focus {
            margin-bottom: 2px;
        }

        .text-red-700 {
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="w-3/4 mt-10 mx-auto">
        <div class="">
            <h1 class="text-xl font-bold capitalize text-center">
                Loan Intake Information
            </h1>
        </div>
    <x-form.intake-form :intake="$intake"/>
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/intake.js') }}"></script>
    <script>
        @if ($intake->loan_type)
            changeLoantype(@json($intake->loan_type));
        @endif
        $(".intakeForm :input").prop("disabled", true);
        $(".intakeFormSubmit").remove();
    </script>
@endsection
