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
    @include('parts.custom-quote-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Custom Quotes" titlecounts="{{ count($customQuotes) }}"
            iconurl="{{ asset('icons/Marketing.svg') }}" />
        <button class="{{ $customQuotes ? 'absolute' : 'mb-5' }} z-10 py-2 text-white bg-red-800 px-8 newProject">
            Custom Quote
        </button>
        <table class="w-full pt-7" id="completed-table">
            <thead class="bg-gray-300 text-left" style="height: 40px;">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        Sr.No
                    </th>
                    <th class="">
                        User Email
                    </th>
                    <th class="">
                        Phone
                    </th>
                    <th class="">
                        Full Name
                    </th>
                    <th class="">
                        Company Name
                    </th>
                    <th class="">
                        Plany Type
                    </th>
                    <th class="">
                        Created at
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customQuotes as $quote)
                    <tr style="height:40px">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $loop->iteration }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->email }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->phone }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->name }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->company->name }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $quote->plan_type }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ date('d/m/y', strtotime($quote->created_at)) }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a href="{{ url(getRoutePrefix() . '/custom-plan/' . $quote->user->id) }}">
                                <button title="temporary delete"
                                    class="bg-themered  tracking-wide capitalize text-white px-2">
                                    {{-- <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7"> --}}
                                    Create Plan
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
        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('.contactForm button[type="submit"]').text('Create');
            $('#name').val('');
            $('#newProjectModal').toggleClass('hidden');
        });



        $('.custom-quote-form').submit(function(e) {
            $('.custom-quote-submit-btn-text').addClass('hidden');
            $('.custom-quote-loader').removeClass('hidden');
            $('.custom-quote-form #email_error').text('');
            $('.custom-quote-form #phone_error').text('');
            $('.custom-quote-form #first_name_error').text('');
            $('.custom-quote-form #last_name_error').text('');
            $('.custom-quote-form #company_error').text('');
            $('.custom-quote-form #team_size_error').text('');
            e.preventDefault();
            var paymentForm = $('.custom-quote-form');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: paymentForm.attr('method'),
                url: paymentForm.attr('action'),
                data: paymentForm.serialize(),
                success: function(response) {
                    console.log(response);
                    $('.custom-quote-submit-btn-text').removeClass('hidden');
                    $('.custom-quote-loader').addClass('hidden');
                    if (response == 'redirect') {
                        $('.custom-quote-form')[0].reset();
                        $('.customQuoteModal').removeClass('secondModalHeightIncrease');
                        $('.btn-close').click();
                        window.location.href =
                        "{{ url(getRoutePrefix() . '/redirect/back/custom-quote-created-successfully') }}";
                        // window.location.replace('trial-custom-quote');
                    }
                    if (response !== 'success') {
                        $.each(response, function(indexInArray, error) {
                            $('.custom-quote-form #' + indexInArray + '_error')
                                .text('');
                            $('.custom-quote-form #' + indexInArray + '_error')
                                .text(response[
                                    indexInArray]);
                        });
                    }
                },
                error: function(jqXHR, excption) {
                    console.log(excption);
                }
            });
        });
    </script>
@endsection
