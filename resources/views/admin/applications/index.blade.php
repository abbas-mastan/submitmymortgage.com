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
                                {{-- {{ $applications->count() }} --}}
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
        @if ($role == 'Super Admin')
            @foreach ($tables as $key => $table)
                @php $serialNo = 1; @endphp
                <h2 class="text-center text-themered text-2xl font-semibold">{{ $table }}</h2>
                <table class="w-full display" id="{{ getTableId($key) }}">
                    <x-table-head />
                    <tbody class="text-center">
                        @foreach ($applications as $application)
                            @if ($application->status == $key)
                                @include('components.table-row')
                                @php
                                $serialNo++;
                            @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
        @if ($role === 'Associate' || $role === 'Junior Associate' || $role == 'Processor' || $role == 'Admin')
            @foreach ($tables as $key => $table)
                <h2 class="text-center text-themered text-2xl font-semibold">{{ $table }}</h2>
                <table class="w-full display" id="{{ getTableId($key) }}">
                    <tbody class="text-center">
                        <x-table-head />
                        @php $serialNo = 1; @endphp
                        @foreach ($users as $user)
                        @if ($user->application)
                        @php $application = $user->application @endphp
                        @if ($application->status == $key)
                                    @include('components.table-row')
                                    @php
                                        $serialNo++;
                                    @endphp
                                @endif
                            @endif
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
