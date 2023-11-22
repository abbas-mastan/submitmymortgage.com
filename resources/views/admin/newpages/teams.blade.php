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

        .inputLabel {
            background-color: rgb(192, 192, 191);
            padding: 3px 8px;
            border-radius: 5px;

        }
    </style>
@endsection
@section('content')

    @include('parts.modal-form')
    <x-flex-card title="Teams" titlecounts="{{ count($enableTeams) }}" iconurl="{{ asset('icons/Teams.svg') }}" />
    @if($currentrole === 'Super Admin' || $currentrole === 'Admin')
    <button class="bg-red-800 px-5 py-2 text-white flex newProject">Add New Team</button>
    @endif
    @if (count($enableTeams) > 0)
        <h2 class="text-center text-xl border-y-4 py-3  mt-5">Enabled Teams</h2>
    @endif
    @foreach ($enableTeams as $team)
        @component('components.accordion', ['title' => $team->name])
            <table class="w-full display shadow-lg" id="{{ Str::slug($team->name) }}-table{{ $team->id }}">
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
                        <tr class="border-none">
                            <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                {{ $serialNumber }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    {{-- href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}" --}}>
                                    {{ $user->name }}
                                </a>
                                @if ($currentrole === 'Super Admin')
                                    <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                        <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                    </a>
                                @endif
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
                                    {{ $user->createdBy->role}}
                                @endif
                            </td>
                            <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                @if (session('role') === 'Super Admin')
                                    <a data="Delete" disabaled class="delete"
                                        href="{{ url(getRoutePrefix() . "/delete-user-from-team/$team->id/" . $user->id) }}">
                                        <button class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                            <img src="{{ asset('icons/trash.svg') }}" alt="">
                                        </button>
                                    </a>
                                    <form method="POST" action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
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
                    @endforeach
                </tbody>
            </table>
            @if ($team->owner_id === Auth::id())
            <div class="mt-5">
                <a data="{{ $team->disable ? 'Enable' : 'Disable' }}" class="delete"
                    href="{{ url(getRoutePrefix() . '/delete-team/' . $team->id) }}">
                    <button class="bg-red-800 px-5 py-2 text-white">
                        {{ $team->disable ? 'Enable' : 'Disable' }} Team
                    </button>
                </a>
            </div>
            @endif
        @endcomponent
    @endforeach

    @can('isSuperAdmin')
        @if (count($disableTeams) > 0)
            <h2 class="text-center text-xl border-y-4 py-3  mt-5">Disabled Teams</h2>
        @endif
        @foreach ($disableTeams as $key => $team)
            @if ($team->disable)
                @component('components.accordion', ['title' => $team->name])
                    <table class="w-full display shadow-lg" id="{{ Str::slug($team->name) }}-table{{ $team->id }}">
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
                                <tr class="border-none">
                                    <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                        {{ $serialNumber }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                            {{-- href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}" --}}>
                                            {{ $user->name }}
                                        </a>
                                        @if ($currentrole === 'Super Admin')
                                            <a title="Edit this user"
                                                href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                                <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                            </a>
                                        @endif
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        {{ $user->email }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        {{ $user->role }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        @if ($user->created_by)
                                            {{ \App\Models\User::where('id', $user->created_by)->first()->name }}
                                            |
                                            {{ \App\Models\User::where('id', $user->created_by)->first()->role }}
                                        @endif
                                    </td>
                                    <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                        @if (session('role') === 'Super Admin')
                                            <a data="Delete" disabaled class="delete"
                                                href="{{ url(getRoutePrefix() . "/delete-user-from-team/$team->id/" . $user->id) }}">
                                                <button
                                                    class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                    <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                </button>
                                            </a>
                                            <form method="POST" action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
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
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        <a data="{{ $team->disable ? 'Enable' : 'Disable' }}" class="delete"
                            href="{{ url(getRoutePrefix() . '/delete-team/' . $team->id) }}">
                            <button class="bg-red-800 px-5 py-2 text-white">
                                {{ $team->disable ? 'Enable' : 'Disable' }} Team
                            </button>
                        </a>
                    </div>
                @endcomponent
            @endif
        @endforeach
    @endcan
@endsection
@section('foot')
    @include('parts.js.teams-script')
@endsection
