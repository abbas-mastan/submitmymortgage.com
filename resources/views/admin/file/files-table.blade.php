<table class="w-full" id="completed-table">
    @if (!empty($cat))
        <caption class="text-center font-bold mb-3">{{ $cat }}</caption>
    @endif
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
        @foreach ($files as $file)
            <tr>
                <td class=" pl-2 tracking-wide border border-l-0">{{ $loop->iteration }}</td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    <a target="_blank" href='{{ \File::extension($file->file_name) == "docx" ? url("/show-docx/$file->id") : asset($file->file_path) }}' class="hover:text-blue-500 inline">
                        {{ $file->file_name }}
                    </a>
                    <a download href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline" download>
                        <img src="{{ asset('icons/download.svg') }}" alt="" class="w-6 h-8 ml-5 inline">
                    </a>
                </td>
                <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                    {{ convertDBDateUSFormat($file->created_at) }}
                </td>
                <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                    {{ $file->uploadedBy->name ?? $file->user->name }} |
                    {{ $file->uploadedBy->role ?? $file->user->role }}
                </td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    {{ $file->user->email }}
                </td>
                <td class=" pl-2 tracking-wide border border-r-0">
                    <div class="flex justify-center">
                        <a class="delete" data="Delete" title="Delete this file"
                            href="{{ url(getRoutePrefix() . '/delete-file/' . $file->id) }}">
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
