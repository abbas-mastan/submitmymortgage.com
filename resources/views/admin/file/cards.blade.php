<div class="w-full   my-2">
    <div class="w-full h-44 ">
        <a href="{{ url(getRoutePrefix() . '/files') }}">
            <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                <div class="w-1/2 p-4 pl-8">
                    <span class="text-white text-lg block text-left">Files Uploaded</span>
                    <span class="text-white text-2xl block text-left font-bold mt-1">
                        {{ $filesCount }}
                    </span>
                </div>
                <div class="w-1/2 pt-7 pr-7">
                    <img src="{{ asset('icons/disk.svg') }}" alt="" class="w-12 h-12 float-right mt-3 mr-4">
                </div>
            </div>
        </a>
    </div>
</div>
