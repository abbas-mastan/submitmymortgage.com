@extends('layouts.empty')
@section('content')
    <div class="m-10">
        <div class="child flex-col justify-center mt-5 shadow-lg bg-white w-full p-10">
            <header class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white rounded-t-2xl p-4">
                <h1 class="text-3xl text-center font-bold">You've Been Added as a Team Member on a Submit My Loan Deal!</h1>
            </header>
            <p class="text-2xl font-bold p-8 text-center">
                <span class="block mb-2">
                    Dear {{ $user->name ?? "Borrower's Name" }}
                </span>
                <br>
                Congratulations! You've been added as a team member on a Submit My Loan deal. This is an important step in
                completing your mortgage application.
                <br><br>
                Click the link below to begin adding the necessar files to complete your mortgage deal:
            </p>
            <div class="flex justify-center">
                <a class="block w-40 text-white py-3 px-5 text-lg font-bold bg-red-700 rounded-md text-center">Get
                    Started</a>
            </div>
            <p class="text-2xl font-bold p-8 text-center">
                if you have nay quuesitons or need assistance, please don't hesitate to read out to our support team.
                <br><br>
                Thank you for choosing Submit My Loan!
            </p>
        </div>
    </div>
@endsection
