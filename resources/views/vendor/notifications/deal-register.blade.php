@extends('layouts.empty')
@section('head')
    <style>
        body div:first-child {
            height: 80%;
        }
    </style>
@endsection
@section('content')
    <div class="child mt-24 w-2/3 shadow-2xl bg-white p-10 rounded-2xl">
        <header class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white rounded-t-2xl p-4">
            <h1 class="text-3xl text-center font-bold">Welcome to Submit My Loan</h1>
        </header>
        <form class="my-3" action="{{ url('deal-user-register') }}" method="post">
            @csrf
            <div class="flex flex-col w-full">
                <label for="firstname" class="py-3 text-xl font-bold">First Name</label>
                <input type="text" class="rounded" name="firstname" placeholder="Enter youur first name" id="firstname">
            </div>
            <div class="flex flex-col w-full">
                <label for="lastname" class="py-3 text-xl font-bold">Last Name</label>
                <input type="text" class="rounded" name="lastname" placeholder="Enter youur last name" id="lastname">
            </div>
            <div class="flex flex-col w-full">
                <label for="email" class="py-3 text-xl font-bold">Email</label>
                <input type="text" class="rounded" name="email" placeholder="Enter youur email address" id="email">
            </div>
            <div class="flex flex-col w-full">
                <label for="phone" class="py-3 text-xl font-bold">Phone</label>
                <input type="text" class="rounded" name="phone" placeholder="Enter youur phone address" id="phone">
            </div>
            <button type="submit" class="px-5 py-3 text-white bg-red-700 mt-7 rounded-md">Continue</button>
            <p class="mt-3 font-bold">Alread have an account? <a href="{{url('login')}}" class="text-red-700">Log in!</a></p>
        </form>
    </div>
@endsection
