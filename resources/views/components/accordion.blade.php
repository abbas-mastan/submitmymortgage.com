<div class="flex flex-wrap w-full">
    <div class="grid divide-y divide-neutral-200 w-full mt-8">
        <div class="py-2">
            <details class="group">
                <summary
                    class="{{ $color ?? 'bg-gradient-to-b from-gradientStart to-gradientEnd' }} text-white py-2 flex text-xl justify-between items-center font-medium cursor-pointer list-none">
                    <span class="px-5">{{ $title }}
                        @if (isset($count))
                            <span style="background: rgb(203 213 225); color:brown;" class="ml-2 bg-slate-300 red-700 font-medium text-sm border rounded-full  {{$count > 1 ? 'px-[7px]' : 'px-2'}} py-1">
                                {{$count}}
                            </span>
                        @endif
                    </span>
                    <span class="mr-4 transition group-open:rotate-180">
                        <svg fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </span>
                </summary>
                <p id="" class="toptable text-neutral-600 group-open:animate-fadeIn">
                    {{ $slot }}
                </p>
            </details>
        </div>
    </div>
</div>
