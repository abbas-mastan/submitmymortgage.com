@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="flex flex-wrap flex-shrink-0 w-full">
        {{-- @can('isAdmin') --}}
        <div class="w-full my-2">
            <div class="w-full h-44 ">
                <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <div class="w-1/2 p-4 pl-8">
                        <span class="text-white text-lg block text-left">Users</span>
                        <span class="text-white text-2xl block text-left font-bold mt-1">
                            {{ $users->count() }}
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
            </div>
        </div>
    </div>
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
                <tr>
                    <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNumber }}</td>
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
                    <td class="flex pl-2 tracking-wide border border-r-0">
                        <a data="Delete" class="delete" href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                            <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
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
            @endforeach
        </tbody>
    </table>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('mouseenter', '.loginBtn', function() {
                $(this).append(
                    '<div role="tooltip" class="w-40 mt-2 -ml-16 absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">Login As This User<div class="tooltip-arrow" data-popper-arrow></div></div>'
                );
            }).on('mouseleave', '.loginBtn', function() {
                $(this).find('div[role="tooltip"]').remove();
            });

            $('#user-table').DataTable({
                pageLength: 30,
                lengthMenu: [10, 20, 30, 50, 100, 200],
            });
        });
    </script>
@endsection
