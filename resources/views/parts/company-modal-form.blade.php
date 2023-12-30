@component('components.modal-background', ['title' => 'Create New Contact'])
    <div>
        <form class="contactForm" action="{{url(getRoutePrefix().'/do-company')}}" method="post">
            @csrf
            <div class="namepart">
                <x-form.input name="name" label="Company Name" />
                <div class="my-3 flex justify-end mt-5">
                    <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
@endcomponent
