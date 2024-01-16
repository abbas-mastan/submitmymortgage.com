@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        #file {
            display: none;
        }

        #completed-table_length,
        #completed-table_filter,
        #completed-table>thead,
        #deleted-table_length,
        #deleted-table_filter,
        #deleted-table>thead,
        #user-table_length,
        #user-table_filter,
        #user-table>thead {
            display: none !important;
        }

        #completed-table_wrapper,
        #deleted-table_wrapper,
        #user-table_wrapper {
            box-shadow: 0px 0px 11px 0px gray;
        }

        .dataTables_info {
            margin-left: 10px;
        }

        .dataTables_paginate {
            margin-right: 10px;
            margin-bottom: 4px;
        }
    </style>
@endsection
@section('content')
    @component('components.modal-background', ['title' => 'Add a User'])
        <form class="userform" action="{{ getRoutePrefix() . '/do-user/-1' }}" method="POST">
            @csrf
            <x-form.input name="name" label="User's Name" />
            <x-form.input name="email" label="User's Email" />
            <div class="my-3">
                <label for="role" class="text-sm text-dark-500 leading-6 font-bold"> User's Role
                </label>
                <select
                    class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                    sm:text-sm sm:leading-6"
                    name="role" id="role">
                    <option value="Select Role">Select Role</option>
                    @if ($currentrole === 'Super Admin')
                        <option value="Admin">Admin</option>
                    @endif
                    @if ($currentrole === 'Admin' || $currentrole === 'Super Admin')
                        <option value="Processor">Processor</option>
                    @endif
                    @if ($currentrole === 'Processor' || $currentrole === 'Admin' || $currentrole === $superadminrole)
                        <option value="Associate">Associate</option>
                    @endif
                    <option value="Junior Associate">Jr.Associate</option>
                    <option value="Borrower">Borrower</option>
                </select>
                <span class="text-red-700" id="role_error"></span>
            </div>
            <div id="finance_loan_div" class="hidden">
                <div class="mt-3 mx-auto" id="finance-div" {{-- style="{{ in_array($user->role, ['Processor', 'Associate', 'Junior Associate']) ? 'display: none' : '' }}" --}}>
                    <div class=" text-left mr-12">
                        <label for="finance_type" class="">Finance Type</label>
                    </div>
                    <div class="mt-2">
                        <select id="finance_type" name="finance_type"
                            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                    sm:text-sm sm:leading-6">
                            <option value="" class="">Choose a value</option>
                            <option {{ old('finance_type') == 'Purchase' ? 'selected' : '' }} value="Purchase" class="">
                                Purchase</option>
                            <option {{ old('finance_type') == 'Refinance' ? 'selected' : '' }} value="Refinance" class="">
                                Refinance</option>
                        </select>
                    </div>
                    <span class="text-red-700" id="finance_error"></span>

                </div>
                <div class="mt-3 mx-auto" id="loan_type_div" {{-- style="{{ in_array($user->role, ['Processor', 'Associate', 'Junior Associate']) ? 'display: none' : '' }}" --}}>
                    <div class=" text-left mr-12">
                        <label for="loan_type" class="">Loan Type</label>
                    </div>
                    <div class="mt-2">
                        <select id="loan_type" name="loan_type"
                            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                    sm:text-sm sm:leading-6">
                            <option value="" class="">Choose a value</option>
                            <option {{ old('loan_type') == 'Private Loan' ? 'selected' : '' }} value="Private Loan"
                                class="">Private Loan</option>
                            <option {{ old('loan_type') == 'Full Doc' ? 'selected' : '' }} value="Full Doc" class="">Full
                                Doc</option>
                            <option {{ old('loan_type') == 'Non QM' ? 'selected' : '' }} value="Non QM" class="">Non QM
                            </option>
                        </select>
                    </div>
                    <span class="text-red-700" id="loan_error"></span>
                </div>
            </div>

            <div class="mt-3 text-left mr-12">
                <input type="checkbox" {{ old('sendemail') == 'on' ? 'checked' : '' }} name="sendemail" id="sendemail">
                <label for="sendemail">Send Welcome Email</label>
            </div>
            <span id="passwordParent">
                <div class="mt-3 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="password" class="">Create Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password"
                            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                            sm:text-sm sm:leading-6"
                            name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                    </div>
                    <span class="text-red-700" id="password_error"></span>
                </div>
                <div class="mt-3 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="password_confirmation" class="">Confirm Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password"
                            class=" w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
                            ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                            sm:text-sm sm:leading-6"
                            name="password_confirmation" id="password_confirmation"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                    </div>
                </div>
            </span>
            {{-- <x-form.input name="team" label="User's Team" class="team hidden" /> --}}
            {{-- <x-form.input name="lead" label="Jr Associate's Lead Associate" class="lead mb-10 hidden" /> --}}
            <div class="my-3 flex justify-end submitButton">
                <button type="submit" class="bg-red-800 text-white px-8 py-1 text-xs font-thin ">Continue</button>
            </div>
        </form>
    @endcomponent
    <x-flex-card title="Verified Users" id="verified" titlecounts="0" iconurl="{{ asset('icons/Users.svg') }}" />
    <a href="{{url(getRoutePrefix().'/add-user/-1')}}" class="bg-red-800 px-5 py-2 text-white inline">Add New User</a>
    @component('components.accordion', ['title' => 'Verified Users'])
        <table class="w-full display" id="completed-table">
            <thead class="bg-gray-300">
                <tr>
                    <th class="pl-2 tracking-wide">
                        S No.
                    </th>
                    <th class="">
                        Name
                    </th>
                    <th class="">
                        User ID
                    </th>
                    <th class="">
                        Role
                    </th>
                    <th class="">
                        Created By
                    </th>
                    <th class="">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $serialNumber = 1;
                @endphp
                @foreach ($users as $key => $processor)
                    @if ($processor->email_verified_at !== null)
                        <tr>
                            <td class="verifiedSerial pl-2 tracking-wide border border-l-0">{{ $serialNumber }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                <a title="Click to view files uploaded by this user" class="text-blue-500 inline"
                                    href="{{ url(getRoutePrefix() . ($processor->role == 'Borrower' ? '/file-cat/' : '/all-users/') . $processor->id) }}">
                                    {{ $processor->name }}
                                </a>
                                <a title="Edit this user" href="{{ url(getRoutePrefix() . '/add-user/' . $processor->id) }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="" class="inline ml-5">
                                </a>
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                {{ $processor->email }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                {{ $processor->role }}
                            </td>
                            <td class=" pl-2 tracking-wide border border-l-0">
                                @if ($processor->createdBy)
                                    {{ $processor->createdBy->name ?? null }}
                                    @if ($processor->createdBy->name)
                                        |
                                    @endif
                                    {{ $processor->createdBy->role ?? null }}
                                @endif
                            </td>
                            <td class="flex pl-2 justify-center tracking-wide border border-r-0">
                                <a data="{{ $currentrole === $superadminrole ? 'temporary' : 'Delete' }}" class="delete"
                                    href="{{ url(getRoutePrefix() . '/delete-user/' . $processor->id) }}">
                                    <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                        <img style="-webkit-writing-mode: vertical-lr;" src="{{ asset('icons/trash.svg') }}"
                                            alt="" class="p-1 w-7">
                                    </button>
                                </a>
                                @if (session('role') == 'Super Admin')
                                    <form method="POST" action="{{ url(getRoutePrefix() . '/login-as-this-user') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $processor->id }}">
                                        <span class="loginBtn">
                                            <button type="submit"
                                                class="ml-1 bg-themered tracking-wide text-white font-semibold capitalize w-7 p-1">
                                                <img src="{{ asset('icons/user.svg') }}" alt="">
                                            </button>
                                        </span>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @php
                            $serialNumber++;
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
    @endcomponent
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        // $('.userform').submit(function (e) { 
        //     e.preventDefault();
        //     $('.jq-loader-for-ajax').removeClass('hidden');
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //         });
        //         $('.jq-loader-for-ajax').removeClass('hidden');
        //         $.ajax({
        //             type: "post",
        //             url: "{{ getRoutePrefix() . '/do-user/-1' }}",
        //             dataType: "json",
        //             data: $(this).serialize(),
        //             success: function(data) {
        //                 console.log('adsf');
        //                 $('.jq-loader-for-ajax').addClass('hidden');
        //             }
        //         });
        //     });

        $("#sendemail").on('change', function(e) {
            e.preventDefault();
            if ($(this).is(":checked")) {
                $("#passwordParent").addClass('hidden');
            } else {
                $("#passwordParent").removeClass('hidden');
            }
        });
        if ($("#sendemail").is(":checked")) {
            $("#passwordParent").addClass('hidden');
        } else {
            $("#passwordParent").removeClass('hidden');
        }

        $('#role').change(function(e) {
            e.preventDefault();
            var role = $('#role').val();
            console.log(role);
            if (role === 'Processor' || role === 'Associate' || role === 'Junior Associate' || role === 'Admin') {
                $('#finance_loan_div').addClass('hidden');
            } else {
                $('#finance_loan_div').removeClass('hidden');
            }
        });
        $('.newProject').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').removeClass('hidden');
        });
        $('.closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('hidden');
        });

        $('.submitButton').addClass('mt-10');

        var role = $('#role').find(':selected').html();
        var roleError = document.getElementById("role_error");
        var nameError = document.getElementById("name_error");
        var financeError = document.getElementById("finance_error");
        var loanError = document.getElementById("loan_error");
        var passwordError = document.getElementById("password_error");

        $(".userform").submit(function(e) {
            e.preventDefault();
            let hasErrors = false;

            if ($('#name').val() === "") {
                nameError.innerHTML = "Name field is required";
                $("#name").addClass('border-red-700 border-2');
                let hasErrors = false;
            }
            if ($("#sendemail").is(":checked")) {
                hasErrors = false;
            } else {
                if ($('#password').val() === "") {
                    passwordError.innerHTML = "Password field is required";
                    $("#password").addClass('border-red-700 border-2');
                    hasErrors = true;
                } else {
                    if ($('#password').val().length < 7) {
                        passwordError.innerHTML = "Password shouldn't be less than 8 characters";
                        $("#password").addClass('border-red-700 border-2');
                        hasErrors = true;
                    } else {
                        if ($('#password').val() !== $('#password_confirmation').val()) {
                            passwordError.innerHTML = "Password confirmation does not match.";
                            $("#password").addClass('border-red-700 border-2');
                            hasErrors = true;
                        } else {
                            passwordError.innerHTML = "";
                            $("#password").removeClass('border-red-700 border-2');
                        }
                    }

                }
            }
            if ($('#role').val() === 'Borrower') {
                if ($('#finance_type').find(':selected').html() === "Choose a value") {
                    financeError.innerHTML = "Please select a finance type.";
                    $("#finance_type").addClass('border-red-700 border-2');
                    hasErrors = true;
                }
                if ($('#loan_type').find(':selected').html() === "Choose a value") {
                    loanError.innerHTML = "Please select a loan type.";
                    $("#finance_type").addClass('border-red-700 border-2');
                    hasErrors = true;
                }
            }
            if ($('#role').find(':selected').html() === "Select Role") {
                roleError.innerHTML = "Please select a role.";
                $("#role").addClass('border-red-700 border-2');
                hasErrors = true;
            } else {
                roleError.innerHTML = "";
                $("#role").removeClass('border-red-700 border-2');
            }
            if ($('#email').val() === '') {
                $('#email').addClass('border-red-700 border-2');
                $('#email_error').text('Email is not valid');
                hasErrors = true;
            } else {
                $('#email').removeClass('border-red-700');
                $('#email_error').text('');
            }
            if (!hasErrors) {
                this.submit();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('mouseenter', '.loginBtn', function() {
                if ($(this).attr('data') == 'restore') {
                    var data = $(this).attr('data');
                }
                if ($(this).attr('data') == 'Permanent Delete') {
                    var data = $(this).attr('data');
                }
                $(this).append(
                    `<div role="tooltip" class="w-40 mt-2 -ml-16 absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        ${!data ? 'Login As This User': data+' this user'}
                        <div class="tooltip-arrow" data-popper-arrow></div></div>`
                );
            }).on('mouseleave', '.loginBtn', function() {
                $(this).find('div[role="tooltip"]').remove();
            });
        });
        $('#unverified').html($('.unverifiedSerial:last').html());
        $('#verified').html($('.verifiedSerial:last').html());
        $('#deleted').html($('.deletedSerial:last').html());
    </script>
@endsection
