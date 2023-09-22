@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        #toptable>#incomplete-table_wrapper>div#incomplete-table_length,
        #toptable>#incomplete-table_wrapper>div#incomplete-table_filter {
            display: none !important;
        }

        #incomplete-table_wrapper {
            box-shadow: 0px 0px 11px 0px gray;
        }

        .dataTables_info {
            margin-left: 10px;
        }

        .dataTables_paginate {
            margin-right: 10px;
            margin-bottom: 4px;
        }
    </style>
@endsection
@section('content')
    @extends('parts.modal-background')
@section('modal-content')
    <div>
    @section('modal-title', 'Create New Project')
    <form action="#" class="projectForm" method="post">
        <div>
            <input type="radio" name="team" id="newInput" onclick="changeInputs()">
            <label for="newInput">Add New</label>
            <input class="ml-2" type="radio" name="team" id="existingInput" onclick="changeInputs()">
            <label for="existingInput">Existing Team</label>
        </div>
        <div id="new">
            <x-form.input name="name" label="Borrower's Name" />
            <x-form.input name="email" label="Borrower's Email" />
        </div>
        <div id="existing" class="hidden my-3">
            <label for="User" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                Select User
            </label>
            <select
                class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
                name="name" id="selecUser">
                <option>Select User</option>
                @foreach ($borrowers as $borrower)
                    <option value="{{ $borrower->id }}">{{ $borrower->name }}</option>
                @endforeach
            </select>
            <span class="text-red-700" id="name_error"></span>
        </div>
        <div class="my-3 mt-1flex align-center">
            <input type="checkbox" name="involved" id="involved">
            <label class="ml-2 text-sm leading-normal text-gray-500" for="involved">I want the borrower
                involved</label>
        </div>
        <x-form.input name="address" label="Borrower's Address" />
        <div class="my-3">
            <label for="selecTeam" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                Select Team
            </label>
            <select
                class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
            sm:text-sm sm:leading-6"
                name="name" id="selecTeam">
                <option>Select Team</option>
                @foreach ($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
            <span class="text-red-700" id="team_error"></span>
        </div>
        <div class="my-3">
            <label for="selecassociate" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                Select Associate
            </label>
            <select
                class="w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"
                name="associate" id="selecassociate">
                <!-- Options for associates will be populated dynamically using jQuery -->
            </select>
        </div>

        <div class="my-3">
            <label for="selectJuniorAssociate" class="mt-3 text-sm text-dark-500 leading-6 font-bold">
                Jr.Associate
            </label>
            <select
                class="w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"
                name="juniorAssociate" id="selectJuniorAssociate">
                <!-- Options for junior associates will be populated dynamically using jQuery -->
            </select>
        </div>
        <div class="my-3">
            <a href="#" class="text-red-800 font-bold">+ Add Jr. Associate</a>
        </div>
        <div class="my-3 flex justify-between mt-10">
            <span class="closeModal text-gray-600 cursor-pointer">Skip</span>
            <button type="submit" class="bg-red-800 text-white px-5 text-xs font-thin">Continue</button>
        </div>
    </form>
</div>
@endsection
<x-flex-card title="Projects" titlecounts="17" iconurl="{{ asset('icons/user.svg') }}" />
<button class="bg-red-800 px-5 py-2 text-white flex newProject">Add New Project</button>
{{-- <div class="flex flex-wrap w-full  ">
<div class="grid divide-y divide-neutral-200 w-full mt-8">
    <div class="py-2">
        <details class="group">
            <summary
                class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white py-2 flex text-xl justify-between items-center font-medium cursor-pointer list-none">
                <span class="px-5"> 4500 Woodman Avenue | Copeland Finance Group</span>
                <span class="mr-4 transition group-open:rotate-180">
                    <svg fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </span>
            </summary>
            <p id="toptable" class="text-neutral-600 group-open:animate-fadeIn">
            <table class="w-full display shadow-lg" id="incomplete-table">
                <thead class="hidden bg-gray-300">
                    <tr>
                        <th class="pl-2 tracking-wide">
                            S No.
                        </th>
                        <th class="">
                            Name
                        </th>
                        <th class="">
                            User ID
                        </th>
                        <th class="">
                            Role
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
                    @php
                        $serialNumber = 1;
                    @endphp
                    @foreach ($users as $key => $processor)
                        @if ($processor->email_verified_at !== null)
                            <tr class="border-none">
                                <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                    {{ $serialNumber }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    <a title="Click to view files uploaded by this user"
                                        class="text-blue-500 inline"
                                        href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $processor->id) }}">
                                        {{ $processor->name }}
                                    </a>
                                    <a title="Edit this user"
                                        href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                        <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                            class="inline ml-5">
                                    </a>
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $processor->email }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $processor->role }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    @if ($processor->created_by)
                                        {{ \App\Models\User::where('id', $processor->created_by)->first()->name }}
                                        |
                                        {{ \App\Models\User::where('id', $processor->created_by)->first()->role }}
                                    @endif
                                </td>
                                <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                    <a data="Delete" class="delete"
                                        href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                        <button
                                            class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                            <img src="{{ asset('icons/trash.svg') }}" alt="">
                                        </button>
                                    </a>
                                    @if (session('role') == 'Admin')
                                        <form method="POST"
                                            action="{{ url(getAdminRoutePrefix() . '/login-as-this-user') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $processor->id }}">
                                            <span class="loginBtn">
                                                <button type="submit"
                                                    class="ml-1 bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1">
                                                    <img src="{{ asset('icons/user.svg') }}" alt="">
                                                </button>
                                            </span>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @php
                                $serialNumber++;
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            <button class="bg-red-800 px-5 py-2 text-white flex mt-5">Project Overview</button>
            </p>
        </details>
    </div>
</div>
</div> --}}
@endsection
@section('foot')
<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $("#selecTeam").change(function() {


            // Use Ajax to retrieve the associated users for the selected team
            $.ajax({
                url: `{{ getAdminRoutePrefix() }}/getUsersByTeam/${$(this).val()}`, // Replace with the actual URL for retrieving users by team
                type: 'GET',
                success: function(data) {
                    // Clear existing options in the "selecassociate" and "selectJuniorAssociate" selects
                    $("#selecassociate").empty();
                    $("#selectJuniorAssociate").empty();
                    // Add the retrieved users to the "selecassociate" and "selectJuniorAssociate" selects
                    
                    $.each(data, function(index, user) {
                        console.log("Processing user: " + user.name + ", Role: " + user.role);
                        if (user.role === 'Associate') {
                            $("#selecassociate").append('<option value="' + user
                                .id + '">' + user.name + '</option>');
                        } else if (user.role === 'Junior Associate') {
                            $("#selectJuniorAssociate").append('<option value="' +
                                user.id + '">' + user.name + '</option>');
                        }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>

<script>
    function changeInputs() {
        if ($('#newInput').is(':checked')) {
            $('#new').removeClass('hidden');
            $('#existing').addClass('hidden');
            $('#name').removeAttr('disabled'); // Correct the selector and method
            $('#selecUser').attr('disabled', 'disabled'); // Correct the selector and method
        } else {
            $('#new').addClass('hidden');
            $('#existing').removeClass('hidden');
            $('#selecUser').removeAttr('disabled'); // Correct the selector and method
            $('#name').attr('disabled', 'disabled'); // Correct the selector and method
        }
    }

    $('.newProject').click(function(e) {
        e.preventDefault();
        $('#newProjectModal').removeClass('hidden');
    });
    $('.closeModal').click(function(e) {
        e.preventDefault();
        $('#newProjectModal').addClass('hidden');
    });

    $(".projectForm").submit(function(e) {
        e.preventDefault();
        var data = ['address', 'email', 'name', 'associate', 'team', 'junior_associate'];
        data.forEach(function(field) {
            var input = $("#" + field);
            var name = input.attr('name');
            var errorElement = $("#" + name + "_error");
            if (input.val() === '') {
                input.addClass('border-red-700 border-2');
                errorElement.text(name + ' field is required');
            } else {
                input.removeClass('border-red-700 border-2');
                errorElement.text(''); // Clear the error message if the input is not empty
            }
        });
    });

    $(document).ready(function() {
        $(document).on('mouseenter', '.loginBtn', function() {
            if ($(this).attr('data') == 'restore') {
                var data = $(this).attr('data');
            }
            if ($(this).attr('data') == 'Permanent Delete') {
                var data = $(this).attr('data');
            }
            $(this).append(
                `<div role="tooltip" class="w-40 mt-2 -ml-16 absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        ${!data ? 'Login As This User': data+' this user'}
                        <div class="tooltip-arrow" data-popper-arrow></div></div>`
            );
        }).on('mouseleave', '.loginBtn', function() {
            $(this).find('div[role="tooltip"]').remove();
        });

        $('#user-table').DataTable({
            pageLength: 30,
            lengthMenu: [10, 20, 30, 50, 100, 200],
        });
    });
    $('#unverified').html($('.unverifiedSerial:last').html());
    $('#verified').html($('.verifiedSerial:last').html());
    $('#deleted').html($('.deletedSerial:last').html());
</script>
@endsection
