@component('components.modal-background', ['title' => 'Create New Contact'])
    <div>
        <form class="contactForm" action="{{url(getRoutePrefix().'/do-contact')}}" method="post">
            @csrf
            <div class="namepart">
                <x-form.input name="name" label="Contact Name" />
                <x-form.input name="email" label="Contact Email" />
                <x-form.input type="number" name="loanamount" label="Loan Amount" />
                <x-form.input name="loantype" label="Loan Type" />
                <div class="my-3 flex justify-end mt-5">
                    <button class="bg-red-800 text-white px-8 py-2 text-xs font-thin" type="submit">Continue</button>
                </div>
            </div>
        </form>
    </div>
@endcomponent
