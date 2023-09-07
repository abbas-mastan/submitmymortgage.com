@extends('layouts.app')
@section('head')
    <style>
        input[type=text]:focus {
            margin-bottom: 2px;
        }
        textarea:focus {
            margin-bottom: 2px;
        }
        .text-red-700 {
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="w-3/4 mt-10 mx-auto">
        <div class="">
            <h1 class="text-xl font-bold capitalize text-center">
                loan breakdown information
            </h1>
        </div>
        <form id="info-form" action="{{ url(getRoutePrefix() . '/do-application') }}" method="post" class="w-full">
            @csrf
            @if ($id > 0)
                <input type="hidden" name="user_id" value="{{ $id }}">
            @endif
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="{{ session('role') == 'Borrower' ? 'name' : 'email' }}" class="">Client's
                            {{ session('role') == 'Borrower' ? 'Name' : 'Email' }}</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('email', $application->email) }}" type="email"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="email" id="email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email Address">
                        @error('email')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="date" class="">Date</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('date', $application->date) }}" type="date"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="date" id="date" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;date">
                        @error('date')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="{{ session('role') === 'Borrower' ? 'email' : 'name' }}"
                            class="">{{ session('role') === 'Borrower' ? 'Email' : 'Name' }}</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('name', $application->name) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="name" id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Client's Name">
                        @error('name')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="phone" class="">Phone #</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('phone', $application->phone) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="phone" id="phone" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Phone#">
                        @error('phone')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            <span class="text-lg font-bold ">Property Profile:</span>
            <div class="grid grid-cols-3 gap-8">
                <div class="">
                    <div class="">
                        <input value="primary"
                            {{ old('property_profile', $application->property_profile) == 'primary' ? 'checked' : '' }}
                            type="radio" name="property_profile" id="primary">
                        <label class="pt-3" for="primary">Primary</label>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <input value="investment"
                            {{ old('property_profile', $application->property_profile) == 'investment' ? 'checked' : '' }}
                            type="radio" name="property_profile" id="investment"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;investment">
                        <label class="pt-3" for="investment">Investment</label>
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <input type="radio" value="other"
                            {{ old('property_profile', $application->property_profile) == 'other' ? 'checked' : '' }}
                            name="property_profile" id="property_other">
                        <label for="property_other" class="">Other</label>
                    </div>
                </div>
                @error('property_profile')
                    <span class="text-center col-span-4 text-red-700">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            <div class="">
                <p class="text-lg font-bold ">Subject Property</p>
            </div>
            <div class=" grid grid-cols-5 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="address" class="">Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('address', $application->address) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="address" id="address" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Address">
                        @error('address')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="city" class="">City</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('city', $application->city) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="city" id="city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;City">
                        @error('city')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="state" class="">State</label>
                    </div>
                    <div class="mt-2">
                        <select name="state" id="state"
                            class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ old('state', $application->state) === $state ? 'selected' : '' }}
                                    value="{{ $state }}">
                                    {{ $state }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="zip" class="">Zip Code</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('zip', $application->zip) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="zip" id="zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Zip">
                        @error('zip')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <label for="property_value" class="">Property Value</label>
                    <div class=" text-left mr-12">
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('property_value', $application->property_value) }}" type="text"
                            min="0" max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="property_value" id="property_value"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Property Value">
                        @error('property_value')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="purchase_date" class="">Purchase Date</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('purchase_date', $application->purchase_date) }}" type="date"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="purchase_date" id="purchase_date" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Purchase Date">
                        @error('purchase_date')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="purchase_value" class="">Purchase Value</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('purchase_value', $application->purchase_value) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Purchase Value" name="purchase_value"
                            id="purchase_value">
                        @error('purchase_value')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class=" font-bold text-lg grid grid-cols-5 mt-5">Property Type:</div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="mt-2">
                    <div class="mt-1">
                        <input value="singlefamily" onclick="javascript:toggleInputVisibility()"
                            {{ old('property_type', $application->property_type) == 'singlefamily' ? 'checked' : '' }}
                            type="radio" name="property_type" id="singlefamily">
                        <label class="pt-3" for="singlefamily">Single Family Residence</label>
                    </div>
                </div>
                <div class="">
                    <div class=" mt-2">
                        <input value="Multi-Unit Residential" onclick="javascript:toggleInputVisibility()"
                            {{ old('property_type', $application->property_type) == 'Multi-Unit Residential' ? 'checked' : '' }}
                            type="radio" name="property_type" id="Multi-Unit Residential"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Multi-Unit Residential">
                        <label class="pt-3" for="Multi-Unit Residential">Multi-Unit Residential</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="Multi-Unit Building" onclick="javascript:toggleInputVisibility()"
                            {{ old('property_type', $application->property_type) == 'Multi-Unit Building' ? 'checked' : '' }}
                            type="radio" class="" name="property_type" id="Multi-Unit Building">
                        <label class="pt-3" for="Multi-Unit Building">Multi-Unit Building
                        </label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-1">
                        <input value="Commercial Property" onclick="javascript:toggleInputVisibility()"
                            {{ old('property_type', $application->property_type) == 'Commercial Property' ? 'checked' : '' }}
                            type="radio" name="property_type" id="Commercial Property">
                        <label class="pt-3" for="Commercial Property">Commercial Property</label>
                    </div>
                </div>
                <div class="">
                    <div class=" mt-2">
                        <input value="Construction" onclick="javascript:toggleInputVisibility()"
                            {{ old('property_type', $application->property_type) == 'Construction' ? 'checked' : '' }}
                            type="radio" name="property_type" id="Construction"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;investment">
                        <label class="pt-3" for="Construction">Construction</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="Multi-Use Property" onclick="javascript:toggleInputVisibility()"
                            {{ old('property_type', $application->property_type) == 'Multi-Use Property' ? 'checked' : '' }}
                            type="radio" class="" name="property_type" id="Multi-Use Property">
                        <label class="pt-3" for="Multi-Use Property">Multi-Use Property
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class=" text-left mr-12">
                        <input value="other"
                            @php $a = $application->property_type;
                                $array = ['Multi-Use Property','Construction' ,'Commercial Property','Multi-Unit Building','Multi-Unit Residential','singlefamily'];
                                if(old('property_type')== 'other' || !in_array($a,$array)) {
                                    echo 'checked';
                                } @endphp
                            type="radio" name="property_type" onclick="javascript:toggleInputVisibility();"
                            id="property_type_other">
                        <label for="property_type_other">Other</label>
                    </div>
                    <div class="mt-1">
                        <input style="display:none"
                            value="@php $value = $application->property_type;
                            $array = ['Multi-Use Property','Construction' ,'Commercial Property','Multi-Unit Building','Multi-Unit Residential','singlefamily','other'];
                            // if the value is not in array then value will show OR if value is return in validation then it will show 
                            echo old('property_type_other', !in_array($value, $array) ? $value : ''); @endphp"
                            type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Other" name="property_type_other"
                            id="property_type_other_input">
                        @error('property_type_other')
                            <span class="text-red-700">
                                This field is required!
                            </span>
                        @enderror
                    </div>
                </div>
                @error('property_type')
                    <span class="text-red-700">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <br>
            <span class=" font-bold text-lg">Property Vested in:</span>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-1">
                        <input value="personal_name"
                            {{ old('property_vested', $application->property_vested) == 'personal_name' ? 'checked' : '' }}
                            type="radio" name="property_vested" id="personal_name">
                        <label class="pt-3" for="personal_name">Personal Name</label>
                    </div>
                </div>
                <div class="">
                    <div class=" mt-2">
                        <input value="trust"
                            {{ old('property_vested', $application->property_vested) == 'trust' ? 'checked' : '' }}
                            type="radio" name="property_vested" id="trust"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;investment">
                        <label class="pt-3" for="trust">Trust</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="LLC"
                            {{ old('property_vested', $application->property_vested) == 'LLC' ? 'checked' : '' }}
                            type="radio" class="" name="property_vested" id="LLC">
                        <label class="pt-3" for="LLC">LLC
                        </label>
                    </div>
                </div>
                @error('property_vested')
                    <span class="text-red-700">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="seekloanamount" class="">Seeking Loan Amount:</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('seek_loan_amount', $application->seek_loan_amount) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="seek_loan_amount" id="seekloanamount"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Seeking Loan Amount">
                        @error('seek_loan_amount')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="Closing Date" class="">Closing Date:</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('closing_date', $application->closing_date) }}" type="date"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="closing_date" id="Closing Date" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Closing Date">
                        @error('closing_date')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="Loan Purpose" class="">Loan Purpose:</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('loan_purpose', $application->loan_purpose) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="loan_purpose" id="Loan Purpose" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Loan Purpose">
                        @error('loan_purpose')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <span class=" mt-5 block font-bold">Property Income:</span>
            <div class="grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-2">
                        <input value="Leased"
                            {{ old('income_type', $application->income_type) == 'Leased' ? 'checked' : '' }}
                            type="radio" name="income_type" id="Leased">
                        <label class="pt-3" for="Leased">Leased</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="Vacant"
                            {{ old('income_type', $application->income_type) == 'Vacant' ? 'checked' : '' }}
                            type="radio" name="income_type" id="Vacant">
                        <label class="pt-3" for="Vacant">Vacant</label>
                    </div>
                    @error('income_type')
                        <span class="col-span-4 text-center text-red-700">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="">
                    <div class="mt-2">
                        <label class="pt-3" for="montyrentalincome">Monthly Rental Income:</label>
                        <input value="{{ old('monthly_rental_income', $application->monthly_rental_income) }}"
                            type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Monthly Rental Income" name="monthly_rental_income"
                            id="montyrentalincome">
                        @error('monthly_rental_income')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            <div class="">
                <p class="mb-3 text-lg font-bold ">Existing Loans</p>
            </div>
            <span class=" mt-2">Is the Property Paid Off?</span>
            <div class="grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-2">
                        <input value="yes"
                            {{ old('is_property_paid', $application->is_property_paid) == 'yes' ? 'checked' : '' }}
                            type="radio" name="is_property_paid" id="yes">
                        <label class="pt-3" for="yes">Yes</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="no"
                            {{ old('is_property_paid', $application->is_property_paid) == 'no' ? 'checked' : '' }}
                            type="radio" name="is_property_paid" id="no">
                        <label class="pt-3" for="no">No</label>
                    </div>
                </div>
                @error('is_property_paid')
                    <span class="text-red-700">
                        {{ $message }}
                    </span>
                @enderror
                <div class="">
                    <div class="mt-2">
                        <label class="pt-3" for="loan_type">Loan Type</label>
                        <input value="{{ old('loan_type', $application->loan_type) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="loan_type" id="loan_type">
                        @error('loan_type')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="mortage1" class="">1st Loan Amount</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('first_loan', $application->first_loan) }}" type="text" min="0"
                            max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="first_loan" id="mortage1" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;1st Loan Amount">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                    @error('first_loan')
                        <span class="text-red-700">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="interest1" class="">Rate</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('first_loan_rate', $application->first_loan_rate) }}" type="number"
                            min="0" max="100"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="first_loan_rate" id="interest1" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Rate">
                        <span class="inline -ml-12 z-10 opacity-50">%</span>
                        @error('first_loan_rate')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="first_loan_lender" class="">Lender</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('first_loan_lender', $application->first_loan_lender) }}" type="text"
                            min="0" max="100"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="first_loan_lender" id="first_loan_lender" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Lender">
                        @error('first_loan_lender')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="mortage2" class="">2nd Loan Amount</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('second_loan', $application->second_loan) }}" type="text" min="0"
                            max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="second_loan" id="mortage2" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;2nd Loan Amount">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                    @error('monthly_rental_income')
                        <span class="text-red-700">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="second_loan_rate" class="">Rate</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('second_loan_rate', $application->second_loan_rate) }}" type="number"
                            min="0" max="100"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="second_loan_rate" id="second_loan_rate"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Interest Rate">
                        <span class="inline -ml-12 z-10 opacity-50">%</span>
                        @error('second_loan_rate')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="second_loan_lender" class="">Lender</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('second_loan_lender', $application->second_loan_lender) }}" type="text"
                            min="0" max="100"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="second_loan_lender" id="second_loan_lender"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Lender">
                        @error('second_loan_lender')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="value" class="">Late Payments</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('late_payments', $application->late_payments) }}" type="text"
                            min="0" max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="late_payments" id="late_payments" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Late Payments">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                    @error('late_payments')
                        <span class="text-red-700">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="foreclosure" class="">BK/Foreclosure</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('foreclosure', $application->foreclosure) }}" type="text" min="0"
                            max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="foreclosure" id="foreclosure" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Foreclosure">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                    @error('foreclosure')
                        <span class="text-red-700">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="Liens" class="">Liens</label>
                    </div>
                    <div class="">
                        <input value="{{ old('liens', $application->liens) }}" type="text"
                            class="inputFocus inline rounded-md py-2 w-full focus:border-none focus:outline-none focus:ring-1 focus:ring-blue-400"
                            name="liens" id="Liens" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Liens">
                        @error('liens')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="LTV" class="">LTV</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('LTV', $application->LTV) }}" type="text" min="0" max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="LTV" id="LTV" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;LTV">
                        @error('LTV')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="CLTV" class="">CLTV</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('CLTV', $application->CLTV) }}" type="text" min="0"
                            max="99999999"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="CLTV" id="CLTV" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;CLTV">
                        @error('CLTV')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class=" font-bold text-lg grid grid-cols-5 mt-5">Client's Information:</div>
            <div class=" flex mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-1">
                        <input value="Self Employed" onclick="javascript:employestatus();"
                            {{ old('employement_status', $application->employement_status) == 'Self Employed' ? 'checked' : '' }}
                            type="radio" name="employement_status" id="Self Employed">
                        <label class="pt-3" for="Self Employed">Self Employed</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="Retired" onclick="javascript:employestatus();"
                            {{ old('employement_status', $application->employement_status) == 'Retired' ? 'checked' : '' }}
                            type="radio" name="employement_status" id="Retired"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Multi-Unit Residential">
                        <label class="pt-3" for="Retired">Retired</label>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="Wage Earner" onclick="javascript:employestatus();"
                            {{ old('employement_status', $application->employement_status) == 'Wage Earner' ? 'checked' : '' }}
                            type="radio" class="" name="employement_status" id="Wage Earner">
                        <label class="pt-3" for="Wage Earner">Wage Earner
                        </label>
                    </div>
                </div>
                @error('employement_status')
                    <span class="col-span-1 text-red-700">
                        {{ $message }}<br>
                    </span>
                @enderror

                <div class="">
                    <div class=" text-left mr-12">
                        <input value="other"
                            @php
$a = $application->employement_status;
                        $array = ['Self Employed','Retired','Wage Earner'];
                        if (old('employement_status') == 'other' || !in_array($a, $array)) {
                            echo 'checked';
                        } @endphp
                            onclick="javascript:employestatus();" type="radio" name="employement_status"
                            id="employment_other">
                        <label for="employment_other" class="">Other</label>
                    </div>
                    <div class="mt-1">
                        <input style="display:none;" disabled="true"
                            value="@php
$val = $application->employement_status;
                            $array = ['Self Employed','Retired','Wage Earner'];
                        echo old('employment_other_status', !in_array($val,$array) ? $val : ''); @endphp"
                            type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Other" name="employment_other_status"
                            id="employment_other_status">
                        @error('employment_other_status')
                            <span class="col-span-1 text-red-700">
                                This field is required!
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="Credit Score1" class="">Credit Score 1</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('credit_score1', $application->credit_score1) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Credit Score 1" name="credit_score1" id="Credit Score1">
                        @error('credit_score1')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="Credit Score2" class="">Credit Score 2</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('credit_score2', $application->credit_score2) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Credit Score 2" name="credit_score2" id="Credit Score2">
                        @error('credit_score2')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="reserves" class="">Reserves</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('reserves', $application->reserves) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Reserves" name="reserves" id="reserves">
                        @error('reserves')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="down" class="">Down</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('down', $application->down) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Down" name="down" id="down">
                        @error('down')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="Additional Property" class="">Additional Property</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('additional_property', $application->additional_property) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Additional Property" name="additional_property"
                            id="Additional Property">
                        @error('additional_property')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="Goals/Exit Strategy" class="">Goals/Exit Strategy</label>
                    </div>
                    <div class="mt-1">
                        <input value="{{ old('goal', $application->goal) }}" type="text"
                            class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Goals/Exit Strategy" name="goal"
                            id="Goals/Exit Strategy">
                        @error('goal')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="note" class="">Note</label>
                    </div>
                    <div class="mt-2">
                        <textarea class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="note" id="note" cols="30" rows="7">{{ old('note', $application->note) }}</textarea>
                        @error('note')
                            <span class="text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-5 grid grid-cols-7 text-center">
                <div class="col-span-3 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-3">
                    <button type="submit"
                        class="text-white bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        {{ !empty($application->id) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('foot')
    <script>
        if (document.getElementById('employment_other').checked) {
            var otherInput = document.getElementById('employment_other_status');
            otherInput.style.display = 'block';
            otherInput.disabled = false;
        }

        function employestatus() {
            var otherInput = document.getElementById('employment_other_status');
            if (document.getElementById('employment_other').checked) {
                otherInput.style.display = 'block';
                otherInput.disabled = false;
            } else {
                otherInput.style.display = 'none';
                otherInput.disabled = true;
            }
        }
        if (document.getElementById('property_type_other').checked) {
            var otherInput = document.getElementById('property_type_other_input');
            otherInput.style.display = 'block';
            otherInput.disabled = false;
        }

        function toggleInputVisibility() {
            var otherInput = document.getElementById('property_type_other_input');
            if (document.getElementById('property_type_other').checked) {
                otherInput.style.display = 'block';
                otherInput.disabled = false;
            } else {
                otherInput.style.display = 'none';
                otherInput.disabled = true;
            }
        }
    </script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('[name="cashout"]').on('change', function() {
                if ($(this).val() === 'Yes') {
                    $('#cashout-amount').removeClass('hidden');
                } else {
                    $('#cashout-amount').addClass('hidden');
                }
            });
            $('[name="purchase_type"]').on('change', function() {
                if ($(this).val() === 'company') {
                    $('#company-name').removeClass('hidden');
                } else {
                    $('#company-name').addClass('hidden');
                }
            });
            let mortgage1 = $('#mortage1').val();
            let mortgage2 = $('#mortage2').val();
            let value = $('#value').val();
            let cashoutAmount = $('#cashout-amt').val();
            //Remove commas
            mortgage1 = mortgage1.replaceAll(",", "");
            mortgage2 = mortgage2.replaceAll(",", "");
            value = value.replaceAll(",", "");
            cashoutAmount = cashoutAmount.replaceAll(",", "");
            $('#mortage1').val(formatNumbers(mortgage1));
            $('#mortage2').val(formatNumbers(mortgage2));
            $('#value').val(formatNumbers(value));
            $('#cashout-amt').val(formatNumbers(cashoutAmount));
            $("#mortage1, #mortage2, #value, #cashout-amt").on("keyup paste", function() {
                value = $(this).val();
                value = value.replaceAll(",", "")
                $(this).val(formatNumbers(value));
            });
            $("#info-form").on("submit", function() {
                let mortgage1 = $('#mortage1').val();
                let mortgage2 = $('#mortage2').val();
                let value = $('#value').val();
                let cashoutAmount = $('#cashout-amt').val();
                //Remove commas
                mortgage1 = mortgage1.replaceAll(",", "");
                mortgage2 = mortgage2.replaceAll(",", "");
                value = value.replaceAll(",", "");
                cashoutAmount = cashoutAmount.replaceAll(",", "");
                $('#mortage1').val(mortgage1);
                $('#mortage2').val(mortgage2);
                $('#value').val(value);
                $('#cashout-amt').val(cashoutAmount);
            });
        });

        function formatNumbers(number) {
            number += '';
            x = number.split(',');
            x1 = x[0];
            x2 = x.length > 1 ? ',' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endsection
