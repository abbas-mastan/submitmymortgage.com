@component('components.modal-background', ['title' => 'Edit Connection'])
    <div>
        <form class="contactForm" action="{{url(getRoutePrefix().'/do-user')}}" method="post">
            @csrf
            <div class="namepart">
                <x-form.input name="name" label="Connection Name" />
                <x-form.input name="email" label="Connection Email" />
                <div class="my-3">
                    <label for="role" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                        Role
                    </label>
                    <select
                        class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
                        name="role" id="role">
                        @php
                            $roles =  config('smm.roles');
                        @endphp
                        <option value="">Select user type</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
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
