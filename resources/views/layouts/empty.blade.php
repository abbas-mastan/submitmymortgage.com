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
    <div class="body-first-div h-full flex justify-center items-center">
        @yield('content')
        @include('parts/footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    @yield('foot')
    <script>

        $(".phone").on('keyup', function() {
                var input = $(this).val();

                var phoneError = $('.phone_error');
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

        function showTooltip(flag) {
            switch (flag) {
                case 1:
                    document.getElementById("tooltip1").classList.remove("hidden");
                    break;
                case 2:
                    document.getElementById("tooltip2").classList.remove("hidden");
                    break;
                case 3:
                    document.getElementById("tooltip3").classList.remove("hidden");
                    break;
            }
        }

        function hideTooltip(flag) {
            switch (flag) {
                case 1:
                    document.getElementById("tooltip1").classList.add("hidden");
                    break;
                case 2:
                    document.getElementById("tooltip2").classList.add("hidden");
                    break;
                case 3:
                    document.getElementById("tooltip3").classList.add("hidden");
                    break;
            }
        }
    </script>
</body>

</html>
