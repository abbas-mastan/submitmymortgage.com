<tr>
    <td class=" pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
    <td class=" pl-2 tracking-wide border border-l-0">
        <a title="Click to view this application" class="text-blue-500 inline"
            href="{{ url(getRoutePrefix() . '/application-show/' . $application->id) }}">
            {{ $application->name }}
        </a>
        <a title="Click to Edit this application"
            href="{{ url(getRoutePrefix() . '/application-edit/' . $application->id) }}">
            <img src="{{ asset('icons/pencil.svg') }}" alt=""
                class="inline ml-5">
        </a>
    </td>
    <td class=" pl-2 tracking-wide border border-l-0">
        {{ $application->email }}
    </td>
    <td class="text-center pl-2 tracking-wide border border-r-0">
        @if($key !== 3)
        <a class="delete" data="Delete" title="Click to Delete this application"
        href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id.'/delete') }}">
        <button
                class="bg-black  tracking-wide font-semibold capitalize text-xl">
                <img src="{{ asset('icons/trash.svg') }}" alt=""
                    class="p-1 w-7">
            </button>
        </a>
        @endif
        @if ($key == 0)
            <a class="delete mx-2" data="Accept"
                title="Click to Accept this application"
                href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/accept') }}">
                <button
                    class="bg-black tracking-wide font-semibold capitalize text-xl">
                    <img src="{{ asset('icons/tick.svg') }}" alt=""
                        class="p-1 w-7">
                </button>
            </a>
            <a class="delete" data="Reject"
                title="Click to Reject this application"
                href="{{ url(getRoutePrefix() . '/application-update-status/' . $application->id . '/reject') }}">
                <button
                    class="bg-black  tracking-wide font-semibold capitalize text-xl">
                    <img src="{{ asset('icons/cross.svg') }}" alt=""
                        class="p-1 w-7">
                </button>
            </a>
        @endif
    </td>
</tr>
@php $serialNo++; @endphp
