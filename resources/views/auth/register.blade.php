@extends('layouts.empty')
@section('content')
    <div class="mx-auto w-1/3 mt-24 mb-10">
        <div class="">
            <h1 class="text-3xl uppercase text-center font-bold text-white">
                Registration
            </h1>
        </div>
        <form  enctype="multipart/form-data" action="{{ url('/doRegister') }}" method="post"
            class=" w-7/8">
            @include('parts.alerts')
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="name" class="text-white">Full Name</label>
                </div>
                <div class="mt-2">
                    <input required value="{{old('name')}}" type="text"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="name" id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Full Name">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="email" class="text-white">Email Address</label>
                </div>
                <div class="mt-2">
                    <input required value="{{old('email')}}" type="email"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="email" id="email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email Address">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-white">Create Password</label>
                </div>
                <div class="mt-2">
                    <input required type="password"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password_confirmation" class="text-white">Confirm Password</label>
                </div>
                <div class="mt-2">
                    <input required type="password"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password_confirmation" id="password_confirmation"
                        placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="finance_type" class="text-white">Finance Type</label>
                </div>
                <div class="mt-2">
                    <select id="finance_type" required name="finance_type" id=""
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option {{old('finance_type') == 'Purchase' ? 'selected':''}} value="Purchase" class="">Purchase</option>
                        <option {{old('finance_type') == 'Refinance' ? 'selected':''}} value="Refinance" class="">Refinance</option>
                    </select>
                </div>
            </div>
            <div class="mt-3 mx-auto" id="loan_type_div">
                <div class=" text-left mr-12">
                    <label for="loan_type" class="text-white">Loan Type</label>
                </div>
                <div class="mt-2">
                    <select id="loan_type" name="loan_type"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option {{old('loan_type') == 'Private Loan'? 'selected': ''}} value="Private Loan" class="">Private Loan</option>
                        <option {{old('loan_type') == 'Full Doc'? 'selected': ''}} value="Full Doc" class="">Full Doc</option>
                        <option {{old('loan_type') == 'Non QM'? 'selected': ''}} value="Non QM" class="">Non QM</option>
                    </select>
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="file" class="text-white">Profile Picture</label>
                </div>
                <div class="mt-2">
                    <input type="file" name="file" id="file" accept="image/*">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class="g-recaptcha" data-sitekey="6Lf-upQfAAAAAImPKfTMmHctYc6WaAAN9GEFMnzw"></div>
            </div>
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit"
                        class=" border-2 border-white rounded-md bg-white px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        Sign Up
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
{{-- @section('foot')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function checkRecaptcha() {
            if (grecaptcha.getResponse() === "") {
                alert("Please, check the recaptch");
                return false;
            }
            if (grecaptcha.getResponse() === false) {
                alert("Recaptch failed please try again.");
                return false;
            }
            return true;
        }
    </script>
@endsection --}}
@section('foot')
<script>
$(document).ready(function () {
$('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd');
});
</script>
@endsection
