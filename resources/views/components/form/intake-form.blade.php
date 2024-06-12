@props(['intake','enableTeams'])
<form class="intakeForm" action="{{ url(getRoutePrefix() . '/submit-intake-form') }}" method="post">
    <x-jq-loader />
    @csrf 

    @if (request()->route()->getName() != 'loan-intake')
        @if (Auth::user()->role == 'Super Admin')
            <div class="mt-3 ">
                <label for="company" class="block text-sm text-dark-500 leading-6 font-bold">Company</label>
                <select
                    class="company w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                        sm:text-sm sm:leading-6"
                    name="company">
                    <option value="">Select Company</option>
                    @foreach (\App\Models\Company::get() as $company)
                        <option {{ old('company') === $company->id ? 'selected' : '' }} value="{{ $company->id }}">
                            {{ $company->name }}</option>
                    @endforeach
                </select>
                <span class="text-red-700" style="text-transform: none !important;" id="company_error"></span>
            </div>
        @endif
        <div class="mt-3 ">
            <label for="team" class="block text-sm text-dark-500 leading-6 font-bold">Teams</label>
            <select
                class="teams w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                        sm:text-sm sm:leading-6"
                name="team">
                <option value="">Select Team</option>
                @if ($currentrole !== 'Super Admin')
                    @foreach ($enableTeams as $team)
                        <option value="{{$team->id}}">{{$team->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-red-700" style="text-transform: none !important;" id="team_error"></span>
        </div>
        <div class="personalinfo grid grid-cols-2 gap-x-4">
            <x-form.input name="first_name" label="First Name" class="mb-0 " />
            <x-form.input name="last_name" label="Last Name" class="mb-0" />
            <x-form.input name="email" label="Email" type="email" />
            <x-form.input name="phone" type="tel" label="Phone Number" value="+1" />
        </div>
    @endif
    <span class="block k mt-1 font-bold">Property Address</span>
    <div class="grid grid-cols-2 gap-x-4">
        <x-form.input name="address" :value="$intake->address ?? ''" label="Street Adress" class="mb-0" />
        <x-form.input name="address_two" :value="$intake->address_two ?? ''" label="Street Address Line 2" class="mb-0" />
        <x-form.input name="city" :value="old('city', $intake->city) ?? ''" label="City" class="mb-0" />
        <x-form.input name="state" :value="$intake->state ?? ''" label="State / Province / Region" class="mb-0" />
        <x-form.input name="zip" type="number" :value="$intake->zip ?? ''" label="Postal/Zip Code" />
        <div class="mt-3 ">
            <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Loan Type</label>
            <select
                class="w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                            sm:text-sm sm:leading-6"
                name="loan_type">
                @foreach (['Private Loan', 'Full Doc', 'Non QM'] as $LoanType)
                    <option {{ old('loan_type', $intake->loan_type) === $LoanType ? 'selected' : '' }}
                        value="{{ $LoanType }}">{{ $LoanType }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <span class="block mt-1 font-bold">Loan Information</span>
    <div class="purchase grid grid-cols-2 gap-x-4">
        <div class="mt-3 ">
            <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Finance Type</label>
            <select
                class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                        sm:text-sm sm:leading-6"
                name="finance_type">
                @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                    <option {{ old('finance_type', $intake->finance_type) === $LoanType ? 'selected' : '' }}
                        value="{{ $LoanType }}">{{ $LoanType }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <x-form.input name="purchase_price" :value="$intake->purchase_price ?? ''" label="Purchase Price" class="mb-0"
                inputClass="input_number" sign="1" />
        </div>
        <div class="relative">
            <x-form.input name="property_value" :value="$intake->property_value ?? ''" label="Property Value" class="mb-0"
                inputClass="input_number" sign="1" />
        </div>
        <div class="relative">
            <x-form.input name="down_payment" :value="$intake->down_payment ?? ''" inputClass="input_number" label="Down Payment"
                class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input name="current_loan_amount_purchase" :value="$intake->current_loan_amount ?? ''" inputClass="input_number"
                label="Current Loan Amount" class="mb-0" sign="1" />
        </div>
        <x-form.input name="closing_date_purchase" :value="$intake->closing_date ?? ''" type="date" class="mb-0"
            label="Closing Date" />
    </div>
    <div class="cashout hidden grid grid-cols-2 gap-x-4">
        <div class="mt-3 ">
            <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Finance Type</label>
            <select
                class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                        sm:text-sm sm:leading-6"
                name="finance_type">
                @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                    <option {{ old('finance_type', $intake->finance_type) === $LoanType ? 'selected' : '' }}
                        value="{{ $LoanType }}">{{ $LoanType }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <x-form.input :value="$intake->current_loan_amount ?? ''" name="current_loan_amount_cashout" inputClass="input_number"
                label="Current Loan Amount" class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->current_lender ?? ''" name="current_lender_cashout" label="Current Lender" class="mb-0" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->rate ?? ''" name="rate_cashout" inputClass="input_number" label="Rate"
                class="mb-0" sign="1" />
        </div>
        <div class="mt-3 ">
            <label for="isItRentalProperty" class="block text-sm text-dark-500 leading-6 font-bold">Is it Rental
                Property?</label>
            <select
                class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                        sm:text-sm sm:leading-6"
                name="is_it_rental_property" id="isItRentalProperty">
                @foreach (['Yes', 'No'] as $rental)
                    <option {{ old('isItRentalProperty', $intake->isItRentalProperty) === $rental ? 'selected' : '' }}
                        value="{{ $rental }}">{{ $rental }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <x-form.input :value="$intake->monthly_rental_income ?? ''" name="monthly_rental_income" inputClass="input_number"
                label="Monthly Rental Income" class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->cashout_amount ?? ''" name="cashout_amount" inputClass="input_number" label="Cash Out Amount"
                class="mb-0" sign="1" />
        </div>
    </div>
    <div class="fix-flip hidden grid grid-cols-2 gap-x-4">
        <div class="mt-3 ">
            <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Finance Type</label>
            <select
                class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                            sm:text-sm sm:leading-6"
                name="finance_type">
                @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                    <option {{ old('finance_type', $intake->finance_type) === $LoanType ? 'selected' : '' }}
                        value="{{ $LoanType }}">{{ $LoanType }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <x-form.input :value="$intake->purchase_price ?? ''" name="purchase_price_fix_flip" inputClass="input_number"
                label="Purchase Price" class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->property_value ?? ''" name="property_value_fix_flip" inputClass="input_number"
                label="Property Value" class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->down_payment ?? ''" name="down_payment_fix_flip" inputClass="input_number"
                label="Down Payment" class="mb-0" sign="1" />
        </div>
        <x-form.input name="closing_date_fix_flip" :value="$intake->closing_date ?? ''" type="date" class="mb-0"
            label="ClosingDate" />
        <div class="mt-3 ">
            <label for="isRepairFinanceNeeded" class="block text-sm text-dark-500 leading-6 font-bold">Is Repair
                Financing Needed?</label>
            <select
                class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
    sm:text-sm sm:leading-6"
                name="is_repair_finance_needed" id="isRepairFinanceNeeded">
                @foreach (['Yes', 'No'] as $rental)
                    <option
                        {{ old('isRepairFinanceNeeded', $intake->isRepairFinanceNeeded) === $rental ? 'selected' : '' }}
                        value="{{ $rental }}">{{ $rental }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative repairfinanceamountdiv">
            <x-form.input :value="$intake->how_much ?? ''" name="repair_finance_amount" inputClass="input_number" label="How much?"
                class="mb-0" sign="1" />
        </div>
    </div>
    <div class="refinance hidden grid grid-cols-2 gap-x-4">
        <div class="mt-3 ">
            <label for="loantype" class="block text-sm text-dark-500 leading-6 font-bold">Finance Type</label>
            <select
                class="loantype w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
    sm:text-sm sm:leading-6"
                name="finance_type">
                @foreach (['Purchase', 'Cash Out', 'Fix & Flip', 'Refinance'] as $LoanType)
                    <option {{ old('finance_type', $intake->finance_type) === $LoanType ? 'selected' : '' }}
                        value="{{ $LoanType }}">{{ $LoanType }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <x-form.input :value="$intake->current_loan_amount ?? ''" name="current_loan_amount_refinance" inputClass="input_number"
                label="Current Loan Amount" class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->current_lender ?? ''" name="current_lender_refinance" type="text" label="Current Lender"
                class="mb-0" sign="1" />
        </div>
        <div class="relative">
            <x-form.input :value="$intake->rate ?? ''" name="rate_refinance" inputClass="input_number" label="Rate"
                class="mb-0" sign="1" />
        </div>
        <div class="mt-3 ">
            <label for="isItRentalPropertyRefinance" class="block text-sm text-dark-500 leading-6 font-bold">Is it
                Rental
                Property?</label>
            <select
                class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
    sm:text-sm sm:leading-6"
                name="is_it_rental_property_refinance" id="isItRentalPropertyRefinance">
                @foreach (['No', 'Yes'] as $rental)
                    <option value="{{ $rental }}">{{ $rental }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <x-form.input :value="$intake->monthly_rental_income ?? ''" name="monthly_rental_income_refinance" inputClass="input_number"
                label="Monthly Rental Income" class="mb-0 hidden" sign="1" />
        </div>
    </div>
    <div class="mt-3 grid grid-cols-1">
        <label for="Note" class="block text-sm text-dark-500 leading-6 font-bold">Note</label>
        <textarea
            class="w-full bg-gray-100 border-1
ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
sm:text-sm sm:leading-6"
            name="note" id="Note" cols="30" rows="3">{{ old('note', $intake->note) }}</textarea>
        <span class="text-red-700" style="text-transform: none !important;" id="note_error"></span>

        <div class="flex justify-end">
            <button type="submit"
                class="intakeFormSubmit w-1/4 py-2 mt-3 bg-red-800 text-white px-5 text-xs font-thin teamContinue">Continue</button>
        </div>
    </div>
</form>
