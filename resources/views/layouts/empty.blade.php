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
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('css/app.min.css') }}" rel="stylesheet"/> --}}
    <script>
        var reConfig = {
            "siteUrl": '{{ url('/') }}',
            "csrfToken": '{{ csrf_token() }}',
            "username": ''
        };
    </script>
    @yield('head')
</head>

<body class="font-graphik" style="font-family: graphik, sans-serif !important">
    @isset($msg_error)
        <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <span class="font-medium">Error!</span>{{ $msg_error }}
        </div>
    @endisset
    <div class="body-first-div h-full 2xl:h-screen flex justify-center">
        @yield('content')
        @include('parts/footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('js/app.min.js') }}"></script> --}}
    @yield('foot')
</body>

</html>
