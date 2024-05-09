@extends('layouts.app')
@section('content')
    @php($user = Auth::user())
    <div class="w-1/2 mx-auto">
        <div class="flex justify-center items-center mt-4">
            <img class="w-40 h-40 rounded-full" src="{{ asset(auth()->user()->pic ?? 'img/profile-default.svg') }}"
                alt="Profile Picture">
        </div>
        <form action="{{ url(getRoutePrefix() . '/do-profile') }}" method="post" enctype="multipart/form-data">
            <div class="flex  justify-center mt-2">
                @csrf
                {{-- <input class=" xl:text-2xl rounded-md py-2 w-2/3 bg-gray-200" type="text" id="filename" disabled>
            <button type="button" class=" tracking-wide rounded-lg text-white px-7 py-2 text-lg capitalize bg-gradient-to-b from-gradientStart to-gradientEnd"
             id="file-upload-btn">
                                Browse..
                                </button>   --}}
                <input type="file" name="file" id="file" accept="image/*">
            </div>
            <span id="passwordParent">
                <div class="flex justify-between">
                    <div class="mt-3 w-[49%]">
                        <div class=" text-left mr-12">
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
                    <div class="mt-3 w-[49%]">
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
        @if (
            $user->role === 'Admin' &&
                ($user->userSubscriptionInfo->is_subscribed || ($user->training() && $user->training->start_time === null)))
            <div class="bg-white py-24 sm:py-32 py-8 shadow-2xl">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div
                        class="mx-auto mt-10 grid max-w-lg items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                        @if ($user->role === 'Admin' && $user->userSubscriptionInfo->is_subscribed)
                            <h2 class="text-center text-lg font-semibold leading-8 text-gray-900">Subscription Details</h2>
                            <table class="border-separate border border-slate-500 ...">
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
                                            <a href="{{ route('cancel.subscription') }}"
                                                class="bg-blue-500 px-2 py-2 text-white delete" data="cancel">Cancel
                                                Subscription</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        @if (Auth::user()->training && Auth::user()->training->start_time === null)
                            <div>
                                <h2 class="mt-5 mb-3 text-2xl">Select Training Time</h2>
                                <form action="{{ route('update.training.time') }}" method="post">
                                    @csrf
                                    <select name="time" id="">
                                        <option value="">Select Training Time</option>
                                        <option value="09:00">09:00 AM PST</option>
                                        <option value="10:00">10:00 AM PST</option>
                                        <option value="11:00">11:00 AM PST
                                        </option>
                                    </select>
                                    <button type="submit"
                                        class="mt-3 block tracking-wide rounded-lg text-white px-7 py-2 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
                                        Submit
                                    </button>
                                </form>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
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
