@extends('layouts.app')
@section('content')
    <div class="mx-auto w-3/4 mt-24">

        <div class="">
            <h1 class="text-xl uppercase text-center">
                Create A New User
            </h1>
        </div>
        <form onsubmit="event.preventDefault(); showPrompt(this);" enctype="multipart/form-data"
            action="{{ empty($user->id) ? url(getRoutePrefix() . '/do-user/-1') : url(getRoutePrefix() . '/do-user/' . $user->id) }}"
            method="post" class=" w-7/8">
            {{-- @include('parts.alerts') --}}
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="name" class="">Enter Full Name</label>
                </div>
                <div class="mt-2">
                    <input value="{{ old('name', $user->name) }}" type="text"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="name" id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Full Name">
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="email" class="">Email Address</label>
                </div>
                <div class="mt-2">
                    <input value="{{ old('email', $user->email) }}" type="email"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="email" id="email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email Address">
                </div>
            </div>
            {{-- @if (!$user->password > 0)
                <div class="mt-3 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="password" class="">Create Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                    </div>
                </div>
                <div class="mt-3 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="password_confirmation" class="">Confirm Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="password_confirmation" id="password_confirmation"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                    </div>
                </div>
            @endif --}}
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="role" class="">User Type</label>
                </div>
                <div class="mt-2">
                    <select required name="role" id="role"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="">Choose a type</option>
                        @foreach (config('smm.roles') as $role)
                            @if (!(Auth::user()->role == 'Processor' && $role == 'Processor'))
                                @if (!(Auth::user()->role == 'Associate' && in_array($role, ['Associate', 'Processor'])))
                                    @if (!(Auth::user()->role == 'Junior Associate' && in_array($role, ['Junior Associate', 'Associate', 'Processor'])))
                                        <option {{ old('role', $user->role) == $role ? 'selected' : '' }}
                                            value="{{ $role }}">
                                            {{ $role }}</option>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                        {{-- <option value="sadmin">Secondary Admin</option> --}}
                    </select>
                </div>
            </div>
            <div class="mt-3 mx-auto" id="finance-div"
                style="{{ in_array($user->role, ['Processor', 'Associate', 'Junior Associate']) ? 'display: none' : '' }}">
                <div class=" text-left mr-12">
                    <label for="finance_type" class="">Finance Type</label>
                </div>
                <div class="mt-2">
                    <select id="finance_type" name="finance_type"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option {{ $user->finance_type == 'Purchase' ? 'selected' : '' }} value="Purchase" class="">
                            Purchase</option>
                        <option {{ $user->finance_type == 'Refinance' ? 'selected' : '' }} value="Refinance" class="">
                            Refinance</option>
                    </select>
                </div>
            </div>
            <div class="mt-3 mx-auto" id="loan_type_div"
                style="{{ in_array($user->role, ['Processor', 'Associate', 'Junior Associate']) ? 'display: none' : '' }}">
                <div class=" text-left mr-12">
                    <label for="loan_type" class="">Loan Type</label>
                </div>
                <div class="mt-2">
                    <select id="loan_type" name="loan_type"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                        <option value="" class="">Choose a value</option>
                        <option {{ $user->loan_type == 'Private Loan' ? 'selected' : '' }} value="Private Loan"
                            class="">Private Loan</option>
                        <option {{ $user->loan_type == 'Full Doc' ? 'selected' : '' }} value="Full Doc" class="">Full
                            Doc</option>
                        <option {{ $user->loan_type == 'Non QM' ? 'selected' : '' }} value="Non QM" class="">Non QM
                        </option>
                    </select>
                </div>
            </div>
            <div class="mt-3 mx-auto">
                <div class=" text-left mr-12">
                    <label for="file" class="">Profile Picture</label>
                </div>
                <div class="mt-2">
                    <img src="{{ $user->pic }}" alt="">
                    <input type="file" name="file" id="file" accept="image/*">
                </div>

            </div>
            <div class="mt-5 grid grid-cols-6">
                <div class="col-span-2 text-right mr-12">
                    &nbsp;
                </div>
                <div class="col-span-4 ml-1 ">
                    <button type="submit"
                        class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                        {{ !empty($user->id) ? 'Update' : 'Create' }}
                    </button>
                </div>

            </div>
        </form>

    </div>
@endsection
@section('foot')
    <script>
        let role = document.querySelector('#role');
        let financeDiv = document.querySelector('#finance-div');
        let loanDiv = document.querySelector('#loan_type_div');
        let financeType = document.querySelector('#finance_type');

        role.addEventListener("change", function() {
            if (this.value === 'Processor' || this.value === 'Associate' || this.value === 'Junior Associate') {
                financeDiv.style.display = 'none';
                loanDiv.style.display = 'none';
                financeType.removeAttribute('required');
            } else {
                financeDiv.style.display = 'block';
                loanDiv.style.display = 'block';
                financeType.setAttribute('required', 'true');
            }
        });

        // Trigger the change event on page load to initialize the display and required attribute
        role.dispatchEvent(new Event('change'));

        function showPrompt(form) {
            if (role.value == 'Processor') {
                if (confirm('Are you sure you want to add a Processor?')) {
                    form.submit();
                }
                return;
            }
            return form.submit();
        }
    </script>
@endsection
