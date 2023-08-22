<table class="w-full overflow-x-scroll">
    <caption class="text-center font-bold mb-3">Category Wise Files Details</caption>
    <thead class="bg-gray-300">
        @if(json_decode($user->skipped_category))
        <div class="dropdown inline w-full">
            <button class="bg-gray-300 justify-center w-fit text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <span class="">Hidden Categories</span>
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </button>
            <ul class="dropdown-menu ml-1 w-fit hidden absolute text-gray-700 pt-1">
                @foreach (json_decode($user->skipped_category) as $categ)
                    <li class="flex rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">
                        {{ $categ }}
                        <a data="Unhide" class="delete tooltip inline-flex"
                            href="{{ url(getRoutePrefix() . '/hide-cat/' . $user->id . '/' . $categ) }}">
                            <img src="{{ asset('icons/unhide.svg') }}" class="ml-3 w-6 " alt="Unhide image">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        <tr>
            @php
                $header = ["S No.","Documents","Count","Submitted by Client","Verified by Us",
                " User's Comments" , "Your Comments", " Action"];
            @endphp
            @foreach ($header as $item)
                <th>{{$item}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
            $categories = config('smm.file_category');
            if (isset($user) && $user->categories()->exists()) {
                foreach ($user->categories()->get() as $cat) {
                    $categories[] = $cat->name;
                }
            }
        @endphp
        @foreach ($categories as $cat)
            @if (\App\Services\CommonService::filterCat($user, $cat))
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
                <td class="border-r-1 pl-2 tracking-wide border capitalize ">
                    <div
                        class="flex flex-col xxl:flex-row justify-center items-center xxl:space-x-4 space-y-2 xxl:space-y-0">
                        @if (fileCatVerified($cat, $user->id))
                            <img src="{{ asset('icons/tick.svg') }}" alt="" class="w-6 h-6">
                        @elseif (!fileCatVerified($cat, $user->id))
                            <img src="{{ asset('icons/cross.svg') }}" alt="" class="w-7 h-7">
                            @if (fileCatCount($cat, $user->id) > 0)
                                <form method="POST" action="{{ url(getRoutePrefix() . '/update-category-status') }}"
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
                <td class=" pl-2 tracking-wide border ">
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
                                        class="mr-3 bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-3 py-0.5  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </td>

                <td class="text-center tracking-wide border border-l-1">
                    <div class="flex justify-center">
                        @if (!in_array($cat, config('smm.file_category')))
                            <a class="delete tooltip" data="Delete"
                                href="{{ url(getRoutePrefix() . '/delete-category/' . $user->id . '/' . $cat) }}">
                                <img src="{{ asset('icons/trash.svg') }}" class="p-1 mr-2  bg-orange-600 w-6"
                                    alt="hide image">
                            </a>
                        @endif
                        @if (!empty($user->skipped_category) && in_array($cat, json_decode($user->skipped_category)))
                            <a class="delete tooltip" data="Unhide"
                                href="{{ url(getRoutePrefix() . '/hide-cat/' . $user->id . '/' . $cat) }}">
                                <img src="{{ asset('icons/unhide.svg') }}" class="bg--600 w-6 " alt="Unhide image">
                            </a>
                        @else
                            <a class="delete tooltip " data="Hide"
                                href="{{ url(getRoutePrefix() . '/hide-cat/' . $user->id . '/' . $cat) }}">
                                <img src="{{ asset('icons/hide.svg') }}" class="bg--600 w-6 " alt="hide image">
                            </a>
                        @endif
                    </div>

                </td>

            </tr>
            @php
                $count++;
            @endphp
        @endforeach
    </tbody>
</table>
<div class="flex justify-center mt-3">
    <div class="flex addCategoryBtn justify-center items-center">
        <button
            class="tracking-wide rounded-lg text-white px-10 py-0.5 text-xl capitalize bg-gradient-to-b from-gradientStart to-gradientEnd">
            Add Category +
        </button>
    </div>
</div>
@section('')
@endsection
