@extends('layouts.app')
@section('title', 'Gmail Inbox')
@section('content')
    <div class="w-full   my-2">
        <div class="w-full h-44 ">
            <a>
                <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <div class="w-1/2 p-4 pl-8">
                        <span class="text-white text-lg block text-left">&nbsp;&nbsp;</span>
                        <span class="text-white text-2xl block text-left font-bold mt-1">
                            Gmail Inbox
                        </span>
                    </div>
                    <div class="w-1/2 pt-7 pr-7">
                        <img src="{{ asset('icons/disk.svg') }}" alt="" class="w-12 h-12 float-right mt-3 mr-4">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <hr>
    <div class="w-full my-4">
        <table class="table-auto w-full">
            <thead class="bg-gradient-to-b from-gradientStart to-gradientEnd text-white py-8">
                <tr>
                    <th class="p-2">Gmail from</th>
                    <th colspan="2">Total attachments</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fullMessages as $message)
                    @if ($message->getPayload())
                        @php
                            $string = $message->getPayload()->getHeaders()[5]['value'];
                            if (preg_match('/smtp\.mailfrom=([^;]+)/', $string, $matches)) {
                                $email = trim($matches[1]);
                            } else {
                                $string = $message->getPayload()->getHeaders()[6]['value'];
                                if (preg_match('/header\.i=@([^;\s]+)/', $string, $matches)) {
                                    $email = trim($matches[1]);
                                }
                            }
                            
                        @endphp
                        <tr class="bg-gray-200">
                            <td class="p-2" colspan="2">{{ $email ?? '' }}</td>
                            <td colspan="2">
                                @foreach ($message->getPayload()->getParts() as $key => $part)
                                    @if ($part->filename)
                                        <a href="{{ route('download', ['messageId' => $message->getId(), 'attachmentId' => $part['body']['attachmentId'], 'attachmentIndexId' => $part->getPartId()]) }}"
                                            class="mr-2 bg-blue-500  btn-primary btn-success px-3 py-1 rounded text-white">
                                            {{ $part->filename }}
                                        </a>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {!! $fullMessages->links() !!}
    </div>
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script>
        $('nav > div a:first-child').each(function() {
            var href = $(this).attr('href');
            var newurl = href.replace("/",'/gmail-inbox');
            $(this).attr('href',newurl);
        });
        $('nav > div a:last-child').each(function() {
            var href = $(this).attr('href');
            var newurl = href.replace("/",'/gmail-inbox');
            $(this).attr('href',newurl);
        });
    </script>
@endsection
@endsection
