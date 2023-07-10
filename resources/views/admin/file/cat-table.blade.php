<table class="w-full mt-3">
    {{-- <caption class="text-center font-bold mb-3">{{ $user->name }}</caption> --}}
    <thead class="bg-gray-300">
        <tr>
            <th class="">
                File Details
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class=" pl-2 tracking-wide border  border-l-0 border-r-0">
                @foreach ($files as $file)
                    @if ($file->category === 'Credit Report')
                        @continue
                    @endif
                    <table class="w-full">
                        <tr class="">
                            <th class="" width="30%">
                                File Name
                            </th>
                            <td class="" width="30%">
                                <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline">
                                    {{ $file->file_name }}
                                </a>
                            </td>
                            <td class="" width="30%" rowspan="6">
                                <div class="flex space-x-4">
                                    <label for="status-verified{{ $file->id }}" class="font-bold">Sent By
                                        Client</label>
                                    <input type="checkbox" {{ $file->uploaded_by === $file->user_id ? 'checked' : '' }}
                                        class="mt-0.5">
                                </div>
                                <form id="status-form"
                                    action="{{ url(getRoutePrefix() . '/update-file-status/' . $file->id) }}"
                                    class="">
                                    @csrf
                                    <div class="font-bold">
                                        Status
                                    </div>
                                    <div class="">
                                        <div class="flex space-x-2">
                                            <input {{ $file->status === 'Verified' ? 'checked' : '' }} type="radio"
                                                id="status-verified{{ $file->id }}" name="status" class=""
                                                value="Verified">
                                            <label for="status-verified{{ $file->id }}"
                                                class="">Verified</label>
                                        </div>
                                        <div class="flex space-x-2">
                                            <input
                                                {{ $file->status === 'Not Verified' || $file->status === null ? 'checked' : '' }}
                                                type="radio" id="status-notverified{{ $file->id }}"
                                                name="status" class="" value="Not Verified">
                                            <label for="status-notverified{{ $file->id }}" class="">Not
                                                Verified</label>
                                        </div>
                                    </div>
                                    <div class="font-bold">
                                        Comments
                                    </div>
                                    <div class="w-full">
                                        <div class="flex space-x-2">
                                            <textarea class="rounded comments" name="comments" id="" cols="30" rows="1">{{ $file->comments }}</textarea>
                                        </div>
                                        <div class=" my-0.5">
                                            <button title="Update status of this file" type="submit"
                                                class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td class="text-right" width="10%" rowspan="6">
                                <a 
                                class="delete" data="Delete"
                                    title="Delete this file"
                                    href="{{ url(getRoutePrefix() . '/delete-file/' . $file->id) }}">
                                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="">
                                Category
                            </th>
                            <td class="">
                                <div class="px-3 py-1 bg-yellow-500 w-fit rounded-2xl">
                                    <a href="{{ url(getRoutePrefix() . '/docs/' . $user->id . '/' . str_replace('/', '-', $file->category)) }}"
                                        class="hover:text-blue-700">
                                        {{ $file->category }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="">
                                Upload Date
                            </th>
                            <td class="">
                                {{ convertDBDateUSFormat($file->created_at) }}
                            </td>
                        </tr>
                        <tr class="">
                            <th class="">
                                Uploaded by
                            </th>
                            <td class="">
                                {{ $file->uploadedBy ? $file->uploadedBy->name : '' }}
                            </td>
                        </tr>
                        <tr class="">
                            <th class="">
                                User ID
                            </th>
                            <td class="">
                                {{-- {{ $file->user->email }} --}}
                                {{ $file->uploadedBy ? $file->uploadedBy->email : '' }}
                            </td>
                        </tr>
                    </table>
                    <hr class="py-2">
                @endforeach
            </td>



        </tr>


    </tbody>
</table>
