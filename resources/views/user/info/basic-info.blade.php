@extends('layouts.app')
@section('content')
    <div class= "w-3/4 mt-10 mx-auto">
        
        <div class="">
            <h1 class="text-xl uppercase text-center">
                Basic Information
            </h1>
        </div>
        
        <form id="info-form" action="{{ url(getUserRoutePrefix().'/do-info') }}" method="post" class="w-full">
            @include('parts.alerts')
            @csrf
            <div class="">
                <p class="text-lg font-bold -ml-8">Borrower's Info</p>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_fname" class="">Borrower's First Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->b_fname }}" type="text" class=" rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_fname"  id="b_fname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;First Name">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_lname" class="">Borrower's Last Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->b_lname }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_lname"  id="b_lname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Last name">
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_email" class="">Email</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->b_email }}" type="email" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_email"  id="b_email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Email Address">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_phone" class="">Phone #</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->b_phone }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_phone"  id="b_phone" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Phone#">
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="b_address" class="">Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->b_address }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_address"  id="b_address" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Address">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_suite" class="">&nbsp;</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->b_suite }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_suite"  id="b_suite" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Suite">
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    
                    <div class="mt-2">
                        <input value="{{ $info->b_city }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_city"  id="b_city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's City">
                    </div>
                </div>
                <div class="">
                    
                    <div class="mt-2">
                        
                        <select  name="b_state" id="b_state" class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ $info->b_state === $state ? 'selected' : '' }} value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="{{ $info->b_zip }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="b_zip"  id="b_zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Borrower's Zip">
                    </div>
                </div>
            </div>
            
            <div class="my-5">
                <hr class="">
            </div>
            <div class="">
                <p class="text-lg font-bold -ml-8">Co Borrower's Info</p>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_fname" class="">Co Borrower's First Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->co_fname }}" type="text" class=" rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_fname"  id="co_fname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;First Name">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="co_lname" class="">Co Borrower's Last Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->co_lname }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_lname"  id="co_lname" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Last name">
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="co_email" class="">Email</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->co_email }}" type="email" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_email"  id="co_email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Email Address">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="co_phone" class="">Phone #</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->co_phone }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_phone"  id="co_phone" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Phone#">
                    </div>
                </div>
            </div>
            
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="co_address" class="">Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->co_address }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_address"  id="co_address" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Address">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="b_suite" class="">&nbsp;</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->co_suite }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_suite"  id="co_suite" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Suite">
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    
                    <div class="mt-2">
                        <input value="{{ $info->co_city }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_city"  id="co_city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's City">
                    </div>
                </div>
                <div class="">
                    
                    <div class="mt-2">
                        
                        <select  name="co_state" id="co_state" class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ $info->co_state === $state ? 'selected' : '' }} value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="{{ $info->co_zip }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="co_zip"  id="co_zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Co Borrower's Zip">
                    </div>
                </div>
            </div>
            <div class="my-5">
                <hr class="">
            </div>
            <div class="">
                <p class="text-lg font-bold -ml-8">Subject Property</p>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="col-span-2">
                    <div class=" text-left mr-12">
                        <label for="b_address" class="">Subject Property Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->p_address }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="p_address"  id="p_address" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Property's Address">
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="p_suite" class="">&nbsp;</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->p_suite }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="p_suite"  id="p_suite" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Suite">
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-8">
                <div class="">
                    
                    <div class="mt-2">
                        <input value="{{ $info->p_city }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="p_city"  id="p_city" placeholder="&nbsp;&nbsp;&nbsp;&nbsp; City">
                    </div>
                </div>
                <div class="">
                    
                    <div class="mt-2">
                        
                        <select  name="p_state" id="p_state" class="w-full  rounded-md py-2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">State</option>
                            @foreach (config('smm.states') as $state)
                                <option {{ $info->p_state === $state ? 'selected' : '' }} value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="">
                    <div class="mt-2">
                        <input value="{{ $info->p_zip }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="p_zip"  id="p_zip" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Zip">
                    </div>
                </div>
            </div>
            
            <div class="my-5">
                <hr class="">
            </div>
            @if (auth()->user()->finance_type == "Refinance")
                
           
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="mortage1" class="">1st Mortgage</label>
                    </div>
                    <div class="mt-2">
                        
                        <input value="{{ $info->mortage1 }}" type="text" min="0" max="99999999" class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="mortage1"  id="mortage1" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;1st Mortgage">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="interest1" class="">Interest Rate</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->interest1 }}" type="number" min="0" max="100" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="interest1"  id="interest1" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Interest Rate">
                        <span class="inline -ml-12 z-10 opacity-50">%</span>
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="mortage2" class="">2nd Mortgage</label>
                    </div>
                    <div class="mt-2">
                        
                        <input value="{{ $info->mortage2 }}" type="text" min="0" max="99999999" class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="mortage2"  id="mortage2" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;2nd Mortgage">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                </div>
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="interest2" class="">Interest Rate</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->interest2 }}" type="number" min="0" max="100" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="interest2"  id="interest2" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Interest Rate">
                        <span class="inline -ml-12 z-10 opacity-50">%</span>
                    </div>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-8">
                <div class="">
                    <div class=" text-left mr-12">
                        <label for="value" class="">Home Value</label>
                    </div>
                    <div class="mt-2">
                        
                        <input value="{{ $info->value }}" type="text" min="0" max="99999999" class="inline rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="value"  id="value" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Home Value">
                        <span class="inline -ml-12 z-10 opacity-50">$</span>
                    </div>
                </div>
                <div class="">
                    
                </div>
            </div>
            <div class="mt-2">
                <div class=" text-left mr-12">
                    <label  class="">Cash Out</label>
                </div>
                <div class="mt-2 ml-5">
                    <input {{ $info->cashout === 'Yes' ? 'checked' : '' }} value="Yes" type="radio" class="" name="cashout"  id="cashout-yes" > 
                    <label for="cashout-yes" class="">Yes</label><br>
                    <input {{ $info->cashout === 'No' ? 'checked' : '' }}  value="No"  type="radio" class="" name="cashout"  id="cashout-no" > 
                    <label for="cashout-no" class="">No</label>
                </div>
            </div>
            <div class="{{ $info->cashout === 'Yes' ? '' : 'hidden' }}" id="cashout-amount">
                <div class=" text-left mr-12">
                    <label for="cashout-amt" class="">How much cashout are you requesting?</label>
                </div>
                <div class="mt-2">
                    <input value="{{ $info->cashout_amount }}" type="text" min="0" max="99999999" class="inline rounded-md py-2 w-1/2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="cashout_amount"  id="cashout-amt" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Cashout Amount">
                    <span class="inline -ml-12 z-10 opacity-50">$</span>
                </div>
            </div>
            
            @endif
            @if (auth()->user()->finance_type == "Purchase")
                <div class="mt-4">
                    <div class=" text-left mr-12">
                        <label  class="">Is this a Personal purchase or a Company purchase?</label>
                    </div>
                    <div class="mt-2  ml-5">
                        <input {{ $info->purchase_type === 'personal' ? 'checked' : '' }}  value="personal"  type="radio" class="" name="purchase_type"  id="personal" > 
                        <label for="personal" class="">Personal</label><br>
                        <input {{ $info->purchase_type === 'company' ? 'checked' : '' }} value="company"  type="radio" class="" name="purchase_type"  id="company" > 
                        <label for="company" class="">Company</label>
                    </div>
                </div>
                <div class="{{ $info->purchase_type ? '' : 'hidden' }}" id="company-name">
                    <div class=" text-left mr-12">
                        <label for="company_name" class="">Company Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ $info->company_name }}" type="text" class="inline rounded-md py-2 w-1/2 focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="company_name"  id="company_name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Company's Name">
                        
                    </div>
                </div>
                <div class="mt-4">
                    <div class=" text-left mr-12">
                        <label  class="">Investment or Primary Residence</label>
                    </div>
                    <div class="mt-2  ml-5">
                        <input {{ $info->purchase_purpose === 'investment' ? 'checked' : '' }}  value="investment"  type="radio" class="" name="purchase_purpose"  id="investment" > 
                        <label for="investment" class="">Investment</label><br>
                        <input {{ $info->purchase_purpose === 'residence' ? 'checked' : '' }} value="residence"  type="radio" class="" name="purchase_purpose"  id="residence" > 
                        <label for="residence" class="">Residence</label>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-8">
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="purchase_price" class="">Purchase Price</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ $info->purchase_price }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="purchase_price"  id="purchase_price" placeholder="&nbsp;&nbsp;&nbsp;&nbsp; Purchase Price">
                        </div>
                    </div>
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="purchase_dp" class="">Down Payment Amount</label>
                        </div>
                        <div class="mt-2">
                            
                            <div class="mt-2">
                                <input value="{{ $info->purchase_dp }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="purchase_dp"  id="purchase_dp" placeholder="&nbsp;&nbsp;&nbsp;&nbsp; Down Payment Amount">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class=" text-left mr-12">
                            <label for="loan_amount" class="">Loan Amount</label>
                        </div>
                        <div class="mt-2">
                            <input value="{{ $info->loan_amount }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="loan_amount"  id="loan_amount" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Loan Amount">
                        </div>
                    </div>
                </div>
            @endif
            <div class="my-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button  type="submit" class="text-white bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        {{ !empty( $info->id) ? "Update" : "Save"  }} 
                    </button>
                </div>
                
            </div>    
           
        </form>
       
    </div>
@endsection
@section('foot')
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"  type="text/javascript"></script>
<script>
$(document).ready(function(){

    $('[name="cashout"]').on('change',function(){
        if( $(this).val() === 'Yes' )
        {
            $('#cashout-amount').removeClass('hidden');
        }
        else
        {
            $('#cashout-amount').addClass('hidden');
        }
    });
    $('[name="purchase_type"]').on('change',function(){
        if( $(this).val() === 'company' )
        {
            $('#company-name').removeClass('hidden');
        }
        else
        {
            $('#company-name').addClass('hidden');
        }
    });

    let mortgage1 = $('#mortage1').val();
        let mortgage2 = $('#mortage2').val();
        let value = $('#value').val();
        let cashoutAmount = $('#cashout-amt').val();

        //Remove commas
        mortgage1 = mortgage1.replaceAll(",","");
        mortgage2 = mortgage2.replaceAll(",","");
        value = value.replaceAll(",","");
        cashoutAmount = cashoutAmount.replaceAll(",","");

        $('#mortage1').val(formatNumbers(mortgage1));
        $('#mortage2').val(formatNumbers(mortgage2));
        $('#value').val(formatNumbers(value));
        $('#cashout-amt').val(formatNumbers(cashoutAmount));
    $("#mortage1, #mortage2, #value, #cashout-amt").on("keyup paste",function(){
        value = $(this).val();
        value = value.replaceAll(",","")
        $(this).val(formatNumbers(value));
        
    });
    $("#info-form").on("submit",function(){
        let mortgage1 = $('#mortage1').val();
        let mortgage2 = $('#mortage2').val();
        let value = $('#value').val();
        let cashoutAmount = $('#cashout-amt').val();

        //Remove commas
        mortgage1 = mortgage1.replaceAll(",","");
        mortgage2 = mortgage2.replaceAll(",","");
        value = value.replaceAll(",",""); 
        cashoutAmount = cashoutAmount.replaceAll(",",""); 

        $('#mortage1').val(mortgage1);
        $('#mortage2').val(mortgage2);
        $('#value').val(value);
        $('#cashout-amt').val(cashoutAmount);

    });
    
});
function formatNumbers(number){
    number += '';
    x = number.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>


@endsection