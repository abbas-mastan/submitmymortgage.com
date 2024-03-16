@extends('layouts.empty')
@section('content')
    <div class="mx-auto w-1/3 flex flex-col justify-center items-center">

        <div class="">
            <h1 class="xl:text-3xl text-2xl uppercase text-center font-bold text-white">
                @if (\Request::route()->getName() === 'user.register')
                    Create
                @else
                    Reset
                @endif
                Password
            </h1>
        </div>
        @php
            $routeName = Route::currentRouteName();
            $expirePage = $routeName === 'password.expired';
        @endphp
        <form
            @if ($expirePage) action="{{ route('password.post_expired') }}"
            @else
            action="{{ url($routeName === 'user.register' ? 'set-password-new-user' : '/reset-password') }}" @endif
            method="post" class="w-full">
            @include('parts.alerts')
            @csrf
            @if ($routeName !== 'password.expired')
                <input value="{{ $token }}" type="hidden" name="token">
                <div class="mt-10 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="username" class="text-white text-md xl:text-xl opacity-70">Email</label>
                    </div>
                    <div class="mt-2">
                        <input type="email" value="{{ old('email', $user->email ?? null) }}"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="email" id="username" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email">
                    </div>
                </div>
            @endif
            @if ($expirePage)
                <div class="mt-3 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="current_password" class="text-white text-md xl:text-xl opacity-70 flex">
                            Current Password
                        </label>

                    </div>
                    <div class="mt-2">
                        <input type="password" required
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="current_password" id="current_password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                    </div>
                </div>
            @endif

            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-white text-md xl:text-xl flex">
                        <span class="opacity-70">
                            {{ $expirePage ? 'New' : '' }} Password
                        </span>
                        <a tabindex="0" role="link" aria-label="tooltip 2"
                            class="ml-2 inline-flex items-centerfocus:outline-none focus:ring-gray-300 rounded-full focus:ring-offset-2 focus:ring-2 focus:bg-gray-200 relative"
                            onmouseover="showTooltip(2)" onfocus="showTooltip(2)" onmouseout="hideTooltip(2)">
                            <div class=" cursor-pointer">
                                <svg aria-haspopup="true" xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-info-circle" width="25" height="25"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#A0AEC0" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <circle cx="12" cy="12" r="9" />
                                    <line x1="12" y1="8" x2="12.01" y2="8" />
                                    <polyline points="11 12 12 12 12 16 13 16" />
                                </svg>
                            </div>
                            <div id="tooltip2" role="tooltip"
                                class="bg-gradient-to-b from-gradientStart to-gradientEnd hidden z-50 -mt-[3.4rem] w-64 absolute opacity-100 transition duration-150 ease-in-out left-0 ml-8 shadow-lg  p-4 rounded">
                                <svg class="absolute left-0 -ml-2 bottom-0 top-0 h-full" width="9px" height="16px"
                                    viewBox="0 0 9 16" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Tooltips-" transform="translate(-874.000000, -1029.000000)" fill="#4c51bf">
                                            <g id="Group-3-Copy-16" transform="translate(850.000000, 975.000000)">
                                                <g id="Group-2" transform="translate(24.000000, 0.000000)">
                                                    <polygon id="Triangle"
                                                        transform="translate(4.500000, 62.000000) rotate(-90.000000) translate(-4.500000, -62.000000) "
                                                        points="4.5 57.5 12.5 66.5 -3.5 66.5"></polygon>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <p class="text-sm font-bold text-white pb-1">Tip!</p>
                                <p class="text-xs leading-4 text-white pb-3">Your password must be 12 characters long.
                                    Should
                                    contain at-least 1 uppercase 1 lowercase 1 Numeric and 1 special character.</p>

                            </div>
                        </a></label>
                </div>
                <div class="mt-2">
                    <input type="password"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                    @error('password')
                        <span class="text-white text-left">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="passwordconfirmation"
                        class="text-white text-md xl:text-xl opacity-70 flex">{{ $expirePage ? 'New' : '' }} Confirm
                        Password
                    </label>

                </div>
                <div class="mt-2">
                    <input type="password" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password_confirmation" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
            </div>
            <div class="mt-5 text-center">

                <button type="submit"
                    class=" opacity-70  border-2 border-white rounded-md bg-white px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                    @if (\Request::route()->getName() === 'user.register')
                        Create
                    @else
                        Update
                    @endif
                    Password
                </button>

            </div>

        </form>

    </div>
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd');
        });
        $('.body-first-div').removeClass('h-full');
        $('.body-first-div').addClass('h-screen');
    </script>
@endsection
