@php
$url = getUserRoutePrefix();
    $categories = [
        [
            'name' => 'Bank Statements',
            'icon' => 'bank.svg',
            'url' => url($url . '/bank-statement'),
            'condition' => !empty(Auth::user()->skipped_category) && !in_array('Bank Statements', json_decode(Auth::user()->skipped_category)),
        ],
        [
            'name' => 'Pay Stub Copies',
            'icon' => 'pay-stub.svg',
            'url' => url($url . '/pay-stub'),
            'condition' => !empty(Auth::user()->skipped_category) && !in_array('Pay Stubs', json_decode(Auth::user()->skipped_category)) && Auth::user()->loan_type !== 'Private Loan',
        ],
        [
            'name' => 'Tax Return Documents',
            'icon' => 'tax-return.svg',
            'url' => url($url . '/tax-return'),
            'condition' => !empty(Auth::user()->skipped_category) && !in_array('Tax Return', json_decode(Auth::user()->skipped_category)) && Auth::user()->loan_type !== 'Private Loan',
        ],
        [
            'name' => "ID/Driver's License",
            'icon' => 'license.svg',
            'url' => url($url . '/id-license'),
            'condition' => !empty(Auth::user()->skipped_category) && !in_array("ID/Driver's License", json_decode(Auth::user()->skipped_category)),
        ],
    ];
@endphp
<div class="grid grid-cols-2 gap-4 mx-auto">
    @foreach($categories as $category)
        @if($category['condition'])
            <div class="w-full mx-4 my-4 rounded shadow-md bg-white">
                <div class="w-full h-56">
                    <div class="flex justify-center mt-6">
                        <div class="w-16 h-16 rounded-full bg-black flex justify-center items-center">
                            <img class="w-7 h-7" src="{{ asset('icons/' . $category['icon']) }}" alt="" srcset="">
                        </div>
                    </div>
                    <div class="flex justify-center mt-6 px-10">
                        <div class="w-full">
                            <span class="text-xl block text-center font-bold tracking-wider">{{ $category['name'] }}</span>
                        </div>
                    </div>
                    <div class="flex justify-center mt-6">
                        <div class="w-full text-center">
                            <a href="{{ $category['url'] }}">
                                <button class="px-5 sm:px-10 lg:px-20 border border-gray-800 rounded py-1 text-md">
                                    Begin
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>