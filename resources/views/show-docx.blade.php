@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        .page-item.active {
            background-color: rgb(70, 120, 228);
            color: white;
        }

        .page-item {
            padding: 10px;
            position: relative;
            line-height: 1;
        }

        .page-item.disabled {
            cursor: not-allowed;
            pointer-events: all !important;
        }
    </style>
@endsection
@section('content')
<iframe class="w-full h-[90%]" src="https://docs.google.com/gview?url={{$path}}&embedded=true"></iframe>
@endsection
@section('foot')
@endsection
