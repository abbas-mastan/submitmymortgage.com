@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        .menu::-webkit-scrollbar {
            width: 4px;
        }

        /* Track */
        .menu::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .menu::-webkit-scrollbar-thumb {
            background: #848484;
            border-radius: 5px;
        }

        /* Handle on hover */
        .menu::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection
@section('content')
    @can('isUser')
        @include('user.dashboard.upload')
    @endcan
    <div class="flex-wrap justify-center w-full">
        @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
            @include('admin.dashboard.menu')
            {{-- @include('admin.dashboard.cards')
        @include('admin.dashboard.users') --}}
        @endif
        @can('isAssociate')
            @include('admin.dashboard.menu')
            {{-- @include('admin.dashboard.cards')
        @include('admin.dashboard.users') --}}
        @endcan
        @can('isUser')
            {{-- @include('admin.dashboard.menu') --}}
            @include('user.dashboard.cards')
        @endcan
        @can('isAssistant')
            @include('user.assistant.deal-documents-submit')
        @endcan
    </div>
@endsection
@section('foot')
@include('parts.js.dashboard-script')
@endsection
