@component('components.modal-background', ['title' => 'Add Members', 'id' => 'addNewMember'])
    <div>
        <form class="EditProjectForm" method="post">
            <x-jq-loader />
            <div class="teampart hidden">
                <div class="my-3 teamDiv">
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
                <div class="addProcessorDiv">
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
                        <label for="jrAssociate">Jr.Associate</label>
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
        </form>
    </div>
@endcomponent
