<div class="flex flex-col sm:flex-row justify-between w-full gap-8 mt-8">
    <a href="{{url(getRoutePrefix().'/projects')}}" class="flex justify-center align-center flex-col">
        <div class="h-16  flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
            <img class="object-contain  sm:w-[100%] h-14  w-14" src="{{ asset('icons/loan.png') }}" alt="">
        </div>
        <p class="text-center font-bold">Deals</p>
    </a>
    <a href="{{url(getRoutePrefix().'/teams')}}" class="flex justify-center align-center flex-col">
        <div class="h-16  flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
            <img class="object-contain  sm:w-[100%] " src="{{ asset('icons/team.png') }}" alt="">
        </div>
        <p class="text-center font-bold">Teams</p>
    </a>
    <a href="{{url(getRoutePrefix().'/new-users')}}" class="flex justify-center align-center flex-col">
        <div class="h-16 flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
            <img class="object-contain  sm:w-[100%] "  src="{{ asset('icons/user.svg') }}" alt="">
        </div>
        <p class="text-center font-bold">Users</p>
    </a>
    <a href="{{url(getRoutePrefix().'/contacts')}}" class="flex justify-center align-center flex-col">
        <div class="h-16 w-auto flex justify-center align-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
            <img class="object-contain  sm:w-[100%] h-12" src="{{ asset('icons/markeeting.png') }}" alt="">
        </div>
        <p class="text-center font-bold">Marketing</p>
    </a>
</div>
<div class="px-8 py-5 flex rounded justify-between w-full mt-8 bg-gradient-to-b from-gradientStart to-gradientEnd">
    <div class="text-white flex flex-col justify-center">
        <h3 class="">Teams</h3>
        <h2 class="text-center text-2xl">7</h2>
    </div>
    <div class="text-white flex flex-col justify-center">
        <h3 class="text-center">Opened <br class="lg:hidden block"> Deals</h3>
        <h1 class="text-center text-2xl">8</h1>
    </div>
    <div class="text-white flex flex-col justify-center">
        <h3 class="text-center">Closed <br class="lg:hidden block"> Deals</h3>
        <h2 class="text-center text-2xl">7</h2>
    </div>
</div>