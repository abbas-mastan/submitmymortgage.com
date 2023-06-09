@extends('layouts.app')
@section('content')
    <div class="mt-10">
        <table class="w-full">
            <caption class="tas[i]-center font-bold mb-3">Application Status</caption>
            <thead class="bg-gray-300">
                <tr>
                    <th class=" pl-2 tracking-wide">
                        S No.
                    </th>
                    <th class="">
                        Documents
                    </th>
                    <th class="">
                        Count
                    </th>
                    <th class="">
                        Submitted by You
                    </th>
                    <th class="">
                        Verified
                    </th>
                    <th class="">
                        Provided Comments
                    </th>
                    <th class="">
                        Your Comments
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp
                @foreach (config('smm.file_category') as $cat)
                    @if ((auth()->user()->finance_type === 'Purchase' && $cat === 'Purchase Agreement') || $cat === 'Credit Report')
                        @continue
                    @endif
                    <tr>
                        <td class=" pl-2 tracking-wide border border-l-0">{{ $count }}</td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a href="{{ url(getUserRoutePrefix() . '/' . getCatLink($cat)) }}" class="">
                                {{ $cat }}
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                            @if ($cat !== 'Loan Application')
                                {{ fileCatCount($cat, $user->id) }}
                            @elseif(\App\Models\User::find(Auth::id())->application()->exists())
                                yes
                            @else
                                no
                            @endif
                        </td>
                        <td class=" pl-2 tracking-wide border capitalize">
                            <div class=" flex justify-center">
                                @if($cat !== 'Loan Application')
                                @if (fileCatSubmittedByClient($cat, $user->id))
                                    <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                                    @else
                                    <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                                    @endif
                                    @elseif($applicationsidebar)
                                    <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                                    @else
                                    <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                                @endif
                            </div>
                        </td>
                        <td class=" pl-2 tracking-wide border capitalize">
                            <div class="  flex justify-center space-x-4">
                                @if (fileCatVerified($cat, $user->id))
                                    <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                                @elseif (!fileCatVerified($cat, $user->id))
                                    <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                                @endif
                            </div>
                        </td>
                        <td class=" pl-2 tracking-wide border">
                            @if (fileCatCount($cat, $user->id) > 0)
                                {{ getCatComments($cat, $user->id) }}
                            @endif
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            @if (fileCatCount($cat, $user->id) > 0)
                                <form method="POST" action="{{ url(getUserRoutePrefix() . '/update-cat-comments') }}"
                                    class="">
                                    @csrf
                                    <div class="flex space-x-4">
                                        <input type="hidden" name="cat" value="{{ $cat }}">
                                        <div class="flex space-x-2">
                                            <textarea rows="1" class="rounded cat_comments" name="cat_comments" id="" cols="30">{{ getUserCatComments($cat, $user->id) }}</textarea>
                                        </div>
                                        <div class=" my-0.5">
                                            <button title="Add comments" type="submit"
                                                class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 tas[i]-white">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @php
                        $count++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('foot')
    <script>
        function getContent() {
            document.getElementById("my-textarea").value = document.getElementById("my-content").innerHTML;
        }
        //Textarea resizing partially solved
        (function() {
            let textarea = document.querySelectorAll(".cat_comments");
            for (let i = 0; i < textarea.length; i++) {
                textarea[i].addEventListener("click", () => {
                    textarea[i].setAttribute("rows", 5);
                });
                textarea[i].addEventListener("focusin", () => {
                    textarea[i].setAttribute("rows", 5);
                });
                textarea[i].addEventListener("focusout", () => {
                    textarea[i].setAttribute("rows", 1);
                });
            }
        })();
    </script>
@endsection
