<div id="default-modal" aria-hidden="true"
    class="hidden w-full h-full overflow-x-hidden overflow-y-auto 
fixed bg-gray-500 bg-opacity-40
 z-50 justify-center items-center">
    <div class="fixed left-1/3 top-1/4 w-full max-w-2xl px-4 h-full md:h-auto bg-white shadow relative">
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
                    <table class="user-table w-full">
                        <thead>
                            <th>filename</th>
                        </thead>
                        <tbody>

                            @php
                                $attachments = \App\Models\Attachment::where('user_id', Auth::id())->get();
                            @endphp
                            @foreach ($attachments as $key => $file)
                                <tr>
                                    <td>
                                        <div id="attachments" class="inline ">
                                            <input id="check{{ $file->id }}" type="checkbox"
                                                value="{{ $file->id }}" name="attachment[]" class="form-control">
                                            <label for="check{{ $file->id }}">
                                                {{ $file->file_name }}
                                            </label>
                                        </div>
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
