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
        <x-flex-card title="Contacts" titlecounts="{{ count($contacts) }}" iconurl="{{ asset('icons/Marketing.svg') }}" />
        <button class="absolute z-10 py-2 text-white bg-red-800 px-8 newProject">
            Add New Contact
        </button>
        <table class="w-full pt-7" id="deleted-table">
            <thead class="bg-gray-300">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        Created on
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
                   Created By
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr class="text-center">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ date('d/m/y', strtotime($contact->created_at)) }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit contact" class="text-blue-500 inline"
                                {{-- href="{{ url(getRoutePrefix() . '/contact/' . $contact->id) }}" --}}>
                                {{ $contact->name }}
                                <button class="editcontact" data-contact-id="{{ $contact->id }}"
                                    data-contact-name="{{ $contact->name }}" data-contact-email="{{ $contact->email }}"
                                    data-contact-loanamount="{{ $contact->loanamount }}"
                                    data-contact-loantype="{{ $contact->loantype }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="edit-icon">
                                </button>
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $contact->email }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                         {{$contact->loanamount ? '$'.$contact->loanamount : ''}}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $contact->loantype }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $contact->user->name ?? '' }} | {{$contact->user->role ?? ''}}
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a data="Delete" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-contact/' . $contact->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    {{-- <form action="{{url(getRoutePrefix().'/pdfform')}}">
    @csrf
    <iframe class="w-full h-screen" src="{{asset('Loan.pdf')}}" frameborder="0"></iframe>
    <button type="submit">Submit</button>
    </form> --}}

@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $('.editcontact').click(function(e) {
            $('#newProjectModal').toggleClass('hidden');
            e.preventDefault();

            $('.contactForm').attr('action', $('.contactForm').attr('action') + "/" + $(this).attr(
                'data-contact-id'));
            $('#name').val($(this).attr('data-contact-name'));
            $('#email').val($(this).attr('data-contact-email'));
            $('#loanamount').val($(this).attr('data-contact-loanamount'));
            var loantypeValue = $(this).attr('data-contact-loantype');
            $('.contactForm button[type="submit"]').text('Update');
            // Find the option with the matching value and set it as selected
            $('#loantype option').filter(function() {
                return $(this).val() == loantypeValue;
            }).prop('selected', true);

        });
    </script>
    <script>
        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('.contactForm button[type="submit"]').text('Create');
            $('#name').val('');
            $('#email').val('');
            $('#loanamount').val('');
            $('#loantype').val('');
            $('#newProjectModal').toggleClass('hidden');
        });

        $('.contactForm').submit(function(e) {
            e.preventDefault();
            var hasErrors = false;
            ['name', 'email', 'loanamount', 'loantype'].forEach(inputName => {
                if (inputName === 'loantype') {
                    if ($('#loantype').find(':checked').html() === 'Select Loan Type') {
                        $('#loantype_error').text('Please select a loan type');
                        hasErrors = true;
                    } else {
                        $('#loantype_error').text('');
                    }
                } else {
                    var input = $(this).find('input[name=' + inputName + ']');
                    var errorSelector = '#' + inputName + '_error';
                    if (input.val() === '') {
                        $(errorSelector).text(inputName + " field is required");
                        hasErrors = true; // Set the flag to true
                    } else {
                        $(errorSelector).text('');
                    }
                }
            });
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
