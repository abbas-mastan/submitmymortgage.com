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
                        {{-- <div class="flex justify-center">
                            <form id="status-form" action="{{ url(getRoutePrefix().'/update-file-status/'.$file->id) }}" class="">
                                <select name="status" id="status" required class="p-0">
                                    <option value="">Change the status</option>
                                    <option {{ $file->status === 'Complete' ? 'selected' : '' }} value="Complete">Complete</option>
                                    <option {{ $file->status === 'Incomplete' ? 'selected' : '' }} value="Incomplete">Incomplete</option>
                                </select>
                            </form>
                        </div> --}}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
