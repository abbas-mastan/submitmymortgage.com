@extends('layouts.empty')
@section('content')
    <div class="mt-40 m-10 w-[50%] bg-['#edf2f7'] flex items-center justify-center">
        <div>
            <h2 class="flex justify-center my-3 ">
                <span>
                    SubmitMyMortgage
                </span>
            </h2>
            <div class="h-[50%] child w-100 flex-col justify-center mt-5 shadow-2xl bg-white p-10">
                <h3 class="text-lg">Hello!</h3>
                <p class="text-md mt-2">You are receiving this email to complete your registration process by entering your
                    password.
                </p>
                <div class="flex justify-center">
                    <a href="{{ $url }}" class="text-center my-5 bg-black rounded text-white px-3 py-1.5">Create
                        Password</a>
                </div>
                <p class="text-md">Regards,<br>
                    SubmitMyMortgage</p>

                <hr class="my-3">
               
            </div>
        </div>
    </div>
@endsection
