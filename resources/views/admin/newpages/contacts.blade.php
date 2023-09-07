@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        #deleted-table_length,
        #user-table_length {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="flex-wrap flex-shrink-0 w-full">
        @if (Auth::user()->role != 'Borrower')
            <x-flex-card title="Contacts" titlecounts="{{ count($leads) }}" iconurl="{{ asset('icons/user.svg') }}" />
            <button class="absolute z-10 py-2 text-white bg-red-800 px-8 newProject">
                Add New Contact
            </button>
            <table class="w-full pt-7" id="deleted-table">
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
                            Loan Amount
                        </th>
                        <th class="">
                            Loan Type
                        </th>
                        <th class="">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (Auth::user()->role == 'Admin')
                        @foreach ($leads as $lead)
                            <tr class="text-center">
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ date('d/m/y', strtotime($lead->created_at)) }}
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
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $lead->loan_amount }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $lead->user->application->loan_type ?? null}}
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
                                            {{ $info->create_at }}
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
                                                <button class="bg-black  tracking-wide font-semibold capitalize text-xl">
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
                                            <td class=" pl-2 tracking-wide border border-l-0"> <input class="mr-4 checkbox"
                                                    type="checkbox" name="contact[]"
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
                                                                <img src="{{ asset('icons/trash.svg') }}" alt=""
                                                                    class="p-1 w-7">
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
        $('#selectall').click(function(e) {
            if ($(this).is(':checked')) {
                checkboxes.prop('checked', true);
                submitButton.removeClass('cursor-not-allowed')
                    .removeAttr('disabled');
            } else {
                checkboxes.prop('checked', false);
                submitButton.addClass('cursor-not-allowed')
                    .attr('disabled', true);
            }
        });

        checkboxes.click(function() {
            if (checkboxes.is(':checked')) {
                submitButton.removeClass('cursor-not-allowed')
                    .removeAttr('disabled');
            } else {
                submitButton.addClass('cursor-not-allowed')
                    .attr('disabled', true);
            }
        });
        $('.newProject').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').removeClass('hidden');
        });
        $('.closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('hidden');
        });
    </script>
@endsection
