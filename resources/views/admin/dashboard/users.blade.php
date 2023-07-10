<table id="user-table" class="display w-full">
    <thead class="text-center bg-gray-300">
        <tr>
            <th class="pl-2 tracking-wide">
                S No.
            </th>
            <th class="">
                Name
            </th>
            <th class="">
                User ID
            </th>
            <th class="">
                Role
            </th>
            <th class="">
                Created By
            </th>
            <th class="">
                Actions
            </th>
        </tr>
    </thead>
    <tbody class="text-center">
        @php
            $serialNo = 1;
        @endphp
        @foreach ($users as $processor)
            <tr>
                <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    <a title="{{ $processor->role == 'Borrower' ? 'Click to view files uploaded by this user' : '' }}"
                        class="text-blue-500 inline"
                        href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}">
                        {{ $processor->name }}
                    </a>
                    <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                        <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                    </a>
                </td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    {{ $processor->email }}
                </td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    {{ $processor->role }}
                </td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    @if ($processor->created_by)
                        {{ \App\Models\User::where('id', $processor->created_by)->first()->name }} |
                        {{ \App\Models\User::where('id', $processor->created_by)->first()->role }}
                    @endif
                </td>
                <td class=" pl-2 tracking-wide border border-r-0">
                    <a class="delete" data="Delete" title="Delete this user"
                        href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                        <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                            <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                        </button>
                    </a>
                </td>
            </tr>
            @php
                $associates = $processor
                    ->createdUsers()
                    ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])
                    ->with('createdUsers')
                    ->get();
                $serialNo++;
            @endphp
            @foreach ($associates as $associate)
                <br>
                <tr>
                    <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        <a title="{{ $associate->role == 'Borrower' ? 'Click to view files uploaded by this user' : '' }}"
                            class="text-blue-500 inline"
                            href="{{ url(getRoutePrefix() . ($associate->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $associate->id) }}">
                            {{ $associate->name }}
                        </a>
                        <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $associate->id) }}">
                            <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                        </a>
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        {{ $associate->email }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        {{ $associate->role }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-l-0">
                        {{ \App\Models\User::where('id', $associate->created_by)->first()->name }} |
                        {{ \App\Models\User::where('id', $associate->created_by)->first()->role }}
                    </td>
                    <td class=" pl-2 tracking-wide border border-r-0">
                        <a class="delete" data="Delete" title="Delete this lead"
                            href="{{ url(getRoutePrefix() . '/delete-user/' . $associate->id) }}">
                            <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                            </button>
                        </a>
                    </td>
                </tr>
                @php
                    $juniorAssociates = $associate
                        ->createdUsers()
                        ->whereIn('role', ['junior Associate', 'Borrower'])
                        ->with('createdUsers')
                        ->get();
                    $serialNo++;
                @endphp
                @foreach ($juniorAssociates as $jassociate)
                    <tr>
                        <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="{{ $processor->role == 'Borrower' ? 'Click to view files uploaded by this user' : '' }}"
                                class="text-blue-500 inline"
                                href="{{ url(getRoutePrefix() . ($jassociate->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $jassociate->id) }}">
                                {{ $jassociate->name }}
                            </a>
                            <a title="Edit this user"
                                href="{{ url(getRoutePrefix() . '/add-user/' . $jassociate->id) }}">
                                <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $jassociate->email }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $jassociate->role }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ \App\Models\User::where('id', $jassociate->created_by)->first()->name }} |
                            {{ \App\Models\User::where('id', $jassociate->created_by)->first()->role }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a class="delete" data="Delete" title="Delete this lead"
                                href="{{ url(getRoutePrefix() . '/delete-user/' . $jassociate->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </td>
                    </tr>
                    @php
                        $borrowers = $jassociate
                            ->createdUsers()
                            ->where('role', 'Borrower')
                            ->with('createdUsers')
                            ->get();
                        $serialNo++;
                    @endphp
                    @foreach ($borrowers as $borrower)
                        <tr>
                            <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    href="{{ url(getRoutePrefix() . ($borrower->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $borrower->id) }}">
                                    {{ $borrower->name }}
                                </a>
                                <a title="Edit this user"
                                    href="{{ url(getAdminRoutePrefix() . '/add-user/' . $borrower->id) }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                </a>
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                {{ $borrower->email }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                {{ $borrower->role }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                {{ \App\Models\User::where('id', $borrower->created_by)->first()->name }} |
                                {{ \App\Models\User::where('id', $borrower->created_by)->first()->role }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-r-0">
                                <a class="delete" data="Delete"
                                    title="Delete this lead"
                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $borrower->id) }}">
                                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @php
                            $serialNo++;
                        @endphp
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
