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
    <x-flex-card title="Teams" titlecounts="{{ count($teams) }}" iconurl="{{ asset('icons/Teams.svg') }}" />
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
    @include('parts.js.teams-script')
@endsection
