@extends('layouts.empty')
@section('head')
    <style>
        .body-first-div {
            height: 80%;
        }

        .file-block {
            border-radius: 10px;
            background-color: rgba(144, 163, 203, 0.2);
            margin: 5px;
            color: initial;
            display: inline-flex;
            width: 80%;
        }

        span.name {
            padding-right: 10px;
            width: max-content;
            display: inline-flex;
        }

        .file-delete {
            display: flex;
            width: 24px;
            color: initial;
            background-color: #6eb4ff00;
            font-size: large;
            justify-content: center;
            margin-right: 3px;
            cursor: pointer;
            transform: rotate(45deg);
        }

        .file-delete:hover {
            background-color: rgba(144, 163, 203, 0.2);
            border-radius: 10px;
        }


        span.name-old {
            padding-right: 10px;
            width: max-content;
            /* display: inline-flex; */
            overflow: hidden;
            text-overflow: ellipsis !important;
            white-space: nowrap;

        }

        .file-delete-old {
            display: flex;
            width: 24px;
            color: initial;
            background-color: #6eb4ff00;
            font-size: large;
            justify-content: center;
            margin-right: 3px;
            cursor: pointer;
            transform: rotate(45deg);
        }

        .file-delete-old:hover {
            background-color: rgba(144, 163, 203, 0.2);
            border-radius: 10px;
        }

        .menu::-webkit-scrollbar {
            width: 4px;
        }

        /* Track */
        .menu::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .menu::-webkit-scrollbar-thumb {
            background: #848484;
            border-radius: 5px;
        }

        /* Handle on hover */
        .menu::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection
@section('content')
    <div class="child mt-24 mx-16 w-full shadow-2xl bg-white p-10 rounded-2xl">
        <div class="my-5 flex justify-end ">
            <a href="{{ url('/logout') }}" class="rounded-md bg-red-700 px-5 py-2 text-white">Logout</a>
        </div>
        <header class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white rounded-t-2xl p-4">
            <h1 class="text-2xl text-center font-bold">Submit Documents for Your Mortgage Deal </h1>
        </header>
        <form class="my-3" action="{{ url(getAssistantRoutePrefix() . '/submit-document') }}" enctype="multipart/form-data"
            method="post">
            @csrf
            <div class="flex items-center h-10 bg-gradient-to-b from-gradientStart to-gradientEnd text-white">
                <div class="w-1/5 border-e-2 pl-5">Item</div>
                <div class="pl-5">Action</div>
            </div>
            @forelse (json_decode($cats->categories) as $item)
                @php($id = Str::slug($item))
                <div class="flex mt-3">
                    <div class="flex w-1/5 h-8 py-7 items-center px-3">{{ $item }}</div>
                    <div class="flex h-8 py-7 items-center w-full ">
                        <p id="{{ $id }}-files-area" class="menu w-[90%] pl-10 h-16 overflow-y-auto flex items-center">
                            <span id="{{ $id }}filesList">
                                <span class="grid grid-cols-5 items-end">
                                    @forelse(\App\Models\Media::where('uploaded_by',Auth::id())->get() as $file)
                                        @if ($file->category !== $item)
                                            @continue
                                        @endif
                                        <span>
                                            <span class="font-bold text-[#56b35a] ml-2 capitalize success">file
                                                Submitted!</span>
                                            <span class="file-block flex items-center" style="background-color:#56b35a;">
                                                <span value="{{ $file->id }}" title="delete this item"
                                                    class="file-delete-old px-2 cursor-pointer rotate-45">+</span>
                                                <span class="name-old">{{ $file->file_name }}</span>
                                            </span>
                                        </span>
                                    @empty
                                    @endforelse
                                </span>
                                <span id="{{ $id }}-files-names" class="grid grid-cols-5"></span>
                            </span>
                        </p>
                        <div>
                            <input accept=".xlsx,.xls,.jpeg,.jpg,.png,.doc, .docx,.ppt, .pptx,.txt,.pdf"
                                id="{{ $id }}" type="file" name="{{ $id }}[]" multiple hidden>
                            <label for="{{ $id }}"
                                class="px-4 py-2 text-white min-w-[20px] bg-red-700 rounded-md">Add File</label>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
            <div class="mt-3 flex justify-center">
                <button type="submit" class="px-5 py-2 text-white bg-red-700 mt-7 rounded-md">Submit All Files</button>
            </div>
        </form>
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script>
        $('span.file-delete-old').click(function(e) {
            e.preventDefault();
            var $span = $(this); // Store a reference to the clicked span
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $span.attr('value');
            $.ajax({
                type: "get",
                url: `/assistant/delete-file/${id}`,
                data: $span
                    .serialize(), // Note: serialize() is typically used with forms, so this may not be necessary
                success: function(response) {
                    console.log(response);
                    if (response == 'file delete') {
                        $span.parent().parent()
                    .remove(); // Use the stored reference to remove the parent element
                    }
                }
            });
        });

        $(document).ready(function() {
            // Function to handle file inputs
            function handleFileInput(inputId, filesListId, filesNamesId) {
                const dt = new DataTransfer();
                $(inputId).on('change', function(e) {
                    for (var i = 0; i < this.files.length; i++) {
                        let fileBloc = $('<span/>', {
                                class: 'file-block flex items-center'
                            }),
                            fileName = $('<p/>', {
                                class: 'name truncate',
                                text: this.files.item(i).name
                            });
                        fileBloc.append('<span class="px-1 file-delete"><span>+</span></span>')
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
            @foreach (json_decode($cats->categories) as $item)
                @php($id = Str::slug($item))
                handleFileInput("#{{ $id }}", "#{{ $id }}filesList",
                    "#{{ $id }}-files-names");
            @endforeach
        });
    </script>
@endsection
