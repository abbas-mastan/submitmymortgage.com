@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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

        .page-item.pageNumbers {
            display: none;
        }

        nav {
            margin-top: 20px;
            text-align: center;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        #user-table_length,
        #user-table_paginate,
        #user-table_info {
            display: none;
        }

        .serachinput::-webkit-input-placeholder {
            color: white;
        }

        .serachinput {
            border-radius: 0px !important;
        }

        #user-table_filter label {
            font-size: 0;
            /* Hide the text by setting font-size to 0 */
        }

        #user-table_filter {
            color: white;
        }

        .serachlabel {
            position: relative;
        }

        .svg {
            fill: white;
        }

        .icon {
            filter: invert(1);
        }
    </style>
@endsection
@section('content')
<div class="alertbox hidden mt-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <span class="block sm:inline alerttextbox"></span>
    <span class="closealertbox absolute top-0 bottom-0 right-0 px-4 py-3">
      <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
    </span>
  </div>
    <x-flex-card title="Files Uploaded" titlecounts="{{ $filesCount }}" iconurl="{{ asset('icons/disk.svg') }}" />
    @component('components.modal-background', ['title' => 'Add Items to Share', 'width' => 'max-w-md'])
        <div class="firstTable">
            <table class="firstTable border border-1 border-gray-300 w-full">
                <thead class="border border-1 border-gray-300 bg-gradient-to-b from-gradientStart to-gradientEnd text-white">
                    <th class="py-3 border border-1 border-gray-300">Items</th>
                    <th class="py-3 border border-1 border-gray-300">Action</th>
                </thead>
                <tbody class="itemsToShare">
                    @php
                        $itemsToShare = ['Bank Statements', "ID/Driver's License", 'Fillable Loan Application'];
                    @endphp
                    @foreach ($itemsToShare as $item)
                        <tr @class([
                            'deleteItemTr items-center text-center',
                            'bg-gray-100' => $loop->odd,
                        ])>
                            <td class="py-2 border border-1 border-gray-300">{{ $item }}</td>
                            <td class="py-2 flex justify-center text-center border border-1 border-gray-300">
                                <a class="deleteItem">
                                    <img class="bg-themered p-3" src="{{ asset('icons/trash.svg') }}" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="firstTableButtonsParent flex justify-between items-center mt-3">
                <button class="requestButton underline text-xl text-themered capitalize font-bold">Request Another Item</button>
                <button class="nextButton bg-red-700 text-white py-2 rounded-full px-5">Next</button>
            </div>
        </div>
        <div class="secondTable hidden">
            <table class="border border-1 border-gray-300 w-full">
                <thead class="border border-1 border-gray-300 bg-gradient-to-b from-gradientStart to-gradientEnd text-white">
                    <th class="py-1 px-8 border border-1 border-gray-300"></th>
                    <th class="py-1 border border-1 border-gray-300">Items</th>
                </thead>
                <tbody class="secondTableTbody">
                    @php
                        $filecat = config('smm.file_category');
                        $user = \App\Models\User::with('categories')->find($user->id);
                        if (isset($user) && $user->categories()->exists()) {
                            foreach ($user->categories()->get() as $cat) {
                                $filecat[] = $cat->name;
                            }
                        }
                        $itemsToShare[] = 'Loan Application';
                        $filecategories = array_diff($categories, $itemsToShare);
                    @endphp
                    @foreach ($filecategories as $category)
                        <tr @class(['items-center text-center', 'bg-gray-100' => $loop->odd])>
                            <td class="py-1.5 flex justify-center text-center border border-1 border-gray-300">
                                <input type="checkbox" value="{{ $category }}" name="category[]" id="{{ $category }}">
                            </td>
                            <td class="py-0.5 border border-1 border-gray-300">{{ $category }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="secondTableButtonsParent flex justify-between items-center mt-3">
                <button class="backButton bg-red-700 text-white py-2 rounded-full px-5">Back</button>
                <button class="nextButton bg-red-700 text-white py-2 rounded-full px-5">Next</button>
            </div>
        </div>
        <div class="hidden py-3 submitPart">
            <span class="errors">
            </span>
            <form action="{{ url(getRoutePrefix() . '/share-items') }}" method="POST">
                @csrf
               <x-jq-loader />
                <input type="email" name="email"
                    class="bg-transperent w-full py-3 focus:bg-transperent focus:ring-2 focus:border-0 focus:ring-red-700 rounded-md">
                <h3 class="mt-3 text-xl font-bold">People With access</h3>
                @forelse($assistants as $assistant)
                    @if($assistant->assistant->active !== 0 || $assistant->assistant->active !== 2)
                    <div class="flex justify-between items-center mt-3">
                        <div>
                            <h3 class="text-xl font-normal">{{ $assistant->assistant->name }}</h3>
                            <p class="text-gray-600">{{ $assistant->assistant->email }}</p>
                        </div>
                        <a class="removeAccess" href="#" data-id="{{ $assistant->assistant->id }}">
                            <img class="icon w-10" src="{{ asset('icons/trash.svg') }}" alt="">
                        </a>
                    </div>
                    @endif
                @empty
                    <div class="text-center text-xl font-bold">Sorry! no data available</div>
                @endforelse
                <div class="flex justify-between items-center mt-3">
                    <button class="bg-red-700 text-white py-2 rounded-full px-5 back">Back</button>
                    <button type="submit" class="bg-red-700 text-white  py-2 rounded-full px-5">Done</button>
                </div>
            </form>
        </div>
    @endcomponent
    <div class="">
        @include('elems.upload-btn')
        <div class="flex justify-between">
            <div class="flex align-center">
                <Button class="newProject bg-red-800 px-5 py-2 text-white flex">
                    <img class="w-7 mr-2" src="{{ asset('icons/share.png') }}" alt="">
                    <span class="pt-1">
                        Share Upload Link
                    </span>
                </Button>
            </div>
            <div>
                @isset($user)
                    @php
                        $name = explode(' ', $user->name);
                        $rearrangedName = count($name) > 1 ? $name[1] . ', ' . $name[0] : $user->name;
                    @endphp
                    <h2 class="text-center text-2xl -mt-3.5 mb-5 text-red-700">
                        {{ $rearrangedName }}
                    </h2>
                    @isset($info)
                        <h3 class="text-center text-xl -mt-3.5 mb-5 text-red-700">
                            {{ $info->b_address . $info->b_city . ', ' . $info->b_state }}
                        </h3>
                    @endisset
                @endisset
            </div>
            <div class="inline-block">
                <div class="relative dropdownButton">
                    <button class=" bg-red-800 px-5 py-2 text-white flex" id="menu-button" aria-expanded="true"
                        aria-haspopup="true">Move To
                        <svg class="ml-2 w-4 mt-1" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 185.344 185.344" xml:space="preserve">
                            <g>
                                <g>
                                    <path style="fill:#ffffff;"
                                        d="M92.672,144.373c-2.752,0-5.493-1.044-7.593-3.138L3.145,59.301c-4.194-4.199-4.194-10.992,0-15.18
                                                                                                                                                                                                                                c4.194-4.199,10.987-4.199,15.18,0l74.347,74.341l74.347-74.341c4.194-4.199,10.987-4.199,15.18,0
                                                                                                                                                                                                                                c4.194,4.194,4.194,10.981,0,15.18l-81.939,81.934C98.166,143.329,95.419,144.373,92.672,144.373z" />
                                </g>
                            </g>
                        </svg>
                    </button>
                    <div class="dropdownMenu hidden absolute right-0 ring-1 ring-blue-700 z-10 mt-1 shadow w-full bg-white">
                        <div class="py-1">
                          <a href="{{ url(getRoutePrefix() . '/project/disable/' . $user->project->id) }}"
                                class="text-gray-700 block px-4 py-2 text-sm {{$user->project->status === 'disable' ? 'bg-red-800 text-white':''}}" role="menuitem" tabindex="-1"
                                id="menu-item-0">Disable Deal</a>
                            <a href="{{ url(getRoutePrefix() . '/project/close/' . $user->project->id) }}"
                                class="text-gray-700 block px-4 py-2 text-sm {{$user->project->status === 'close' ? 'bg-red-800 text-white':''}}" role="menuitem" tabindex="-1"
                                id="menu-item-1">Close Deal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.file.info-table')
    </div>
    <div class="">
        @include('admin.file.category-wise-files-table')
    </div>
    <div class="">
        @if ($files)
            <div class="flex justify-between mb-5">
                <div class="relative categoryContainer">
                    <button class="categoryButton bg-red-800 px-5 py-1 text-white flex">Sort By</button>
                    <div
                        class="categoryMenu hidden absolute right-0 ring-1 ring-blue-700 z-10 mt-1 shadow w-full bg-white">
                        <div class="py-1">
                            <a href="{{ url(getRoutePrefix() . '/sortby/' . $user->id . '/category') }}"
                                @class([
                                    'text-gray-700 block px-4 py-2 text-sm',
                                    isset($sortby) && $sortby === 'category' ? 'bg-red-800 text-white' : '',
                                ]) role="menuitem" tabindex="-1" id="menu-item-0">Category</a>
                            <a href="{{ url(getRoutePrefix() . '/sortby/' . $user->id . '/latest') }}"
                                @class([
                                    'text-gray-700 block px-4 py-2 text-sm',
                                    isset($sortby) && $sortby === 'latest' ? 'bg-red-800 text-white' : '',
                                ]) role="menuitem" tabindex="-1" id="menu-item-1">Files</a>
                        </div>
                    </div>
                </div>
                <label class="serachlabel flex justify-end" for="" class="">
                    <input type="text" id="myInput" placeholder="search"
                        class="serachinput bg-red-800 px-5 py-1 ring-0  text-white flex">
                    <img class="absolute z-10 top-1/4 mr-2" width="20" src="{{ asset('icons/search.svg') }}"
                        alt="">
                </label>
            </div>
        @endif
        @foreach ($categories as $category)
            @if (\Illuminate\Support\Facades\DB::table('media')->where('user_id', $user->id)->where('category', $category)->count() > 0 && $category !== 'Credit Report')
                <div class="searchablediv">
                    @component('components.accordion', [
                        'title' => $category,
                        'color' => 'bg-red-800',
                        'count' => \Illuminate\Support\Facades\DB::table('media')->where('user_id', $user->id)->where('category', $category)->count(),
                    ])
                        @foreach ($files as $file)
                            @if ($file->category === $category)
                                <div class="searchablediv">
                                    <div @class([
                                        'mb-5 flex justify-evenly items-center',
                                        'bg-gray-200' => $loop->odd,
                                    ])>
                                        <div class="text-center" width="30%">
                                            <div class="font-bold mb-2">File Name</div>
                                            <div class="font-bold mb-2">Category</div>
                                            <div class="font-bold mb-2">Upload Date</div>
                                            <div class="font-bold mb-2">Uploaded By</div>
                                            <div class="font-bold mb-2">User ID</div>
                                        </div>
                                        <div width="30%">
                                            <!-- File Name -->
                                            <div class="mb-2">
                                                <a href="{{ asset($file->file_path) }}" class="text-blue-500 inline">
                                                    {{ $file->file_name }} <img class="w-5 inline" src="{{asset('icons/download.svg')}}" alt="">
                                                </a>
                                            </div>
                                            <!-- Category -->
                                            <div class="mb-2 px-3 py-1 bg-yellow-500 w-fit rounded-2xl">
                                                <a href="{{ url(getRoutePrefix() . '/docs/' . $user->id . '/' . str_replace('/', '-', $file->category)) }}"
                                                    class="hover:text-blue-700">
                                                    {{ $file->category }}
                                                </a>
                                            </div>
                                            <!-- Upload Date -->
                                            <div class="mb-2"> {{ convertDBDateUSFormat($file->created_at) }}</div>
                                            <!-- Uploaded By -->
                                            <div class="mb-2">{{ $file->uploadedBy ? $file->uploadedBy->name : '' }}
                                            </div>
                                            <!-- User ID -->
                                            <div class="mb-2">{{ $file->uploadedBy ? $file->uploadedBy->email : '' }}
                                            </div>
                                        </div>
                                        <div width="30%">
                                            <!-- Sent By Client -->
                                            <div class="flex space-x-4">
                                                <label for="status-verified{{ $file->id }}" class="font-bold">Sent By
                                                    Client</label>
                                                <input type="checkbox"
                                                    {{ $file->uploaded_by === $file->user_id ? 'checked' : '' }}
                                                    class="mt-0.5">
                                            </div>
                                            <!-- Status and Comments -->
                                            <div class="">
                                                <form id="status-form"
                                                    action="{{ url(getRoutePrefix() . '/update-file-status/' . $file->id) }}"
                                                    class="">
                                                    @csrf
                                                    <div class="font-bold">Status</div>
                                                    <div class="">
                                                        <div class="flex space-x-2">
                                                            <input {{ $file->status === 'Verified' ? 'checked' : '' }}
                                                                type="radio" id="status-verified{{ $file->id }}"
                                                                name="status" class="" value="Verified">
                                                            <label for="status-verified{{ $file->id }}"
                                                                class="">Verified</label>
                                                        </div>
                                                        <div class="flex space-x-2">
                                                            <input
                                                                {{ $file->status === 'Not Verified' || $file->status === null ? 'checked' : '' }}
                                                                type="radio" id="status-notverified{{ $file->id }}"
                                                                name="status" class="" value="Not Verified">
                                                            <label for="status-notverified{{ $file->id }}"
                                                                class="">Not
                                                                Verified</label>
                                                        </div>
                                                    </div>
                                                    <div class="font-bold">Comments</div>
                                                    <div class="w-full">
                                                        <div class="flex space-x-2">
                                                            <textarea class="rounded comments" name="comments" id="" cols="30" rows="1">{{ $file->comments }}</textarea>
                                                        </div>
                                                        <div class="my-0.5">
                                                            <button title="Update status of this file" type="submit"
                                                                class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                                                                Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="flex align-center">
                                            <a class="delete" data="Delete" title="Delete this file"
                                                href="{{ url(getRoutePrefix() . '/delete-file/' . $file->id) }}">
                                                <button class="bg-themered tracking-wide font-semibold capitalize text-xl">
                                                    <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                        class="p-1 w-7">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endcomponent
                </div>
            @endif
        @endforeach
    </div>
@endsection
@section('foot')
    @include('parts.js.project-overview-script')
@endsection
