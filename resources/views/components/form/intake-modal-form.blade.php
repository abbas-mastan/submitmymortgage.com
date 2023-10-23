@component('components.modal-background', ['title' => 'Loan Intake Form', 'width' => 'max-w-lg'])
@php
    $dollarsign = '<span
            class="absolute  top-1/4 mt-5 inset-y-0  pl-3  sm:text-sm sm:leading-6
    flex items-center">$</span>';
@endphp
<div class="grid grid-cols-2 gap-x-4">
    <x-form.input name="firstname" label="First Name" class="mb-0" />
    <x-form.input name="lastname" label="Last Name" class="mb-0" />
    <x-form.input name="email" label="Email" type="email" />
    <x-form.input name="phone" type="number" label="Phone Number" />
</div>
<span class="block k mt-1 font-bold">Property Address</span>
<div class="grid grid-cols-2 gap-x-4">
    <x-form.input name="address" label="Street Adress" class="mb-0" />
    <x-form.input name="addresstwo" label="Street Address Line 2" class="mb-0" />
    <x-form.input name="city" label="city" class="mb-0" />
    <x-form.input name="state" label="State / Province / Region" class="mb-0" />
    <x-form.input name="zip" label="Postal/Zip Code" />
</div>
<span class="block mt-1 font-bold">Loan Information</span>
<div class="purchase grid grid-cols-2 gap-x-4">
    <div class="mt-3 ">
        <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Loan Type</label>
        <select
            class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="loantype">
            @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                <option value="{{ $LoanType }}">{{ $LoanType }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative">
        <x-form.input name="purchaseprice" type="number" label="Purchase Price" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="propertyvalue" type="number" label="Property Value" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="downpayment" type="number" label="Down Payment" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="loanamount" type="number" label="Current Loan Amount" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <x-form.input name="closingdate" type="date" class="mb-0" label="ClosingDate" />
</div>
<div class="cashout hidden grid grid-cols-2 gap-x-4">
    <div class="mt-3 ">
        <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Loan Type</label>
        <select
            class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="loantype">
            @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                <option value="{{ $LoanType }}">{{ $LoanType }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative">
        <x-form.input name="currentloanamount" type="number" label="Current Loan Amount" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="currentlender" type="number" label="Current Lender" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="rate" type="number" label="Rate" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="mt-3 ">
        <label for="isItRentalProperty" class="block text-sm text-dark-500 leading-6 font-bold">Is it Rental
            Property?</label>
        <select
            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="isItRentalProperty" id="isItRentalProperty">
            @foreach (['Yes', 'No'] as $retal)
                <option value="{{ $retal }}">{{ $retal }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative">
        <x-form.input name="monthlyrentalincome" type="number" label="Monthly Rental Income" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="cashoutamount" type="number" label="Cash Out Amount" class="mb-0" />
        {!! $dollarsign !!}
    </div>
</div>
<div class="fix-flip hidden grid grid-cols-2 gap-x-4">
    <div class="mt-3 ">
        <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Loan Type</label>
        <select
            class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="loantype">
            @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                <option value="{{ $LoanType }}">{{ $LoanType }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative">
        <x-form.input name="purchaseprice" type="number" label="Purchase Price" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="propertyvalue" type="number" label="Property Value" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="downpayment" type="number" label="Down Payment" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <x-form.input name="closingdate" type="date" class="mb-0" label="ClosingDate" />
    <div class="mt-3 ">
        <label for="isRepairFinanceNeeded" class="block text-sm text-dark-500 leading-6 font-bold">Is Repair
            Financing Needed?</label>
        <select
            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="isRepairFinanceNeeded" id="isRepairFinanceNeeded">
            @foreach (['Yes', 'No'] as $retal)
                <option value="{{ $retal }}">{{ $retal }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative repairfinanceamountdiv">
        <x-form.input name="repairfinanceamount" type="number" label="How much?" class="mb-0" />
        {!! $dollarsign !!}
    </div>
</div>
<div class="refinance hidden grid grid-cols-2 gap-x-4">
    <div class="mt-3 ">
        <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Loan Type</label>
        <select
            class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="loantype">
            @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                <option value="{{ $LoanType }}">{{ $LoanType }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative">
        <x-form.input name="currentloanamount" type="number" label="Current Loan Amount" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="currentlender" type="number" label="Current Lender" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="relative">
        <x-form.input name="rate" type="number" label="Rate" class="mb-0" />
        {!! $dollarsign !!}
    </div>
    <div class="mt-3 ">
        <label for="isItRentalProperty" class="block text-sm text-dark-500 leading-6 font-bold">Is it Rental
            Property?</label>
        <select
            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
            name="isItRentalProperty" id="isItRentalProperty">
            @foreach (['Yes', 'No'] as $retal)
                <option value="{{ $retal }}">{{ $retal }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative">
        <x-form.input name="monthlyrentalincome" type="number" label="Monthly Rental Income" class="mb-0" />
        {!! $dollarsign !!}
    </div>
</div>
<div class="mt-3 grid grid-cols-1">
    <label for="Note" class="block text-sm text-dark-500 leading-6 font-bold">Note</label>
    <textarea
        class="w-full bg-gray-100 border-1
    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
    sm:text-sm sm:leading-6"
        name="Note" id="Note" cols="30" rows="3"></textarea>
    <div class="flex justify-end">
        <button type="submit"
            class="w-1/4 py-2 mt-3 bg-red-800 text-white px-5 text-xs font-thin teamContinue">Continue</button>
    </div>
</div>
@endcomponent