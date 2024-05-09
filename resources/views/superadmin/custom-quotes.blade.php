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
    @include('parts.company-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Custom Quotes" titlecounts="{{ count($customQuotes) }}"
            iconurl="{{ asset('icons/Marketing.svg') }}" />
        <table class="w-full pt-7" id="{{ count($customQuotes) > 10 ? 'completed-table' : '' }}">
            <thead class="bg-gray-300 text-left" style="height: 40px;">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        Sr.NO
                    </th>
                    <th class="">
                        User Email
                    </th>
                    <th class="">
                        Phone
                    </th>
                    <th class="">
                        Full Name
                    </th>
                    <th class="">
                        Company Name
                    </th>
                    <th class="">
                        Plany Type
                    </th>
                    <th class="">
                        Created at
                    </th>
                    {{-- <th class="">
                        Actions
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($customQuotes as $quote)
                    <tr style="height:40px">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $loop->iteration }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->email }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->phone }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->name }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit company" class="inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $quote->id) }}" --}}>
                                {{ $quote->user->company->name }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $quote->plan_type }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ date('d/m/y', strtotime($quote->created_at)) }}
                        </td>
                        {{-- <td class=" pl-2 tracking-wide border border-r-0">
                            <a data="Disable" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-company/' . $quote->id) }}">
                                <button title="temporary delete"
                                    class="bg-themered  tracking-wide capitalize text-white px-2"> --}}
                                    {{-- <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7"> --}}
                                    {{-- Disable
                                </button>
                            </a>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endsection
