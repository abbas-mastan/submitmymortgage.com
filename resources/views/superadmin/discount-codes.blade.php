@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        #deleted-table_length,
        #user-table_length {
            display: none;
        }
    </style>
@endsection
@section('content')
    @include('parts.discount-code-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Discount Codes" titlecounts="{{ count($discountCodes) }}"
            iconurl="{{ asset('icons/Marketing.svg') }}" />
        <button class="{{ $discountCodes ? 'absolute' : 'mb-5' }} z-10 py-2 text-white bg-red-800 px-8 newProject">
            Generate Code
        </button>
        <table class="w-full pt-7" id="completed-table">
            <thead class="bg-gray-300 text-left" style="height: 40px;">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        Sr.No
                    </th>
                    <th class="">
                        Discount Code
                    </th>
                    <th class="">
                        Discount Value
                    </th>
                    <th class="">
                        Created on
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discountCodes as $code)
                    <tr style="height:40px">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $loop->iteration }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $code->code }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ ($code->discount_type == 'fixed_amount' ? '$' : '') . $code->discount . ($code->discount_type !== 'fixed_amount' ? '%' : '') }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ date('d/m/y', strtotime($code->created_at)) }}
                        </td>
                        <td class=" text-center pl-2 tracking-wide border border-r-0">
                            <a data="Permanent Delete" class="delete ml-2"
                                href="{{ url(getRoutePrefix() . '/delete-code/' . $code->id) }}">
                                <button class="bg-themered tracking-wide font-semibold capitalize p-1 text-xl w-7">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="filter ">
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $('main > div:nth-child(2)').removeClass('flex');
        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('items-center');
            $('#newProjectModal > div').removeClass('md:top-44');
            $('#newProjectModal > div').removeClass('sm:top-36');
            $('#newProjectModal').toggleClass('hidden');
        });

        $('input[name=discount_type]').attr('required', true);

        $('input[name=discount_type]').change(function(e) {
            e.preventDefault();
            if ($(this).val() === 'fixed_amount') {
                $(`label[for=fixed_amount]`).removeClass('hidden');
                $('#fixed_amount').attr('required', true);
            } else {
                $('#fixed_amount').removeAttr('required');
                $(`label[for=fixed_amount]`).addClass('hidden');
            }

            if ($(this).val() === 'percent') {
                $(`label[for=percent]`).removeClass('hidden');
                $('#percent').attr('required', true);
            } else {
                $('#percent').attr('required', true);
                $('#percent').removeAttr('required');
                $(`label[for=percent]`).addClass('hidden');
            }
        });

        $('.discount-form').submit(function(e) {
            $('.custom-quote-loader').removeClass('hidden');
            $('.custom-quote-loader').parent().addClass('cursor-not-allowed');
            $('.custom-quote-loader').parent().attr('disabled');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response !== 'success') {
                        $.each(response, function(indexInArray, error) {
                            $('.discount-form .' + indexInArray + '_error')
                                .text('');
                            $('.discount-form .' + indexInArray + '_error')
                                .text(response[
                                    indexInArray]);
                        });
                    }
                    if (response == 'success') {
                        $('.custom-quote-loader').addClass('hidden');
                        $('.discount-form')[0].reset();
                        $('.close-modal').click();
                        window.location.href =
                            "{{ url(getRoutePrefix() . '/redirect/back/Discount-code-created-successfully') }}";
                        // window.location.replace('trial-custom-quote');
                    }
                }
            });
        });
    </script>
@endsection
