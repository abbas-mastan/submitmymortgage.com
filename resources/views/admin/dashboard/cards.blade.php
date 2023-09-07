<div class="w-full my-2">
    <div class="w-full h-44 " >
        <a href="{{url("/dashboard")}}">
            <div class="flex h-32 bg-gradient-to-b from-gradientStart to-gradientEnd">
                <div class="w-1/2 p-4 pl-8">
                    <span class="text-white text-lg block text-left">
                    All Users</span>
                    <span class="text-white text-2xl block text-left font-bold mt-1">
                        {{-- {{ $usersCount }}  --}}
                    </span>
                </div>
                <div class="w-1/2 pt-7 pr-7"> 
                    <img src="{{ asset('icons/user.svg') }}" alt="" class="z-20 float-right mt-3 mr-4">
                    <img src="{{ asset('icons/circle-big.svg') }}" alt="" class="z-10 opacity-10 float-right mt-1 -mr-11 w-20">
                    <img src="{{ asset('icons/circle-small.svg') }}" alt="" class="z-0 opacity-10 float-right mt-16 -mr-12 w-12">
                </div>
            </div>
        </a>
    </div>
</div>



