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

        #the-canvas {
            border: 1px solid black;
            direction: ltr;
        }

        .inputLabel {
            background-color: rgb(192, 192, 191);
            padding: 3px 8px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    @if ($currentrole !== 'Borrower')
        @include('parts.project-modal-form')
    @endif
    <x-flex-card title="Deals" titlecounts="{{ count($projects) }}" iconurl="{{ asset('icons/Deals.svg') }}" />
    @if (Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
        <button class="bg-red-800 px-5 py-2 text-white flex newProject">Add New Deal</button>
    @endif
    @if (count($enableProjects) > 0)
        <h2 class="text-center text-xl border-y-4 py-3  mt-5">Enable Deals</h2>
    @endif
    @forelse ($enableProjects as $project)
        <div class="flex mb-10 flex-wrap w-full">
            <div class="grid divide-y divide-neutral-200 w-full mt-8">
                <div class="py-2">
                    <details class="group">
                        <summary
                            class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white py-2 flex text-xl justify-between items-center font-medium cursor-pointer list-none">
                            <span class="px-5"> {{ $project->name }} |
                                {{ $project->team->name }}</span>
                            <span class="mr-4 transition group-open:rotate-180">
                                <svg fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <p id="toptable1" class="text-neutral-600 group-open:animate-fadeIn">
                        <table class="w-full display shadow-lg" id="{{ Str::slug($project->name . $project->id) }}-table">
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
                                @foreach ($project->users as $user)
                                    @if ($user->email_verified_at !== null)
                                        <tr class="border-none">
                                            <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                                {{ $serialNumber }}
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                <a title="Click to view files uploaded by this user"
                                                class="text-blue-500 inline"
                                                @if($currentrole === 'Super Admin') 
                                                href="{{ url(getRoutePrefix() . ($user->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $user->id) }}"
                                                @endif
                                                >
                                                {{ $user->name }}
                                            </a>
                                                {{-- <a title="Edit this user"
                                                    href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                                    <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                        class="inline ml-5">
                                                </a> --}}
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                {{ $user->email }}
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                {{ $user->role }}
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                @if ($user->created_by)
                                                    {{ $user->createdBy->name }}
                                                    |
                                                    {{ $user->createdBy->role }}
                                                @endif
                                            </td>
                                            <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                                @if ($currentrole === 'Super Admin')
                                                    <a data="Delete" class="delete"
                                                        href='{{ url(getRoutePrefix() . "/delete-project-user/$project->id/" . $user->id) }}'>
                                                        <button
                                                            class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                            <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                        </button>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
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
                                <tr class="border-none">
                                    <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                        {{ $serialNumber }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                            href="{{ url(getRoutePrefix() . ($project->borrower->role ?? null == 'Borrower' ? '/project-overview/' : '/all-users/') . ($project->borrower->id ?? null)) }}">
                                            {{ $project->borrower->name }}
                                        </a>
                                        {{-- <a title="Edit this user"
                                            href="{{ url(getRoutePrefix() . '/add-user/' . $borrower->id) }}">
                                            <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                class="inline ml-5">
                                        </a> --}}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        {{ $project->borrower->email }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        {{ $project->borrower->role }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        @if ($project->borrower->created_by)
                                            {{ $project->borrower->createdBy->name }}
                                            |
                                            {{ $project->borrower->createdBy->role }}
                                        @endif
                                    </td>
                                    <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                        @if ($currentrole === 'Super Admin')
                                            <form method="POST"
                                                action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $project->borrower->id }}">
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
                            </tbody>
                        </table>
                        <div class="flex justify-between">
                            <a href="{{ url(getRoutePrefix() . ($project->borrower->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $project->borrower->id) }}"
                                class="w-fit bg-red-800 px-5 py-2 text-white flex mt-5">Project Overview</a>
                            {{-- <button class="AddNewMember w-fit bg-red-800 px-5 py-2 text-white flex mt-5">Add New Member</button> --}}
                        </div>
                        </p>
                    </details>
                </div>
            </div>
        </div>
    @empty
    @endforelse

    @can('isSuperAdmin')
        @if (count($disableProjects) > 0)
            <h2 class="text-center text-xl border-y-4 py-3  mt-5">Disable Deals</h2>
        @endif
        @forelse ($disableProjects as $project)
            <div class="flex mb-10 flex-wrap w-full">
                <div class="grid divide-y divide-neutral-200 w-full mt-8">
                    <div class="py-2">
                        <details class="group">
                            <summary
                                class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white py-2 flex text-xl justify-between items-center font-medium cursor-pointer list-none">
                                <span class="px-5"> {{ $project->name }} |
                                    {{ $project->team->name }}</span>
                                <span class="mr-4 transition group-open:rotate-180">
                                    <svg fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <p id="toptable1" class="text-neutral-600 group-open:animate-fadeIn">
                            <table class="w-full display shadow-lg"
                                id="{{ Str::slug($project->name . $project->id) }}-table">
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
                                    @foreach ($project->users as $key => $user)
                                        @if ($user->email_verified_at !== null)
                                            <tr class="border-none">
                                                <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                                    {{ $serialNumber }}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    <a title="Click to view files uploaded by this user"
                                                        class="text-blue-500 inline"
                                                        href="{{ url(getRoutePrefix() . ($user->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $user->id) }}">
                                                        {{ $user->name }}
                                                    </a>
                                                    {{-- <a title="Edit this user"
                                                href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                                <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                    class="inline ml-5">
                                            </a> --}}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    {{ $user->email }}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    {{ $user->role }}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    @if ($user->created_by)
                                                        {{ $user->createdBy->name }}
                                                        |
                                                        {{ $user->createdBy->role }}
                                                    @endif
                                                </td>
                                                <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                                    <a data="Delete" class="delete"
                                                        href='{{ url(getRoutePrefix() . "/delete-project-user/$project->id/" . $user->id) }}'>
                                                        <button
                                                            class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                            <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                        </button>
                                                    </a>
                                                    @if ($currentrole === 'Super Admin')
                                                        <form method="POST"
                                                            action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">
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
                                    <tr class="border-none">
                                        <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                            {{ $serialNumber }}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                                href="{{ url(getRoutePrefix() . ($project->borrower->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $project->borrower->id) }}">
                                                {{ $project->borrower->name }}
                                            </a>
                                            {{-- <a title="Edit this user"
                                        href="{{ url(getRoutePrefix() . '/add-user/' . $borrower->id) }}">
                                        <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                            class="inline ml-5">
                                    </a> --}}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            {{ $project->borrower->email }}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            {{ $project->borrower->role }}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            @if ($project->borrower->created_by)
                                                {{ $project->borrower->createdBy->name }}
                                                |
                                                {{ $project->borrower->createdBy->role }}
                                            @endif
                                        </td>
                                        <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                            @if ($currentrole === 'Super Admin')
                                                <form method="POST"
                                                    action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id"
                                                        value="{{ $project->borrower->id }}">
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
                                </tbody>
                            </table>
                            <div class="flex justify-between">
                                <a href="{{ url(getRoutePrefix() . ($project->borrower->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $project->borrower->id) }}"
                                    class="w-fit bg-red-800 px-5 py-2 text-white flex mt-5">Project Overview</a>
                                {{-- <button class="AddNewMember w-fit bg-red-800 px-5 py-2 text-white flex mt-5">Add New Member</button> --}}
                            </div>
                            </p>
                        </details>
                    </div>
                </div>
            </div>
        @empty
        @endforelse

        @if (count($closeProjects) > 0)
            <h2 class="text-center text-xl border-y-4 py-3  mt-5">Closed Deals</h2>
        @endif
        @forelse ($closeProjects as $project)
            <div class="flex mb-10 flex-wrap w-full">
                <div class="grid divide-y divide-neutral-200 w-full mt-8">
                    <div class="py-2">
                        <details class="group">
                            <summary
                                class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white py-2 flex text-xl justify-between items-center font-medium cursor-pointer list-none">
                                <span class="px-5"> {{ $project->name }} |
                                    {{ $project->team->name }}</span>
                                <span class="mr-4 transition group-open:rotate-180">
                                    <svg fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <p id="toptable1" class="text-neutral-600 group-open:animate-fadeIn">
                            <table class="w-full display shadow-lg"
                                id="{{ Str::slug($project->name . $project->id) }}-table">
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
                                    @foreach ($project->users as $key => $user)
                                        @if ($user->email_verified_at !== null)
                                            <tr class="border-none">
                                                <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                                    {{ $serialNumber }}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    <a title="Click to view files uploaded by this user"
                                                        class="text-blue-500 inline"
                                                        href="{{ url(getRoutePrefix() . ($user->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $user->id) }}">
                                                        {{ $user->name }}
                                                    </a>
                                                    {{-- <a title="Edit this user"
                                                href="{{ url(getRoutePrefix() . '/add-user/' . $user->id) }}">
                                                <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                    class="inline ml-5">
                                            </a> --}}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    {{ $user->email }}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    {{ $user->role }}
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    @if ($user->created_by)
                                                        {{ $user->name }}
                                                        |
                                                        {{ $user->role }}
                                                    @endif
                                                </td>
                                                <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                                    <a data="Delete" class="delete"
                                                        href='{{ url(getRoutePrefix() . "/delete-project-user/$project->id/" . $user->id) }}'>
                                                        <button
                                                            class="bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1.5">
                                                            <img src="{{ asset('icons/trash.svg') }}" alt="">
                                                        </button>
                                                    </a>
                                                    @if ($currentrole == 'Super Admin')
                                                        <form method="POST"
                                                            action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">
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
                                    <tr class="border-none">
                                        <td class="verifiedSerial w-14 pl-2 tracking-wide border border-l-0">
                                            {{ $serialNumber }}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                                href="{{ url(getRoutePrefix() . ($project->borrower->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $project->borrower->id) }}">
                                                {{ $project->borrower->name }}
                                            </a>
                                            {{-- <a title="Edit this user"
                                        href="{{ url(getRoutePrefix() . '/add-user/' . $borrower->id) }}">
                                        <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                            class="inline ml-5">
                                    </a> --}}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            {{ $project->borrower->email }}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            {{ $project->borrower->role }}
                                        </td>
                                        <td class=" pl-2 tracking-wide border border-l-0">
                                            @if ($project->borrower->created_by)
                                                {{ $project->borrower->createdBy->name }}
                                                |
                                                {{ $project->borrower->createdBy->role }}
                                            @endif
                                        </td>
                                        <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                            @if ($currentrole === 'Super Admin')
                                                <form method="POST"
                                                    action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id"
                                                        value="{{ $project->borrower->id }}">
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
                                </tbody>
                            </table>
                            <div class="flex justify-between">
                                <a href="{{ url(getRoutePrefix() . ($project->borrower->role == 'Borrower' ? '/project-overview/' : '/all-users/') . $project->borrower->id) }}"
                                    class="w-fit bg-red-800 px-5 py-2 text-white flex mt-5">Project Overview</a>
                                {{-- <button class="AddNewMember w-fit bg-red-800 px-5 py-2 text-white flex mt-5">Add New Member</button> --}}
                            </div>
                            </p>
                        </details>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    @endcan

@endsection
@section('foot')
    @include('parts.js.project-script')
@endsection
