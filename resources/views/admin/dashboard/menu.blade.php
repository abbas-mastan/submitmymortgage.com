<div class="flex justify-evenly gap-8 align-center">
    <div class="sm:w-2/3 w-full">
        <div class="flex flex-col sm:flex-row justify-between w-full gap-8 mt-8">
            <a href="{{ url(getRoutePrefix() . '/projects') }}" class="flex justify-center align-center flex-col">
                <div
                    class="h-16  flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <img class="object-contain  sm:w-[100%] h-12  w-14" src="{{ asset('icons/Deals.svg') }}" alt="">
                </div>
                <p class="text-center font-bold">Deals</p>
            </a>
            <a href="{{ url(getRoutePrefix() . '/teams') }}" class="flex justify-center align-center flex-col">
                <div
                    class="h-16  flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <img class="object-contain  sm:w-[100%] " src="{{ asset('icons/Teams.svg') }}" alt="">
                </div>
                <p class="text-center font-bold">Teams</p>
            </a>
            @if (Auth::user()->role !== 'Borrower')
                
            <a href="{{ url(getRoutePrefix() . '/new-users') }}" class="flex justify-center align-center flex-col">
                <div
                    class="h-16 flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <img class="object-contain  sm:w-[100%] " src="{{ asset('icons/Users.svg') }}" alt="">
                </div>
                <p class="text-center font-bold">Users</p>
            </a>
            @endif

            <a href="{{ url(getRoutePrefix() . '/contacts') }}" class="flex justify-center align-center flex-col">
                <div
                    class="h-16 w-auto flex justify-center align-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <img class="object-contain  sm:w-[100%] h-12" src="{{ asset('icons/Marketing.svg') }}"
                        alt="">
                </div>
                <p class="text-center font-bold">Contacts</p>
            </a>
        </div>
        <div
            class="px-8 py-5 flex rounded justify-between w-full mt-8 
            bg-gradient-to-b from-gradientStart to-gradientEnd">
            <div class="text-white flex flex-col justify-center">
                <h3 class="">Teams</h3>
                <h2 class="text-center text-2xl">{{count($teams)}}</h2>
            </div>
            <div class="text-white flex flex-col justify-center">
                <h3 class="text-center">Opened <br class="lg:hidden block"> Deals</h3>
                <h1 class="text-center text-2xl">{{count(\App\Models\Application::where('status',1)->get())}}</h1>
            </div>
            <div class="text-white flex flex-col justify-center">
                <h3 class="text-center">Closed <br class="lg:hidden block"> Deals</h3>
                <h2 class="text-center text-2xl">{{count(\App\Models\Application::where('status',3)->get())}}</h2>
            </div>
        </div>
    </div>
    <div class="px-5 py-3 mt-5 shadow-lg rounded-xl md:w-1/3 w-full mt-8 bg-white">
        <ul>
            @foreach ([1, 2, 3, 4] as $message)
                <li class="mb-5 list-disc list-inside">
                    <span class="text-themered">Jasmine Saiedian</span> With <span class="text-themered">Copland
                        Group
                    </span>
                    Updated Bank Statment for
                    <span class="text-themered">
                        4500 Woodman Ave
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
