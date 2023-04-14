<div class=" flex-shrink flex-grow-0 bg-gradient-to-b from-gradientStart to-gradientEnd">
    <div
        class="sticky top-0 py-3 my-1 bg-white rounded-xl w-full h-full bg-gradient-to-b from-gradientStart to-gradientEnd">
        <ul class="flex justify-start gap-2 sm:gap-0 sm:flex-col overflow-hidden sm:content-center sm:justify-center">
            <li class="py-3 my-1 sm:px-24 mt-5 hidden sm:block ">
                <a class="truncate flex flex-col items-center" href="{{ url('/dashboard') }}">
                    {{-- <img src="//cdn.jsdelivr.net/npm/heroicons@1.0.1/outline/home.svg" class="w-7 sm:mx-2 mx-4 block " /> --}}
                    <span class="tracking-wide text-xl text-white ">Submit My <br class="xl:hidden"> Mortgage</span>
                </a>
            </li>
            {{-- <li class="pt-0 sm:px-24 ">
                <a class="truncate flex flex-col items-center" href="{{ url('/dashboard') }}">
                    <img src="{{ asset('img/logo.svg') }}" class="w-20 sm:mx-2 mx-4 block" />

                </a>
            </li> --}}

            @can('isAdmin')
                <!-- Sidebar for admin starts -->
                @if (session('role') === 'admin')
                    <li class="mt-10 py-3 my-1 sm:px-24 flex flex-row">
                        <span class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <a class="truncate ml-4" href="{{ url(getAdminRoutePrefix() . '/add-user/-1') }}">

                            <span class="tracking-wide sm:block  capitalize text-white">Create New User</span>
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
                    <a class="truncate ml-4" href="{{ url(getAdminRoutePrefix() . '/files') }}">

                        <span class="tracking-wide sm:block  capitalize text-white">Files Uploaded</span>
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
                    <a class="truncate ml-4" href="{{ url(Auth::user()->accessToken ? '/gmail-inbox' : '/gmail/auth') }}">
                        <span
                            class="tracking-wide sm:block  capitalize text-white">{{ Auth::user()->accessToken ? 'Gmail Inbox' : 'Connect Mail' }}</span>
                    </a>
                </li>
                {{-- <li class="-mt-3">
                <span class="border-l-4 border-l-gray-400 h-14 ml-11">
                    &nbsp;
                </span>
            </li> --}}
                <!-- Sidebar for admin ends -->
            @endcan
            @can('isUser')
                <!-- Sidebar for admin starts -->
                <li class="my-1 sm:px-24 mt-5 sm:block   -ml-14">
                    <span class="tracking-wide text-2xl text-white text-left ">Required Documents</span>
                </li>
                <li class="mt-3 pb-3 my-1 sm:px-24 flex flex-row">
                    <span
                        class="hidden sm:block border-4  {{ $basicInfo ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/basic-info') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $basicInfo ? 'text-themegreen' : 'text-white   opacity-60' }}">Basic
                            Information</span>
                    </a>
                </li>

                {{-- <li class="-mt-3.5  hidden sm:block">
                    <span class="border-l-4 border-l-white  border-opacity-20 h-14 vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row mt-10 sm:-mt-3">
                    <span class="hidden sm:block border-4 {{ $report ? "border-themegreen" : "border-white border-opacity-20" }}   rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix().'/credit-report') }}">

                        <span class="tracking-wide sm:block  capitalize  {{ $report ? "text-themegreen" : "text-white   opacity-60" }} ">Credit Report</span>
                    </a>
                </li> --}}

                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white   border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block border-4  {{ $bank ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/bank-statement') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $bank ? 'text-themegreen' : 'text-white   opacity-60' }}">Bank
                            Statements</span>
                    </a>
                </li>

                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block border-4 {{ $pay ? 'border-themegreen' : 'border-white  border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/pay-stub') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $pay ? 'text-themegreen' : 'text-white   opacity-60' }}">Pay
                            Stubs</span>
                    </a>
                </li>

                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block  border-4 {{ $tax ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/tax-return') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $tax ? 'text-themegreen' : 'text-white   opacity-60' }}">Tax
                            Returns</span>
                    </a>
                </li>

                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block  border-4 {{ $license ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/id-license') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $license ? 'text-themegreen' : 'text-white   opacity-60' }}">ID/Driver's
                            License</span>
                    </a>
                </li>
                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block  border-4 {{ $_1003 ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/1003') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $_1003 ? 'text-themegreen' : 'text-white   opacity-60' }}">Loan
                            Application</span>
                    </a>
                </li>
                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block  border-4 {{ $statement ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/mortgage-statement') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $statement ? 'text-themegreen' : 'text-white   opacity-60' }}">Mortgage
                            Statement</span>
                    </a>
                </li>
                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block  border-4 {{ $evidence ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/insurance-evidence') }}">

                        <span
                            class="tracking-wide sm:block  {{ $evidence ? 'text-themegreen' : 'text-white   opacity-60' }}">Evidence
                            of Insurance</span>
                    </a>
                </li>
                @if (auth()->user()->finance_type === 'Purchase')
                    <li class="-mt-3 hidden sm:block">
                        <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                            &nbsp;
                        </span>
                    </li>

                    <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                        <span
                            class="hidden sm:block  border-4 {{ $purchaseAgreement ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/purchase-agreement') }}">

                            <span
                                class="tracking-wide sm:block  capitalize {{ $purchaseAgreement ? 'text-themegreen' : 'text-white   opacity-60' }}">Purchase
                                Agreement</span>
                        </a>
                    </li>
                @endif

                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="py-3 sm:px-24 flex flex-row  mt-10 sm:-mt-3">
                    <span
                        class="hidden sm:block  border-4 {{ $miscellaneous ? 'border-themegreen' : 'border-white border-opacity-20' }} rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4" href="{{ url(getUserRoutePrefix() . '/miscellaneous') }}">

                        <span
                            class="tracking-wide sm:block  capitalize {{ $miscellaneous ? 'text-themegreen' : 'text-white   opacity-60' }}">Miscellaneous</span>
                    </a>
                </li>
                <li class="-mt-3 hidden sm:block">
                    <span class="border-l-4  border-l-white  border-opacity-20 h-14  vertical-line-m">
                        &nbsp;
                    </span>
                </li>
                <li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
                    <span class="hidden sm:block border-4 border-themegreen  rounded-full text-xs  -ml-16">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <a class="truncate ml-4"
                        href="{{ url(Auth::user()->accessToken ? '/gmail-inbox' : '/gmail/auth') }}">
                        <span
                            class="tracking-wide sm:block  capitalize text-themegreen text-white">{{ Auth::user()->accessToken ? 'Gmail Inbox' : 'Connect Mail' }}</span>
                    </a>
                </li>
                <li class="my-1 sm:px-24 mt-5 sm:block   -ml-14">
                    <span class="tracking-wide text-2xl text-white text-left ">Loan Status</span>
                </li>
                <li class="py-5 sm:px-24 flex flex-row justify-left ">

                    <a class="-ml-16 truncate ml-4 text-md border-2 border-white rounded-md bg-white px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        href="{{ url(getUserRoutePrefix() . '/application-status') }}">

                        See My Loan Status
                    </a>
                </li>
                <!-- Sidebar for user ends -->
            @endcan
        </ul>

    </div>
</div>
