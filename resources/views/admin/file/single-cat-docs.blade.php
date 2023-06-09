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
    @include('admin.file.cards')
    <div class="">
        @if (!empty($id))
            @include('elems.upload-btn')
            {{-- @include('admin.file.info-table') --}}
        @endif
    </div>

    <div class="">
        @include('admin.file.single-category-files-table')
    </div>
@endsection
@section('foot')
    <script>
        @if (!empty($id))
            var userId = {{ $id }};
            var cat = "{!! $cat !!}";
            var uploadUrl = '{{ url(getRoutePrefix() . '/file-upload') }}';
        @endif
    </script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/upload.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#status').on('change', function() {
                if ($('#status').val() !== "")
                    $('#status-form').submit();
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            const listElement = $('.list-group');
            listElement.paginathing({
                perPage: 10,
                limitPagination: 5,
                containerClass: '',
                pageNumbers: true,
                ulClass: 'inline-flex gap-2',
            });
        });
    </script>
@endsection
