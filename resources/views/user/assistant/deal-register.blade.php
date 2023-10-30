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
        <form class="my-3" action="{{ url(getAssistantRoutePrefix() . '/register-assistant/'.$user->id) }}" method="post">
            @csrf
            <div class="flex flex-col w-full">
                <label for="name" class="py-3 text-xl font-bold">Full Name</label>
                <input type="text" class="rounded" name="name"  value="{{old('name')}}" placeholder="Enter your Full name" id="name">
                @error('name')
                    <span class="text-red-700">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col w-full">
                <label for="email" class="py-3 text-xl font-bold">Email</label>
                <input type="text" class="rounded" name="email" value="{{ $user->email }}" disabled
                    placeholder="Enter youur email address" id="email">
            </div>
            <div class="flex flex-col w-full">
                <label for="phone" class="py-3 text-xl font-bold">Phone</label>
                <input type="text" class="rounded" value="{{old('phone')}}" name="phone" placeholder="Enter your phone address" id="phone">
                @error('phone')
                    <span class="text-red-700">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col w-full">
                <label for="password" class="py-3 text-xl font-bold">password</label>
                <input type="password" class="rounded" name="password" placeholder="Enter your password" id="password">
                @error('password')
                    <span class="text-red-700">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col w-full">
                <label for="password_confirmation" class="py-3 text-xl font-bold">Confirm Password</label>
                <input type="password" class="rounded" name="password_confirmation"
                    placeholder="Enter your confirm password " id="password_confirmation">
            </div>
            <button type="submit" class="px-5 py-3 text-white bg-red-700 mt-7 rounded-md">Continue</button>
            <p class="mt-3 font-bold">Already have an account? <a href="{{ url('login') }}" class="text-red-700">Log
                    in!</a></p>
        </form>
    </div>
@endsection
