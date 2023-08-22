@extends('layouts.app')
@section('content')
    <div class="mx-auto w-3/4 mt-24">
        <div class="">
            <h1 class="text-xl uppercase text-center">
                Upload (Multiple) Files
            </h1>
        </div>
        <form class="w-7/8" action="{{ url(getRoutePrefix() . '/upload-files') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="file" class="">Select File</label>
                </div>
                <div class="mt-2">
                    <input type="file" accept="image/*,.docx,.pdf" multiple
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="file[]" id="file" required>
                </div>
                @error('file')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <div class="col-span-4 ml-1 mt-3 ">
                <button type="submit"
                    class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection
