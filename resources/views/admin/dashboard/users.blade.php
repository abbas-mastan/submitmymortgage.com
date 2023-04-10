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
        @foreach ($users as $user)
            <tr>
                <td class=" pl-2 tracking-wide border border-l-0">{{ $loop->iteration }}</td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                        href="{{ url(getAdminRoutePrefix() . '/file-cat/' . $user->id) }}">
                        {{ $user->name }}
                    </a>
                    <a title="Edit this user" href="{{ url(getAdminRoutePrefix() . '/add-user/' . $user->id) }}">
                        <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                    </a>
                </td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    {{ $user->email }}
                </td>
                <td class=" pl-2 tracking-wide border border-r-0">
                    <a onclick="return confirm('Are you sure you want to delete this user?')" title="Delete this user"
                        href="{{ url(getAdminRoutePrefix() . '/delete-user/' . $user->id) }}">
                        <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                            <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
