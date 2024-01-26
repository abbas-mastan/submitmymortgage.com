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
                        @include('parts.alerts')
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- tooltip logic starts here --}}
    <script>
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
            function getPopupText(text) {
                if (text == 'Accept') return 'Accepted!';
                if (text == 'Reject') return 'Rejected!';
                if (text == 'Restore') return 'Restored!';
                if (text == 'Hide') return 'Hidden!';
                if (text == 'Enable') return 'Enabled!';
                if (text == 'Disable') return 'Disabled!';
                if (text == 'Unhide') return 'Showed!';
                else return 'Deleted!'
            }
            var textClass = $(this).attr('data');
            if (textClass) {
                var titleText = 'Are you sure to ' + textClass.toLowerCase() + ' it?';
            }

            if (textClass == 'Reject' || textClass == 'Accept' || textClass == 'Hide' || textClass == 'Unhide' ||
                textClass == 'Disable' || textClass == 'Enable' ||
                textClass == 'Restore') {
                middleSentenceOfModal = null;
            } else {
                if (textClass == 'temporary') {
                    middleSentenceOfModal =
                        'This is not a permanent delete. You can restore it from deleted users anytime';
                    titleText = 'Are you sure to delete this user?';
                    textClass = "Delete";
                } else {
                    textClass = "Delete";
                    middleSentenceOfModal = "You won't be able to revert this!"
                }
            }
            e.preventDefault();
            Swal.fire({
                title: titleText,
                text: middleSentenceOfModal,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: textClass,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = $(this).attr('href');
                    Swal.fire(
                        getPopupText(textClass),
                        'Your' + (textClass == 'Disable' || textClass == 'Enable' ? ' team ' :
                            ' file ') +
                        ' has been ' + getPopupText(textClass) + ' .',
                        'success'
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
