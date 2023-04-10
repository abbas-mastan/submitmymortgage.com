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
                Welcome To <br> Submit My Mortgage
            </h1>
        </div>
        <div class="text-center mt-5">
            <span class="text-lg xl:text-2xl text-white">
                Sign up / Login
            </span>
        </div>
        <form action="{{url('/do-login')}}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="username" class="text-white text-md xl:text-xl opacity-70">Username/Email</label>
                </div>
                <div class="mt-2">
                    <input type="email" class=" text-md xl:text-lg rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="email"  id="username" placeholder="&nbsp;&nbsp;Username">
                </div>
                
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-white text-md xl:text-xl opacity-70">Password</label>
                </div>
                <div class="mt-2">
                    <input type="password" class="xl:text-xl   text-md rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="password"  id="password" placeholder="&nbsp;&nbsp;***********">
                </div>
                
            </div>  
            
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4">
                    <input type="checkbox" class=" "  name="remember" id="remember" > <label for="remember" class="text-white text-md xl:text-xl opacity-70">Remember me</label>
                </div>
                
            </div>
            <div class="mt-2 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 pl-5">
                    <a href="{{url('/forgot-password')}}" class="text-white text-md xl:text-xl opacity-70 underline">
                        Forgot Password?
                    </a>
                </div>
            </div>    
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit" class="  text-md xl:text-xl  border-2 border-white rounded-md bg-white px-10 xl:px-12 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        Sign In
                    </button>
                </div>
                
            </div>    
            <div class="mt-2  grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <a href="{{ url('/register') }}">
                        <button type="button" class="  text-md  xl:text-xl text-white rounded-md bg-transparent border-2 border-white px-4 xl:px-4 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            Register Here
                        </button>
                    </a>
                </div>
                
                
            </div> 
        </form>
        <footer style="margin-top:239px">
            <a href="/privacy-policy" class="border p-2 bg-gray-300">Privacy Policy</a>
        </footer>
    </div>
@endsection