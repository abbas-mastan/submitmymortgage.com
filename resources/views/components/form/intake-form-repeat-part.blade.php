@props(['intake'])
<div class="mt-3 ">
    <label for="finance_type" class="block text-sm text-dark-500 leading-6 font-bold">Finance Type</label>
    <select
        class="finance_type w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
        name="finance_type">
        @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $finance_type)
            <option {{ old('finance_type', $intake->finance_type ?? '') === $finance_type ? 'selected' : '' }}
                value="{{ $finance_type }}">{{ $finance_type }}</option>
        @endforeach
    </select>
    <span class="text-red-700 finance_type_error" style="text-transform: none !important;" id="finance_type_error"></span>
</div>
<div class="mt-3 ">
    <label for="property_type" class="block text-sm text-dark-500 leading-6 font-bold">Property Type</label>
    <select
        class="property_type w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
        name="property_type">
        <option value="">Select an option</option>
        @foreach (['Single Family Residence', 'Multi-Unit Residential', 'Multi-Unit Building', 'Commercial Property'] as $property_type)
            <option {{ old('property_type', $intake->property_type ?? '') === $property_type ? 'selected' : '' }}
                value="{{ $property_type }}">{{ $property_type }}</option>
        @endforeach
    </select>
    <span class="text-red-700 property_type_error" style="text-transform: none !important;" id="property_type_error"></span>
</div>
<div class="mt-3 ">
    <label for="loan_type" class="block text-sm text-dark-500 leading-6 font-bold">Loan Type</label>
    <select
        class="loan_type w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                    sm:text-sm sm:leading-6"
        name="loan_type">
        <option value="">Select an option</option>
        @foreach (['Private Loan', 'Full Doc', 'Non QM'] as $LoanType)
            <option {{ old('loan_type', $intake->loan_type ?? '') === $LoanType ? 'selected' : '' }}
                value="{{ $LoanType }}">{{ $LoanType }}</option>
        @endforeach
    </select>
    <span class="text-red-700 loan_type_error" style="text-transform: none !important;" id="loan_type_error"></span>
</div>
<div class="mt-3 ">
    <label for="property_profile" class="block text-sm text-dark-500 leading-6 font-bold">Property Profile</label>
    <select
        class="property_profile w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
        name="property_profile">
        <option value="">Select an option</option>
        @foreach (['Primary', 'Investment'] as $property_profile)
            <option
                {{ old('property_profile', $intake->property_profile ?? '') === $property_profile ? 'selected' : '' }}
                value="{{ $property_profile }}">{{ $property_profile }}</option>
        @endforeach
    </select>
    <span class="text-red-700 property_profile_error" style="text-transform: none !important;" id="property_profile_error"></span>
</div>