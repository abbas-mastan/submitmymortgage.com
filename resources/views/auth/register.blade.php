@extends('layouts.empty')
@section('content')
    <div class="mx-auto w-1/3 mt-24 mb-10">
        <div class="">
            <h1 class="text-3xl uppercase text-center font-bold text-white">
                Registration
            </h1>
        </div>
        <form enctype="multipart/form-data" action="{{ url('/doRegister') }}" method="post" class=" w-7/8">
            {{-- @include('parts.alerts') --}}
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="name" class="text-white">Full Name</label>
                </div>
                <div class="mt-2">
                    <input value="{{ old('name') }}" type="text" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="name" id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Full Name">
                </div>
                @error('name')
                    <span class="text-white">{{ $message }}</span>
                @enderror

            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="email" class="text-white">Email Address</label>
                </div>
                <div class="mt-2">
                    <input value="{{ old('email') }}" type="email" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="email" id="email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email Address">
                </div>
                @error('email')
                    <span class="text-white">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="finance_type" class="text-white">Finance Type</label>
                </div>
                <div class="mt-2">
                    <select id="finance_type" name="finance_type" id="" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option {{ old('finance_type') == 'Purchase' ? 'selected' : '' }} value="Purchase" class="">
                            Purchase</option>
                        <option {{ old('finance_type') == 'Refinance' ? 'selected' : '' }} value="Refinance" class="">
                            Refinance</option>
                    </select>
                    @error('finance_type')
                        <span class="text-white">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-3 mx-auto" id="loan_type_div">
                <div class=" text-left mr-12">
                    <label for="loan_type" class="text-white">Loan Type</label>
                </div>
                <div class="mt-2">
                    <select id="loan_type" name="loan_type" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option {{ old('loan_type') == 'Private Loan' ? 'selected' : '' }} value="Private Loan"
                            class="">Private Loan</option>
                        <option {{ old('loan_type') == 'Full Doc' ? 'selected' : '' }} value="Full Doc" class="">Full
                            Doc</option>
                        <option {{ old('loan_type') == 'Non QM' ? 'selected' : '' }} value="Non QM" class="">Non QM
                        </option>
                    </select>
                    @error('loan_type')
                        <span class="text-white">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="text-white flex">Create Password
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
                                class="bg-white hidden z-20 -mt-[3.4rem] w-64 absolute transition duration-150 ease-in-out left-0 ml-8 shadow-lg  p-4 rounded text-black">
                                <svg class="absolute left-0 -ml-2 bottom-0 top-0 h-full" width="9px" height="16px"
                                    viewBox="0 0 9 16" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Tooltips-" transform="translate(-874.000000, -1029.000000)"
                                            fill="#4c51bf">
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
                                <p class="text-sm font-bold pb-1">Tip!</p>
                                <p class="text-xs leading-4 pb-3">Your password must be 12 characters long.
                                    Should contain at-least 1 uppercase 1 lowercase 1 Numeric and 1 special character.</p>

                            </div>
                        </a>
                    </label>
                </div>
                <div class="mt-2">
                    <input type="password" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
                @error('password')
                    <span class="text-white">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password_confirmation" class="text-white">Confirm Password</label>
                </div>
                <div class="mt-2">
                    <input type="password" required
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="password_confirmation" id="password_confirmation"
                        placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
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
@section('foot')
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
        $(document).ready(function() {
            $('.body-first-div').addClass('bg-gradient-to-b from-gradientStart to-gradientEnd');
        });
    </script>
@endsection
