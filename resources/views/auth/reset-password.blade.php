
@extends('layouts.empty')
@section('content')
    <div class="mx-auto w-1/3 mt-40">
        
        <div class="">
            <h1 class="xl:text-3xl text-2xl uppercase text-center font-bold text-white">
                Reset Passsword
            </h1>
        </div>
        <form action="{{ url('/reset-password') }}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
			<input value="{{$token}}" type="hidden" name="token">
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="username" class="text-white text-md xl:text-xl opacity-70">Email</label>
                </div>
                <div class="mt-2">
                    <input type="email" value="{{old('email')}}" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="email"  id="username" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-white text-md xl:text-xl opacity-70">Password</label>
                </div>
                <div class="mt-2">
                    <input type="password" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="password"  id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="passwordconfirmation" class="text-white text-md xl:text-xl opacity-70">Confirm Password</label>
                </div>
                <div class="mt-2">
                    <input type="password" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="password_confirmation"  id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>    
            </div>
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit" class=" opacity-70  border-2 border-white rounded-md bg-white px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        Update Password
                    </button>
                </div>
                
            </div>    
           
        </form>
       
    </div>
@endsection
@section('foot')
<script>
$(document).ready(function () {
$('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd');
});
</script>
@endsection
