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
    @foreach ($teams as $team)
        @component('components.accordion', ['title' => $team->name])
            <table class="w-full display shadow-lg" id="{{ str_replace(' ', '', $team->name) }}-table">
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
                    @foreach ($team->users as $key => $user)
                        @php
                            $associates = \App\Models\User::where('id', $user->pivot->associates)->get();
                        @endphp
                        @foreach ($associates as $key => $associate)
                            <tr class="border-none">
                                <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                    {{ $serialNumber }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                        {{-- href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}" --}}>
                                        {{ $associate->name }}
                                    </a>
                                    <a title="Edit this user"
                                        href="{{ url(getRoutePrefix() . '/add-user/' . $associate->id) }}">
                                        <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                    </a>
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $associate->email }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $associate->role }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    @if ($associate->created_by)
                                        {{ \App\Models\User::where('id', $associate->created_by)->first()->name }}
                                        |
                                        {{ \App\Models\User::where('id', $associate->created_by)->first()->role }}
                                    @endif
                                </td>
                                <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                    {{-- <a data="Delete" disabaled class="delete"
                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $user->id) }}"
                                    >
                                    <button class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="">
                                    </button>
                                </a> --}}
                                    @if (session('role') == 'Admin')
                                        <form method="POST" action="{{ url(getAdminRoutePrefix() . '/login-as-this-user') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $associate->id }}">
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
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <button class="bg-red-800 px-5 py-2 text-white flex mt-5">Project Overview</button>
        @endcomponent
    @endforeach
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    @foreach ($teams as $team)
        <script>
            new DataTable("#{{ str_replace(' ', '', $team->name) }}-table");
            $("#{{ str_replace(' ', '', $team->name) }}-table_length").css('display', 'none');
            $("#{{ str_replace(' ', '', $team->name) }}-table_filter").css('display', 'none');
            $("#{{ str_replace(' ', '', $team->name) }}-table_wrapper").css('box-shadow', '0px 0px 11px 0px gray');
            $(`select[name="{{ $team->name }}-table_length"]`).addClass('w-16');
            $(`select[name="{{ $team->name }}-table_length"]`).addClass('mb-3');
        </script>
    @endforeach
    <script>
        var teamid = 0;
        $('.teamContinue').click(function(e) {
            if ($('#new').hasClass('hidden')) {
                if ($('#selecTeam').find(':checked').html() !== "Select Team") {
                    teamid = $('#selecTeam').find(':checked').val()
                }
            }
        });
        $(document).ready(function() {
            $("#processor,#associate").change(function() {
                $.ajax({
                    url: `{{ getAdminRoutePrefix() }}/getUsersByProcessor/${$(this).val()}/${teamid}`, // Replace with the actual URL for retrieving users by team
                    type: 'GET',
                    success: function(data) {

                        if (data == 'processorerror') {
                            $('#processor').removeClass('mb-5');
                            $('.processorContinue').attr('disabled', 'disabled');
                            $('#processor_error').text('this is processor is already exists');
                        } else {
                            $(this).removeClass('mb-5');
                            $("#associate").empty();
                            $("#jrAssociate").empty();

                            // // Process the data to categorize roles
                            var associates = [];
                            var juniorAssociates = [];

                            $.each(data, function(index, associate) {
                                if (associate.role === 'Associate') {
                                    associates.push(associate);
                                } else if (associate.role === 'Junior Associate') {
                                    juniorAssociates.push(associate);
                                }
                            });

                            // Populate the "associate" select with Associate options
                            $('#associate').append(
                            '<option value="">Select Associate asdf</option>');
                            $.each(associates, function(index, associate) {
                                $("#associate").append('<option value="' + associate
                                    .id + '">' + associate.name + '</option>');
                            });

                            // Populate the "jrAssociate" select with Junior Associate options
                            $('#jrAssociate').append(
                                '<option value="">Select Jr. Associate</option>');
                            $.each(juniorAssociates, function(index, associate) {
                                $("#jrAssociate").append('<option value="' + associate
                                    .id + '">' + associate.name + '</option>');
                            });
                        }
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });


        $('.newProject').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').removeClass('hidden');
        });
        $('.closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('hidden');
        });

        function showError(id, error = " field is required") {
            $('#' + id).addClass('border-red-700 border-2');
            $('#' + id + "_error").text(id + error);
            return false;
        }

        function removeError(id) {
            $('#' + id).removeClass('border-red-700 border-2');
            $('#' + id + '_error').text('');
            return true;
        }
        $('.teamContinue').click(function(e) {
            e.preventDefault();
            if ($('#new').hasClass('hidden')) {
                if ($('#selecTeam').find(':checked').html() === "Select Team") {
                    showError('team')
                } else {
                    $('#teamForm').attr('action',
                        `{{ url(getAdminRoutePrefix() . '/teams') }}/${$('#selecTeam').find(':checked').val()}`
                    )
                    removeError('name');
                    $('.modalTitle').text('Add an Processor');
                    $('.createTeam').addClass('hidden');
                    $('.processor').removeClass('hidden');
                }
            } else {
                if ($('#name').val() === '') showError('name');
                else if ($('#name').val().length < 8) showError('name', ' must be at least 8 characters');
                else {
                    removeError('name');
                    $('.modalTitle').text('Add an Processor');

                    $('.createTeam').addClass('hidden');
                    $('.processor').removeClass('hidden');
                }
            }
        });

        $('.processorContinue').click(function(e) {
            e.preventDefault();
            if ($('#processor').find(':selected').html() === "Select Processor") {
                showError('processor');
                $('select[name=processor]').removeClass('mb-5');
            } else {
                $('select[name=processor]').addClass('mb-5');
                removeError('processor');
            }
            if ($('#processor').find(':selected').html() !== "Select Processor") {
                $('.modalTitle').text('Add an Associate');
                $('.processor').addClass('hidden');
                $('.associate').removeClass('hidden');
            }
        });

        $('.associateContinue').click(function(e) {
            e.preventDefault();
            if ($('#associate').find(':selected').html() === "Select Associate") {
                $('select[name=associate]').removeClass('mb-5');
                showError('associate');
            } else {

                $('select[name=associate]').addClass('mb-5');
                removeError('associate');
            }
            if ($('#associate').find(':selected').html() !== "Select Associate") {
                $('.modalTitle').text('Add an Jr Associate');
                $('.associate').addClass('hidden');
                $('.jrAssociate').removeClass('hidden');
            }
        });

        $('.jrAssociateContinue').click(function(e) {
            e.preventDefault();
            if ($('#jrAssociate').find(':selected').html() === "Select Jr. Associate") {
                showError('jrAssociate');
                return;
            } else removeError('jrAssociate');

            if ($('#jrAssociateManager').val() === '') {
                showError('jrAssociateManager');
                return;
            } else {
                removeError('jrAssociateManager');
            }
            $('#teamForm').submit();
        });

        $(document).ready(function() {
            if ($('#newInput').is(':checked')) {
                $('#new').removeClass('hidden');
                $('#existing').addClass('hidden');
                $('#new input').removeAttr('disabled'); // Correct the selector and method
                $('#existing select').attr('disabled', 'disabled'); // Correct the selector and method
            }
        });

        function changeInputs() {
            if ($('#newInput').is(':checked')) {
                $('#new').removeClass('hidden');
                $('#existing').addClass('hidden');
                $('#new input').removeAttr('disabled'); // Correct the selector and method
                $('#existing select').attr('disabled', 'disabled'); // Correct the selector and method
            } else {
                $('#new').addClass('hidden');
                $('#existing').removeClass('hidden');
                $('#existing select').removeAttr('disabled'); // Correct the selector and method
                $('#new input').attr('disabled', 'disabled'); // Correct the selector and method
            }
        }

        $('.backToCreateTeam').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Create New Team');
            $('.createTeam').removeClass('hidden');
            $('.processor').addClass('hidden');
        });
        $('.backToCreateProcessor').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Create New Processor');
            $('.processor').removeClass('hidden');
            $('.associate').addClass('hidden');
        });
        $('.backToCreateAssociate').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Add an Associate');
            $('.associate').removeClass('hidden');
            $('.jrAssociate').addClass('hidden');
        });

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
