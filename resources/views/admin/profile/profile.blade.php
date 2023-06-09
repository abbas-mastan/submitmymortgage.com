@extends('layouts.app')

@section('head')
    <style>
        #file {
            /* display: none; */
        }
    </style>
@endsection

@section('content')
    <div class="w-1/2 mx-auto">
        <div class="flex justify-center items-center mt-4">
            <img class="w-40 h-40 rounded-full" src="{{ asset(auth()->user()->pic) }}" alt="Profile Picture">
        </div>
        <form action="{{ url(getRoutePrefix() . '/do-profile') }}" method="post" enctype="multipart/form-data">
            <div class="flex  justify-center mt-2">
                @csrf
                {{-- <input class=" xl:text-2xl rounded-md py-2 w-2/3 bg-gray-200" type="text" id="filename" disabled>
            <button type="button" class=" tracking-wide rounded-lg text-white px-7 py-2 text-lg capitalize bg-gradient-to-b from-gradientStart to-gradientEnd"
             id="file-upload-btn">
                                Browse..
                                </button>   --}}
                <input required type="file" name="file" id="file" accept="image/*">
            </div>
            <div class="flex justify-center mt-2">
                <button type="submit"
                    class="tracking-wide rounded-lg text-white px-7 py-2 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
                    Update
                </button>
            </div>
        </form>
        @if (Auth::user()->accessToken)
        <div class="flex justify-center mt-2">
            <a href="{{url(getRoutePrefix().'/disconnect-google')}}"
                class="tracking-wide rounded-lg text-white px-7 py-2 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
                Disconnect from Google
            </a>
        </div>
        @endif
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#file-upload-btn").on("click", function() {
                alert();
                $("#file").trigger("click");
            });
            $('input[type="file"]').change(function(e) {
                file = e.target.files[0];
                var fileName = e.target.files[0].name;
                $("#filename").text(fileName);
            });
        });
    </script>
@endsection
