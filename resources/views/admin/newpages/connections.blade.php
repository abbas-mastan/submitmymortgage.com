@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
 @endsection
@section('content')
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Connections" titlecounts="{{ count($connections) }}" iconurl="{{ asset('icons/Marketing.svg') }}" />
        <table class="w-full pt-7" id="deleted-table">
            <thead class="bg-gray-300">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        S.No
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
                @foreach ($connections as $connection)
                    <tr class="text-center">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{$loop->index+1}}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit contact" class="text-blue-500 inline"
                                {{-- href="{{ url(getRoutePrefix() . '/contact/' . $connection->id) }}" --}}>
                                {{ $connection->name }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $connection->email }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $connection->role }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            @if($connection->createdBy())
                            {{ $connection->createdBy->name ?? null }}{{$connection->createdBy->name !== null ? ' | ':''}}{{$connection->createdBy->role ?? null}}
                            @endif
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a data="Delete" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-connection/' . $connection->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </td>
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
