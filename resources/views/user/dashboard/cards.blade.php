<div class="grid grid-cols-2 gap-4 mx-auto">
    {{-- <div class="w-full  mx-4  my-4 rounded shadow-md bg-white">
        <div class="w-full h-56" >
                <div class="flex justify-center  mt-6">
                    <div class="w-16 h-16 rounded-full bg-black flex justify-center items-center">
                        <img class="w-7 h-7" src="{{ asset('icons/credit-report.svg') }}" alt="" srcset="">
                    </div>
                </div>
                <div class="flex flex-wrap justify-center mt-6 px-10">
                    <div class="w-full">
                        <span class="text-lg lg:text-xl block text-center font-bold tracking-wider">&nbsp;&nbsp;Credit Report Document&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <div class="w-full text-center">
                        <a href="{{url(getUserRoutePrefix()."/credit-report")}}">
                            <button class="px-5 sm:px-10 lg:px-20 border border-gray-800 rounded py-1 text-md">
                                Begin
                            </button>
                        </a>
                    </div>
                </div>
        </div>
    </div> --}}
    <div class="w-full   mx-4 my-4 rounded shadow-md bg-white">
        <div class="w-full h-56 ">
            <div class="flex justify-center  mt-6 ">
                <div class="w-16 h-16 rounded-full bg-black flex justify-center items-center">
                    <img class="w-7 h-7" src="{{ asset('icons/bank.svg') }}" alt="" srcset="">
                </div>
            </div>
            <div class="flex justify-center mt-6 px-10">
                <div class="w-full">
                    <span class="text-lg lg:text-xl  block text-center font-bold tracking-wider">Bank Statements</span>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <div class="w-full text-center">
                    <a href="{{ url(getUserRoutePrefix() . '/bank-statement') }}">
                        <button class="px-5 sm:px-10 lg:px-20 border border-gray-800 rounded py-1 text-md">
                            Begin
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full    mx-4 my-4 rounded shadow-md bg-white">
        <div class="w-full h-56 ">
            <div class="flex justify-center  mt-6">
                <div class="w-16 h-16 rounded-full bg-black flex justify-center items-center">
                    <img class="w-7 h-7" src="{{ asset('icons/pay-stub.svg') }}" alt="" srcset="">
                </div>
            </div>
            <div class="flex justify-center mt-6 px-10">
                <div class="w-full">
                    <span class="text-xl block text-center font-bold tracking-wider">&nbsp;&nbsp; Pay Stub Copies
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <div class="w-full text-center">
                    <a href="{{ url(getUserRoutePrefix() . '/pay-stub') }}">
                        <button class="px-5 sm:px-10 lg:px-20  border border-gray-800 rounded py-1 text-md">
                            Begin
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full    mx-4 my-4 rounded shadow-md bg-white">
        <div class="w-full h-56 ">
            <div class="flex justify-center  mt-6">
                <div class="w-16 h-16 rounded-full bg-black flex justify-center items-center">
                    <img class="w-7 h-7" src="{{ asset('icons/tax-return.svg') }}" alt="" srcset="">
                </div>
            </div>
            <div class="flex justify-center mt-6 px-10">
                <div class="w-full">
                    <span class="text-xl block text-center font-bold tracking-wider">Tax Return Documents</span>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <div class="w-full text-center">
                    <a href="{{ url(getUserRoutePrefix() . '/tax-return') }}">
                        <button class="px-5 sm:px-10 lg:px-20  border border-gray-800 rounded py-1 text-md">
                            Begin
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full    mx-4 my-4 rounded shadow-md bg-white">
        <div class="w-full h-56 ">
            <div class="flex justify-center  mt-6">
                <div class="w-16 h-16 rounded-full bg-black flex justify-center items-center">
                    <img class="w-7 h-7" src="{{ asset('icons/license.svg') }}" alt="" srcset="">
                </div>
            </div>
            <div class="flex justify-center mt-6 px-10">
                <div class="w-full">
                    <span class="text-xl block text-center font-bold tracking-wider">ID/Driver's License</span>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <div class="w-full text-center">
                    <a href="{{ url(getUserRoutePrefix() . '/id-license') }}">
                        <button class="px-5 sm:px-10 lg:px-20  border border-gray-800 rounded py-1 text-md">
                            Begin
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
