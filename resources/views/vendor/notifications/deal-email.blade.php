@extends('layouts.empty')
@section('content')
    <div class="m-10">
        <div class="child flex-col justify-center mt-5 shadow-2xl bg-white w-full p-10">
            <header class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white rounded-t-2xl p-4">
                <h1 class="text-3xl text-center font-bold">You've Been Added as a Team Member on a Submit My Mortgage Deal!</h1>
            </header>
            <p class="text-2xl font-bold p-8 text-center">
                <span class="block mb-2">
                    {{-- Dear {{ $user->name ?? "" }} --}}
                </span>
                <br>
                This is an important step in
                completing your mortgage application.
                <br><br>
                Click the link below to begin adding the necessary files to complete your mortgage deal:
            </p>
            <div class="flex justify-center">
                <a href="{{$url}}" class="block w-40 text-white py-3 px-5 text-lg font-bold bg-red-700 rounded-md text-center">Get
                    Started</a>
            </div>
            <p class="text-2xl font-bold p-8 text-center">
                if you have any quries or need assistance, please don't hesitate to reach out to our support team.
                <br><br>
                Thank you for choosing Submit My Mortgeage!
            </p>
        </div>
    </div>
@endsection
