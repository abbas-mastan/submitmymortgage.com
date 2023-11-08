@component('components.modal-background', ['title' => 'Create New Deal'])
    <div>
        <form class="projectForm" method="post">
            @csrf
            <div class="namepart">
                <x-form.input name="name" label="Borrower's Name" />
                <div class="my-3 mt-1flex align-center">
                    <input type="checkbox" value="1" name="sendemail" id="sendemail">
                    <label class="ml-2 text-sm leading-normal text-gray-500" for="sendemail">I want the borrower
                        involved</label>
                </div>
                <x-form.input name="email" attribute="disabled" class="email hidden" label="Borrower's Email" />
                <x-form.input name="borroweraddress" label="Borrower's Address" />
                <div class="my-3 flex justify-end mt-5">
                    <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin nameContinue">Continue</button>
                </div>
            </div>

            <div class="typepart hidden">
                <div class="my-3">
                    <label for="financetype" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                        Finance Type
                    </label>
                    <select
                        class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
                        name="financetype" id="financetype">
                        <option value="">Select Finance Type</option>
                        @foreach (['Purchase', 'Refinance'] as $finance)
                            <option value="{{ $finance }}">{{ $finance }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-700" id="financetype_error"></span>
                </div>
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
                <div class="my-3 mt-10 flex justify-between">
                    <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToname">back</span>
                    <button class="bg-red-800 text-white px-8 py-1 text-xs font-thin typeContinue">Continue</button>
                </div>
            </div>
            <div class="teampart hidden">
                <div class="my-3">
                    <label for="team" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                        Select Team
                    </label>
                    <select
                        class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
                        name="team" id="team">
                        <option value="" disabled selected>Select Team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-700" id="team_error"></span>
                </div>
                <div>
                    <input type="checkbox" name="addprocessor" id="addprocessor">
                    <label class="text-normal" for="addprocessor">Add Processor</label>
                </div>
                <div class="my-3 processor hidden">
                    <div class="relative text-left">
                        <label for="Processor" class="text-sm text-dark-500 leading-6 font-bold">Select Processor</label>
                        <div class="">
                            <button type="button" id="Processor"
                                class="processorButton h-8 pt-1 flex justify-between align-center w-full shadow-none px-4 py-0.5 bg-gray-100 border-1
                                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                                 sm:text-sm sm:leading-6"
                                id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                                <span class="processorButtonText truncate">
                                    Select Processor
                                </span>
                                <img style="width: 10px;" class="mt-2" src="{{ asset('icons/chewron.svg') }}"
                                    alt="">
                            </button>
                        </div>
                        <!-- Dropdown panel -->
                        <div class="processorDropdown hidden absolute z-10 flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                            role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">
                        </div>
                    </div>
                    <span class="text-red-700" id="processor_error"></span>
                </div>
                <div class="my-3">
                    <div class="relative text-left">
                        <label for="Associate" class="text-sm text-dark-500 leading-6 font-bold">Select Associate</label>
                        <div class="">
                            <button type="button" id="Associate"
                                class="associateButton h-8 pt-1 flex justify-between align-center w-full shadow-none px-4 py-0.5 bg-gray-100 border-1
                                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                                 sm:text-sm sm:leading-6"
                                id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                                <span class="associateButtonText truncate">
                                    Select Associate
                                </span>
                                <img style="width: 10px;" class="w-[10px] mt-2" src="{{ asset('icons/chewron.svg') }}"
                                    alt="">
                            </button>
                        </div>
                        <!-- Dropdown panel -->
                        <div class="associateDropdown hidden absolute z-10 flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                            role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">
                        </div>
                    </div>
                    <span class="text-red-700" id="associate_error"></span>
                </div>
                <div class="my-3" bis_skin_checked="1">
                    <div class="relative text-left" bis_skin_checked="1">
                        <label for="jrAssociate" class="text-sm text-dark-500 leading-6 font-bold">Select
                            Jr.Associate</label>
                        <div class="">
                            <button type="button" id="jrAssociate"
                                class="jrAssociateButton h-8 pt-1 flex justify-between align-center w-full shadow-none px-4 py-0.5 bg-gray-100 border-1
                                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                                 sm:text-sm sm:leading-6"
                                id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                                <span class="juniorAssociateButtonText truncate">
                                    Select Jr.Associate
                                </span>
                                <img style="width: 10px;" class="w-[10px] mt-2" src="{{ asset('icons/chewron.svg') }}"
                                    alt="">
                            </button>
                        </div>
                        <!-- Dropdown panel -->
                        <div class="jrAssociateDropdown hidden absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                            role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">
                        </div>
                    </div>
                    <span class="text-red-700" id="juniorAssociate_error"></span>
                </div>
                <div class="my-3 flex justify-between mt-10">
                    <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backTotype">back</span>
                    <button type="submit"
                        class="bg-red-800 text-white px-5 text-xs font-thin teamContinue">Continue</button>
                </div>
            </div>
        </form>
    </div>
@endcomponent
