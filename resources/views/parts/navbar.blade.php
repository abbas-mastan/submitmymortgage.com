
<div class="w-full grid grid-cols-2 h-20 m-auto items-center justify-start bg-white shadow-md">
    <div class="col-span-1">
        <div class="flex flex-row">
            @can('isAdmin')
            <div class="pl-20">
                <span class="text-xl font-semibold" >
                        Admin Dashboard
                </span>
            </div>
            @endcan
            @can('isUser')
            <div class="pl-10">
                <span class="text-xl font-semibold" >
                        Mortgage Application Dashboard
                </span>
            </div>
            @endcan
        </div>
    </div>
    <div class="col-span-1 flex justify-end">
        <div class="flex mr-3">
            <div class="">
                <a href="{{ url(getRoutePrefix()."/profile") }}" class="">
                    <img class="rounded-full w-12 h-12" src="{{ asset(auth()->user()->pic) }}" alt="" srcset="">
                </a>
                
            </div>
            <div class="pt-3 ">
                <span class="ml-3 capitalize">Welcome, {{ auth()->user()->getFirstName()  }}</span>
            </div>
        </div>
        <div class="flex mr-3 pt-2 ">
            <a href="{{ url('/') }}" class="font-bold">
                <img src="{{ asset('icons/bell.svg') }}" alt="" class="">
            </a>
        </div>
        <div class=" mr-20 pt-3 ">
            <a href="{{ url('/logout') }}">
                <button class="font-bold px-2 bg-red-600 text-white">Logout</button>
            </a>
            
        </div>
    </div>
    
</div>