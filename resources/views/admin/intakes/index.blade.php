@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        .dataTables_empty {
            display: none;
        }
    </style>
@endsection
@section('content')
    @can('isUser')
        @include('user.dashboard.upload')
    @endcan
    <div class="flex-wrap flex-shrink-0 w-full">
        <div class="w-full my-2">
            <div class="w-full h-44 ">
                <a href="{{ url('/dashboard') }}">
                    <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                        <div class="w-1/2 p-4 pl-8">
                            <span class="text-white text-lg block text-left">Intake Forms</span>
                            <span class="text-white text-2xl block text-left font-bold mt-1">
                                {{ $intakes->count() }}
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
                </a>
            </div>
        </div>
        @foreach ($tables as $key => $table)
            @php $serialNo = 1; @endphp
            {{-- <h2 class="text-center text-themered text-2xl font-semibold">{{ $table }}</h2> --}}
            <table class="w-full display" id="{{ count($intakes) > 10 ? getTableId($key) : null }}">
                <x-table-head />
                <tbody class="text-center">
                    @foreach ($intakes as $intake)
                        @if ($intake->status == $key)
                            <tr>
                                <td class="verifiedSerial pl-2 tracking-wide border border-l-0">{{ $serialNo }}</td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    <a title="Click to view this intake" class="text-blue-500 inline"
                                        href="{{ url(getRoutePrefix() . '/loan-intake/' . $intake->id) }}">
                                        {{ $intake->name }}
                                    </a>
                                    {{-- <a title="Click to Edit this intake"
                                            href="{{ url(getRoutePrefix() . '/intake-edit/' . $intake->id) }}">
                                            <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                        </a> --}}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $intake->email }}
                                </td>
                                <td class=" pl-2 tracking-wide border border-l-0">
                                    {{ $intake->user->createdBy->name ?? null }} |
                                    {{ $intake->user->createdBy->role ?? null }}
                                </td>
                                <td class="text-center pl-2 tracking-wide border border-r-0">
                                    {{-- @if ($key !== 3)
                                        <a class="delete"
                                            data="{{ $currentrole === $superadminrole ? 'temporary' : 'Delete' }}"
                                            title="Click to Delete this intake"
                                            href="{{ url(getRoutePrefix() . '/intake-update-status/' . $intake->id . '/delete') }}">
                                            <button class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                            </button>
                                        </a>
                                    @endif
                                    @if ($key == 0)
                                        <a class="delete mx-2" data="Accept" title="Click to Accept this intake"
                                            href="{{ url(getRoutePrefix() . '/intake-update-status/' . $intake->id . '/accept') }}">
                                            <button class="bg-black tracking-wide font-semibold capitalize text-xl">
                                                <img src="{{ asset('icons/tick.svg') }}" alt="" class="p-1 w-7">
                                            </button>
                                        </a>
                                        <a class="delete" data="Reject" title="Click to Reject this intake"
                                            href="{{ url(getRoutePrefix() . '/intake-update-status/' . $intake->id . '/reject') }}">
                                            <button class="bg-black  tracking-wide font-semibold capitalize text-xl">
                                                <img src="{{ asset('icons/cross.svg') }}" alt="" class="p-1 w-7">
                                            </button>
                                        </a>
                                    @endif
                                    @if ($key === 3)
                                        <a class="delete mx-2" data="Restore" title="Click to restore this intake"
                                            href="{{ url(getRoutePrefix() . '/intake-update-status/' . $intake->id . '/restore') }}">
                                            <button class="bg-themered tracking-wide font-semibold capitalize text-xl">
                                                <img src="{{ asset('icons/restore.svg') }}" alt="" class="p-1 w-7">
                                            </button>
                                        </a>
                                    @endif --}}
                                </td>
                            </tr>
                            @php $serialNo++; @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endforeach
        @can('isUser')
            @include('user.dashboard.cards')
        @endcan
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        var verifiedSerialText = $('.verifiedSerial').text();



        $('[data="Reject"]').attr('title', 'Reject This Deal');
        $('[data="Accept"]').attr('title', 'Accept This Deal');
        $('[title="Delete this user"]').attr('title', 'Delete This Deal');
        var verifiedSerialText = $('.verifiedSerial').text();
        if (verifiedSerialText.length > 0) {
            $('.dataTables_empty').css('display:none');
        } else {
            $('.dataTables_empty').css('display:block');
        }
    </script>
@endsection
