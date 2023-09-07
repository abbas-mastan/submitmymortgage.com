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

        .page-item.pageNumbers {
            display: none;
        }

        nav {
            margin-top: 20px;
            text-align: center;

        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        #user-table_length,
        #user-table_paginate,
        #user-table_info {
            display: none;
        }

        .serachinput::-webkit-input-placeholder {
            color: white;
        }

        .serachinput {
            border-radius: 0px !important;
            padding: 5px 3px;
            background-image: url({{ asset('icons/bell.svg') }});
            background-repeat: no-repeat;
            display: flex;
            justify-content: end;
        }

        #user-table_filter label {
            font-size: 0;
            /* Hide the text by setting font-size to 0 */
        }

        #user-table_filter {
            color: white;
        }
    </style>
@endsection
@section('content')
    @include('admin.file.cards')
    <div class="">
        @include('elems.upload-btn')
        @isset($user)
            @php
                $name = explode(' ', $user->name);
                $rearrangedName = count($name) > 1 ? $name[1] . ', ' . $name[0] : $user->name;
            @endphp
            <h2 class="text-center text-2xl -mt-3.5 mb-5 text-red-700">
                {{ $rearrangedName }}
            </h2>
            @isset($info)
                <h3 class="text-center text-xl -mt-3.5 mb-5 text-red-700">
                    {{ $info->b_address . $info->b_city . ', ' . $info->b_state }}
                </h3>
            @endisset
        @endisset
        @include('admin.file.info-table')
    </div>
    <div class="">
        @include('admin.file.category-wise-files-table')
    </div>
    <div class="">
        <label for="category">Sort By:</label>
        <div class="absolute z-10">
            <button class="bg-red-800 px-5 py-1  text-white flex newProject">Category</button>
        </div>

        {{-- @include('admin.file.cat-table') --}}
        <table class="w-full mt-3" id="user-table">
            <thead class="hidden">
                <th>sno</th>
            </thead>
            <tbody>
                <tr>
                    <td class=" pl-2 tracking-wide border  border-l-0 border-r-0">
                        @foreach ($files as $file)
                            @if ($file->category === 'Credit Report')
                                @continue
                            @endif
                            @php
                                $categories = config('smm.file_category');
                            @endphp
                            @foreach ($categories as $category)
                                @if ($category === $file->category)
                                    @component('components.accordion', ['title' => $category, 'color' => 'bg-red-800'])
                                        <table class="w-full" id="table-{{ $file->id }}">
                                            <tr class="">
                                                <th class="" width="30%">
                                                    File Name
                                                </th>
                                                <td class="" width="30%">
                                                    <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline">
                                                        {{ $file->file_name }}
                                                    </a>
                                                </td>
                                                <td class="" width="30%" rowspan="6">
                                                    <div class="flex space-x-4">
                                                        <label for="status-verified{{ $file->id }}" class="font-bold">Sent
                                                            By
                                                            Client</label>
                                                        <input type="checkbox"
                                                            {{ $file->uploaded_by === $file->user_id ? 'checked' : '' }}
                                                            class="mt-0.5">
                                                    </div>
                                                    <form id="status-form"
                                                        action="{{ url(getRoutePrefix() . '/update-file-status/' . $file->id) }}"
                                                        class="">
                                                        @csrf
                                                        <div class="font-bold">
                                                            Status
                                                        </div>
                                                        <div class="">
                                                            <div class="flex space-x-2">
                                                                <input {{ $file->status === 'Verified' ? 'checked' : '' }}
                                                                    type="radio" id="status-verified{{ $file->id }}"
                                                                    name="status" class="" value="Verified">
                                                                <label for="status-verified{{ $file->id }}"
                                                                    class="">Verified</label>
                                                            </div>
                                                            <div class="flex space-x-2">
                                                                <input
                                                                    {{ $file->status === 'Not Verified' || $file->status === null ? 'checked' : '' }}
                                                                    type="radio" id="status-notverified{{ $file->id }}"
                                                                    name="status" class="" value="Not Verified">
                                                                <label for="status-notverified{{ $file->id }}"
                                                                    class="">Not
                                                                    Verified</label>
                                                            </div>
                                                        </div>
                                                        <div class="font-bold">
                                                            Comments
                                                        </div>
                                                        <div class="w-full">
                                                            <div class="flex space-x-2">
                                                                <textarea class="rounded comments" name="comments" id="" cols="30" rows="1">{{ $file->comments }}</textarea>
                                                            </div>
                                                            <div class=" my-0.5">
                                                                <button title="Update status of this file" type="submit"
                                                                    class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                                                                    Update
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-right" width="10%" rowspan="6">
                                                    <a class="delete" data="Delete" title="Delete this file"
                                                        href="{{ url(getRoutePrefix() . '/delete-file/' . $file->id) }}">
                                                        <button
                                                            class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                                            <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                                class="p-1 w-7">
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <th class="">
                                                    Category
                                                </th>
                                                <td class="">
                                                    <div class="px-3 py-1 bg-yellow-500 w-fit rounded-2xl">
                                                        <a href="{{ url(getRoutePrefix() . '/docs/' . $user->id . '/' . str_replace('/', '-', $file->category)) }}"
                                                            class="hover:text-blue-700">
                                                            {{ $file->category }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <th class="">
                                                    Upload Date
                                                </th>
                                                <td class="">
                                                    {{ convertDBDateUSFormat($file->created_at) }}
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <th class="">
                                                    Uploaded by
                                                </th>
                                                <td class="">
                                                    {{ $file->uploadedBy ? $file->uploadedBy->name : '' }}
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <th class="">
                                                    User ID
                                                </th>
                                                <td class="">
                                                    {{-- {{ $file->user->email }} --}}
                                                    {{ $file->uploadedBy ? $file->uploadedBy->email : '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    @endcomponent
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>

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
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            // $("input[type=search]").css("background", "#991b1b");
            $("input[type=search]").attr("placeholder", "search");
            $("input[type=search]").addClass('serachinput');
            $("input[type=search]").addClass('bg-red-800');
            $('#user-table').removeClass("no-footer");

            // $("#user-table_filter").append("<img src="{{ asset('icons/search.svg') }}" />");
        });

        (function() {
            let textarea = document.querySelectorAll(".comments");
            for (let i = 0; i < textarea.length; i++) {
                textarea[i].addEventListener("click", () => {
                    textarea[i].setAttribute("rows", 5);
                });
                textarea[i].addEventListener("focusin", () => {
                    textarea[i].setAttribute("rows", 5);
                });
                textarea[i].addEventListener("focusout", () => {
                    textarea[i].setAttribute("rows", 1);
                });
            }
        })();
    </script>
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
