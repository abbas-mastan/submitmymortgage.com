@extends('layouts.app')

@section('head')
    <style>
        #file {
            display: none;
        }
    </style>
@endsection

@section('content')
    @include('elems.upload-btn')
    <div class="flex flex-wrap flex-shrink-0">

        <table class="w-full">
            <caption class="text-center font-bold mb-3">Miscellaneous</caption>
            <thead class="bg-gray-300">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        S No.
                    </th>
                    <th class="">
                        File Title
                    </th>
                    <th class="">
                        Status
                    </th>
                    <th class="">
                        Comments
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td class=" pl-2 tracking-wide border border-l-0">{{ $loop->iteration }}</td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline">
                                {{ $file->file_name }}
                            </a>
                            <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline" download>
                                <img src="{{ asset('icons/download.svg') }}" alt="" class="w-6 h-8 ml-5 inline">
                            </a>
                        </td>
                        <td class="border">
                            {{ $file->status }}
                        </td>
                        <td class="border">
                            {{ $file->comments }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a data="Delete"  class="delete" title="Delete this file"
                                href="{{ url(getRoutePrefix() . '/delete-file/' . $file->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
@endsection
@section('foot')
    <script>
        var cat = 'Miscellaneous';
    </script>
    @include('parts.js.userfooter')
@endsection
