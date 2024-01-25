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
@include('parts.company-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Companies" titlecounts="{{ count($companies) }}" iconurl="{{ asset('icons/Marketing.svg') }}" />
        <button class="absolute z-10 py-2 text-white bg-red-800 px-8 newProject">
            Add New Company
        </button>
        <table class="w-full pt-7" id="completed-table">
            <thead class="bg-gray-300">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        Created on
                    </th>
                    <th class="">
                        Name
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    @if(!$company->trashed())   
                <tr class="text-center {{$company->trashed() ? 'text-red-700' : ''}}">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ date('d/m/y', strtotime($company->created_at)) }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline"
                                {{-- href="{{ url(getRoutePrefix() . '/contact/' . $company->id) }}" --}}>
                                {{ $company->name }}
                                <button class="editcontact" data-contact-id="{{ $company->id }}"
                                    data-contact-name="{{ $company->name }}" >
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="edit-icon">
                                </button>
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a data="Disable" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-company/' . $company->id) }}">
                                <button title="temporary delete" class="bg-themered  tracking-wide capitalize text-white px-2">
                                    {{-- <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7"> --}}
                                    Disable
                                </button>
                            </a>
                            
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Deleted Companies" titlecounts="{{ count($trashed) }}" iconurl="{{ asset('icons/Marketing.svg') }}" />
        <table class="w-full pt-7" id="deleted-table">
            <thead class="bg-gray-300">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        Deleted on
                    </th>
                    <th class="">
                        Name
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trashed as $company)
                <tr class="text-center {{$company->trashed() ? 'text-red-700' : ''}}">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ date('d/m/y',$company->updated_on) }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline"
                                {{-- href="{{ url(getRoutePrefix() . '/contact/' . $company->id) }}" --}}>
                                {{ $company->name }}
                                <button class="editcontact" data-contact-id="{{ $company->id }}"
                                    data-contact-name="{{ $company->name }}" >
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="edit-icon">
                                </button>
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            {{-- <a data="Delete" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-company-permanent/' . $company->id) }}">
                                <button title="permanent delete" class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a> --}}
                            <a data="Enable" class="delete"
                                href="{{ route('company.restore',$company->id) }}">
                                <button title="restore" class="bg-themered  tracking-wide capitalize text-white px-2">
                                    {{-- <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7"> --}}
                                    Enable
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
        $('.editcontact').click(function(e) {
            $('#newProjectModal').toggleClass('hidden');
            e.preventDefault();
            $('.contactForm').attr('action', $('.contactForm').attr('action') + "/" + $(this).attr(
                'data-contact-id'));
            $('#name').val($(this).attr('data-contact-name'));
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
            $('#newProjectModal').toggleClass('hidden');
        });

        $('.contactForm').submit(function(e) {
            e.preventDefault();
            var hasErrors = false;
            ['name'].forEach(inputName => {
                    var input = $(this).find('input[name=' + inputName + ']');
                    var errorSelector = '#' + inputName + '_error';
                    if (input.val() === '') {
                        $(errorSelector).text(inputName + " field is required");
                        hasErrors = true; // Set the flag to true
                    } else {
                        $(errorSelector).text('');
                    }
            });
            if (!hasErrors) {
                this.submit(); 
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
