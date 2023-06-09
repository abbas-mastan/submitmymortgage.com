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
    <div class="flex flex-wrap flex-shrink-0 w-full">
        {{-- @can('isAdmin') --}}
        <div class="w-full my-2">
            <div class="w-full h-44 ">
                <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <div class="w-1/2 p-4 pl-8">
                        <span class="text-white text-lg block text-left">Users</span>
                        <span class="text-white text-2xl block text-left font-bold mt-1">
                            {{ $users->count() }}
                        </span>
                    </div>
                    <div class="w-1/2 pt-7 pr-7">
                        <img src="{{ asset('icons/user.svg') }}" alt="" class="z-20 float-right mt-3 mr-4">
                        <img src="{{ asset('icons/circle-big.svg') }}" alt=""
                            class="z-10 opacity-10 float-right mt-1 -mr-11 w-20">
                        <img src="{{ asset('icons/circle-small.svg') }}" alt=""
                            class="z-0 opacity-10 float-right mt-16 -mr-12 w-12">
                    </div>
                </div>
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
            <tbody>
                {{-- @foreach ($processors as $processor)
                    $associates = $processor->createdUsers()->where('role', 'Associate')->with('createdUsers')->get();
                    @foreach ($associates as $associate)
                        $juniorAssociates = $associate->createdUsers()->where('role', 'Junior
                        Associate')->with('createdUsers')->get();
                        @foreach ($juniorAssociates as $juniorAssociate)
                            $borrowers = $juniorAssociate->createdUsers()->where('role', 'Borrower')->get();
                            @foreach ($borrowers as $borrower)
                                dump($borrower->email.' ===> '.$borrower->role);
                            @endforeach
                            dump($juniorAssociate->email.' ===> '.$juniorAssociate->role);
                        @endforeach
                        dump($associate->email.' ===> '.$associate->role);
                        // Process the junior associates
                    @endforeach
                    dump($processor->email.' ===> '.$processor->role);
                    // Process the associates
                @endforeach --}}
                @foreach ($users as $processor)
                    @php
                        $associates = $processor
                            ->createdUsers()
                            ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])
                            ->with('createdUsers')
                            ->get();
                    @endphp
                    <tr>
                        <td class=" pl-2 tracking-wide border border-l-0">{{ $loop->iteration }}</td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                {{-- href="{{ url(getAdminRoutePrefix() . '/lead/' . $user->id) }}" --}}>
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
                            <a onclick="return confirm('Are you sure you want to delete this user?')"
                                title="Delete this lead"
                                href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </td>
                    </tr>
                    @foreach ($associates as $associate)
                        <tr>
                            <td class=" pl-2 tracking-wide border border-l-0"></td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    {{-- href="{{ url(getAdminRoutePrefix() . '/lead/' . $user->id) }}" --}}>
                                    {{ $associate->name }}
                                </a>
                                <a title="Edit this user"
                                    href="{{ url(getRoutePrefix() . '/add-user/' . $associate->id) }}">
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
                        @endphp
                        @foreach ($juniorAssociates as $jassociate)
                            <tr>
                                <td class=" pl-2 tracking-wide border border-l-0"></td>
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
                            @endphp
                            @foreach ($borrowers as $borrower)
                                <tr>
                                    <td class=" pl-2 tracking-wide border border-l-0"></td>
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
                                                <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                    class="p-1 w-7">
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
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
@endsection
