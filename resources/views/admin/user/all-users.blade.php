@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
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
    @component('components.modal-background', ['title' => 'Add a User'])
    @endcomponent

    <x-flex-card title="Verified Users" id="verified" titlecounts="{{count($verified)}}" iconurl="{{ asset('icons/Users.svg') }}" />
    <table class="w-full display verifiedUsersTable mb-26" id="{{ count($verified) > 10 ? 'completed-table' : null }}">
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
                @if ($role === 'Super Admin')
                    <th class="">
                        Company
                    </th>
                @endif
                <th class="">
                    Created By
                </th>
                <th class="">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @php $serialNumber = 1; @endphp
            @foreach ($verified as $user)
                @if ($user->email_verified_at !== null)
                    <tr>
                        <td class="verifiedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                {{-- href="{{ url(getRoutePrefix() . ($user->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $user->id) }}" --}}>
                                {{ $user->name }}
                            </a>
                            <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $user->email }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $user->role }}
                        </td>
                        @if (auth()->user()->role === 'Super Admin')
                            <td class=" pl-2 tracking-wide border border-l-0">
                                @if ($user->company_id)
                                    {{ $user->company->name ?? null }}
                                @endif
                            </td>
                        @endif
                        <td class=" pl-2 tracking-wide border border-l-0">
                            @if ($user->createdBy)
                                {{ $user->createdBy->name ?? null }}
                                @if ($user->createdBy->name)
                                    |
                                @endif
                                {{ $user->createdBy->role ?? null }}
                            @endif
                        </td>
                        <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                            <a data="{{ $role === $superadminrole ? 'temporary' : 'Delete' }}" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-user/' . $user->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img style="-webkit-writing-mode: vertical-lr;" src="{{ asset('icons/trash.svg') }}"
                                        alt="" class="p-1 w-7">
                                </button>
                            </a>
                            @if ($role === $superadminrole)
                                <form method="POST"
                                    action="{{ url(getSuperAdminRoutePrefix() . '/login-as-this-user') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
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

    <x-flex-card title="Unverified Users" id="unverified" titlecounts="{{count($unverified)}}" iconurl="{{ asset('icons/Users.svg') }}" />
    <table class="w-full display unVerifiedUsersTable mb-20" id="{{ count($unverified) > 10 ? 'user-table' : null }}">
        <x-users-table-head/>
        <tbody>
            @php
                $serialNumber = 1;
            @endphp
            @foreach ($unverified as $user)
                <tr>
                    <td class="unverifiedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                            href="{{ url(getRoutePrefix() . ($user->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $user->id) }}">
                            {{ $user->name }}
                        </a>
                        <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                            <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                        </a>
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        {{ $user->email }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        {{ $user->role }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        @if ($user->createdBy)
                            {{ $user->createdBy->name }}
                            |
                            {{ $user->createdBy->role }}
                        @endif
                    </td>
                    <td class="flex pl-2 justify-center items-center tracking-wide border border-r-0">
                        <a data="{{ $role === $superadminrole ? 'temporary' : 'Delete' }}" class="delete"
                            href="{{ url(getRoutePrefix() . '/delete-user/' . $user->id) }}">
                            <button class="bg-themered  tracking-wide font-semibold capitalize mt-1 text-xl">
                                <img style="-webkit-writing-mode: vertical-lr;" src="{{ asset('icons/trash.svg') }}"
                                    alt="" class="p-1 w-7">
                            </button>
                        </a>
                        @if ($role === $superadminrole || $role === 'Admin')
                            <a href="{{ url(getRoutePrefix() . '/verify-user/' . $user->id) }}"
                                class="bg-themered text-white px-2.5 py-[0.15rem] tracking-wide ml-1">Verify</a>
                        @endif
                    </td>
                </tr>
                @php
                    $serialNumber++;
                @endphp
            @endforeach
        </tbody>
    </table>

    @if ($role === 'Super Admin')
        <x-flex-card title="Deleted Users" id="deleted" titlecounts="{{count($trashed)}}" iconurl="{{ asset('icons/Users.svg') }}" />
        <table class="w-full display my-5 deletedUsersTable" id="{{ count($trashed) > 10 ? 'deleted-table' : '' }}">
            <x-users-table-head/>
            <tbody>
                @php $serialNumber = 1; @endphp
                @forelse ($trashed as $user)
                    <tr>
                        <td class="deletedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                        </td>
                        <td class="pl-2 tracking-wide border border-l-0">
                            <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                {{-- href="{{ url(getRoutePrefix() . ($user->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $user->id) }}" --}}>
                                {{ $user->name }}
                            </a>
                            {{-- <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                            </a> --}}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $user->email }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $user->role }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            @if ($user->createdBy)
                                {{ $user->createdBy->name }}
                                |
                                {{ $user->createdBy->role }}
                            @endif
                        </td>
                        <td class="flex justify-center pl-2 tracking-wide border border-r-0">
                            <a data="Restore" class="delete loginBtn"
                                href="{{ url(getRoutePrefix() . '/restore-user/' . $user->id) }}">
                                <button class="bg-themered tracking-wide font-semibold capitalize p-1 text-xl w-7">
                                    <img src="{{ asset('icons/restore.svg') }}" alt="" class="filter ">
                                </button>
                            </a>
                            <a data="Permanent Delete" class="delete ml-2"
                                href="{{ url(getRoutePrefix() . '/delete-user-permenant/' . $user->id) }}">
                                <button class="bg-themered tracking-wide font-semibold capitalize p-1 text-xl w-7">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="filter ">
                                </button>
                            </a>
                        </td>
                    </tr>
                    @php
                        $serialNumber++;
                    @endphp
                @empty
                @endforelse
            </tbody>
        </table>
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
            new DataTable('#completed-table', {
                columnDefs: [{
                    target: {{ $role == 'Super Admin' ? 5 : 4 }},
                    searchable: false
                }]
            });
            new DataTable('#deleted-table', {
                columnDefs: [{
                    target: 4,
                    searchable: false
                }]
            });
            new DataTable('#user-table', {
                columnDefs: [{
                    target: 4,
                    searchable: false
                }]
            });
            ['user', 'completed', 'incomplete', 'deleted'].map((table) => {
                $(`select[name="${table}-table_length"]`).addClass('w-16');
                $(`select[name="${table}-table_length"]`).addClass('mb-3');
            });

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


            if ($('.unverifiedSerial:last').html() < 11) {
                $('.unVerifiedUsersTable').attr('id', 'asdf');
            } else {
                $('.unVerifiedUsersTable').attr('id', 'incomplete-table');
            }
            if ($('.verifiedSerial:last').html() < 11) {
                $('.verifiedUsersTable').attr('id', 'asdf');
            } else {
                $('.unVerifiedUsersTable').attr('id', 'completed-table');
            }
            if ($('.deletedSerial:last').html() < 11) {
                $('.deletedUsersTable').attr('id', 'asdf');
            } else {
                $('.deletedUsersTable').attr('id', 'deleted-table');
            }
            // $('#verified').html($('.verifiedSerial:last').html());
            // $('#unverified').html($('.unverifiedSerial:last').html());
            // $('#deleted').html($('.deletedSerial:last').html());
        });
    </script>
@endsection
