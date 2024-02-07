{{-- @if ($currentrole === $superadminrole || $currentrole === 'Admin') --}}
<x-form.intake-modal-form :intake="$intake" />
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

            <a href="{{ url(getRoutePrefix() . '/all-users') }}" class="flex justify-center align-center flex-col">
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
            <div
                class="px-8 py-5 flex rounded justify-between w-full mt-8 
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
        {{-- @if ($currentrole === $superadminrole || $currentrole === 'Admin') --}}
        <div class="mt-8">
            <button class="newProject underline text-2xl mt-5 text-red-700 capitalize font-bold">
                intake form submission
            </button>
        </div>
        {{-- @endif --}}
    </div>
    @if ($currentrole !== 'Borrower' && count(Auth::user()->notifications) > 0)
        <div class="pl-5 pr-1 rounded-xl md:w-1/3 w-full mt-8">
            <h2 class="text-center text-xl font-bold">Notifications</h2>
            <ul class="menu overflow-y-auto max-h-[80vh] ">
                @foreach (Auth::user()->notifications as $message)
                    @php
                        if ($message->data['project'] ?? false) {
                            $project = \App\Models\Project::find($message->data['project']);
                        } else {
                            $project = \App\Models\Project::where('borrower_id', $message->data['user_id'])->first();
                        }
                    @endphp
                    <div
                        class="@if ($loop->first) mt-5 @endif rounded-sm bg-white p-5 mr-4 font-bold px-5 pt-5 mb-5 list-disc list-inside">
                        @if (!$project)
                            <div>
                                @if (isset($message->data['team']))
                                    <div>
                                        Team: <a class="textcolor">
                                            {{ $message->data['team'] }}
                                        </a>
                                    </div>
                                @else
                                    @if (isset($message->data['user_created']))
                                        User Name : <span class="textcolor">{{ $message->data['user_created'] }}</span>
                                    @else
                                        <div>
                                            <span class="textcolor">{{ $message->data['user_name'] }}</span>
                                            {{ $message->data['message'] ?? '' }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <div>
                                <div>
                                    Deal: <a class="textcolor"
                                        href="{{ url(getRoutePrefix() . '/project-overview/' . $project->borrower->id) }}">
                                        {{ $project->name ?? '' }}
                                    </a>
                                </div>
                                @isset($message->data['category'])
                                    <div>Doc Uploaded:
                                        <span class="textcolor">
                                            {{ $message->data['message'] }}
                                        </span>
                                    </div>
                                @endisset
                            </div>
                        @endif
                        <div>
                            @if (isset($message->data['category']))
                                Uploaded
                            @else
                                Created
                            @endif by:
                            <span class="textcolor">
                                {{ $message->data['user_name'] }}
                            </span>
                        </div>
                        @if (isSuperAdmin() && isset($message->data['company']))
                            <div>
                                Company:
                                <span class="textcolor">
                                    {{ \App\Models\Company::find($message->data['company'])->name }}
                                </span>
                            </div>
                        @endif
                        <div class="flex justify-end mt-2">
                            <span class="text-xs">
                                <span class="mr-1">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                                <a
                                    @if (!$message->read_at) href="{{ url(getRoutePrefix() . "/mark-as-read/$message->id") }}" @endif>
                                    @if (!$message->read_at)
                                        <img class="inline w-4" src="{{ asset('icons/unread.png') }}" alt="">
                                    @else
                                        <img class="inline w-4" src="{{ asset('icons/read.png') }}" alt="">
                                    @endif
                            </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    @endif
</div>