@php
$associates = $processor
    ->createdUsers()
    ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])
    ->with('createdUsers')
    ->get();
$serialNumber++;
@endphp
@foreach ($associates as $associate)
<tr>
    <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNumber }}</td>
    <td class=" pl-2 tracking-wide border border-l-0">
        <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
            {{-- href="{{ url(getAdminRoutePrefix() . '/lead/' . $user->id) }}" --}}>
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
        @if ($associate->created_by)
            {{ \App\Models\User::where('id', $associate->created_by)->first()->name }} |
            {{ \App\Models\User::where('id', $associate->created_by)->first()->role }}
        @endif
    </td>
    <td class=" pl-2 tracking-wide border border-r-0">
        <a onclick="return confirm('Are you sure you want to delete this user?')"
            title="Delete this lead"
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
    $serialNumber++;
    
@endphp
@foreach ($juniorAssociates as $jassociate)
    <tr>
        <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNumber }}</td>
        <td class=" pl-2 tracking-wide border border-l-0">
            <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                {{-- href="{{ url(getAdminRoutePrefix() . '/lead/' . $user->id) }}" --}}>
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
            @if ($jassociate->created_by)
                {{ \App\Models\User::where('id', $jassociate->created_by)->first()->name }} |
                {{ \App\Models\User::where('id', $jassociate->created_by)->first()->role }}
            @endif
        </td>
        <td class=" pl-2 tracking-wide border border-r-0">
            <a onclick="return confirm('Are you sure you want to delete this user?')"
                title="Delete this lead"
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
        $serialNumber++;
    @endphp
    @foreach ($borrowers as $borrower)
        <tr>
            <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNumber }}</td>
            <td class=" pl-2 tracking-wide border border-l-0">
                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                    {{-- href="{{ url(getAdminRoutePrefix() . '/lead/' . $user->id) }}" --}}>
                    {{ $borrower->name }}
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
                <a onclick="return confirm('Are you sure you want to delete this user?')"
                    title="Delete this lead"
                    href="{{ url(getRoutePrefix() . '/delete-user/' . $borrower->id) }}">
                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                        <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                    </button>
                </a>
            </td>
        </tr>
        @php
            $serialNumber++;
        @endphp
    @endforeach
@endforeach
@endforeach