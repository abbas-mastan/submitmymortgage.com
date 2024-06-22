@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <style>
        #file {
            display: none;
        }

        #deleted-table_length,
        #user-table_length {
            display: none;
        }

        input,
        select {
            height: 55px;
        }

        input::placeholder {
            color: lightgray;
        }
    </style>
@endsection
@section('content')
    @include('parts.company-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full px-10">
        <h2 class="text-center text-xl my-16 font-extrabold">
            Create Custom Plan
        </h2>
        <form id="custom-plan-form" enctype="multipart/form-data" action="{{ route('create-plan', $user->id) }}" method="post"
            class="w-7/8">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <div class="text-left mr-12">
                        <label for="name" class="">Full Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('name', $user->name) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="name" id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Full Name">
                    </div>
                    @error('name')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="email" class="">Email Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('email', $user->email) }}" type="email"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="email" {{ $user->id > 0 ? 'readonly' : '' }} id="email"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;example@example.com">
                    </div>
                    @error('email')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="phone" class="">Phone Number</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('phone', $user->phone) }}" type="tel"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            name="phone" id="phone" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;(_ _ _)  -  _ _ _ - _ _ _ _">
                    </div>
                    @error('phone')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="company" class="">Company Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('company', $user->company->name) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            name="company" id="company" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Company Name">
                    </div>
                    @error('company')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="country" class="">Country</label>
                    </div>
                    <div class="mt-2">
                        <select
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            name="country" id="country">
                            <option value="USA">USA</option>
                        </select>
                    </div>
                    @error('country')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="state" class="">State</label>
                    </div>
                    <div class="mt-2">
                        <select
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            name="state" id="state">
                            <option value="">Select State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ old('state', $user->personalInfo->state ?? '') === $state ? 'selected' : '' }}
                                    value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('state')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="city" class="">City</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('city', $user->personalInfo->city ?? '') }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            name="city" id="city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;City">
                    </div>
                    @error('city')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="text-left mr-12">
                        <label for="postal_code" class="">Postal Code</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('postal_code', $user->personalInfo->postal_code ?? '') }}" type="number"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            name="postal_code" id="postal_code" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Postal Code">
                    </div>
                    @error('postal_code')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div class="lg:col-span-2">
                    <div class="text-left mr-12">
                        <label for="postal_code" class="">Enter Card Number</label>
                    </div>
                    <div class="mt-2 border border-1 border-black bg-white p-5 rounded-md py-4 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                        id="card-element">
                    </div>
                    <div class="text-red-700" id="card-errors"></div>
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 mt-8 mb-3">
                <label for="plan_type" class="font-bold">Plan Type:</label>
                <div>
                    <input type="radio"
                        {{ old('plan_type', $user->customQuote->plan_type) === 'monthly' ? 'checked' : '' }}
                        name="plan_type" value="monthly" id="monthly">
                    <label for="monthly" class="ml-2 font-thin">Monthly</label>
                </div>
                <div>
                    <input type="radio"
                        {{ old('plan_type', $user->customQuote->plan_type) === 'yearly' ? 'checked' : '' }}
                        name="plan_type" value="yearly" id="yearly">
                    <label for="yearly" class="ml-2 font-thin">Yearly</label>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-4 gap-x-8">
                <div class="mt-3">
                    <div class="text-left mr-12">
                        <label for="team_size" class="">Team size</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('team_size', $user->team_size) }}" type="number"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="team_size" id="team_size"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;What size is your team?">
                    </div>
                    @error('team_size')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <div class="grid grid-cols-3">
                        <div class="col-span-3 text-left mr-12">
                            <label for="training_date">Training Date</label>
                        </div>
                        <div class="col-span-3 mt-2 h-full">
                            <input type="text" onfocus="this.showPicker()" min="{{ date('Y-m-d') }}"
                                class="absolute z-[-1]" name="training_date" id="training_date"
                                placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Training Date">
                            <button type="button"
                                class="py-4 select-date border border-1 border-gray-700 bg-gray-400 rounded-md text-white w-full">Select
                                Training Date</button>
                        </div>
                    </div>
                    @error('training_date')
                        <div class="col-span-3 text-red-700">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <div class="text-left mr-12">
                        <label for="plan_price" class="">Plan Price</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('plan_price', $user->plan_price) }}" type="number"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="plan_price" id="plan_price" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;$60000.00/-">
                    </div>
                    @error('plan_price')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-10 flex justify-center">
                <button type="submit"
                    class="w-[30%] py-4 bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                    Create Plan
                </button>
            </div>
        </form>
    </div>
@endsection
@section('foot')
    {{-- date input logic starts here --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var dateInput = $('#training_date');
            dateInput.datepicker({
                minDate: "+8d",
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day === 4]; // 4 is Thursday
                }
            });

            $('.select-date').click(function(e) {
                e.preventDefault();
                dateInput.focus();
            });

            $(dateInput).change(function(e) {
                e.preventDefault();
                if (dateInput.val() !== '') {
                    $('.select-date').html(dateInput.val());
                }
            });
        });
    </script>
    {{-- date input logic end here --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        if (window.Stripe) {
            var stripe = Stripe("{{ env('STRIPE_PK') }}");
            var elements = stripe.elements();
            var card = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        fontWeight: '500',
                        fontSize: '17px',
                        fontFamily: 'Lexend, sans-serif',
                        '::placeholder': {
                            color: '#c7bbbb',
                        },
                    }
                }
            });
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors')
                displayError.textContent = event.error ? event.error.message : '';
            });
            const form = document.getElementById('custom-plan-form');
            form.addEventListener('submit', function(ev) {
                ev.preventDefault();
                $('.loader').removeClass('d-none');
                stripe.createToken(card).then(function(result) {
                    $('.loader').addClass('d-none');
                    validateFields();
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        if (validateFields()) {
                            // console.log(result.token);
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.card.id}" name="card">`
                            );
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.id}" name="stripeToken">`
                            );
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.card.last4}" name="card_no">`
                            );
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.card.brand}" name="brand">`
                            );
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.card.exp_month}" name="month">`
                            );
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.card.exp_year}" name="year">`
                            );
                            $('#custom-plan-form').append(
                                `<input type="hidden" value="${result.token.card.name}" name="name">`
                            );
                            form.submit();
                        }
                    }
                });
            });

            function showError(id) {
                $(`#custom-plan-form #${id}`).parent().append(
                    '<span class="text-red-700 error">This field is required!</span>');
            }

            function validateFields() {
                $('.error').remove();
                var isValid = true;
                if ($('#custom-plan-form #name').val() === '') {
                    showError('name');
                    isValid = false;
                }
                if ($('#custom-plan-form #email').val() === '') {
                    showError('email');
                    isValid = false;
                }
                if ($('#custom-plan-form #phone').val() === '+1' || $('#custom-plan-form #phone').val() === '') {
                    showError('phone');
                    isValid = false;
                }
                if ($('#custom-plan-form #company').val() === '') {
                    showError('company');
                    isValid = false;
                }
                if ($('#custom-plan-form #country').val() === '') {
                    showError('country');
                    isValid = false;
                }
                if ($('#custom-plan-form #state').val() === '') {
                    showError('state');
                    isValid = false;
                }
                if ($('#custom-plan-form #city').val() === '') {
                    showError('city');
                    isValid = false;
                }
                if ($('#custom-plan-form #postal_code').val() === '') {
                    showError('postal_code');
                    isValid = false;
                }
                if ($('#custom-plan-form #team_size').val() === '') {
                    showError('team_size');
                    isValid = false;
                }
                if ($('#custom-plan-form #training_date').val() === '') {
                    showError('training_date');
                    isValid = false;
                }
                if ($('#custom-plan-form #plan_price').val() === '') {
                    showError('plan_price');
                    isValid = false;
                }
                return isValid;
            }
        }
    </script>
@endsection
