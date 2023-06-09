@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }
    </style>
@endsection
@section('content')
    @can('isUser')
        @include('user.dashboard.upload')
    @endcan
    <div class="flex flex-wrap flex-shrink-0 w-full">
        @can('isAdmin')
        <div class="w-full my-2">
            <div class="w-full h-44 " >
                <a href="{{url("/dashboard")}}">
                    <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                        <div class="w-1/2 p-4 pl-8">
                            <span class="text-white text-lg block text-left">Applications</span>
                            <span class="text-white text-2xl block text-left font-bold mt-1">
                                {{ $applications->count() }} 
                            </span>
                        </div>
                        <div class="w-1/2 pt-7 pr-7"> 
                            <img src="{{ asset('icons/user.svg') }}" alt="" class="z-20 float-right mt-3 mr-4">
                            <img src="{{ asset('icons/circle-big.svg') }}" alt="" class="z-10 opacity-10 float-right mt-1 -mr-11 w-20">
                            <img src="{{ asset('icons/circle-small.svg') }}" alt="" class="z-0 opacity-10 float-right mt-16 -mr-12 w-12">
                        </div>
                    </div>
                </a>
            </div>
        </div>        
            <table class="w-full" id="user-table">
                {{-- <caption class="text-left font-bold mb-3">Existing Teachers:</caption> --}}
                <thead class="bg-gray-300">
                    <tr>
                        <th class=" pl-2 tracking-wide">
                            S No.
                        </th>
                        <th class="">
                            Name
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
                    @foreach ($applications as $application)
                        <tr>
                            <td class=" pl-2 tracking-wide border border-l-0">{{ $loop->iteration }}</td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    href="{{ url(getAdminRoutePrefix() . '/application-show/' . $application->id) }}">
                                    {{ $application->user->name }}
                                </a>
                                <a title="Edit this user" href="{{ url(getAdminRoutePrefix() . '/application-edit/' . $application->id) }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                </a>
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                {{ $application->user->email }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-r-0">
                                <a onclick="return confirm('Are you sure you want to delete this user?')" title="Delete this user"
                                    href="{{ url(getAdminRoutePrefix() . '/application-delete/' . $application->id) }}">
                                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
            
                </tbody>
            </table>
            
        @endcan
        @can('isUser')
            @include('user.dashboard.cards')
        @endcan
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-table').DataTable({
                pageLength: 30,
                lengthMenu: [10, 20, 30, 50, 100, 200],
            });
        });
    </script>
    <script>
        $("#start-upload-btn").click(function(e) {
            e.preventDefault();
            if ($('input[name="attachment[]"]').length > 0) {
                var checkedBoxes = $('input[name="attachment[]"]:checked');
                var checkedValues = checkedBoxes.map(function() {
                    return $(this).val();
                }).get();
                if ($('#category').val() === "") {
                    alert('Please choose document type');
                    return;
                }
                if (!file && checkedValues == 0) {
                    alert('Please select or drag a file to upload. Or select at least one file from Gmail');
                    return;
                }
                $("#start-upload-div").toggleClass("hidden");
                $("#file-progress").toggleClass("hidden");
                $("#file-name-progress").text(file?.name ?? '');
                uploadToPHPServer(checkedValues);
            } else {
                if ($('#category').val() === "") {
                    alert('Please choose document type');
                    return;
                }
                if (!file) {
                    alert('Please select or drag a file to upload.');
                    return;
                }
                $("#start-upload-div").toggleClass("hidden");
                $("#file-progress").toggleClass("hidden");
                $("#file-name-progress").text(file.name);
                uploadToPHPServer();
            }
        });

        function uploadToPHPServer(checkedValues = null) {
            var formData = new FormData();
            if (file) {
                var blob = file instanceof Blob ? file : file.getBlob();
                blob = new File([blob], file.name.split(".")[1], {
                    type: 'application/octet-stream'
                });
                formData.append('filename', file.name);
                formData.append('file', blob);
            }
            formData.append('_token', reConfig.csrfToken);
            if (typeof userId !== 'undefined') {
                formData.append('id', userId);
            }
            formData.append('category', $('#category').val());
            if (checkedValues !== null) {
                formData.append('attachment', $.map(checkedValues, function(value, index) {
                    return [value];
                }));
            }
            // var upload_url = 'https://your-domain.com/files-uploader/';
            var upload_url = '{{ url(getUserRoutePrefix() . '/file-upload') }}';
            makeXMLHttpRequest(upload_url, formData, function(progress) {
                console.log(progress);
                if (progress !== 'upload-ended') {
                    $("#progressbar").css("width", progress);
                    $("#file-name-percent").text(progress);
                    return;
                }
                alert('File upload complete.')
                $("#start-upload-div").toggleClass("hidden");
                $("#file-progress").toggleClass("hidden");
                $("#filename").text("");
                location.reload();
            });
        }

        function makeXMLHttpRequest(url, data, callback) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var data = JSON.parse(request.responseText);
                    if (data.status === 'success') {
                        callback('upload-ended');
                        uploaded_path = data.url;
                        return;
                    }
                    if (data.status == 'File exists') {
                        alert(data.filename + ' already exists');
                        $("#start-upload-div").removeClass("hidden");
                    }
                }
            };
            request.upload.onloadstart = function() {
                //callback('Upload started...');
            };
            request.upload.onprogress = function(event) {
                callback(Math.round(event.loaded / event.total * 100) + "%");
            };
            request.upload.onload = function() {
                // callback('progress-about-to-end');
            };
            request.upload.onload = function() {
                // callback('Getting File URL..');
            };
            request.upload.onerror = function(error) {
                // callback('Failed to upload to server');
            };
            request.upload.onabort = function(error) {
                // callback('Upload aborted.');
            };
            request.open('POST', url);
            request.send(data);
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#user-table_wrapper').css('width', '100%');
            $('select[name="user-table_length"]').css('width', '4rem');
            $("#file-upload-btn").on("click", function() {
                $("#file").trigger("click");
            });
            $("#modal-close").on("click", function() {
                $("#default-modal").toggleClass("hidden");
            });
            $("#upload-btn").on("click", function() {
                $("#default-modal").toggleClass("hidden");
            });
        });
        $('input[type="file"]').change(function(e) {
            file = e.target.files[0];
            var fileName = e.target.files[0].name;
            $("#filename").text(fileName);
            // var reader = new FileReader();
            // reader.onload = function(e) {
            //     // get loaded data and render thumbnail.
            //     // document.getElementById("preview").src = e.target.result;
            // };
            // // read the image file as a data URL.
            // reader.readAsDataURL(this.files[0]);
        });
    </script>
    <script>
        var file;

        function dropHandler(ev) {
            console.log('File(s) dropped');
            // Prevent default behavior (Prevent file from being opened)
            ev.preventDefault();
            if (ev.dataTransfer.items) {
                // Use DataTransferItemList interface to access the file(s)
                for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                    // If dropped items aren't files, reject them
                    if (ev.dataTransfer.items[i].kind === 'file') {
                        file = ev.dataTransfer.items[i].getAsFile();
                        console.log('... file[' + i + '].name = ' + file.name);
                        $("#filename").text(file.name);
                        break;
                    }
                }
            } else {
                // Use DataTransfer interface to access the file(s)
                for (var i = 0; i < ev.dataTransfer.files.length; i++) {
                    console.log('... file[' + i + '].name = ' + ev.dataTransfer.files[i].name);
                    file = ev.dataTransfer.files[i];
                    $("#filename").text(file.name);
                    break;
                }
            }
        }

        function dragOverHandler(ev) {
            ev.preventDefault();
        }
    </script>
@endsection
