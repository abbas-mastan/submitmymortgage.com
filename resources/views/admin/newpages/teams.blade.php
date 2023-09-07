@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        #incomplete-table_length,
        #incomplete-table_filter {
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
    @include('parts.modal-form')

    <x-flex-card title="Teams" titlecounts="4" iconurl="{{ asset('icons/group.png') }}" />
    <button class="bg-red-800 px-5 py-2 text-white flex newProject">Add New Team</button>
    @component('components.accordion', ['title' => '4500 Woodman Avenue | Copeland Finance Group'])
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
                                    <button class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="">
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
        <button class="bg-red-800 px-5 py-2 text-white flex mt-5">Project Overview</button>
    @endcomponent
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

        function showError(id, error = " field is required") {
            $('#' + id).addClass('border-red-700');
            $('#' + id + "_error").text(id + error);
        }

        function removeError(id) {
            $('#' + id).removeClass('border-red-700');
            $('#' + id + '_error').text('');
        }

        $('.teamContinue').click(function(e) {
            e.preventDefault();
            if ($('#name').val() === '') showError('name');
            else {
                removeError('name');
                $('.modalTitle').text('Add an Associate');
                $('.createTeam').addClass('hidden');
                $('.associate').removeClass('hidden');
            }
        });

        $('.associateContinue').click(function(e) {
            e.preventDefault();
            if ($('#associateEmail').val() === '') showError('associateEmail');
            else removeError('associateEmail');
            if (!validateEmail($('#associateEmail'))) showError('associateEmail', ' is not valid');
            else removeError('associateemail');
            if ($('#associate').val() === '') showError('associate');
            else removeError('associate');

            if ($('#associateEmail').val() !== '' && $('#associate').val() !== '' && validateEmail($(
                    '#associateEmail'))) {
                $('.modalTitle').text('Add an Jr Associate');
                $('.associate').addClass('hidden');
                $('.jrassociate').removeClass('hidden');
            }
        });

        $('.jrAssociateContinue').click(function(e) {
            e.preventDefault();
            if ($('#jrassociate').val() === '') showError('jrassociate');
            else removeError('jrassociate');
            if ($('#jrAssociateEmail').val() === '') showError('jrAssociateEmail');
            else {
                removeError('jrAssociateEmail')
                if (!validateEmail($('#jrAssociateEmail'))) showError('jrAssociateEmail', ' is not valid')
                else removeError('jrAssociateEmail');
            }
            if ($('#jrAssociateManager').val() === '') showError('jrAssociateManager');
            else removeError('jrAssociateManager');
        });

        $('.backToCreateTeam').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Create New Team');
            $('.createTeam').removeClass('hidden');
            $('.associate').addClass('hidden');
        });
        $('.backToCreateAssociate').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Add an Associate');
            $('.associate').removeClass('hidden');
            $('.jrassociate').addClass('hidden');
        });

        function validateEmail(email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test(email.val());
        }

        $(document).ready(function() {
            $('#user-table').DataTable({
                pageLength: 30,
                lengthMenu: [10, 20, 30, 50, 100, 200],
            });
            $('#unverified').html($('.unverifiedSerial:last').html());
            $('#verified').html($('.verifiedSerial:last').html());
            $('#deleted').html($('.deletedSerial:last').html());
        });
    </script>
@endsection
