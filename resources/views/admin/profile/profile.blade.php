@extends('layouts.app')
@section('content')
    @php($user = Auth::user())
    <div class="w-1/2 mx-auto">
        <div class="flex justify-center items-center mt-4">
            <label for="file">
                <img class="w-40 h-40 rounded-full" src="{{ asset(auth()->user()->pic ?? 'img/profile-default.svg') }}"
                    alt="Profile Picture">
            </label>
        </div>
        <form action="{{ url(getRoutePrefix() . '/do-profile') }}" method="post" enctype="multipart/form-data">
            <div class="flex justify-center mt-2">
                @csrf
                {{-- <input class=" xl:text-2xl rounded-md py-2 w-2/3 bg-gray-200" type="text" id="filename" disabled>
            <button type="button" class=" tracking-wide rounded-lg text-white px-7 py-2 text-lg capitalize bg-gradient-to-b from-gradientStart to-gradientEnd"
             id="file-upload-btn">
                                Browse..
                                </button>   --}}
                <input type="file" name="file" id="file" accept="image/*">
            </div>
            <span id="passwordParent">
                <div class="xl:flex xl:gap-3 items-center">
                    <div class="mt-3 xl:w-[49%]">
                        <div class="text-left mr-12">
                            <label for="password" class="">Password</label>
                        </div>
                        <div class="mt-2">
                            <input type="password"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                        </div>
                        @error('password')
                            <span class="text-red-700">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3 xl:w-[49%]">
                        <div class=" text-left mr-12">
                            <label for="password_confirmation" class="">Confirm Password</label>
                        </div>
                        <div class="mt-2">
                            <input type="password"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="password_confirmation" id="password_confirmation"
                                placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                        </div>
                    </div>
                </div>
            </span>
            <div class="flex justify-center mt-2">
                <button type="submit"
                    class="tracking-wide rounded-lg text-white px-7 py-2 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
                    Update
                </button>
            </div>
        </form>
        <div class="flex justify-between mt-2">
            @if ($user->accessToken)
                <a href="{{ url(getRoutePrefix() . '/disconnect-google') }}"
                    class="tracking-wide rounded-lg text-white px-7 py-2 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
                    Disconnect from Google
                </a>
            @endif
            @if ($user->role === 'Super Admin')
                <a href="{{ url(getSuperAdminRoutePrefix() . '/logout-all-users') }}" data="Logout All"
                    class="delete tracking-wide rounded-lg text-white px-7 py-2 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
                    Logout All Users
                </a>
            @endif
        </div>

    </div>
    @if ($user->role === 'Admin')
        <div class="w-1/2 mt-3 p-10 mx-auto justify-center bg-white shadow-2xl">
            <div class="flex justify-center flex-col">
                <h2 class="text-center text-lg font-semibold leading-8 text-gray-900">Subscription Details</h2>
                <table class="border border-slate-500 w-full">
                    <thead>
                        <tr>
                            <th class="border border-slate-600 p-2 text-center">Card No</th>
                            <th class="border border-slate-600 p-2 text-center">Brand</th>
                            <th class="border border-slate-600 p-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-700 p-2 text-center">xxxx xxxx xxxx
                                {{ $card->card_no }}
                            </td>
                            <td class="border border-slate-700 p-2 text-center">{{ $card->brand }}</td>
                            <td class="border border-slate-700 p-2 text-center">
                                {{-- <a href="#" class="bg-red-600 px-2 py-2 text-white">Change Card</a> --}}
                                @if ($user->userSubscriptionInfo->is_subscribed)
                                    <a href="{{ route('cancel.subscription') }}"
                                        class="flex justify-center bg-red-700 md:px-2 px-0 text-sm sm:text-md py-2 text-white delete"
                                        data="cancel">Cancel
                                        Subscription</a>
                                @else
                                    <a class="text-red-700" disabled data="cancel">Subscription Cancelled</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-1/2 mt-3 p-10 mx-auto justify-center bg-white shadow-2xl">
            <div class="flex justify-center flex-col">
                <h2 class="text-center text-lg font-semibold leading-8 text-gray-900">Payment History</h2>
                <table class="mt-3 border border-slate-500 w-full">
                    <thead>
                        <tr>
                            <th class="border border-slate-600 p-2 text-center">S.No</th>
                            <th class="border border-slate-600 p-2 text-center">Amount</th>
                            <th class="border border-slate-600 p-2 text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->payments as $payment)
                            <tr>
                                <td class="border border-slate-700 p-2 text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="border border-slate-700 p-2 text-center">
                                    {{ '$'.number_format($payment->amount,2) }}
                                </td>
                                <td class="border border-slate-700 p-2 text-center">
                                    {{ $payment->payment_date }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#file-upload-btn").on("click", function() {
                alert();
                $("#file").trigger("click");
            });
            $('input[type="file"]').change(function(e) {
                file = e.target.files[0];
                var fileName = e.target.files[0].name;
                $("#filename").text(fileName);
            });
        });
    </script>
@endsection
