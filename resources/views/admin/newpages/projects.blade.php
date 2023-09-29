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
    @include('parts.project-modal-form')
    <x-flex-card title="Projects" titlecounts="{{ count($projects) }}" iconurl="{{ asset('icons/user.svg') }}" />
    <button class="bg-red-800 px-5 py-2 text-white flex newProject">Add New Project</button>
    @forelse ($projects as $project)
        <div class="flex flex-wrap w-full  ">
            <div class="grid divide-y divide-neutral-200 w-full mt-8">
                <div class="py-2">
                    <details class="group">
                        <summary
                            class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white py-2 flex text-xl justify-between items-center font-medium cursor-pointer list-none">
                            <span class="px-5"> {{ $project->name }} |
                                {{ \App\Models\Team::find($project->team_id)->name }}</span>
                            <span class="mr-4 transition group-open:rotate-180">
                                <svg fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <p id="toptable" class="text-neutral-600 group-open:animate-fadeIn">
                        <table class="w-full display shadow-lg" id="{{ str_replace(' ', '', $project->name)}}-table">
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
                                @foreach ($project->managers[2] as $key => $processor)
                                    @php
                                        $processor = \App\Models\User::find($processor);
                                    @endphp
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
                                                {{-- <a title="Edit this user"
                                                    href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                                    <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                        class="inline ml-5">
                                                </a> --}}
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
                                                {{-- <a data="Delete" class="delete"
                                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                                    <button
                                                        class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                        <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                    </button>
                                                </a> --}}
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
                                @foreach ($project->managers[0] as $key => $processor)
                                    @php
                                        $processor = \App\Models\User::find($processor);
                                    @endphp
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
                                                {{-- <a title="Edit this user"
                                                    href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                                    <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                        class="inline ml-5">
                                                </a> --}}
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
                                                {{-- <a data="Delete" class="delete"
                                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                                    <button
                                                        class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                        <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                    </button>
                                                </a> --}}
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
                                @foreach ($project->managers[1] as $key => $processor)
                                    @php
                                        $processor = \App\Models\User::find($processor);
                                    @endphp
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
                                                {{-- <a title="Edit this user"
                                                    href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                                    <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                        class="inline ml-5">
                                                </a> --}}
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
                                                {{-- <a data="Delete" class="delete"
                                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                                    <button
                                                        class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                        <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                    </button>
                                                </a> --}}
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
        </div>
    @empty
    @endforelse

@endsection
@section('foot')
    @include('parts.js.project-script')
@endsection
