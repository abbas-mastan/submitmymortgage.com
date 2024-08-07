<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>Submit My Mortgage @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <style>
        @font-face {
            font-family: graphik;
            src: url('{{ asset('fonts/GraphikRegular.otf') }}');
        }

        .vertical-line-m {
            margin-left: 2.68rem;
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

        .swal2-show {
            left: 100px;
        }

        .textcolor {
            color: #963437;
        }

        #attachment-table_length,
        #attachment-table_info {
            display: none;
        }

        #attachment-table_filter label {
            font-size: 0;
        }

        #attachment-table_filter {
            color: white;
        }

        #attachment-table_filter {
            margin-left: auto;
        }

        #attachment-table_wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .serachinput::-webkit-input-placeholder {
            color: white;
        }

        #attachment-table_filter input[type="search"] {
            background-color: #963437;
            color: white;
            /* Replace "your-color" with the desired color value */
        }

        #attachment-table_paginate .paginate_button {
            padding: 5px !important;
            margin: 0 6px;
        }

        #attachment-table_paginate .paginate_button:hover {
            background: none;
            color: black !important;
            border-radius: 4px;
            border: 1px solid #828282;
        }

        #attachment-table_paginate .paginate_button.current {
            background: #4676e5 !important;
            color: white !important;
        }

        .profile-dropdown-btn {}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <script>
        var reConfig = {
            "siteUrl": '{{ url('/') }}',
            "csrfToken": '{{ csrf_token() }}',
            "debug": 'true'
        };
    </script>
    @yield('head')
</head>

<body class="font-graphik" style="font-family: graphik, sans-serif !important">
    @include('user.file-upload.upload-modal')
    @include('user.file-upload.category-modal')
    <div class="min-h-screen flex flex-col flex-grow ">
        <div class="w-full flex flex-col sm:flex-row flex-wrap sm:flex-nowrap flex-grow">
            @include('parts.sidebar')
            <main role="main" class="pb-20 bg-themebackground sm:w-full">
                <div class="w-full">
                    @include('parts.navbar')
                </div>
                <div class="flex px-5" style="padding-right:80px;padding-left:80px">
                    <div class="w-full">
                        @if (\Request::route()->getName() !== 'profile')
                            @include('parts.alerts')
                        @endif
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
        @include('parts.footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        window.returnBack = "{{ url(getRoutePrefix() . '/redirect/back/file-uploaded-successfully') }}";
    </script>
    @yield('foot')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('.deals, .initialized').hover(function() {
            $('.initialized').removeClass('hidden');
            $('.line').removeClass('sm:block');
        }, function() {
            $('.initialized').addClass('hidden');
            $('.line').addClass('sm:block');
        });

        $('.initialized').hover(function() {
            $('.initialized').removeClass('hidden');
            $('.line').removeClass('sm:block');
        }, function() {
            $('.initialized').addClass('hidden');
            $('.line').addClass('sm:block');
        });

        $('.modalsort').click(function(e) {
            e.preventDefault();
            $('.uploadModalDropdown').toggleClass('hidden');

        });
        $(document).on("click", function(e) {
            if (!$(e.target).closest(".modalsort").length) {
                // Clicked outside of the .categoryContainer
                $('.uploadModalDropdown').addClass('hidden');
            }
        });

        // Initialize the DataTable
        var otable = $('#attachment-table').dataTable({
            iVote: -1, //field name 
            "bRetrieve": true,
            "sPaginationType": "full_numbers",
            language: {
                'paginate': {
                    'previous': '<span class="prev-icon">&lt;&lt;</span>',
                    'next': '<span class="next-icon">&gt;&gt;</span>'
                }
            }
        });

        otable.fnSort([
            [2, 'desc']
        ]);
        $('.latest').addClass('bg-red-800 text-white w-full');
        $('.latest').click(function() {
            $('.latest').addClass('bg-red-800 text-white w-full');
            $('.filetype').removeClass('bg-red-800 text-white');
            otable.fnSort([
                [2, 'desc']
            ]);
        });

        // Add event listener for the File Type button
        $('.filetype').click(function() {
            $('.latest').removeClass('bg-red-800 text-white');
            $('.filetype').addClass('bg-red-800 text-white w-full');
            otable.fnSort([
                [1, 'asc']
            ]); // Sort by second column descending
        });




        $('.sorting').addClass('hidden');
        $('.dataTables_wrapper .dataTables_paginate .paginate_button.current').attr('style', 'color:white !important')
        $(document).on('click', '.paginate_button', function(e) {
            e.preventDefault();
            $('.dataTables_wrapper .dataTables_paginate .paginate_button.current').attr('style',
                'color:white !important')
        });
        $(document).ready(function() {
            $("#attachment-table_filter").attr("placeholder", "search");
            $("#attachment-table_filter > input").addClass('bg-red-800');
            // $("input[type=search]").addClass('serachinput');
            $("input[type=search]").attr("placeholder", "search");
            $("#attachment-table_filter > input").addClass('border-none text-white');
        });
    </script>
    <script>
        @if (request()->route()->getName() != 'all-user')
            ['user', 'completed', 'incomplete', 'deleted'].map((table) => {
                new DataTable("#" + table + "-table", {
                    "ordering": false,
                });
                $(`select[name="${table}-table_length"]`).addClass('w-16');
                $(`select[name="${table}-table_length"]`).addClass('mb-3');
            });
        @endif
    </script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- tooltip logic starts here --}}
    <script>
        $(document).ready(function() {
            $("#phone ,#b_phone ,#co_phone,.phone").on('keyup', function() {
                var input = $(this).val();
                var phoneError = $("#"+$(this).attr('name')+'_error');
                // Remove non-numeric characters except the leading +1
                input = input.replace(/[^\d]/g, '');
                if (input.startsWith('1')) {
                    input = '+' + input;
                } else {
                    input = '+1' + input;
                }
                // Format the number as +1 (xxx) xxx-xxxx
                if (input.length > 10) {
                    input = input.replace(/^(\+1)(\d{3})(\d{3})(\d{4}).*/, '$1 ($2) $3-$4');
                } else if (input.length > 6) {
                    input = input.replace(/^(\+1)(\d{3})(\d{3})/, '$1 ($2) $3');
                } else if (input.length > 3) {
                    input = input.replace(/^(\+1)(\d{3})/, '$1 ($2)');
                }

                // Update the input value
                $(this).val(input);

                // Validate length
                if (input.length > 17) {
                    phoneError.text('characters exceeds');
                    phoneError.css('display', 'block');
                } else if (input.length < 17) {
                    phoneError.text('incomplete number');
                    phoneError.css('display', 'block');
                } else {
                    phoneError.hide();
                    phoneError.css('display', 'none');
                }
            });


            $('.input_number').on('keyup',function(event) {
                if (event.which >= 37 && event.which <= 40) return;
                $(this).val(function(index, value) {
                    return value
                        // Keep only digits and decimal points:
                        .replace(/[^\d.]/g, "")
                        // Remove duplicated decimal point, if one exists:
                        .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                        // Keep only two digits past the decimal point:
                        .replace(/\.(\d{2})\d+/, '.$1')
                        // Add thousands separators:
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                });
            });
        });

        $(".tooltip").on('mouseenter', function() {
            var tooltipText = $(this).attr('data');

            if (tooltipText == 'Unhide') {
                var unhideCss = "mt-5 w-full ";
            } else {
                var unhideCss = "w-auto";
            }

            $(this).append(`<div role="tooltip" class="${unhideCss} mt-5 w-full mt-2 -ml-16 absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                ${tooltipText} this category
                <div class="tooltip-arrow" data-popper-arrow></div></div>`);
        }).on('mouseleave', function() {
            $(this).find('div[role="tooltip"]').remove();
        });

        $(document).on("click", '.delete', function(e) {
            e.preventDefault();

            function getPopupText(text) {
                if (text == 'Accept') return 'Accepted!';
                if (text == 'Reject') return 'Rejected!';
                if (text == 'Restore') return 'Restored!';
                if (text == 'Hide') return 'Hidden!';
                if (text == 'Enable') return 'Enabled!';
                if (text == 'Disable') return 'Disabled!';
                if (text == 'Unhide') return 'Showed!';
                if (text == 'cancel') return 'Canceled!';
                if (text == 'Logout All') return 'Logged out!';
                else return 'Deleted!'
            }

            function getSuccessMsg(textClass) {
                if (textClass === 'cancel') {
                    return {
                        title: "Cancelled!",
                        text: "Your subscription has been cancelled.",
                        icon: "success"
                    }
                } else {
                    return {
                        title: getPopupText(textClass),
                        text: 'Your' + (textClass == 'Disable' || textClass == 'Enable' ? ' team ' :
                                ' file ') +
                            ' has been ' + getPopupText(textClass) + ' .',
                        icon: 'success'
                    }
                }
            }

            var textClass = $(this).attr('data');
            if (textClass) {
                if (textClass == 'Logout All') {
                    var titleText = 'Are you sure to Logout all users?';
                } else {
                    var titleText = 'Are you sure to ' + textClass.toLowerCase() + ' it?';
                }
            }

            if (textClass == 'Reject' || textClass == 'Accept' || textClass == 'Hide' || textClass == 'Unhide' ||
                textClass == 'Disable' || textClass == 'Enable' || textClass == 'Logout All' ||
                textClass == 'Restore') {
                middleSentenceOfModal = null;
            } else {
                if (textClass == 'temporary') {
                    middleSentenceOfModal =
                        'This is not a permanent delete. You can restore it from deleted users anytime';
                    titleText = 'Are you sure to delete this user?';
                    textClass = "Delete";
                } else if (textClass == 'cancel') {
                    middleSentenceOfModal = null;
                    titleText = 'Are you sure to cancel your subscription?';
                } else {
                    textClass = "Delete";
                    middleSentenceOfModal = "You won't be able to revert this!"
                }
            }
            Swal.fire({
                title: titleText,
                text: middleSentenceOfModal,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: textClass == 'cancel' ? 'No' : 'Cancel',
                confirmButtonText: textClass == 'cancel' ? 'Yes' : textClass,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = $(this).attr('href');
                    Swal.fire(
                        getSuccessMsg(textClass)
                    )
                }
            })
        });
    </script>
    {{-- tooltip logic end here --}}

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
    <script>
        $('.addCategoryBtn').click(function(e) {
            e.preventDefault();
            $('#categoryModal').toggleClass('hidden');
        });
    </script>
    <script>
        $("#AddCategory").click(function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let url = "{{ getRoutePrefix() . '/add-category/' }}" + id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: $("input[name='name']"),
                success: function(response) {
                    console.log(response);
                    if (response.error)
                        $("input[name='name']").next("span").text(response.error);
                    if (response.success) {
                        alert('Category Added');
                        location.reload();
                    }
                }
            });
        });


        $(document).on('mouseenter', '.loginBtn', function() {
            if ($(this).attr('data') == 'restore') {
                var data = $(this).attr('data');
            }
            if ($(this).attr('data') == 'Permanent Delete') {
                var data = $(this).attr('data');
            }
            $(this).append(
                `<div role="tooltip" class="w-40 mt-2 -ml-16 absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        ${!data ? 'Login As This User': data+' this user'}
                        <div class="tooltip-arrow" data-popper-arrow></div></div>`
            );
        }).on('mouseleave', '.loginBtn', function() {
            $(this).find('div[role="tooltip"]').remove();
        });
    </script>
</body>

</html>
