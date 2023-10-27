@extends('layouts.empty')
@section('content')
    <div class="mx-auto w-1/3 mt-40">
        <div class="">
            <h1 class="xl:text-3xl text-2xl uppercase text-center font-bold text-white">
                Password reset
            </h1>
        </div>
        <form action="{{ url('/forgot-password') }}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="username" class="text-white text-md xl:text-xl opacity-70">Email</label>
                </div>
                <div class="mt-2">
                    <input type="email"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="email" id="username" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email">
                </div>
            </div>
            <div class="mt-2 text-center">
                <button type="submit"
                    class="text-white opacity-70 rounded-md bg-transparent border-2 border-white px-4 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                    Send a Reset Link
                </button>
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

