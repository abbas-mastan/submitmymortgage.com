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
        }

        #user-table_filter label {
            font-size: 0;
            /* Hide the text by setting font-size to 0 */
        }

        #user-table_filter {
            color: white;
        }

        .serachlabel {
            position: relative;
        }

        .svg {
            fill: white;
        }
    </style>
@endsection
@section('content')
    <x-flex-card title="Files Uploaded" titlecounts="{{ $filesCount }}" iconurl="{{ asset('icons/disk.svg') }}" />
    @component('components.modal-background', ['title' => 'Add Items to Share', 'width' => 'max-w-md'])
        <div class="firstTable">

            <table class="firstTable border border-1 border-gray-300 w-full">
                <thead class="border border-1 border-gray-300 bg-gradient-to-b from-gradientStart to-gradientEnd text-white">
                    <th class="py-3 border border-1 border-gray-300">Items</th>
                    <th class="py-3 border border-1 border-gray-300">Action</th>
                </thead>
                <tbody class="itemsToShare">
                    @php
                        $itemsToShare = ['Bank Statements', "ID/Driver's License", 'Fillable Loan Application'];
                    @endphp
                    @foreach ($itemsToShare as $item)
                        <tr @class(['items-center text-center', 'bg-gray-100' => $loop->odd])>
                            <td class="py-2 border border-1 border-gray-300">{{ $item }}</td>
                            <td class="py-2 flex justify-center text-center border border-1 border-gray-300">
                                <a href="{{ url(getAdminRoutePrefix() . '/remove-req-cat') . '/' . $item }}">
                                    <img class="bg-themered p-3" src="{{ asset('icons/trash.svg') }}" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="firstTableButtonsParent flex justify-between items-center mt-3">
                <button class="requestButton underline text-xl text-themered capitalize font-bold">Request Another Item</button>
                <button class="bg-red-700 text-white py-2 rounded-full px-5">Next</button>
            </div>
        </div>
        <div class="secondTable hidden">
            <table class="border border-1 border-gray-300 w-full">
                <thead class="border border-1 border-gray-300 bg-gradient-to-b from-gradientStart to-gradientEnd text-white">
                    <th class="py-1 px-8 border border-1 border-gray-300"></th>
                    <th class="py-1 border border-1 border-gray-300">Items</th>
                </thead>
                <tbody>
                    @php
                        $itemsToShare[] = 'Loan Application';
                        $filecategories = array_diff(config('smm.file_category'), $itemsToShare);
                    @endphp
                    @foreach ($filecategories as $category)
                        <tr @class(['items-center text-center', 'bg-gray-100' => $loop->odd])>
                            <td class="py-1.5 flex justify-center text-center border border-1 border-gray-300">
                                <input type="checkbox" value="{{ $category }}" name="category[]" id="{{ $category }}">
                            </td>
                            <td class="py-0.5 border border-1 border-gray-300">{{ $category }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="secondTableButtonsParent flex justify-between items-center mt-3">
                <button class="backButton bg-red-700 text-white py-2 rounded-full px-5">Back</button>
                <button class="nextButton bg-red-700 text-white py-2 rounded-full px-5">Next</button>
            </div>
        </div>
    @endcomponent
    <div class="">
        @include('elems.upload-btn')
        <div class="flex justify-between">
            <div class="flex align-center">
                <Button class="newProject bg-red-800 px-5 py-2 text-white flex">
                    <img class="w-7 mr-2" src="{{ asset('icons/share.png') }}" alt="">
                    <span class="pt-1">
                        Share Upload Link
                    </span>
                </Button>
            </div>
            <div>
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
            </div>
            <div class="inline-block">
                <div class="relative dropdownButton">
                    <button class=" bg-red-800 px-5 py-2 text-white flex" id="menu-button" aria-expanded="true"
                        aria-haspopup="true">Move To
                        <svg class="ml-2 w-4 mt-1" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 185.344 185.344" xml:space="preserve">
                            <g>
                                <g>
                                    <path style="fill:#ffffff;"
                                        d="M92.672,144.373c-2.752,0-5.493-1.044-7.593-3.138L3.145,59.301c-4.194-4.199-4.194-10.992,0-15.18
                                                                                                                                                                            c4.194-4.199,10.987-4.199,15.18,0l74.347,74.341l74.347-74.341c4.194-4.199,10.987-4.199,15.18,0
                                                                                                                                                                            c4.194,4.194,4.194,10.981,0,15.18l-81.939,81.934C98.166,143.329,95.419,144.373,92.672,144.373z" />
                                </g>
                            </g>
                        </svg>
                    </button>
                    <div class="dropdownMenu hidden absolute right-0 ring-1 ring-blue-700 z-10 mt-1 shadow w-full bg-white">
                        <div class="py-1">
                            @php
                                $application = \App\Models\Project::where('borrower_id', $user->id)->first();
                            @endphp
                            <a href="{{ url(getRoutePrefix() . '/project/disable/' . $application->id) }}"
                                class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                id="menu-item-0">Disable Deal</a>
                            <a href="{{ url(getRoutePrefix() . '/project/close/' . $application->id) }}"
                                class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                id="menu-item-1">Close Deal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.file.info-table')
    </div>
    <div class="">
        @include('admin.file.category-wise-files-table')
    </div>
    <div class="">
        <div class="flex justify-between mb-5">
            <div class="relative categoryContainer">
                <button class="categoryButton bg-red-800 px-5 py-1 text-white flex newProject">Sort By</button>
                <div class="categoryMenu hidden absolute right-0 ring-1 ring-blue-700 z-10 mt-1 shadow w-full bg-white">
                    <div class="py-1">
                        <a href="{{ url(getRoutePrefix() . '/sortby/' . $user->id . '/category') }}"
                            @class([
                                'text-gray-700 block px-4 py-2 text-sm',
                                isset($sortby) && $sortby === 'category' ? 'bg-red-800 text-white' : '',
                            ]) role="menuitem" tabindex="-1" id="menu-item-0">Category</a>
                        <a href="{{ url(getRoutePrefix() . '/sortby/' . $user->id . '/latest') }}"
                            @class([
                                'text-gray-700 block px-4 py-2 text-sm',
                                isset($sortby) && $sortby === 'latest' ? 'bg-red-800 text-white' : '',
                            ]) role="menuitem" tabindex="-1" id="menu-item-1">Files</a>
                    </div>
                </div>
            </div>
            <label class="serachlabel flex justify-end" for="" class="">
                <input type="text" id="myInput" placeholder="search"
                    class="serachinput bg-red-800 px-5 py-1 ring-0  text-white flex">
                <img class="absolute z-10 top-1/4 mr-2" width="20" src="{{ asset('icons/search.svg') }}"
                    alt="">
            </label>
        </div>
        @foreach ($categories as $category)
            @if (fileCatCount($category, $user->id) > 0 && $category !== 'Credit Report')
                <div class="searchablediv">
                    @component('components.accordion', [
                        'title' => $category,
                        'color' => 'bg-red-800',
                        'count' => fileCatCount($category, $user->id),
                    ])
                        @foreach ($files as $file)
                            @if ($file->category === $category)
                                <div class="searchablediv">
                                    <div @class([
                                        'mb-5 flex justify-evenly items-center',
                                        'bg-gray-200' => $loop->odd,
                                    ])>
                                        <div class="text-center" width="30%">
                                            <div class="font-bold mb-2">File Name</div>
                                            <div class="font-bold mb-2">Category</div>
                                            <div class="font-bold mb-2">Upload Date</div>
                                            <div class="font-bold mb-2">Uploaded By</div>
                                            <div class="font-bold mb-2">User ID</div>
                                        </div>
                                        <div width="30%">
                                            <!-- File Name -->
                                            <div class="mb-2">
                                                <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline">
                                                    {{ $file->file_name }}
                                                </a>
                                            </div>
                                            <!-- Category -->
                                            <div class="mb-2 px-3 py-1 bg-yellow-500 w-fit rounded-2xl">
                                                <a href="{{ url(getRoutePrefix() . '/docs/' . $user->id . '/' . str_replace('/', '-', $file->category)) }}"
                                                    class="hover:text-blue-700">
                                                    {{ $file->category }}
                                                </a>
                                            </div>
                                            <!-- Upload Date -->
                                            <div class="mb-2"> {{ convertDBDateUSFormat($file->created_at) }}</div>
                                            <!-- Uploaded By -->
                                            <div class="mb-2">{{ $file->uploadedBy ? $file->uploadedBy->name : '' }}
                                            </div>
                                            <!-- User ID -->
                                            <div class="mb-2">{{ $file->uploadedBy ? $file->uploadedBy->email : '' }}
                                            </div>
                                        </div>
                                        <div width="30%">
                                            <!-- Sent By Client -->
                                            <div class="flex space-x-4">
                                                <label for="status-verified{{ $file->id }}" class="font-bold">Sent By
                                                    Client</label>
                                                <input type="checkbox"
                                                    {{ $file->uploaded_by === $file->user_id ? 'checked' : '' }}
                                                    class="mt-0.5">
                                            </div>
                                            <!-- Status and Comments -->
                                            <div class="">
                                                <form id="status-form"
                                                    action="{{ url(getRoutePrefix() . '/update-file-status/' . $file->id) }}"
                                                    class="">
                                                    @csrf
                                                    <div class="font-bold">Status</div>
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
                                                    <div class="font-bold">Comments</div>
                                                    <div class="w-full">
                                                        <div class="flex space-x-2">
                                                            <textarea class="rounded comments" name="comments" id="" cols="30" rows="1">{{ $file->comments }}</textarea>
                                                        </div>
                                                        <div class="my-0.5">
                                                            <button title="Update status of this file" type="submit"
                                                                class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                                                                Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="flex align-center">
                                            <a class="delete" data="Delete" title="Delete this file"
                                                href="{{ url(getRoutePrefix() . '/delete-file/' . $file->id) }}">
                                                <button class="bg-themered tracking-wide font-semibold capitalize text-xl">
                                                    <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                        class="p-1 w-7">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endcomponent
                </div>
            @endif
        @endforeach
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
        $('.requestButton ,.backButton').click(function(e) {
            e.preventDefault();
            $('.firstTable, .secondTable,.requestButton').toggleClass('hidden');
        });


        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').toggleClass('hidden');
        });

        $('.nextButton').click(function(e) {
            e.preventDefault();
            if ($('.firstTable').hasClass('hidden')) {
                $('.firstTable').removeClass('hidden');
                $('.secondTable').addClass('hidden');
                $('.requestButton').removeClass('hidden');
            } else {
                alert('no class')
            }
        });

        $('.secondTable input[type="checkbox"]').change(function() {
            if ($('.secondTable input[type="checkbox"]:checked').length > 0) {
                $('.backButton').addClass('hidden');
                $('.secondTableButtonsParent').removeClass('justify-between');
                $('.secondTableButtonsParent').addClass('justify-end');
            } else {
                $('.backButton').removeClass('hidden');
                $('.secondTableButtonsParent').removeClass('justify-end');
                $('.secondTableButtonsParent').addClass('justify-between');
            }
        });

        $('.secondTable input[type="checkbox"]').change(function(e) {
            e.preventDefault();
            var checkboxValue = $(this).val();
            if ($(this).prop('checked')) {
                if ($('.itemsToShare').length > 0) {
                    var newRow = `<tr class="items-center text-center bg-gray-100">
                <td class="py-2 border border-1 border-gray-300">${checkboxValue}</td>
                <td class="py-2 flex justify-center text-center border border-1 border-gray-300">
                    <a href="{{ getAdminRoutePrefix() }}/remove-req-cat/${checkboxValue}">
                        <img class="bg-themered p-3" src="{{ asset('icons/trash.svg') }}">
                    </a>
                </td>
            </tr>`;
                    $('.itemsToShare').append(newRow);
                }
            } else {
                $('.itemsToShare td:contains(' + checkboxValue + ')').closest('tr').remove();
            }
        });





        $(document).ready(function() {
            $("input[type=search]").css("background", "#991b1b");
            $("input[type=search]").attr("placeholder", "search");
            $("input[type=search]").addClass('serachinput');
            $("input[type=search]").addClass('bg-red-800');
            $('#user-table').removeClass("no-footer dataTable");
        });
        $(document).on("click", function(e) {
            if (!$(e.target).closest(".categoryContainer").length) {
                // Clicked outside of the .categoryContainer
                $('.categoryMenu').addClass('hidden');
            }
        });

        $(".categoryButton").click(function(e) {
            e.stopPropagation(); // Prevent the document click event from firing
            $('.categoryMenu').toggleClass('hidden'); // Toggle visibility
        });



        $(document).on("click", function(e) {
            if (!$(e.target).closest(".dropdownContainer").length) {
                // Clicked outside of the .dropdownContainer
                $('.dropdownMenu').addClass('hidden');
            }
        });

        $(".dropdownButton").click(function(e) {
            e.stopPropagation(); // Prevent the document click event from firing
            $('.dropdownMenu').toggleClass('hidden'); // Toggle visibility
        });

        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".searchablediv").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
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
