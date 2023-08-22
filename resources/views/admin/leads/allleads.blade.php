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
    <div class="flex-wrap flex-shrink-0 w-full">
        @if (Auth::user()->role != 'Borrower')
            <div class="w-full my-2">
                <div class="w-full h-44 ">
                    <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                        <div class="w-1/2 p-4 pl-8">
                            <span class="text-white text-lg block text-left">Contacts</span>
                            <span class="text-white text-2xl block text-left font-bold mt-1">
                                {{ count($leads) }}
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
            <form method="POST" action="{{ url(getRoutePrefix() . '/export-contacts') }}">
                @csrf
                <table class="w-full" id="user-table">
                    @include('components.table-head')
                    <tbody>
                        @if (Auth::user()->role == 'Admin')
                            @foreach ($leads as $lead)
                                <tr class="text-center">
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        <input class="mr-4 checkbox" type="checkbox" name="contact[]"
                                            value="{{ $lead->id }}">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                            href="{{ url(getRoutePrefix() . '/lead/' . $lead->user->id) }}">
                                            {{ $lead->user->name }}
                                        </a>
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-l-0">
                                        {{ $lead->user->email }}
                                    </td>
                                    <td class=" pl-2 tracking-wide border border-r-0">
                                        <a data="Delete" class="delete"
                                            href="{{ url(getRoutePrefix() . '/delete-lead/' . $lead->id) }}">
                                            <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                                <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @if (Auth::user()->role == 'Processor' || Auth::user()->role == 'Associate' || Auth::user()->role == 'Junior Associate')
                            @php $serialNo = 1; @endphp
                            @foreach ($leads as $processor)
                                @if ($processor->infos)
                                    @foreach ($processor->infos as $info)
                                        <tr>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                <input class="mr-4 checkbox" type="checkbox" name="contact[]"
                                                    value="{{ $lead->id }}">
                                                {{ $serialNo }}
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                <a title="Click to view files uploaded by this user"
                                                    class="text-blue-500 inline"
                                                    href="{{ url(getRoutePrefix() . '/lead/' . $info->user_id) }}">
                                                    {{ $info->b_fname }}
                                                </a>
                                            </td>
                                            <td class=" pl-2 tracking-wide border border-l-0">
                                                {{ $processor->email }}
                                            </td>
                                            <td class="text-center pl-2 tracking-wide border border-r-0">
                                                <a data="Delete" class="delete" title="Delete this user"
                                                    href="{{ url(getRoutePrefix() . '/delete-lead/' . $info->id) }}">
                                                    <button
                                                        class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                        <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                            class="p-1 w-7">
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @php $serialNo++; @endphp
                                    @endforeach
                                @endif
                                @php
                                    $associates = $processor
                                        ->createdUsers()
                                        ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])
                                        ->with('createdUsers')
                                        ->get();
                                @endphp
                                @foreach ($associates as $associate)
                                    @if ($associate->infos)
                                        @foreach ($associate->infos as $info)
                                            <tr>
                                                <td class=" pl-2 tracking-wide border border-l-0"> <input
                                                        class="mr-4 checkbox" type="checkbox" name="contact[]"
                                                        value="{{ $lead->id }}">{{ $serialNo }}</td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    <a title="Click to view files uploaded by this user"
                                                        class="text-blue-500 inline"
                                                        href="{{ url(getRoutePrefix() . '/lead/' . $info->user_id) }}">
                                                        {{ $info->b_fname }}
                                                    </a>
                                                </td>
                                                <td class=" pl-2 tracking-wide border border-l-0">
                                                    {{ $associate->email }}
                                                </td>
                                                <td class="text-center pl-2 tracking-wide border border-r-0">
                                                    <a class="delete" data="Delete" title="Delete this user"
                                                        href="{{ url(getRoutePrefix() . '/delete-lead/' . $info->id) }}">
                                                        <button
                                                            class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                            <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                                class="p-1 w-7">
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $serialNo++; @endphp
                                        @endforeach
                                    @endif
                                    @php
                                        $juniorAssociates = $associate
                                            ->createdUsers()
                                            ->whereIn('role', ['junior Associate', 'Borrower'])
                                            ->with('createdUsers')
                                            ->get();
                                    @endphp
                                    @foreach ($juniorAssociates as $jassociate)
                                        @if ($jassociate->infos)
                                            @forelse($jassociate->infos as $info)
                                                <tr>
                                                    <td class=" pl-2 tracking-wide border border-l-0"> <input
                                                            class="mr-4 checkbox" type="checkbox" name="contact[]"
                                                            value="{{ $lead->id }}">{{ $serialNo }}
                                                    </td>
                                                    <td class=" pl-2 tracking-wide border border-l-0">
                                                        <a title="Click to view files uploaded by this user"
                                                            class="text-blue-500 inline"
                                                            href="{{ url(getRoutePrefix() . '/lead/' . $info->user_id) }}">
                                                            {{ $info->b_fname }}
                                                        </a>
                                                    </td>
                                                    <td class=" pl-2 tracking-wide border border-l-0">
                                                        {{ $jassociate->email }}
                                                    </td>
                                                    <td class="text-center pl-2 tracking-wide border border-r-0">
                                                        <a data="Delete" class="delete" title="Delete this user"
                                                            href="{{ url(getRoutePrefix() . '/delete-lead/' . $info->id) }}">
                                                            <button
                                                                class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                                    class="p-1 w-7">
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php $serialNo++; @endphp
                                            @empty
                                                <tr>
                                                    <td>no data available</td>
                                                </tr>
                                            @endforelse
                                        @endif
                                        @php
                                            $borrowers = $jassociate
                                                ->createdUsers()
                                                ->where('role', 'Borrower')
                                                ->with('createdUsers')
                                                ->get();
                                        @endphp
                                        @foreach ($borrowers as $borrower)
                                            @if ($borrower->infos)
                                                @foreach ($borrower->infos as $info)
                                                    <tr>
                                                        <td class=" pl-2 tracking-wide border border-l-0">
                                                            <input class="mr-4 checkbox" type="checkbox" name="contact[]"
                                                                value="{{ $lead->id }}">{{ $serialNo }}
                                                        </td>
                                                        <td class=" pl-2 tracking-wide border border-l-0">
                                                            <a title="Click to view files uploaded by this user"
                                                                class="text-blue-500 inline"
                                                                href="{{ url(getRoutePrefix() . '/lead/' . $info->user_id) }}">
                                                                {{ $info->b_fname }}
                                                            </a>
                                                        </td>
                                                        <td class=" pl-2 tracking-wide border border-l-0">
                                                            {{ $borrower->email }}
                                                        </td>
                                                        <td class="text-center pl-2 tracking-wide border border-r-0">
                                                            <a data="Delete" class="delete" title="Delete this user"
                                                                href="{{ url(getRoutePrefix() . '/delete-lead/' . $info->id) }}">
                                                                <button
                                                                    class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                                    <img src="{{ asset('icons/trash.svg') }}"
                                                                        alt="" class="p-1 w-7">
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php $serialNo++; @endphp
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <button type="submit" disabled
                    class="dark:bg-white submitButton bg-gray-200 
                    cursor-help text-gray-500 shadow-md hover:shadow-none
                    rounded-md px-3 py-2 hover:text-blue-500 ">
                    Export Selected
                </button>
            </form>
        @endif
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        var checkboxes = $('.checkbox');
        var submitButton = $('.submitButton');
        checkboxes.click(function() {
            if (checkboxes.is(':checked')) {
                submitButton.removeClass('cursor-not-allowed')
                    .removeAttr('disabled');
            } else {
                submitButton.addClass('cursor-not-allowed')
                    .attr('disabled', true);
            }
        });
        $('.dataTables_length').append(checkbox);
        $(document).ready(function() {
            $('#user-table').DataTable({
                pageLength: 30,
                lengthMenu: [10, 20, 30, 50, 100, 200],
            });
        });
    </script>
@endsection
