<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @yield('meta')
        <title>Submit My Mortgage @yield('title')</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
        <style>
            
            @font-face{
                font-family: graphik;
                src: url('{{ asset('fonts/GraphikRegular.otf') }}');
            }
            
        </style>
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
        {{-- <link href="{{ asset('css/app.min.css') }}" rel="stylesheet"/> --}}
        <script>
            var reConfig = {
                "siteUrl":'{{url("/")}}',
                "csrfToken":'{{csrf_token()}}',
                "username":''
            };
         </script>
         
        @yield('head')
    </head>
    <body class="font-graphik" style="font-family: graphik, sans-serif !important">
        <div class="h-full 2xl:h-screen flex justify-center bg-gradient-to-b from-gradientStart to-gradientEnd">
            
            @yield('content')
            @include('parts/footer')
        </div>
        
        <script src="{{ asset('js/app.js') }}"></script>
        {{-- <script src="{{ asset('js/app.min.js') }}"></script> --}}

        @yield('foot')

    </body>
</html>