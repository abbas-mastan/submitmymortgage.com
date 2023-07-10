@extends('layouts.app')
@section('content')
    <div class="w-3/4 mt-10 mx-auto">
        <div class="">
            <h1 class="text-xl uppercase text-center">
                Basic Information
            </h1>
        </div>
        <form id="info-form" action="{{ url(getRoutePrefix() . '/do-info') }}" method="post" class="w-full">
            @csrf
            <div class="">
                <p class="text-lg font-bold -ml-8">Borrower's Info</p>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_fname" class="">Borrower's First Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('b_fname', $info->b_fname) }}" type="text"
                            class=" rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_fname" id="b_fname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;First Name">
                    </div>
                    @error('b_fname')
                        <span class="text-red-700">This field is required</span>
                    @enderror
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_lname" class="">Borrower's Last Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('b_lname', $info->b_lname) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_lname" id="b_lname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Last name">
                    </div>
                    @error('b_lname')
                        <span class="text-red-700">This field is required</span>
                    @enderror
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_email" class="">Email</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('b_email', $info->b_email) }}" type="email"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_email" id="b_email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Email Address">
                    </div>
                    @error('b_email')
                        <span class="text-red-700">This field is required</span>
                    @enderror
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_phone" class="">Phone #</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('b_phone', $info->b_phone) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_phone" id="b_phone" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Phone#">
                        @error('b_phone')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="b_address" class="">Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('b_address', $info->b_address) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_address" id="b_address" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Address">
                        @error('b_address')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_suite" class="">&nbsp;</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('b_suite', $info->b_suite) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_suite" id="b_suite" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Suite">
                        @error('b_suite')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-2">
                        <input value="{{ old('b_city', $info->b_city) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_city" id="b_city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's City">
                        @error('b_city')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <select name="b_state" id="b_state"
                            class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ old('b_state', $info->b_state) === $state ? 'selected' : '' }}
                                    value="{{ $state }}">
                                    {{ $state }}</option>
                            @endforeach
                        </select>
                        @error('b_state')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="{{ old('b_zip', $info->b_zip) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="b_zip" id="b_zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Zip">
                        @error('b_zip')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            <div class="">
                <p class="text-lg font-bold -ml-8">Co Borrower's Info</p>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_fname" class="">Co Borrower's First Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('co_fname', $info->co_fname) }}" type="text"
                            class=" rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_fname" id="co_fname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;First Name">
                        @error('co_fname')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="co_lname" class="">Co Borrower's Last Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('co_lname', $info->co_lname) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_lname" id="co_lname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Last name">
                        @error('co_lname')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="co_email" class="">Email</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('co_email', $info->co_email) }}" type="email"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_email" id="co_email"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Email Address">
                        @error('co_email')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="co_phone" class="">Phone #</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('co_phone', $info->co_phone) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_phone" id="co_phone" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Phone#">
                        @error('co_phone')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="co_address" class="">Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('co_address', $info->co_address) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_address" id="co_address"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Address">
                        @error('co_address')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_suite" class="">&nbsp;</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('co_suite', $info->co_suite) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_suite" id="co_suite" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Suite">
                        @error('co_suite')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-2">
                        <input value="{{ old('co_city', $info->co_city) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_city" id="co_city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's City">
                        @error('co_city')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <select name="co_state" id="co_state"
                            class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ old('co_state', $info->co_state) === $state ? 'selected' : '' }}
                                    value="{{ $state }}">
                                    {{ $state }}</option>
                            @endforeach
                        </select>
                        @error('co_state')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="{{ old('co_zip', $info->co_zip) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="co_zip" id="co_zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Zip">
                        @error('co_zip')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            <div class="">
                <p class="text-lg font-bold -ml-8">Subject Property</p>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="b_address" class="">Subject Property Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('p_address', $info->p_address) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="p_address" id="p_address" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Property's Address">
                        @error('p_address')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="p_suite" class="">&nbsp;</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('p_suite', $info->p_suite) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="p_suite" id="p_suite" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Suite">
                        @error('p_suite')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    <div class="mt-2">
                        <input value="{{ old('p_city', $info->p_city) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="p_city" id="p_city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp; City">
                        @error('p_city')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <select name="p_state" id="p_state"
                            class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ old('p_state', $info->p_state) === $state ? 'selected' : '' }}
                                    value="{{ $state }}">
                                    {{ $state }}</option>
                            @endforeach
                        </select>
                        @error('p_state')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="{{ old('p_zip', $info->p_zip) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="p_zip" id="p_zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Zip">
                        @error('p_zip')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            @if (session('role') != 'Borrower')
                <div class="">
                    <p class="text-lg font-bold -ml-8">Finance Type</p>
                </div>
                <div class="mt-2 grid grid-cols-2 gap-8">
                    <div>
                        <input type="radio" name="finance_type" required id="Refinance" value="Refinance">
                        <label for="Refinance">Refinance</label>
                    </div>
                    <div>
                        <input type="radio" name="finance_type" required id="Purchase" value="Purchase">
                        <label for="Purchase">Purchase</label>
                    </div>
                </div>
            @endif
            {{-- @if (auth()->user()->finance_type == 'Refinance') --}}
            <div class="finance-section @if (auth()->user()->finance_type != 'Refinance') hidden @endif">
                <div class="mt-2 grid grid-cols-2 gap-8">
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="mortage1" class="">1st Mortgage</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ old('mortage1', $info->mortage1) }}" type="number" min="0"
                                max="99999999"
                                class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="mortage1" id="mortage1" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;1st Mortgage">
                            <span class="inline -ml-12 z-10 opacity-50">$</span>
                        </div>
                        @error('mortgage1')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="interest1" class="">Interest Rate</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ old('interest1', $info->interest1) }}" type="number" min="0"
                                max="100"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="interest1" id="interest1" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Interest Rate">
                            <span class="inline -ml-12 z-10 opacity-50">%</span>
                        </div>
                        @error('interest1')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-2 grid grid-cols-2 gap-8">
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="mortage2" class="">2nd Mortgage</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ old('mortage2', $info->mortage2) }}" type="number" min="0"
                                max="99999999"
                                class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="mortage2" id="mortage2" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;2nd Mortgage">
                            <span class="inline -ml-12 z-10 opacity-50">$</span>
                        </div>
                        @error('mortgage2')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="interest2" class="">Interest Rate</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ old('interest2', $info->interest2) }}" type="number" min="0"
                                max="100"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="interest2" id="interest2" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Interest Rate">
                            <span class="inline -ml-12 z-10 opacity-50">%</span>
                        </div>
                        @error('interest2')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-2 grid grid-cols-2 gap-8">
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="value" class="">Home Value</label>
                        </div>
                        <div class="mt-2">

                            <input value="{{ old('value', $info->value) }}" type="number" min="0"
                                max="99999999"
                                class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="value" id="value" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Home Value">
                            <span class="inline -ml-12 z-10 opacity-50">$</span>
                        </div>
                        @error('value')
                            <span class="text-red-700">This field is required</span>
                        @enderror
                    </div>
                    <div class="">

                    </div>
                </div>
                <div class="mt-2">
                    <div class=" text-left mr-12">
                        <label class="">Cash Out</label>
                    </div>
                    <div class="mt-2 ml-5">
                        <input {{ old('cashout', $info->cashout) === 'Yes' ? 'checked' : '' }} value="Yes"
                            type="radio" class="" name="cashout" id="cashout-yes">
                        <label for="cashout-yes" class="">Yes</label><br>
                        <input {{ old('cashout', $info->cashout) === 'No' ? 'checked' : '' }} value="No"
                            type="radio" class="" name="cashout" id="cashout-no">
                        <label for="cashout-no" class="">No</label>
                    </div>
                </div>
                <div class="{{ old('cashout', $info->cashout) === 'Yes' ? '' : 'hidden' }}" id="cashout-amount">
                    <div class=" text-left mr-12">
                        <label for="cashout-amt" class="">How much cashout are you requesting?</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('cashout_amount', $info->cashout_amount) }}" type="number" min="0"
                            max="99999999"
                            class="inline rounded-md py-2 w-1/2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="cashout_amount" id="cashout-amt" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Cashout Amount">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
            {{-- @if (auth()->user()->finance_type == 'Purchase') --}}
            <div class="purchase-section @if (auth()->user()->finance_type != 'Purchase') hidden @endif">
                <div class="mt-4">
                    <div class=" text-left mr-12">
                        <label class="">Is this a Personal purchase or a Company purchase?</label>
                    </div>
                    <div class="mt-2  ml-5">
                        <input {{ old('purchase_type', $info->purchase_type) === 'personal' ? 'checked' : '' }}
                            value="personal" type="radio" class="" name="purchase_type" id="personal">
                        <label for="personal" class="">Personal</label><br>
                        <input {{ old('purchase_type', $info->purchase_type) === 'company' ? 'checked' : '' }}
                            value="company" type="radio" class="" name="purchase_type" id="company">
                        <label for="company" class="">Company</label>
                    </div>
                </div>
                <div class="{{ old('purchase_type', $info->purchase_type) ? '' : 'hidden' }}" id="company-name">
                    <div class=" text-left mr-12">
                        <label for="company_name" class="">Company Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('company_name', $info->company_name) }}" type="text"
                            class="inline rounded-md py-2 w-1/2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="company_name" id="company_name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Company's Name">
                    </div>
                </div>
                <div class="mt-4">
                    <div class=" text-left mr-12">
                        <label class="">Investment or Primary Residence</label>
                    </div>
                    <div class="mt-2  ml-5">
                        <input {{ old('purchase_purpose', $info->purchase_purpose) === 'investment' ? 'checked' : '' }}
                            value="investment" type="radio" class="" name="purchase_purpose" id="investment">
                        <label for="investment" class="">Investment</label><br>
                        <input {{ old('purchase_purpose', $info->purchase_purpose) === 'residence' ? 'checked' : '' }}
                            value="residence" type="radio" class="" name="purchase_purpose" id="residence">
                        <label for="residence" class="">Residence</label>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-8">
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="purchase_price" class="">Purchase Price</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ old('purchase_price', $info->purchase_price) }}" type="number"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="purchase_price" id="purchase_price"
                                placeholder="&nbsp;&nbsp;&nbsp;&nbsp; Purchase Price">
                        </div>
                    </div>
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="purchase_dp" class="">Down Payment Amount</label>
                        </div>
                        <div class="mt-2">

                            <div class="mt-2">
                                <input value="{{ old('purchase_dp', $info->purchase_dp) }}" type="number"
                                    class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                    name="purchase_dp" id="purchase_dp"
                                    placeholder="&nbsp;&nbsp;&nbsp;&nbsp; Down Payment Amount">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="loan_amount" class="">Loan Amount</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ old('loan_amount', $info->loan_amount) }}" type="number"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="loan_amount" id="loan_amount" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Loan Amount">
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
            <div class="my-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit"
                        class="text-white bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        {{ !empty($info->id) ? 'Update' : 'Save' }}
                    </button>
                </div>

            </div>

        </form>

    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            // Event handler for radio button change
            $('input[name="finance_type"]').change(function() {

                var financeType = $(this).val();
                console.log(financeType);
                // Show/hide sections based on the selected radio button
                if (financeType === 'Refinance') {
                    $('.finance-section').removeClass('hidden');
                    $('.purchase-section').addClass('hidden');
                } else if (financeType === 'Purchase') {
                    $('.finance-section').addClass('hidden');
                    $('.purchase-section').removeClass('hidden');
                }
            });
        });
    </script>
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
