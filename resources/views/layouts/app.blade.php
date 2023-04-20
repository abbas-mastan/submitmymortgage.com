<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        .page-item.pageNumbers{
            display: none;
        }
        nav{
            margin-top: 20px;
            text-align: center;

        }
    </style>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('css/app.min.css') }}" rel="stylesheet"/> --}}
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
    <div class="min-h-screen flex flex-col flex-grow ">

        <div class="w-full md:h-full flex flex-col sm:flex-row flex-wrap sm:flex-nowrap flex-grow">

            @include('parts/sidebar')
            <main role="main" class="w-full bg-themebackground">
                <div class="w-full">
                    @include('parts/navbar')
                </div>
                <div class="w-full flex px-5  md:px-24">
                    <div class="w-full">
                        @include('parts/alerts')
                        @yield('content')
                    </div>

                    {{-- @include('parts/widgetbar') --}}
                </div>

            </main>

        </div>

        @include('parts/footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    {{-- <script src="{{ asset('js/app.min.js') }}"></script> --}}

    @yield('foot')
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
</body>

</html>
