@component('components.modal-background', ['title' => 'Create Custom Quote'])
    <div>
        <form class="custom-quote-form" action="{{ route('custom.quote') }}" method="post">
            @csrf
            <div class="namepart">
                <x-form.input name="email" label="Email" type="email" />
                <x-form.input name="phone" label="Phone" type="tel" />
                <x-form.input name="first_name" label="First Name" />
                <x-form.input name="last_name" label="Last Name" />
                <x-form.input name="company" label="Company Name" />
                <div>
                    <div>
                        Plan Type:
                        <label for="monthly" class="px-3">
                            <input type="radio" name="team_size" value="monthly-plan-6" id="monthly">
                            Monthly
                        </label>
                        <label for="yearly">
                            <input type="radio" name="team_size" value="yearly-plan-6" id="yearly">
                            Yearly
                        </label>
                    </div>
                    <span class="text-red-700" style="text-transform: none !important;"
                        id="team_size_error"></span>

                </div>
                <div class="my-3 flex justify-end mt-5">
                    <button class="flex justify-center bg-red-800 text-white px-8 py-2 text-xs font-thin" type="submit">
                        <span class="custom-quote-submit-btn-text">
                            Submit
                        </span>
                        <img width="20%" class="custom-quote-loader hidden" src="{{ asset('assets/trial/loader.svg') }}"
                            alt="loading...">
                    </button>
                </div>
            </div>
        </form>
    </div>
@endcomponent
