<div class="mt-8 w-full my-2">
    <div class="w-full h-44 ">
        <span href="{{ url('/dashboard') }}">
            <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                <div class="w-1/2 p-4 pl-8">
                    <span class="capitalize text-white text-lg block text-left">{{$title}}</span>
                    <span id="{{$id ?? null}}" class="text-white text-2xl block text-left font-bold mt-1">
                        {{$titlecounts}}
                    </span>
                </div>
                <div class="w-1/2 flex justify-end align-center pr-7">
                    <img src="{{ $iconurl }}" alt="" class="z-20 w-[70px] float-right mr-4">
                </div>
            </div>
        </span>
    </div>
</div>
