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
                Loan Application
            </h1>
        </div>
        <x-form.intake-form :intake="$intake" :enableTeams="$enableTeams" />
    </div>
@endsection
@section('foot')
<script>
    var routePrefix = @json(getRoutePrefix());
</script>
    <script src="{{ asset('js/intake.js') }}"></script>
    <script>
        @if ($intake->finance_type)
            changeLoantype(@json($intake->finance_type));
        @endif
        @if ($intake->co_borrower_name)
            borrowerPresent();
        @endif
        $(".teamDiv").addClass('hidden');
        $(".companyDiv").addClass('hidden');
        // Create the input element as a string
        var userInput = '<input type="number" class="hidden" name="user_id" value="{{ $intake->user_id }}" />';
        var emailInput = '<input type="email" class="hidden" name="email" value="{{ $intake->email }}" />';
        // Append the input element to the .intakeForm
        $('.intakeForm').append(userInput);
        $('.intakeForm').append(emailInput);


        $("#email").prop("disabled", true);
        $("#email").addClass("cursor-not-allowed");
            $(".intakeFormSubmit").parent().addClass('justify-center');


        // @if (auth()->user()->role !== 'Borrower')
        //     $(".intakeForm :input").prop("disabled", true);
        //     $(".intakeFormSubmit").remove();
        // @endif
    </script>
@endsection
