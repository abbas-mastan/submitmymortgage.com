@component('components.modal-background', ['title' => 'Create New Team'])
    <form action="{{ url(getAdminRoutePrefix() . '/teams') }}" id="teamForm" method="post">
        @csrf
        <div class="createTeam">
            @if (count($teams) > 0)
                <div>
                    <input type="radio" name="team" id="newInput" onclick="changeInputs()">
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
                    @foreach ($teams as $team)
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
                            class="processorButton  h-8 pt-1 flex justify-between align-center w-full shadow-none px-2 py-0.5 bg-gray-100 border-1
                            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                             sm:text-sm sm:leading-6"
                            id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                            Select Processor
                            <img class="w-4 mt-1" src="{{ asset('icons/chewron.svg') }}" alt="">
                        </button>
                    </div>
                    <!-- Dropdown panel -->
                    <div class="processorDropdown hidden absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                        role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown">
                        <!-- Checkboxes for options -->
                        @if (Auth::user()->role === 'Admin')
                            @foreach ($users as $user)
                                @if ($user->role !== 'Processor')
                                    @continue
                                @endif
                                <input type="hidden" name="count" class="processorcount" value="{{ $loop->index }}">
                                <div class="py-1">
                                    <label
                                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                        role="option">
                                        <input type="checkbox" name="processor[]"
                                            class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <input type="hidden" name="count" class="processorcount" value="1">
                            <div class="py-1">
                                <label
                                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                    role="option">
                                    <input type="checkbox" name="processor[]"
                                        class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="{{ Auth::id() }}">
                                    {{ Auth::user()->name }}
                                </label>
                            </div>
                        @endif

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
                        class="associateButton  h-8 pt-1 flex justify-between align-center w-full shadow-none px-2 py-0.5 bg-gray-100 border-1
                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                         sm:text-sm sm:leading-6"
                        id="multiselect-toggle" aria-haspopup="listbox" aria-expanded="true">
                        Select Associate
                        <img class="w-4 mt-1" src="{{ asset('icons/chewron.svg') }}" alt="">
                    </button>
                </div>
                <!-- Dropdown panel -->
                <div class="associateDropdown hidden absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                    role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">

                </div>
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
                        Select Jr.Associate
                        <img class="w-4 mt-1" src="{{ asset('icons/chewron.svg') }}" alt="">
                    </button>
                </div>
                <!-- Dropdown panel -->
                <div class="jrAssociateDropdown hidden absolute flex-wrap w-[100%] overflow-y-auto mt-2 w-64 bg-white border border-gray-300 shadow-lg origin-top-right divide-y divide-gray-200"
                    role="listbox" aria-labelledby="multiselect-toggle" id="multiselect-dropdown1">
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
@endcomponent
