@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        /* #completed-table_length,
        #completed-table_filter,
        #completed-table>thead,
        #deleted-table_length,
        #deleted-table_filter,
        #deleted-table>thead,
        #user-table_length,
        #user-table_filter,
        #user-table>thead {
            display: none !important;
        }


        #completed-table_wrapper,
        #deleted-table_wrapper,
        #user-table_wrapper {
            box-shadow: 0px 0px 11px 0px gray;
        } */

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
    @component('components.modal-background', ['title' => 'Add a User'])

    <x-flex-card title="Verified Users" id="verified" titlecounts="0" iconurl="{{ asset('icons/Users.svg') }}" />
        <table class="w-full display" id="completed-table">
            <thead class="bg-gray-300">
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
                        <tr>
                            <td class="verifiedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}">
                                    {{ $processor->name }}
                                </a>
                                <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
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
                                    {{ \App\Models\User::where('id', $processor->created_by)->first()->name }} |
                                    {{ \App\Models\User::where('id', $processor->created_by)->first()->role }}
                                @endif
                            </td>
                            <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                <a data="Delete" class="delete"
                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                        <img style="-webkit-writing-mode: vertical-lr;" src="{{ asset('icons/trash.svg') }}"
                                            alt="" class="p-1 w-7">
                                    </button>
                                </a>
                                @if (session('role') == 'Admin')
                                    <form method="POST" action="{{ url(getAdminRoutePrefix() . '/login-as-this-user') }}">
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
    {{-- @endcomponent --}}

    <x-flex-card title="Unverified Users" id="unverified" titlecounts="" iconurl="{{ asset('icons/Users.svg') }}" />
    {{-- @component('components.accordion', ['title' => 'Unverified Users']) --}}
        <table class="w-full display" id="user-table">
            <thead class="bg-gray-300">
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
                    @if ($processor->email_verified_at == null)
                        <tr>
                            <td class="unverifiedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}">
                                    {{ $processor->name }}
                                </a>
                                <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
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
                                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                        <img style="-webkit-writing-mode: vertical-lr;" src="{{ asset('icons/trash.svg') }}"
                                            alt="" class="p-1 w-7">

                                    </button>
                                </a>
                                {{-- @if (session('role') == 'Admin')
                                    <form method="POST" action="{{ url(getAdminRoutePrefix() . '/login-as-this-user') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $processor->id }}">
                                        <span class="loginBtn">
                                            <button type="submit"
                                                class="ml-1 bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1">
                                                <img src="{{ asset('icons/user.svg') }}" alt="">
                                            </button>
                                        </span>
                                    </form>
                                @endif --}}
                            </td>
                        </tr>
                        @php
                            $serialNumber++;
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
    {{-- @endcomponent --}}

    @if (Auth::user()->role === 'Admin')
        <x-flex-card title="Deleted Users" id="deleted" titlecounts="0" iconurl="{{ asset('icons/Users.svg') }}" />
        {{-- @component('components.accordion', ['title' => 'Deleted Users']) --}}
            <table class="w-full display my-5" id="deleted-table">
                <thead class="bg-gray-300">
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
                    @if (isset($trashed))
                        
                    @foreach ($trashed as $key => $processor)
                        <tr>
                            <td class="deletedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                            </td>
                            <td class="pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}">
                                    {{ $processor->name }}
                                </a>
                                <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
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
                            <td class="flex justify-center pl-2 tracking-wide border border-r-0">
                                <a data="restore" class="delete loginBtn"
                                    href="{{ url(getRoutePrefix() . '/restore-user/' . $processor->id) }}">
                                    <button class="bg-themered tracking-wide font-semibold capitalize p-1 text-xl w-7">
                                        <img src="{{ asset('icons/restore.svg') }}" alt="" class="filter ">
                                    </button>
                                </a>
                                <a data="Permanent Delete" class="delete loginBtn ml-2"
                                    href="{{ url(getRoutePrefix() . '/delete-user-permenant/' . $processor->id) }}">
                                    <button class="bg-themered tracking-wide font-semibold capitalize p-1 text-xl w-7">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="" class="filter ">
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @php
                            $serialNumber++;
                        @endphp
                    @endforeach
                    @endif
                </tbody>
            </table>
        {{-- @endcomponent --}}
    @endif
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('.newProject').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').removeClass('hidden');
        });
        $('.closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('hidden');
        });

        $(".userform").submit(function(e) {
            e.preventDefault();
            var data = ['email', 'name', 'role', 'team', 'lead'];

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

            if (data['email'].val() !== '') {
                if (!validateEmail(data['email'])) {
                    data['email'].addClass('border-red-700 border-2');
                    $('#email_error').text('Email is not valid');
                } else {
                    data['email'].removeClass('border-red-700');
                    $('#email_error').text('');
                }
            }

            function validateEmail(email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test(email.val());
            }
        });
    </script>
    <script>
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
