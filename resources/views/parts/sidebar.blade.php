<div class="sticky top-0 h-screen flex-shrink flex-grow-0 bg-gradient-to-b from-gradientStart to-gradientEnd">
    <div class="py-3 my-1 rounded-xl w-full">
        <ul class="flex justify-start gap-2 sm:gap-0 sm:flex-col overflow-hidden sm:content-center sm:justify-center">
            <li class="py-3 my-1 sm:px-24 mt-5 hidden sm:block ">
                <a class="truncate flex flex-col items-center" href="{{ url('/dashboard') }}">
                    {{-- <img src="//cdn.jsdelivr.net/npm/heroicons@1.0.1/outline/home.svg" class="w-7 sm:mx-2 mx-4 block " /> --}}
                    <span class="tracking-wide text-xl text-white ">Submit My <br class="xl:hidden"> Mortgage</span>
                </a>
            </li>
            @if (Gate::check('isAdmin') || Gate::check('isSuperAdmin'))
                <!-- Sidebar for Admin starts -->
                @if ($currentrole === $superadminrole)
                    <li class="mt-10 py-3 my-1 sm:px-24 flex flex-row">
                        <span
                            class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <a class="truncate ml-4" href="{{ url(getSuperAdminRoutePrefix() . '/companies') }}">
                            <span class="tracking-wide sm:block  capitalize text-white">Companies</span>
                        </a>
                    </li>
                    <li class="-mt-4 hidden sm:block">
                        <span class="border-l-4 border-l-white  border-opacity-20 h-14  vertical-line-m">
                            &nbsp;
                        </span>
                    </li>
                @endif
                <li class="pb-3 mb-1 sm:px-24 flex flex-row {{ $currentrole !== $superadminrole ? 'mt-10' : '' }}">
                    <span class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getRoutePrefix() . '/add-user/-1') }}">
                        <span class="tracking-wide sm:block  capitalize text-white">Create New User</span>
                    </a>
                </li>
                <li class="-mt-4 hidden sm:block">
                    <span class="border-l-4 border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                @if (session('role') === 'Processor')
                    <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                        <span
                            class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <a class="truncate ml-4" href="{{ url(getRoutePrefix() . '/application/-1') }}">
                            <span class="tracking-wide sm:block  capitalize text-white">Loan Application</span>
                        </a>
                    </li>

                    <li class="-mt-4 hidden sm:block">
                        <span class="border-l-4 border-l-white  border-opacity-20 h-14  vertical-line-m">
                            &nbsp;
                        </span>
                    </li>
                @endif
                <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                    <span class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getRoutePrefix() . '/all-users') }}">
                        <span class="tracking-wide sm:block  capitalize text-white">All Users </span>
                    </a>
                </li>
                <li class="-mt-4 hidden sm:block">
                    <span class="border-l-4 border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                    <span class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getRoutePrefix() . '/contacts') }}">
                        <span class="tracking-wide sm:block  capitalize text-white">Contacts</span>
                    </a>
                </li>
                @if ($currentrole === 'Admin' || Gate::check('isSuperAdmin'))
                    <x-tab href="connections" title="Connections" />
                @endif
                <x-tab href="loan-intake" title="Loan Intakes" />
                <x-tab href="applications" title="Loan Pipeline" />
                <x-tab href="upload-files" title="Upload Files" />
                <x-tab href="files" title="Files Uploaded" />
                <li class="-mt-4 hidden sm:block">
                    <span class="border-l-4 border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                    <span
                        class="hidden h-6 sm:block border-4 {{ Auth::user()->accessToken ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" style="{{ !Auth::user()->accessToken ? 'margin-top:-5px;' : '' }}"
                        href="{{ url(Auth::user()->accessToken ? '/gmail-inbox' : '/gmail/auth') }}">
                        @if (Auth::user()->accessToken)
                            <span class="tracking-wide sm:block capitalize text-themegreen ">Gmail Inbox</span>
                        @else
                            <div class="px-4 inline-flex pt-1 bg-white shadow rounded-full">
                                <span class="mt-1 mr-3">
                                    Sign in with Google
                                </span>
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    data-name="Layer 1" viewBox="0 0 32 32" id="gmail">
                                    <path fill="#ea4435"
                                        d="M16.58,19.1068l-12.69-8.0757A3,3,0,0,1,7.1109,5.97l9.31,5.9243L24.78,6.0428A3,3,0,0,1,28.22,10.9579Z">
                                    </path>
                                    <path fill="#00ac47"
                                        d="M25.5,5.5h4a0,0,0,0,1,0,0v18a3,3,0,0,1-3,3h0a3,3,0,0,1-3-3V7.5a2,2,0,0,1,2-2Z"
                                        transform="rotate(180 26.5 16)"></path>
                                    <path fill="#ffba00"
                                        d="M29.4562,8.0656c-.0088-.06-.0081-.1213-.0206-.1812-.0192-.0918-.0549-.1766-.0823-.2652a2.9312,2.9312,0,0,0-.0958-.2993c-.02-.0475-.0508-.0892-.0735-.1354A2.9838,2.9838,0,0,0,28.9686,6.8c-.04-.0581-.09-.1076-.1342-.1626a3.0282,3.0282,0,0,0-.2455-.2849c-.0665-.0647-.1423-.1188-.2146-.1771a3.02,3.02,0,0,0-.24-.1857c-.0793-.0518-.1661-.0917-.25-.1359-.0884-.0461-.175-.0963-.267-.1331-.0889-.0358-.1837-.0586-.2766-.0859s-.1853-.06-.2807-.0777a3.0543,3.0543,0,0,0-.357-.036c-.0759-.0053-.1511-.0186-.2273-.018a2.9778,2.9778,0,0,0-.4219.0425c-.0563.0084-.113.0077-.1689.0193a33.211,33.211,0,0,0-.5645.178c-.0515.022-.0966.0547-.1465.0795A2.901,2.901,0,0,0,23.5,8.5v5.762l4.72-3.3043a2.8878,2.8878,0,0,0,1.2359-2.8923Z">
                                    </path>
                                    <path fill="#4285f4"
                                        d="M5.5,5.5h0a3,3,0,0,1,3,3v18a0,0,0,0,1,0,0h-4a2,2,0,0,1-2-2V8.5a3,3,0,0,1,3-3Z">
                                    </path>
                                    <path fill="#c52528"
                                        d="M2.5439,8.0656c.0088-.06.0081-.1213.0206-.1812.0192-.0918.0549-.1766.0823-.2652A2.9312,2.9312,0,0,1,2.7426,7.32c.02-.0475.0508-.0892.0736-.1354A2.9719,2.9719,0,0,1,3.0316,6.8c.04-.0581.09-.1076.1342-.1626a3.0272,3.0272,0,0,1,.2454-.2849c.0665-.0647.1423-.1188.2147-.1771a3.0005,3.0005,0,0,1,.24-.1857c.0793-.0518.1661-.0917.25-.1359A2.9747,2.9747,0,0,1,4.3829,5.72c.089-.0358.1838-.0586.2766-.0859s.1853-.06.2807-.0777a3.0565,3.0565,0,0,1,.357-.036c.076-.0053.1511-.0186.2273-.018a2.9763,2.9763,0,0,1,.4219.0425c.0563.0084.113.0077.169.0193a2.9056,2.9056,0,0,1,.286.0888,2.9157,2.9157,0,0,1,.2785.0892c.0514.022.0965.0547.1465.0795a2.9745,2.9745,0,0,1,.3742.21A2.9943,2.9943,0,0,1,8.5,8.5v5.762L3.78,10.9579A2.8891,2.8891,0,0,1,2.5439,8.0656Z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </a>
                </li>
                <!-- Sidebar for Admin ends -->
            @endif
            @can('isAssociate')
                <li class="mt-10 py-3 my-1 sm:px-24 flex flex-row">
                    <span class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getAssociateRoutePrefix() . '/add-user/-1') }}">
                        <span class="tracking-wide sm:block  capitalize text-white">Create New User</span>
                    </a>
                </li>
                <x-tab href="application/-1" title="Loan Application" />
                <x-tab href="all-users" title="All Users" />
                <x-tab href="upload-files" title="Upload Files" />
                <x-tab href="files" title="Files Uploaded" />
                <x-tab href="applications" title="Loan Pipeline" />
                <x-tab href="loan-intake" title="Loan Intake" />
                <x-tab href="contacts" title="Contacts" />
                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                    <span
                        class="hidden h-6 sm:block border-4 {{ Auth::user()->accessToken ? 'border-themegreen' : 'border-white border-opacity-20' }}  rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" style="{{ !Auth::user()->accessToken ? 'margin-top:-5px;' : '' }}"
                        href="{{ url(Auth::user()->accessToken ? '/gmail-inbox' : '/gmail/auth') }}">
                        @if (Auth::user()->accessToken)
                            <span class="tracking-wide sm:block  capitalize text-themegreen"> Gmail Inbox</span>
                        @else
                            <div class="px-4 inline-flex pt-1 bg-white shadow  rounded-full">
                                <span class="mt-1 mr-3">
                                    Sign in with Google
                                </span>
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    data-name="Layer 1" viewBox="0 0 32 32" id="gmail">
                                    <path fill="#ea4435"
                                        d="M16.58,19.1068l-12.69-8.0757A3,3,0,0,1,7.1109,5.97l9.31,5.9243L24.78,6.0428A3,3,0,0,1,28.22,10.9579Z">
                                    </path>
                                    <path fill="#00ac47"
                                        d="M25.5,5.5h4a0,0,0,0,1,0,0v18a3,3,0,0,1-3,3h0a3,3,0,0,1-3-3V7.5a2,2,0,0,1,2-2Z"
                                        transform="rotate(180 26.5 16)"></path>
                                    <path fill="#ffba00"
                                        d="M29.4562,8.0656c-.0088-.06-.0081-.1213-.0206-.1812-.0192-.0918-.0549-.1766-.0823-.2652a2.9312,2.9312,0,0,0-.0958-.2993c-.02-.0475-.0508-.0892-.0735-.1354A2.9838,2.9838,0,0,0,28.9686,6.8c-.04-.0581-.09-.1076-.1342-.1626a3.0282,3.0282,0,0,0-.2455-.2849c-.0665-.0647-.1423-.1188-.2146-.1771a3.02,3.02,0,0,0-.24-.1857c-.0793-.0518-.1661-.0917-.25-.1359-.0884-.0461-.175-.0963-.267-.1331-.0889-.0358-.1837-.0586-.2766-.0859s-.1853-.06-.2807-.0777a3.0543,3.0543,0,0,0-.357-.036c-.0759-.0053-.1511-.0186-.2273-.018a2.9778,2.9778,0,0,0-.4219.0425c-.0563.0084-.113.0077-.1689.0193a33.211,33.211,0,0,0-.5645.178c-.0515.022-.0966.0547-.1465.0795A2.901,2.901,0,0,0,23.5,8.5v5.762l4.72-3.3043a2.8878,2.8878,0,0,0,1.2359-2.8923Z">
                                    </path>
                                    <path fill="#4285f4"
                                        d="M5.5,5.5h0a3,3,0,0,1,3,3v18a0,0,0,0,1,0,0h-4a2,2,0,0,1-2-2V8.5a3,3,0,0,1,3-3Z">
                                    </path>
                                    <path fill="#c52528"
                                        d="M2.5439,8.0656c.0088-.06.0081-.1213.0206-.1812.0192-.0918.0549-.1766.0823-.2652A2.9312,2.9312,0,0,1,2.7426,7.32c.02-.0475.0508-.0892.0736-.1354A2.9719,2.9719,0,0,1,3.0316,6.8c.04-.0581.09-.1076.1342-.1626a3.0272,3.0272,0,0,1,.2454-.2849c.0665-.0647.1423-.1188.2147-.1771a3.0005,3.0005,0,0,1,.24-.1857c.0793-.0518.1661-.0917.25-.1359A2.9747,2.9747,0,0,1,4.3829,5.72c.089-.0358.1838-.0586.2766-.0859s.1853-.06.2807-.0777a3.0565,3.0565,0,0,1,.357-.036c.076-.0053.1511-.0186.2273-.018a2.9763,2.9763,0,0,1,.4219.0425c.0563.0084.113.0077.169.0193a2.9056,2.9056,0,0,1,.286.0888,2.9157,2.9157,0,0,1,.2785.0892c.0514.022.0965.0547.1465.0795a2.9745,2.9745,0,0,1,.3742.21A2.9943,2.9943,0,0,1,8.5,8.5v5.762L3.78,10.9579A2.8891,2.8891,0,0,1,2.5439,8.0656Z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </a>
                </li>
            @endcan
            @can('isUser')
                <!-- Sidebar for Admin starts -->
                <li class="my-1 sm:px-24 mt-5 sm:block   -ml-14">
                    <span class="tracking-wide text-2xl text-white text-left ">Loan Status</span>
                </li>
                <li class="py-5 sm:px-24 flex flex-row justify-left ">
                    <a class="-ml-16 truncate ml-4 text-md border-2 border-white rounded-md bg-white px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        href="{{ url(getUserRoutePrefix() . '/application-status') }}">
                        See My Loan Status
                    </a>
                </li>
                <li class="mb-5 my-1 sm:px-24 mt-5 sm:block -ml-14">
                    <span class="tracking-wide text-2xl text-white text-left ">Required Documents</span>
                </li>
                @php
                    $categories = config('smm.file_category');
                    array_unshift($categories, 'Basic Info');
                    if (
                        Auth::user()
                            ->categories()
                            ->exists()
                    ) {
                        Auth::user()->load('categories');
                        foreach (Auth::user()->categories as $cat) {
                            $categories[] = $cat->name;
                        }
                    }
                @endphp
                @foreach ($categories as $cat)
                    @if (\App\Services\CommonService::filterCat($user ?? Auth::user(), $cat))
                        @continue
                    @endif
                    <li class="py-3 sm:px-24 flex flex-row {{ $cat == 'Basic Info' ? 'mt-5' : '' }} mt-10 sm:-mt-3">
                        <span
                            class="hidden sm:block  border-4 {{ getVariable($cat) ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/' . getCatLink($cat)) }}">
                            <span
                                class="tracking-wide sm:block  capitalize {{ getVariable($cat) ? 'text-themegreen' : 'text-white   opacity-60' }}">{{ $cat }}</span>
                        </a>
                    </li>
                    <li class="-mt-3 hidden sm:block">
                        <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                            &nbsp;
                        </span>
                    </li>
                @endforeach

                <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                    <span
                        class="hidden h-6 sm:block border-4 {{ Auth::user()->accessToken ? 'border-themegreen' : 'border-white border-opacity-20' }}  rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" style="{{ !Auth::user()->accessToken ? 'margin-top:-5px;' : '' }}"
                        href="{{ url(Auth::user()->accessToken ? '/gmail-inbox' : '/gmail/auth') }}">
                        @if (Auth::user()->accessToken)
                            <span class="tracking-wide sm:block capitalize text-themegreen"> Gmail Inbox</span>
                        @else
                            <div class="px-4 inline-flex pt-1 bg-white shadow  rounded-full">
                                <span class="mt-1 mr-3">
                                    Sign in with Google
                                </span>
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    data-name="Layer 1" viewBox="0 0 32 32" id="gmail">
                                    <path fill="#ea4435"
                                        d="M16.58,19.1068l-12.69-8.0757A3,3,0,0,1,7.1109,5.97l9.31,5.9243L24.78,6.0428A3,3,0,0,1,28.22,10.9579Z">
                                    </path>
                                    <path fill="#00ac47"
                                        d="M25.5,5.5h4a0,0,0,0,1,0,0v18a3,3,0,0,1-3,3h0a3,3,0,0,1-3-3V7.5a2,2,0,0,1,2-2Z"
                                        transform="rotate(180 26.5 16)"></path>
                                    <path fill="#ffba00"
                                        d="M29.4562,8.0656c-.0088-.06-.0081-.1213-.0206-.1812-.0192-.0918-.0549-.1766-.0823-.2652a2.9312,2.9312,0,0,0-.0958-.2993c-.02-.0475-.0508-.0892-.0735-.1354A2.9838,2.9838,0,0,0,28.9686,6.8c-.04-.0581-.09-.1076-.1342-.1626a3.0282,3.0282,0,0,0-.2455-.2849c-.0665-.0647-.1423-.1188-.2146-.1771a3.02,3.02,0,0,0-.24-.1857c-.0793-.0518-.1661-.0917-.25-.1359-.0884-.0461-.175-.0963-.267-.1331-.0889-.0358-.1837-.0586-.2766-.0859s-.1853-.06-.2807-.0777a3.0543,3.0543,0,0,0-.357-.036c-.0759-.0053-.1511-.0186-.2273-.018a2.9778,2.9778,0,0,0-.4219.0425c-.0563.0084-.113.0077-.1689.0193a33.211,33.211,0,0,0-.5645.178c-.0515.022-.0966.0547-.1465.0795A2.901,2.901,0,0,0,23.5,8.5v5.762l4.72-3.3043a2.8878,2.8878,0,0,0,1.2359-2.8923Z">
                                    </path>
                                    <path fill="#4285f4"
                                        d="M5.5,5.5h0a3,3,0,0,1,3,3v18a0,0,0,0,1,0,0h-4a2,2,0,0,1-2-2V8.5a3,3,0,0,1,3-3Z">
                                    </path>
                                    <path fill="#c52528"
                                        d="M2.5439,8.0656c.0088-.06.0081-.1213.0206-.1812.0192-.0918.0549-.1766.0823-.2652A2.9312,2.9312,0,0,1,2.7426,7.32c.02-.0475.0508-.0892.0736-.1354A2.9719,2.9719,0,0,1,3.0316,6.8c.04-.0581.09-.1076.1342-.1626a3.0272,3.0272,0,0,1,.2454-.2849c.0665-.0647.1423-.1188.2147-.1771a3.0005,3.0005,0,0,1,.24-.1857c.0793-.0518.1661-.0917.25-.1359A2.9747,2.9747,0,0,1,4.3829,5.72c.089-.0358.1838-.0586.2766-.0859s.1853-.06.2807-.0777a3.0565,3.0565,0,0,1,.357-.036c.076-.0053.1511-.0186.2273-.018a2.9763,2.9763,0,0,1,.4219.0425c.0563.0084.113.0077.169.0193a2.9056,2.9056,0,0,1,.286.0888,2.9157,2.9157,0,0,1,.2785.0892c.0514.022.0965.0547.1465.0795a2.9745,2.9745,0,0,1,.3742.21A2.9943,2.9943,0,0,1,8.5,8.5v5.762L3.78,10.9579A2.8891,2.8891,0,0,1,2.5439,8.0656Z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </a>
                </li>
                <!-- Sidebar for user ends -->
            @endcan
        </ul>

    </div>
</div>
