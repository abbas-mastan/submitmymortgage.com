@component('components.modal-background', ['title' => 'Create New Team'])
    <form action="{{ url(getRoutePrefix() . '/teams') }}" id="teamForm" method="post">
        <x-jq-loader />
        @csrf
        <div class="createTeam">
            @if (count($enableTeams) > 0)
                <div>
                    <input type="radio" checked name="team" id="newInput" onclick="changeInputs()">
                    <label for="newInput">Add New</label>
                    <input class="ml-2" type="radio" name="team" id="existingInput" onclick="changeInputs()">
                    <label for="existingInput">Existing Team</label>
                </div>
            @endif
            <div id="existing" class="hidden my-3 pb-5">
                <label for="team" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                    Select Team
                </label>
                <select
                    class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
                    name="name" id="selecTeam">
                    <option>Select Team</option>
                    @foreach ($enableTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
                <span class="text-red-700" id="team_error"></span>
            </div>
            <div id="new">
                <x-form.input name="name" label="Group Name" class="mb-10" />
            </div>

            <div class="my-3 flex justify-end mt-5">
                <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin teamContinue">Continue</button>
            </div>
        </div>
        <div class="processor hidden">
            <div class="my-3">
                <div class="relative text-left">
                    <label for="processor" class="text-sm text-dark-500 leading-6 font-bold"> Processor Name
                    </label>
                    <div class="">
                        <button type="button"
                            class="processorButton overflow-hidden h-8 pt-1 flex justify-between align-center w-full shadow-none px-2 py-0.5 bg-gray-100 border-1
                            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                             sm:text-sm sm:leading-6"
                            id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                            <span class="processorButtonText truncate">
                                Select Processor
                            </span>
                            <img class="w-4 mt-1" src="{{ asset('icons/chewron.svg') }}" alt="">
                        </button>
                    </div>
                    <!-- Dropdown panel -->
                    <div class="processorDropdown hidden absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                        role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown">
                        <!-- Checkboxes for options -->
                        @foreach ($users as $user)
                            @continue($user->role !== 'Processor')
                            <input type="hidden" name="count" class="processorcount" value="{{ $loop->index }}">
                            <div class="py-1">
                                <label
                                    class="processorLabel flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                    role="option">
                                    <input type="checkbox" name="processor[]"
                                        class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="{{ $user->id }}">
                                    {{ $user->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <span class="text-red-700" id="processor_error"></span>
            </div>
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateTeam">back</span>
                <button class="bg-red-800 text-white px-8 py-1 text-xs font-thin processorContinue">Continue</button>
            </div>
        </div>
        <div class="associate hidden">
            <div class="relative text-left">
                <label for="Associate" class="text-sm text-dark-500 leading-6 font-bold"> Associate Name
                </label>
                <div class="">
                    <button type="button"
                        class="associateButton h-8 pt-1 flex justify-between align-center w-full shadow-none px-2 py-0.5 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                         sm:text-sm sm:leading-6"
                        id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                        <span class="associateButtonText truncate">
                            Select Associate
                        </span>
                        <img class="w-4 mt-1" src="{{ asset('icons/chewron.svg') }}" alt="">
                    </button>
                </div>
                <!-- Dropdown panel -->
                <div class="associateDropdown hidden absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                    role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">
                    @foreach ($users as $user)
                        @continue($user->role !== 'Associate')
                        <div class="py-1">
                            <label
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                role="option">
                                <input type="checkbox" name="associate[]"
                                    class="associateInput form-checkbox h-4 w-4 text-blue-600 mr-2"
                                    value="{{ $user->id }}">
                                {{ $user->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button class="text-red-700 my-3  addNewAssociate">+ Add Associate</button>
            </div>
            <span class="text-red-700" id="associate_error"></span>
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateProcessor">back</span>
                <button class="bg-red-800 text-white px-8 py-1 text-xs font-thin associateContinue">Continue</button>
            </div>
        </div>
        <div class="jrAssociate hidden">
            <div class="relative text-left">
                <label for="JrAssociate" class="text-sm text-dark-500 leading-6 font-bold"> Jr.Associate Name
                </label>
                <div class="">
                    <button type="button"
                        class="jrAssociateButton  h-8 pt-1 flex justify-between align-center w-full shadow-none px-2 py-0.5 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                         sm:text-sm sm:leading-6"
                        id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                        <span class="jrAssociateButtonText truncate">
                            Select Jr.Associate
                        </span>
                        <img class="w-4 mt-1" src="{{ asset('icons/chewron.svg') }}" alt="">
                    </button>
                </div>
                <!-- Dropdown panel -->
                <div class="jrAssociateDropdown hidden z-10 absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                    role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">
                   
                        @foreach ($users as $user)
                            @continue($user->role !== 'Junior Associate')
                            <div class="py-1">
                                <label
                                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                    role="option">
                                    <input type="checkbox" name="jrAssociate[]"
                                        class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="{{ $user->id }}">
                                    {{ $user->name }}
                                </label>
                            </div>
                        @endforeach
                </div>
            </div>
            <span class="text-red-700" id="jrAssociate_error"></span>
            <x-form.input name="jrAssociateManager" label="Jr. Associate's Manager" type="email" class="mb-10" />
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateAssociate">Back</span>
                <button type="submit"
                    class="bg-red-800 text-white px-8 py-1 text-xs font-thin jrAssociateContinue">Continue</button>
            </div>
        </div>
    </form>

    <form action="{{ getRoutePrefix() . '/do-associate' }}" class="associateForm hidden">
        @csrf
        <x-form.input name="AssociateName" label="Associate Name" class="mb-5" />
        <x-form.input name="AssociateEmail" type="email" label="Assoicate Email" class="mb-5" />
        <div class="my-3 flex justify-between mt-5">
            <button class="bg-gray-400 text-white px-8 py-2 text-xs font-thin backToAssociate">back</button>
            <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin" type="submit ">Continue</button>
        </div>
    </form>

@endcomponent
