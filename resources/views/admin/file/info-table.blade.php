@if (!empty($info))
    <table class="w-full mb-5" id="">
        <caption class="text-center text-white font-bold mb-3  bg-gradient-to-b from-gradientStart to-gradientEnd">Basic
            Information</caption>
        <tr>
            <th class=" pl-2 text-left tracking-wide border border-l-0 border-t-0">
                Borrower
            </th>
            <td class=" pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                {{ $info->b_fname . ' ' . $info->b_lname }}
            </td>
            <th class="pl-2 text-left tracking-wide  border border-l-0 border-t-0">
                Phone#
            </th>
            <td class=" pl-2 text-left tracking-wide border border-r-0 border-t-0 capitalize">
                {{ $info->b_phone }}
            </td>
        </tr>
        <tr>
            <th class=" pl-2 text-left tracking-wide  border border-l-0">
                Email
            </th>
            <td class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                {{ $info->b_email }}
            </td>
            <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                Address
            </th>
            <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                {{ $info->b_address . ',' . $info->b_suite . ', ' . $info->b_city . ', ' . $info->b_state . ' - ' . $info->b_zip }}
            </td>
        </tr>
        <tr>
            <td colspan="4" class=" pl-2 text-center tracking-wide border border-l-0 border-r-0 capitalize">
                <hr class="my-5 w-1/5 mx-auto border-gray-400">
            </td>
        </tr>
        <tr>
            <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                Co Borrower
            </th>
            <td class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                {{ $info->co_fname . ' ' . $info->co_lname }}
            </td>
            <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                Phone#
            </th>
            <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                {{ $info->co_phone }}
            </td>
        </tr>
        <tr>
            <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                Email
            </th>
            <td class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                {{ $info->co_email }}
            </td>
            <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                Address
            </th>
            <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                {{ $info->co_address . ',' . $info->co_suite . ', ' . $info->co_city . ', ' . $info->co_state . ' - ' . $info->co_zip }}
            </td>
        </tr>
        <tr>
            <td colspan="4" class=" pl-2 text-center tracking-wide border border-l-0 border-r-0 capitalize">
                <hr class="my-5 w-1/5 mx-auto border-gray-400">
            </td>
        </tr>
        <tr>
            <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                Subject Property Address
            </th>
            <td colspan="3" class="pl-2 text-left tracking-wide border border-r-0 capitalize">
                {{ $info->p_address . ',' . $info->p_suite . ', ' . $info->p_city . ', ' . $info->p_state . ' - ' . $info->p_zip }}
            </td>
        </tr>
        <tr>
            <td colspan="4" class=" pl-2 text-center tracking-wide border border-l-0 border-r-0 capitalize">
                <hr class="my-5 w-1/5 mx-auto border-gray-400">
            </td>
        </tr>
        @if ($user->finance_type == 'Refinance')
            <tr>
                <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                    1st Mortgage
                </th>
                <td id="mortage1" class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    $ {{ $info->mortage1 }}
                </td>
                <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    Interest Rate
                </th>
                <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                    {{ $info->interest1 }} %
                </td>
            </tr>
            <tr>
                <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                    2nd Mortgage
                </th>
                <td id="mortage2" class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    $ {{ $info->mortage2 }}
                </td>
                <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    Interest Rate
                </th>
                <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                    {{ $info->interest2 }} %
                </td>
            </tr>
            <tr>
                <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    Home Value
                </th>
                <td id="value" class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                    $ {{ $info->value }}
                </td>
            </tr>
            <tr>
                <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                    Cash Out
                </th>
                <td class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    {{ $info->cashout }}
                </td>
                <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    Cash Out Amount
                </th>
                <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                    {{ $info->cashout_amount }}
                </td>
            </tr>
        @endif
        @if ($user->finance_type == 'Purchase')
            <tr>
                <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                    Purchase Type
                </th>
                <td class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    {{ Str::ucfirst($info->purchase_type) }}
                </td>
                @if ($info->purchase_type == 'company')
                    <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                        Company Name
                    </th>
                    <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                        {{ $info->company_name }}
                    </td>
                @endif
            </tr>
            <tr>
                <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                    Purchase Purpose
                </th>
                <td class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    {{ Str::ucfirst($info->purchase_purpose) }}
                </td>
                <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    Purchase Price
                </th>
                <td id="purchase-price" class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                    {{ $info->purchase_price }}
                </td>
            </tr>
            <tr>
                <th class="  pl-2 text-left tracking-wide border border-l-0 border-t-0 capitalize">
                    Down Payment Amount
                </th>
                <td id="purchase-dp" class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    {{ $info->purchase_dp }}
                </td>
                <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                    Loan Amount
                </th>
                <td id="loan-amount" class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                    {{ $info->loan_amount }}
                </td>
            </tr>
        @endif
        {{-- <tr>
            
            <th class=" pl-2 text-left tracking-wide border border-l-0 capitalize">
                Loan Purpose
            </th>
            <td class=" pl-2 text-left tracking-wide border border-r-0 capitalize">
                {{ $info->purpose }}
            </td>
        </tr>  --}}
    </table>
@endif
