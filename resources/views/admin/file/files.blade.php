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
    @include('admin.file.cards')
    <div class="">
        @if (!empty($id))
            @include('elems.upload-btn')
            @include('admin.file.info-table')
        @endif
    </div>

    <div class="">
        @include('admin.file.files-table')
    </div>
@endsection
@section('foot')
    <script>
        @if (!empty($id))
            var userId = {{ $id }};
            var cat = '';
            var uploadUrl = '{{ url(getRoutePrefix() . '/file-upload') }}';
        @endif
    </script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/upload.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#files-table').DataTable({
                pageLength: 50,
                lengthMenu: [10, 20, 30, 50, 100, 200],
            });
            $('#files-table_wrapper').css('width', '100%');
            $('select[name="files-table_length"]').css('width', '4rem');

        });
    </script>
    <script>
        $(document).ready(function() {
            let mortgage1 = $('#mortage1').html();
            let mortgage2 = $('#mortage2').text();
            let value = $('#value').text();
            console.log($('#mortage1').text());
            //Remove commas
            mortgage1 = mortgage1.replaceAll(",", "");
            mortgage2 = mortgage2.replaceAll(",", "");
            value = value.replaceAll(",", "");
            //Remove dollars sign
            mortgage1 = mortgage1.replaceAll("$", "");
            mortgage2 = mortgage2.replaceAll("$", "");
            value = value.replaceAll("$", "");
            //Remove spaces
            mortgage1 = mortgage1.replaceAll(" ", "");
            mortgage2 = mortgage2.replaceAll(" ", "");
            value = value.replaceAll(" ", "");

            $('#mortage1').text(formatNumbers(mortgage1) + " $");
            $('#mortage2').text(formatNumbers(mortgage2) + " $");
            $('#value').text(formatNumbers(value) + " $");



        });

        function formatNumbers(number) {
            number += '';
            x = number.split(',');
            x1 = x[0];
            x2 = x.length > 1 ? ',' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endsection
