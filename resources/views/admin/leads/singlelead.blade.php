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
    <div class="w-full   my-2">
        <div class="w-full h-44 ">
            <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                <div class="w-1/2 p-4 pl-8">
                    <span class="text-white text-lg block text-left">Borrower</span>
                    <span class="text-white text-2xl block text-left font-bold mt-1">
                        {{ $info->b_fname . ' ' . $info->b_lname }}
                    </span>
                </div>
                <div class="w-1/2 pt-7 pr-7">
                    <img src="{{ asset('icons/disk.svg') }}" alt="" class="w-12 h-12 float-right mt-3 mr-4">
                </div>
            </div>
        </div>
    </div>
    <div class="">
        @include('admin.file.info-table')
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
    {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
            @if ($user->finance_type == 'Purchase')
                let purchasePrice = $('#purchase-price').text();
                let purchaseDp = $('#purchase-dp').text();
                let loanAmount = $('#loan-amount').text();
                //Remove commas
                purchasePrice = purchasePrice.replaceAll(",", "");
                purchaseDp = purchaseDp.replaceAll(",", "");
                loanAmount = loanAmount.replaceAll(",", "");
                //Remove dollars sign
                purchasePrice = purchasePrice.replaceAll("$", "");
                purchaseDp = purchaseDp.replaceAll("$", "");
                loanAmount = loanAmount.replaceAll("$", "");
                //Remove spaces
                purchasePrice = purchasePrice.replaceAll(" ", "");
                purchaseDp = purchaseDp.replaceAll(" ", "");
                loanAmount = loanAmount.replaceAll(" ", "");

                $('#purchase-price').text("$ " + formatNumbers(purchasePrice));
                $('#purchase-dp').text("$ " + formatNumbers(purchaseDp));
                $('#loan-amount').text("$ " + formatNumbers(loanAmount));
            @endif
            @if ($user->finance_type == 'Refinance')
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


                $('#mortage1').text("$ " + formatNumbers(mortgage1));
                $('#mortage2').text("$ " + formatNumbers(mortgage2));
                $('#value').text("$ " + formatNumbers(value));
            @endif
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
