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
                <div class="text-left mr-12">
                    <label for="file" class="">Select File</label>
                </div>
                <div class="mt-2">
                    <span id="LicensefilesList">
                        <span id="license-files-names"></span>
                    </span>
                    <input type="file" name="files[]" id="license"
                        class="block my-8 w-full focus:outline-none"
                        multiple accept="image/*,.docx,.pdf">
                        {{-- <label for="license" class="flex mt-5 rounded bg-gray-400 text-white px-5 py-3 w-full">Browse Files</label> --}}

                </div>
                @error('files')
                    <span class="text-red-700">{{ $message }}</span>
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

    <table class="w-full mt-10" id="files-table">
        <thead class="bg-gray-300">
            <tr>
                <th class=" pl-2 tracking-wide">
                    S No.
                </th>
                <th class="">
                    File Title
                </th>
                <th class="">
                    Upload Date
                </th>
                <th class="">
                    Uploaded by
                </th>
                <th class="">
                    User ID
                </th>
                <th class="">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->attachments as $file)
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
                    <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                        {{ convertDBDateUSFormat($file->created_at) }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                        {{ $file->user->name }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        {{ $file->user->email }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-r-0">
                        <div class="flex justify-center">
                            <a class="delete" data="Delete" title="Delete this file"
                                href="{{ url(getRoutePrefix() . '/delete-attachment/' . $file->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            // Function to handle file inputs
            function handleFileInput(inputId, filesListId, filesNamesId) {
                const dt = new DataTransfer();
                $(inputId).on('change', function(e) {
                    for (var i = 0; i < this.files.length; i++) {
                        let fileBloc = $('<span/>', {
                                class: 'file-block'
                            }),
                            fileName = $('<span/>', {
                                class: 'name badge',
                                text: this.files.item(i).name
                            });
                        fileBloc.append('<span class="close file-delete"><span class="hover:text-red-700">x</span></span>')
                            .append(fileName);
                        $(filesListId).find(filesNamesId).append(fileBloc);
                    };
                    for (let file of this.files) {
                        dt.items.add(file);
                    }
                    this.files = dt.files;
                    $('span.file-delete').click(function() {
                        let name = $(this).next('span.name').text();
                        $(this).parent().remove();
                        for (let i = 0; i < dt.items.length; i++) {
                            if (name === dt.items[i].getAsFile().name) {
                                dt.items.remove(i);
                                continue;
                            }
                        }
                        $(inputId).get(0).files = dt.files;
                    });
                });
            }
            handleFileInput("#license", "#LicensefilesList", "#license-files-names");
        });
    </script>

    <style>
        .badge {
            margin-right: 5px;
            display: inline-block;
            padding: 2px 12px;
            background-color: #9ca3af;
            color: #fff;
            border-radius: 0 8px 8px 0;
        }

        .close {
            padding: 6px 0 6px 8px;
            border-radius: 8px 0 0 8px;
            color: #f0f0f0;
            background: #9ca3af;
            border: none;
            cursor: pointer;
        }
    </style>
@endsection
