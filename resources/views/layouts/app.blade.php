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
            .vertical-line-m
            {
                margin-left: 2.68rem;
            }
        </style>
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
        {{-- <link href="{{ asset('css/app.min.css') }}" rel="stylesheet"/> --}}
        <script>
            var reConfig = {
                "siteUrl":'{{url("/")}}',
                "csrfToken":'{{csrf_token()}}',
                "debug":'true'
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

    </body>
</html>