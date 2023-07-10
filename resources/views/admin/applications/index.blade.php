@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }
    </style>
@endsection
@section('content')
    @can('isUser')
        @include('user.dashboard.upload')
    @endcan
    <div class="flex-wrap flex-shrink-0 w-full">
        <div class="w-full my-2">
            <div class="w-full h-44 ">
                <a href="{{ url('/dashboard') }}">
                    <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                        <div class="w-1/2 p-4 pl-8">
                            <span class="text-white text-lg block text-left">Applications</span>
                            <span class="text-white text-2xl block text-left font-bold mt-1">
                                {{ $applications->count() }}
                            </span>
                        </div>
                        <div class="w-1/2 pt-7 pr-7">
                            <img src="{{ asset('icons/user.svg') }}" alt="" class="z-20 float-right mt-3 mr-4">
                            <img src="{{ asset('icons/circle-big.svg') }}" alt=""
                                class="z-10 opacity-10 float-right mt-1 -mr-11 w-20">
                            <img src="{{ asset('icons/circle-small.svg') }}" alt=""
                                class="z-0 opacity-10 float-right mt-16 -mr-12 w-12">
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @if (session('role') == 'Admin')
            @php
                $tables = ['Pending Applications', 'Completed Deals', 'Incomplete Deals'];
            @endphp
            @foreach ($tables as $key => $table)
            @php $serialNo = 1; @endphp
                <h2 class="text-center text-themered text-2xl font-semibold">{{ $table }}</h2>
                <table class="w-full display" id="{{ getTableId($key) }}">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class=" pl-2 tracking-wide">
                                S No.
                            </th>
                            <th class="">
                                Name
                            </th>
                            <th class="">
                                User ID
                            </th>
                            <th class="">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($applications as $application)
                            @if ($application->status == $key)
                                <tr>
                                    <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                            href="{{ url(getAdminRoutePrefix() . '/application-show/' . $application->id) }}">
                                            {{ $application->name }}
                                        </a>
                                        <a title="Edit this user"
                                            href="{{ url(getAdminRoutePrefix() . '/application-edit/' . $application->id) }}">
                                            <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                        </a>
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        {{ $application->email }}
                                    </td>
                                    <td class="text-center pl-2 tracking-wide border border-r-0">
                                        <a class="delete" data="Delete" title="Delete this user"
                                            href="{{ url(getAdminRoutePrefix() . '/application-delete/' . $application->id) }}">
                                            <button class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                            </button>
                                        </a>
                                        @if ($key == 0)
                                            <a class="delete mx-2" data="Accept" title="Delete this user"
                                                href="{{ url(getAdminRoutePrefix() . '/application-update-status/' . $application->id . '/accept') }}">
                                                <button class="bg-black tracking-wide font-semibold capitalize text-xl">
                                                    <img src="{{ asset('icons/tick.svg') }}" alt=""
                                                        class="p-1 w-7">
                                                </button>
                                            </a>
                                            <a class="delete" data="Reject" title="Delete this user"
                                                href="{{ url(getAdminRoutePrefix() . '/application-update-status/' . $application->id . '/reject') }}">
                                                <button class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                    <img src="{{ asset('icons/cross.svg') }}" alt=""
                                                        class="p-1 w-7">
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @php $serialNo++; @endphp
                                @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
        @if (session('role') === 'Processor' || session('role') === 'Associate' || session('role') === 'Junior Associate')
            @php
                $tables = ['Pending Applications', 'Completed Deals', 'Incomplete Deals'];
            @endphp
            @foreach ($tables as $key => $table)
                <h2 class="text-center text-themered text-2xl font-semibold">{{ $table }}</h2>
                <table class="w-full display" id="{{ getTableId($key) }}">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class=" pl-2 tracking-wide">
                                S No.
                            </th>
                            <th class="">
                                Name
                            </th>
                            <th class="">
                                Created By
                            </th>
                            <th class="">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php $serialNo = 1; @endphp
                        @foreach ($applications as $processor)
                            @if ($processor->application)
                                @foreach ($processor->applications as $application)
                                    @if ($application->status == $key)
                                        <tr>
                                            <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                <a title="Click to view view this application" class="text-blue-500 inline"
                                                    href="{{ url(getRoutePrefix() . '/application-show/' . $application->id) }}">
                                                    {{ $application->name }}
                                                </a>
                                                <a title="Edit this application"
                                                    href="{{ url(getRoutePrefix() . '/application-edit/' . $application->id) }}">
                                                    <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                        class="inline ml-5">
                                                </a>
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                {{ $processor->email }}
                                            </td>
                                            <td class="text-center pl-2 tracking-wide border border-r-0">
                                                <a class="delete" data="Delete" title="Click to Delete this application"
                                                    href="{{ url(getRoutePrefix() . '/application-delete/' . $application->id) }}">
                                                    <button
                                                        class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                        <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                            class="p-1 w-7">
                                                    </button>
                                                </a>
                                                @if ($key == 0)
                                                    <a class="delete mx-2" data="Accept"
                                                        title="Click to Accept this application"
                                                        href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/accept') }}">
                                                        <button
                                                            class="bg-black tracking-wide font-semibold capitalize text-xl">
                                                            <img src="{{ asset('icons/tick.svg') }}" alt=""
                                                                class="p-1 w-7">
                                                        </button>
                                                    </a>
                                                    <a class="delete" data="Reject"
                                                        title="Click to Reject this application"
                                                        href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/reject') }}">
                                                        <button
                                                            class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                            <img src="{{ asset('icons/cross.svg') }}" alt=""
                                                                class="p-1 w-7">
                                                        </button>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $serialNo++; @endphp
                                    @endif
                                @endforeach
                            @endif
                            
                            @php
                                $associates = $processor
                                    ->createdUsers()
                                    ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])
                                    ->with('createdUsers')
                                    ->get();
                            @endphp
                            @foreach ($associates as $associate)
                                @if ($associate->application)
                                    @foreach ($associate->applications as $application)
                                        @if ($application->status == $key)
                                            <tr>
                                                <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    <a title="Click to view this application" class="text-blue-500 inline"
                                                        href="{{ url(getRoutePrefix() . '/application-show/' . $application->id) }}">
                                                        {{ $application->name }}
                                                    </a>
                                                    <a title="Click to Edit this application"
                                                        href="{{ url(getRoutePrefix() . '/application-edit/' . $application->id) }}">
                                                        <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                            class="inline ml-5">
                                                    </a>
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    {{ $associate->email }}
                                                </td>
                                                <td class="text-center pl-2 tracking-wide border border-r-0">
                                                    <a class="delete" data="Delete" title="Click to Delete this application"
                                                        href="{{ url(getRoutePrefix() . '/application-delete/' . $application->id) }}">
                                                        <button
                                                            class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                            <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                                class="p-1 w-7">
                                                        </button>
                                                    </a>
                                                    @if ($key == 0)
                                                        <a class="delete mx-2" data="Accept"
                                                            title="Click to Accept this application"
                                                            href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/accept') }}">
                                                            <button
                                                                class="bg-black tracking-wide font-semibold capitalize text-xl">
                                                                <img src="{{ asset('icons/tick.svg') }}" alt=""
                                                                    class="p-1 w-7">
                                                            </button>
                                                        </a>
                                                        <a class="delete" data="Reject"
                                                            title="Click to Reject this application"
                                                            href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/reject') }}">
                                                            <button
                                                                class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                <img src="{{ asset('icons/cross.svg') }}" alt=""
                                                                    class="p-1 w-7">
                                                            </button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $serialNo++; @endphp
                                        @endif
                                    @endforeach
                                @endif
                                @php
                                    $juniorAssociates = $associate
                                        ->createdUsers()
                                        ->whereIn('role', ['junior Associate', 'Borrower'])
                                        ->with('createdUsers')
                                        ->get();
                                @endphp
                                @foreach ($juniorAssociates as $jassociate)
                                    @if ($jassociate->application)
                                        @foreach ($jassociate->applications as $application)
                                            @if ($application->status == $key)
                                                <tr>
                                                    <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}
                                                    </td>
                                                    <td class=" pl-2 tracking-wide border border-l-0">
                                                        <a title="Click to View this application"
                                                            class="text-blue-500 inline"
                                                            href="{{ url(getRoutePrefix() . '/application-show/' . $application->id) }}">
                                                            {{ $application->name }}
                                                        </a>
                                                        <a title="Click to Edit this application"
                                                            href="{{ url(getRoutePrefix() . '/application-edit/' . $application->id) }}">
                                                            <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                                class="inline ml-5">
                                                        </a>
                                                    </td>
                                                    <td class=" pl-2 tracking-wide border border-l-0">
                                                        {{ $jassociate->email }}
                                                    </td>
                                                    <td class="text-center pl-2 tracking-wide border border-r-0">
                                                        <a class="delete" data="Delete" title="Click to Delete this application"
                                                            href="{{ url(getRoutePrefix() . '/application-delete/' . $application->id) }}">
                                                            <button
                                                                class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                                    class="p-1 w-7">
                                                            </button>
                                                        </a>
                                                        @if ($key == 0)
                                                            <a class="delete mx-2" data="Accept"
                                                                title="Click to Accept this application"
                                                                href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/accept') }}">
                                                                <button
                                                                    class="bg-black tracking-wide font-semibold capitalize text-xl">
                                                                    <img src="{{ asset('icons/tick.svg') }}"
                                                                        alt="" class="p-1 w-7">
                                                                </button>
                                                            </a>
                                                            <a class="delete" data="Reject"
                                                                title="Click to Reject this application"
                                                                href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/reject') }}">
                                                                <button
                                                                    class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                    <img src="{{ asset('icons/cross.svg') }}"
                                                                        alt="" class="p-1 w-7">
                                                                </button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php $serialNo++; @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                    @php
                                        $borrowers = $jassociate
                                            ->createdUsers()
                                            ->where('role', 'Borrower')
                                            ->with('createdUsers')
                                            ->get();
                                    @endphp
                                    @foreach ($borrowers as $borrower)
                                        @if ($borrower->application)
                                            @foreach ($borrower->application as $application)
                                                @if ($application->status == $key)
                                                    <tr>
                                                        <td class=" pl-2 tracking-wide border border-l-0">
                                                            {{ $serialNo }}</td>
                                                        <td class=" pl-2 tracking-wide border border-l-0">
                                                            <a title="Click to View this application"
                                                                class="text-blue-500 inline"
                                                                href="{{ url(getRoutePrefix() . '/application-show/' . $application->id) }}">
                                                                {{ $application->name }}
                                                            </a>
                                                            <a title="Click to Edit this application"
                                                                href="{{ url(getRoutePrefix() . '/application-edit/' . $application->id) }}">
                                                                <img src="{{ asset('icons/pencil.svg') }}" alt=""
                                                                    class="inline ml-5">
                                                            </a>
                                                        </td>
                                                        <td class=" pl-2 tracking-wide border border-l-0">
                                                            {{ $borrower->email }}
                                                        </td>
                                                        <td class="text-center pl-2 tracking-wide border border-r-0">
                                                            <a class="delete" data="Delete" title="Click to Delete this application"
                                                                href="{{ url(getRoutePrefix() . '/application-delete/' . $application->id) }}">
                                                                <button
                                                                    class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                    <img src="{{ asset('icons/trash.svg') }}"
                                                                        alt="" class="p-1 w-7">
                                                                </button>
                                                            </a>
                                                            @if ($key == 0)
                                                                <a class="delete mx-2" data="Accept"
                                                                    title="Click to Accept this application"
                                                                    href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/accept') }}">
                                                                    <button
                                                                        class="bg-black tracking-wide font-semibold capitalize text-xl">
                                                                        <img src="{{ asset('icons/tick.svg') }}"
                                                                            alt="" class="p-1 w-7">
                                                                    </button>
                                                                </a>
                                                                <a class="delete" data="Reject"
                                                                    title="Click to Reject this application"
                                                                    href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/reject') }}">
                                                                    <button
                                                                        class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                        <img src="{{ asset('icons/cross.svg') }}"
                                                                            alt="" class="p-1 w-7">
                                                                    </button>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php $serialNo++; @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
        @can('isUser')
            @include('user.dashboard.cards')
        @endcan
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $('[data="Reject"]').attr('title', 'Reject This Deal');
        $('[data="Accept"]').attr('title', 'Accept This Deal');
        $('[title="Delete this user"]').attr('title', 'Delete This Deal');
        $(document).ready(function() {
            $('#user-table').DataTable({
                pageLength: 30,
                lengthMenu: [10, 20, 30, 50, 100, 200],
            });
        });
        $('.no-footer').addClass('w-full');
    </script>
@endsection
