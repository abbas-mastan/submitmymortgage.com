@extends('layouts.app')
@section('content')
    <div class="mx-auto w-3/4 mt-24">
        
        <div class="">
            <h1 class="text-xl uppercase text-center">
                Create A New User
            </h1>
        </div>
        
        <form  onsubmit="event.preventDefault(); showPrompt(this);" enctype="multipart/form-data" action="{{empty($user->id) ? url(getAdminRoutePrefix().'/do-user/-1'):url(getAdminRoutePrefix().'/do-user/'.$user->id) }}" method="post" class=" w-7/8">
            @include('parts.alerts')
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="name" class="">Enter Full Name</label>
                </div>
                <div class="mt-2">
                    <input value="{{ $user->name }}" type="text" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="name"  id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Full Name">
                </div>
                
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="email" class="">Email Address</label>
                </div>
                <div class="mt-2">
                    <input  value="{{ $user->email }}" type="email" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="email"  id="email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email Address">
                </div>
                
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password" class="">Create Password</label>
                </div>
                <div class="mt-2">
                    <input type="password" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="password"  id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
                
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="password_confirmation" class="">Confirm Password</label>
                </div>
                <div class="mt-2">
                    <input type="password" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400" name="password_confirmation"  id="password_confirmation" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                </div>
                
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="role" class="">User Type</label>
                </div>
                <div class="mt-2">
                    <select required name="role" id="role" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="">Choose a type</option>
                        <option value="user">User</option>
                        <option value="sadmin">Secondary Admin</option>
                    </select>
                    
                </div>
                
            </div>
            <div class="mt-3 mx-auto" id="finance-div">
                <div class=" text-left mr-12">
                    <label for="finance_type" class="">Finance Type</label>
                </div>
                <div class="mt-2">
                    <select id="finance_type" name="finance_type" class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option value="Purchase" class="">Purchase</option>
                        <option value="Refinance" class="">Refinance</option>
                    </select>
                    
                </div>
                
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="file" class="">Profile Picture</label>
                </div>
                <div class="mt-2">
                    <input  type="file" name="file" id="file" accept="image/*">
                </div>
                
            </div> 
            
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button  type="submit" class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                        {{ !empty( $user->id) ? "Update" : "Create"  }} 
                    </button>
                </div>
                
            </div>    
           
        </form>
       
    </div>
@endsection
@section('foot')
    <script>
        let role = document.querySelector('#role');
        role.addEventListener("change", function(){
            let financeDiv =  document.querySelector('#finance-div');
            let financeType =  document.querySelector('#finance_type');

            if(this.value == 'sadmin')
            {
                financeDiv.style.display = 'none';
                financeType.removeAttribute('required');
            }
            else
            {
                
                financeDiv.style.display = 'block';
                financeType.setAttribute('required', 'True');
            }
        });
        function showPrompt(form)
        {
            if(role.value == 'sadmin')
            {
                if(confirm('Are you sure you want to add a secondary admin?')){
                    form.submit();
                }
                return;
            }
            return form.submit();
        }
        // let form = document.querySelector('#user-form');
        // form.addEventListener('submit',function(e){
            
        // });
    </script>
@endsection