@component('components.modal-background', ['title' => 'Create New Team'])
    <form action="{{ url(getAdminRoutePrefix() . '/teams') }}" id="teamForm" method="post">
        @csrf
        <div class="createTeam">
            <div>
                <input type="radio" name="team" id="newInput" onclick="changeInputs()">
                <label for="newInput">Add New</label>
                <input  class="ml-2" type="radio" name="team" id="existingInput" onclick="changeInputs()">
                <label for="existingInput">Existing Team</label>
            </div>
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

        <div class="associate hidden">
            <div class="my-3">
                <label for="associate" class="text-sm text-dark-500 leading-6 font-bold"> Associate Name
                </label>
                <select
                    class="mb-5 w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
                    name="associate" id="associate">
                    <option>Select Associate Name</option>
                    @foreach ($users as $user)
                        @if ($user->role !== 'Associate')
                            @continue
                        @endif
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <span class="text-red-700" id="associate_error"></span>
            </div>
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateTeam">back</span>
                <button class="bg-red-800 text-white px-8 py-1 text-xs font-thin associateContinue">Continue</button>
            </div>
        </div>
        <div class="jrAssociate hidden">
            <div class="my-3">
                <label for="role" class="text-sm text-dark-500 leading-6 font-bold"> Jr. Associate's Name </label>
                <select
                    class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                sm:text-sm sm:leading-6"
                    name="jrAssociate" id="jrAssociate">
                    <option>Select Jr. Associate Name</option>
                    @foreach ($users as $user)
                        @if ($user->role !== 'Junior Associate')
                            @continue
                        @endif
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <span class="text-red-700" id="jrAssociate_error"></span>
            </div>
            <x-form.input name="jrAssociateManager" label="Jr. Associate's Manager" type="email" class="mb-10" />
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateAssociate">Back</span>
                <button type="submit"
                    class="bg-red-800 text-white px-8 py-1 text-xs font-thin jrAssociateContinue">Continue</button>
            </div>
        </div>
    </form>
@endcomponent
