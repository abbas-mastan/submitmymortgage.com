{{-- @if($currentrole === $superadminrole || $currentrole === 'Admin') --}}
<x-form.intake-modal-form />
{{-- @endif --}}
<div class="flex justify-evenly gap-8 align-center">
    <div class="sm:w-2/3 w-full">
        <div @class([
            'flex',
            'flex-col',
            'sm:flex-row',
            'justify-center' => $currentrole === 'Borrower',
            'justify-between' => $currentrole !== 'Borrower',
            'w-full',
            'gap-8',
            'mt-8',
        ])>
                <a href="{{ url(getRoutePrefix() . '/teams') }}" class="flex justify-center align-center flex-col">
                    <div
                        class="h-16  flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                        <img class="object-contain  sm:w-[100%] h-12  w-14" src="{{ asset('icons/Teams.svg') }}"
                            alt="">
                    </div>
                    <p class="text-center font-bold">Teams</p>
                </a>
         
            <a href="{{ url(getRoutePrefix() . '/projects') }}" class="flex justify-center align-center flex-col">
                <div
                    class="h-16  flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <img class="object-contain  sm:w-[100%] h-12  w-14" src="{{ asset('icons/Deals.svg') }}"
                        alt="">
                </div>
                <p class="text-center font-bold">{{ $currentrole === 'Borrower' ? 'Deal' : 'Deals' }}</p>
            </a>
           
                <a href="{{ url(getRoutePrefix() . '/new-users') }}" class="flex justify-center align-center flex-col">
                    <div
                        class="h-16 flex align-center justify-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                        <img class="object-contain  sm:w-[100%] h-12  w-14" src="{{ asset('icons/Users.svg') }}"
                            alt="">
                    </div>
                    <p class="text-center font-bold">Users</p>
                </a>
            <a href="{{ url(getRoutePrefix() . '/contacts') }}" class="flex justify-center align-center flex-col">
                <div
                    class="h-16 w-auto flex justify-center align-center rounded px-7 py-2 bg-gradient-to-b from-gradientStart to-gradientEnd">
                    <img class="object-contain  sm:w-[100%] h-12" src="{{ asset('icons/Marketing.svg') }}"
                        alt="">
                </div>
                <p class="text-center font-bold">Contacts</p>
            </a>
  
        </div>
        @if ($currentrole !== 'Borrower')
            <div class="px-8 py-5 flex rounded justify-between w-full mt-8 
            bg-gradient-to-b from-gradientStart to-gradientEnd">
                @if ($currentrole === 'Super Admin' || $currentrole === 'Processor')
                    <div class="text-white flex flex-col justify-center">
                        <h3 class="">Teams</h3>
                        <h2 class="text-center text-2xl">{{ count($teams) }}</h2>
                    </div>
                @endif
                <div class="text-white flex flex-col justify-center">
                    <h3 class="text-center">Opened <br class="lg:hidden block"> Deals</h3>
                    <h1 class="text-center text-2xl">{{ count($projects) }}
                    </h1>
                </div>
                <div class="text-white flex flex-col justify-center">
                    <h3 class="text-center">Closed <br class="lg:hidden block"> Deals</h3>
                    <h2 class="text-center text-2xl">{{ count($closedProjects) }}
                    </h2>
                </div>
            </div>
        @endif
        {{-- @if($currentrole === $superadminrole || $currentrole === 'Admin') --}}
            <div class="mt-8">
                <button class="newProject underline text-2xl mt-5 text-red-700 capitalize font-bold">
                    intake form submission
                </button>
            </div>
        {{-- @endif --}}
    </div>
    @if ($currentrole !== 'Borrower' && count(Auth::user()->notifications) > 0)
        <div class="pl-5 pr-1 shadow-lg rounded-xl md:w-1/3 w-full mt-8 bg-white">
            <ul class="menu overflow-y-auto max-h-[80vh]">
                @foreach (Auth::user()->notifications as $message)
                    <li class="font-bold px-5 pt-5 mb-5 list-disc list-inside">
                        <span class="textcolor">{{ $message->data['user_name'] }}</span>
                        @php
                            $project = \App\Models\Project::where('borrower_id', $message->data['user_id'])->first();
                        @endphp
                        @if ($project)
                            With <span class="textcolor">{{ \App\Models\Team::find($project->team_id)->name }}
                        @endif
                        </span>
                        {{ $message->data['message'] }}
                        @if ($project)
                            for
                            <span class="textcolor">
                                {{ $project->name }}
                            </span>
                            Group
                        @endif
                        <a  @if (!$message->read_at) href="{{ url(getRoutePrefix() . "/mark-as-read/$message->id")  }}"@endif>
                            @if (!$message->read_at)
                                <img class="inline w-4" src="{{ asset('icons/unread.png') }}" alt="">
                            @else
                                <img class="inline w-4" src="{{ asset('icons/read.png') }}" alt="">
                            @endif
                        </a>
                        <span class="text-xs">
                        {{$message->created_at->diffForHumans()}}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
