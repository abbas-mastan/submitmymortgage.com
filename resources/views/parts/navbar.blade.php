<div class="w-full grid grid-cols-2 h-20 m-auto items-center justify-start bg-white shadow-md">
    <div class="col-span-1">
        <div class="flex flex-row">
            @can('isSuperAdmin')
                <div class="pl-20">
                    <span class="text-xl font-semibold">
                        <a href="{{ url(getRoutePrefix() . '/dashboard') }}">
                            Super Admin Dashboard
                        </a>
                    </span>
                </div>
            @endcan
            @can('isAdmin')
                <div class="pl-20">
                    <span class="text-xl font-semibold">
                        <a href="{{ url(getRoutePrefix() . '/dashboard') }}">
                            {{ session('role') === 'Processor' ? 'Processor ' : 'Admin' }}&nbsp;Dashboard
                        </a>
                    </span>
                </div>
            @endcan
            @can('isUser')
                <div class="pl-10">
                    <a href="{{ url('/dashboard') }}">
                        Mortgage Application Dashboard
                        </span>
                    </a>
                </div>
            @endcan
            @can('isAssociate')
                <div class="pl-10">
                    <a href="{{ url(getRoutePrefix() . '/dashboard') }}">
                        <span class="text-xl font-semibold">
                            {{ session('role') === 'Associate' ? 'Associate' : 'Junior Associate' }}
                            &nbsp;Dashboard
                        </span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
    <div class="col-span-1 flex justify-end">
        <a href="{{ url(getRoutePrefix() . '/profile') }}" class="flex mr-3">
            <div class="relative">
                <img class="rounded-full w-12 h-12" src="{{ asset(auth()->user()->pic ?? 'img/profile-default.svg') }}"
                    alt="" srcset="">
                    <svg class="profile-dropdown-btn absolute bottom-0 right-0 w-5 h-5 rounded-full bg-gray-300 border border-2 border-white" fill="none" height="35" width="35" shape-rendering="geometricPrecision"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
            </div>
            <div class="pt-3 ">
                <span class="ml-3 capitalize">Welcome, {{ auth()->user()->getFirstName() }}</span>
            </div>

        </a>
        <div class="flex mr-3 pt-2 ">
            <a href="{{ url('/') }}" class="font-bold">
                <img src="{{ asset('icons/bell.svg') }}" alt="" class="">
            </a>
            @php($unreadNotifications = count(Auth::user()->unreadnotifications))
            @if ($unreadNotifications > 0)
                <span
                    class="absolute bg-themered text-white rounded-full text-xs ml-4 px-1.5 py-0.5">{{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}</span>
            @endif
        </div>
        <div class=" mr-20 pt-3 ">
            @if (session('reLogin'))
                <form method="POST" action="{{ url('/logout-from-this-user') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ session('reLogin') }}">
                    <button title="login as this user" type="submit"
                        class="bg-themered tracking-wide text-white font-semibold capitalize px-2 ">
                        Logout from this user
                    </button>
                </form>
            @else
                <a href="{{ url('/logout') }}">
                    <button class="font-bold px-2 bg-red-600 text-white">Logout</button>
                </a>
            @endif
        </div>
    </div>
</div>
