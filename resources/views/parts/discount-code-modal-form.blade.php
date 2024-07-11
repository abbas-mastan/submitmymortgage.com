@component('components.modal-background', ['title' => ''])
    <div>
        <form class="discount-form" action="{{ route('create.discount-code') }}" method="post">
            @csrf

            <div>
                <div>
                    Discount Type:<br>
                    <div class="ms-2">
                        <label for="fixed">
                            <input type="radio" name="discount_type" checked value="fixed_amount" id="fixed">
                            Fixed Amount
                        </label><br>
                        <label for="percent_label" class="mt-2">
                            <input type="radio" name="discount_type" value="percent" id="percent_label">
                            Percentage
                        </label>
                    </div>
                    <span class="text-red-700" style="text-transform: none !important;" id="team_size_error"></span>
                </div>

            </div>
            <div class="my-3">
                <label class="flex flex-col w-100" for="fixed_amount">             
                    Fixed Amount <br>
                    <input class="w-100" required type="number" id="fixed_amount" name="fixed_amount" placeholder="">
                </label>
                <label class="hidden flex flex-col w-100" for="percent">Percentage
                    <br>
                    <input class="w-100" id="percent" type="number" name="percent" placeholder="">
                </label>
                <span class="text-red-700 fixed_amount_error"></span>
                <span class="text-red-700 percent_error"></span>
            </div>
            <div class="flex justify-center mt-5">
                <button class="flex justify-center bg-red-800 text-white px-8 py-2 text-xs font-thin" type="submit">
                    <span class="custom-quote-submit-btn-text">
                        Create Code
                    </span>
                    <img width="10%" class="ms-2 custom-quote-loader hidden" src="{{ asset('assets/trial/loader.svg') }}"
                        alt="loading...">
                </button>
            </div>
    </div>
    </form>
    </div>
@endcomponent
