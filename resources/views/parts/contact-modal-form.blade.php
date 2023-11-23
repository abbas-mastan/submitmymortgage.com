@component('components.modal-background', ['title' => 'Create New Contact'])
    <div>
        <form class="contactForm" action="{{url(getRoutePrefix().'/do-contact')}}" method="post">
            @csrf
            <div class="namepart">
                <x-form.input name="name" label="Contact Name" />
                <x-form.input name="email" label="Contact Email" />
                <x-form.input type="number" name="loanamount" label="Loan Amount" />
                <div class="my-3">
                    <label for="loantype" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                        Loan Type
                    </label>
                    <select
                        class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
                        name="loantype" id="loantype">
                        <option value="">Select Loan Type</option>
                        @foreach (['Private Loan', 'Full Doc', 'Non QM'] as $loan)
                            <option value="{{ $loan }}">{{ $loan }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-700" id="loantype_error"></span>
                </div>
                <div class="my-3 flex justify-end mt-5">
                    <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
@endcomponent
