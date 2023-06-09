<table class="w-full overflow-x-scroll">
    <caption class="text-center font-bold mb-3">Category Wise Files Details</caption>
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
                Submitted by Client
            </th>
            <th class="">
                Verified by Us
            </th>
            <th class="">
                User's Comments
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
            @if ($cat === 'Credit Report')
                @continue
            @endif
            <tr>
                <td class=" pl-2 tracking-wide border border-l-0">{{ $count }}</td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    <a href="{{ url(getRoutePrefix() . '/docs/' . $user->id . '/' . str_replace('/', '-', $cat)) }}"
                        class="hover:text-blue-700">
                        {{ $cat }}
                    </a>
                </td>
                <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                    @if ($cat !== 'Loan Application')
                        {{ fileCatCount($cat, $user->id) }}
                    @elseif(\App\Models\User::find($user->id)->application()->exists())
                        yes
                    @else
                        no
                    @endif

                </td>
                <td class=" pl-2 tracking-wide border capitalize">
                    <div class=" flex justify-center">
                        @if ($cat !== 'Loan Application')
                            @if (fileCatSubmittedByClient($cat, $user->id))
                                <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                            @else
                                <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                            @endif
                        @elseif(\App\Models\User::find($user->id)->application()->exists())
                            <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                        @else
                            <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                        @endif
                    </div>
                </td>
                <td class=" pl-2 tracking-wide border capitalize">
                    <div
                        class="  flex flex-col xxl:flex-row justify-center items-center xxl:space-x-4 space-y-2 xxl:space-y-0">
                        @if (fileCatVerified($cat, $user->id))
                            <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                        @elseif (!fileCatVerified($cat, $user->id))
                            <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                            @if (fileCatCount($cat, $user->id) > 0)
                                <form method="POST"
                                    action="{{ url(getRoutePrefix() . '/update-category-status') }}"
                                    class="">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="category" value="{{ $cat }}">
                                    <input type="hidden" name="status" value="Verified">
                                    <button title="Verify this whole category" class="hover:text-blue-700 ">
                                        Verify
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </td>
                <td class=" pl-2 tracking-wide border capitalize">
                    <div class="text-sm">
                        {{ getUserCatComments($cat, $user->id) }}
                    </div>
                </td>
                <td class=" pl-2 tracking-wide border border-r-0">
                    @if (fileCatCount($cat, $user->id) > 0)
                        <form id="status-form" method="POST"
                            action="{{ url(getRoutePrefix() . '/update-cat-comments/' . str_replace('/', '-', $cat)) }}"
                            class="">
                            @csrf
                            <div class="flex space-x-4">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="flex space-x-2">
                                    <textarea class="rounded comments" name="cat_comments" id="" cols="30" rows="1">{{ getCatComments($cat, $user->id) }}</textarea>
                                </div>
                                <div class=" my-0.5">
                                    <button title="Save category comments" type="submit"
                                        class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
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
