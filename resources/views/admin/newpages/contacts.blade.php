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
    @include('parts.contact-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full">
        @if (Auth::user()->role != 'Borrower')
            <x-flex-card title="Contacts" titlecounts="{{ count($contacts) }}" iconurl="{{ asset('icons/Marketing.svg') }}" />
            <button class="absolute z-10 py-2 text-white bg-red-800 px-8 newProject">
                Add New Contact
            </button>
            <table class="w-full pt-7" id="deleted-table">
                <thead class="bg-gray-300">
                    <tr>
                        <th class=" pl-2 tracking-wide">
                            S No.
                        </th>
                        <th class="">
                            Name
                        </th>
                        <th class="">
                            User ID
                        </th>
                        <th class="">
                            Loan Amount
                        </th>
                        <th class="">
                            Loan Type
                        </th>
                        <th class="">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (Auth::user()->role == 'Admin')
                        @foreach ($contacts as $lead)
                            <tr class="text-center">
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ date('d/m/y', strtotime($lead->created_at)) }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                        href="{{ url(getRoutePrefix() . '/lead/' . $lead->id) }}">
                                        {{ $lead->name }}
                                    </a>
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $lead->email }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $lead->loanamount }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $lead->loantype }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-r-0">
                                    {{-- <a data="Delete" class="delete"
                                        href="{{ url(getRoutePrefix() . '/delete-lead/' . $lead->id) }}">
                                        <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                            <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                        </button>
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endif
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').toggleClass('hidden');
        });

        $('.contactForm').submit(function(e) {
            e.preventDefault();
            var hasErrors = false;
            // Loop through the input field names
            ['name', 'email', 'loanamount', 'loantype'].forEach(inputName => {
                var input = $(this).find('input[name=' + inputName + ']');
                var errorSelector = '#' + inputName + '_error';

                if (input.val() === '') {
                    // Show an error message
                    $(errorSelector).text(inputName + " field is required");
                    hasErrors = true; // Set the flag to true
                } else {
                    // Clear the error message
                    $(errorSelector).text('');
                }
            });

            // If there are no errors, allow the form to submit
            if (!hasErrors) {
                this.submit(); // Submit the form
            }
        });

        var checkboxes = $('.checkbox');
        var submitButton = $('.submitButton');
        $('#selectall').click(function(e) {
            if ($(this).is(':checked')) {
                checkboxes.prop('checked', true);
                submitButton.removeClass('cursor-not-allowed')
                    .removeAttr('disabled');
            } else {
                checkboxes.prop('checked', false);
                submitButton.addClass('cursor-not-allowed')
                    .attr('disabled', true);
            }
        });

        checkboxes.click(function() {
            if (checkboxes.is(':checked')) {
                submitButton.removeClass('cursor-not-allowed')
                    .removeAttr('disabled');
            } else {
                submitButton.addClass('cursor-not-allowed')
                    .attr('disabled', true);
            }
        });
        $('.newProject').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').removeClass('hidden');
        });
        $('.closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('hidden');
        });
    </script>
@endsection
