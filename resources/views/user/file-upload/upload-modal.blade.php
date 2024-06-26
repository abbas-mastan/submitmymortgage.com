<div id="default-modal" aria-hidden="true" style="padding-bottom: 20rem;"
    class="hidden w-full h-full overflow-x-hidden overflow-y-auto  
fixed bg-gray-500 bg-opacity-40
 z-50 justify-center items-center">
    <div class="fixed left-1/3 top-1/4 w-full max-w-2xl px-4 h-full md:h-auto bg-white shadow relative mb-40">
        <!-- Modal content -->
        <div class="">
            <!-- Modal header -->
            <div class="flex items-end pt-1 pr-1 ">
                <button id="modal-close" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-lg p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="default-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="flex justify-center items-center py-1 ">

                <select required class="w-1/2 rounded-md" name="category" id="category">
                    <option value="">Choose document type</option>
                    @php
                        $categories = config('smm.file_category');
                        foreach (Auth::user()->categories()->get() as $category) {
                            $categories[] = $category->name;
                        }
                        if (isset($user)) {
                            foreach ($user->categories()->get() as $category) {
                                $categories[] = $category->name;
                            }
                        }
                    @endphp
                    @foreach ($categories as $cat)
                        @if (\App\Services\CommonService::filterCat($user ?? Auth::user(), $cat) || $cat === 'Loan Application')
                            @continue
                        @endif
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <span class="block text-center text-red-700" id="select_error"></span>
            <div class="mx-auto mt-6 w-3/4 h-36 outline-red-300 outline-dashed outline-offset-8" id="drop_zone"
                ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                <div class="pt-5 flex justify-center">
                    <img class="h-10 w-10 fill-red-400" src="{{ asset('icons/upload.svg') }}" alt="">
                </div>
                <div class="">
                    <p class=" text-center">
                        Drag your file here or <button
                            class="bg-transparent border-none outline-none
                            font-bold text-gradientStart"
                            id="file-upload-btn">

                            browse
                        </button>
                        <input type="file" name="file" id="file" multiple>
                    </p>
                    <p class=" text-center"><span id='filename' class="text-blue-500"></span></p>
                </div>
            </div>
            <div class="block text-center text-red-700 mt-4" id="file_error"></div>
            <div id="file-progress" class="hidden w-full flex justify-center space-x-2 mt-8">
                <div>
                    <img class="w-10 h-16" src="{{ asset('icons/file-type.svg') }}" alt="" srcset="">
                </div>
                <div class="w-2/4 mt-3">
                    <div class="">
                        <span id="file-name-progress" class="float-left overflow-hidden">
                        </span>
                        <span id="file-name-percent" class="float-right">
                            0%
                        </span>
                    </div>
                    <div class="w-full  mt-7 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div id="progressbar" class="bg-orange-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
                <div class=" mt-5 ml-5">
                    <button id="file-cancel-btn" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-lg p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <br>
            @if (count(\App\Models\Attachment::where('user_id', Auth::id())->get()) > 0)
            <div class="px-20 justify-evenly">
                {{-- <button class="bg-red-800 text-white px-5 py-1.5 absolute ">Sort by</button> --}}
                <div class="absolute z-50">
                    <button class="modalsort bg-red-800 px-4 py-1 text-white flex items-center" id="menu-button"
                        aria-expanded="true" aria-haspopup="true">Sort By
                        <svg class="ml-2 w-3 mt-1" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 185.344 185.344"
                            xml:space="preserve">
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
                    <div class="hidden uploadModalDropdown absolute right-0 ring-1 ring-blue-700 z-10 mt-1 shadow w-full bg-white">
                        <div class="py-1">
                            <button href="#" class="latest text-gray-700 block px-4 py-2 text-sm" role="menuitem"
                                tabindex="-1" id="menu-item-0">Latest</button>
                            <button href="#" class="filetype text-gray-700 block px-4 py-2 text-sm" role="menuitem"
                                tabindex="-1" id="menu-item-1">File Type</button>
                        </div>
                    </div>
                </div>

                <img class="absolute right-0 z-10 w-5 mt-2" style="margin-right: 15%;" src="{{ asset('icons/search.svg') }}" alt="">

                <table class="user-table w-full stripe" id="attachment-table">
                    <thead class="">
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody class="flex flex-col pt-2">
                        @php
                            $attachments = \App\Models\Attachment::where('user_id', Auth::id())->latest()->get();
                            // [(object) ['id' => 'file-1', 'file_name' => 'File 1'], (object) ['id' => 'file-2', 'file_name' => 'File 2'], (object) ['id' => 'file-3', 'file_name' => 'File 3']]
                        @endphp
                        @foreach ($attachments as $key => $file)
                            <tr @class([
                                'bg-gray-200' => $loop->odd,
                            ])>
                                <td class="">
                                    <div id="attachments" class="inline ">
                                        <input id="check{{ $file->id }}" type="checkbox"
                                            value="{{ $file->id }}" name="attachment[]" class="form-control">
                                        <label for="check{{ $file->id }}">
                                            {{ $file->file_name }}
                                        </label>
                                    </div>
                                </td>
                                <td class="hidden">
                                  {{$file->file_extension}}
                                </td>
                                <td class="hidden">
                                  {{date($file->created_at)}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <!-- Modal footer -->
            <div id="start-upload-div" class="flex  items-center justify-center py-8  rounded-b dark:border-gray-600">
                <button id="start-upload-btn" data-modal-toggle="default-modal" type="button"
                    class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white  rounded-lg text-sm px-8 py-2 text-center ">Start
                    Upload</button>
            </div>
        </div>
    </div>
</div>
