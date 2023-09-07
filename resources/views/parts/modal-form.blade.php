@component('components.modal-background', ['title'=> 'Create New Team'])
    <form action="" method="post">
        @csrf
        <div class="createTeam">
            <x-form.input name="name" label="Group Name" class="mb-10" />
            <div class="my-3 flex justify-end mt-5">
                <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin teamContinue">Continue</button>
            </div>
        </div>
        <div class="associate hidden">
            <x-form.input name="associate" label="Associate's Name" />
            <x-form.input name="associateEmail" label="Associate's Email" type="email" class="mb-10" />
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateTeam">back</span>
                <button class="bg-red-800 text-white px-8 py-1 text-xs font-thin associateContinue">Continue</button>
            </div>
        </div>
        <div class="jrassociate hidden">
            <x-form.input name="jrassociate" label="Jr Associate's Name" />
            <x-form.input name="jrAssociateEmail" label="Jr Associate's Email" type="email" />
            <x-form.input name="jrAssociateManager" label="Jr Associate's Manager" type="email" class="mb-10" />
            <div class="my-3 flex justify-between">
                <span class="bg-gray-400 px-8 py-1 text-white cursor-pointer capitalize backToCreateAssociate">Back</span>
                <button type="submit"
                    class="bg-red-800 text-white px-8 py-1 text-xs font-thin jrAssociateContinue">Continue</button>
            </div>
        </div>
    </form>
@endcomponent
