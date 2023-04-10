@extends('layouts.app')
@section('content')
<div class="flex flex-wrap flex-shrink-0">
    <div class="w-full md:w-1/4 sm:w-1/3  mx-2 my-2">
        <div class="w-full h-44 " >
            <div class="flex h-32 bg-gradient-to-r from-gradientStart to-gradientEnd">
                <div class="w-1/2 p-4 pl-8">
                    <span class="text-gray-200 text-lg block text-center -ml-16">Teachers</span>
                    <span class="text-gray-200 text-2xl block text-center font-bold mt-1  -ml-16">03</span>
                </div>
                <div class="w-1/2"> 
                    <img src="{{ asset('icons/person.svg') }}" alt="" class="z-20 float-right mt-3 mr-4">
                    <img src="{{ asset('icons/circle-big.svg') }}" alt="" class="z-10 opacity-10 float-right mt-1 -mr-11 w-20">
                    <img src="{{ asset('icons/circle-small.svg') }}" alt="" class="z-0 opacity-10 float-right mt-16 -mr-12 w-12">
                </div>
            </div>
            <div class="h-12 bg-themered flex flex-row overflow-hidden">
                <div class="flex text-center items-center w-1/4 justify-center">
                    <img src="{{ asset('icons/calendar.svg') }}" alt="" class="w-6">
                </div>
                <div class="flex text-left  w-3/4 items-center justify-start">
                    <span class="text-gray-200">Since the beginning</span>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection