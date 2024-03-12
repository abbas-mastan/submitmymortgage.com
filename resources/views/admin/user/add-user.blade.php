@extends('layouts.app')
@section('content')
    <div class="mx-auto w-3/4 mt-24">
        <x-jq-loader />
        <div class="errors"></div>
        <div class="">
            <h1 class="text-xl uppercase text-center">
                Create A New User
            </h1>
        </div>
        <div class="ml-1 mt-3 w-1/2 flex">
            <a href="{{ asset('users.xlsx') }}" download
                class="block bg-gradient-to-b from-gradientStart to-gradientEnd capitalize flex rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                Download xlsx example <img src="{{ asset('icons/download.svg') }}" class="ml-2 color-white-500" width="20px"
                    alt="">
            </a>
        </div>
        <form class="w-7/8" action="{{ url(getRoutePrefix() . '/spreadsheet') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="mt-10 mx-auto">
                <div class=" text-left mr-12">
                    <label for="spreadsheet" class="">Select File</label>
                </div>
                <div class="mt-2">
                    <input value="{{ old('spreadsheet') }}" type="file" accept=".xlsx"
                        class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                        name="spreadsheet" id="spreadsheet" required>
                </div>
            </div>
            <div class="col-span-4 ml-1 mt-3 ">
                <button type="submit"
                    class="bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                    Create User From xlsx
                </button>
            </div>
        </form>
        <form enctype="multipart/form-data"
            action="{{ empty($user->id) ? url(getRoutePrefix() . (old('role', $user->role) == 'Assistant' ? '/share-items/' : '/do-user/') . '-1') : url(getRoutePrefix() . (old('role', $user->role) == 'Assistant' ? '/share-items/' : '/do-user/') . $user->id) }}"
            method="post" class="userForm w-7/8">
            @csrf
            <div class="flex justify-between">
                <div class="mt-3 w-[49%]">
                    <div class="text-left mr-12">
                        <label for="name" class="">Enter Full Name</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('name', $user->name) }}" type="text"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="name" id="name" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Full Name">
                    </div>
                    @error('name')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3 w-[49%]">
                    <div class="text-left mr-12">
                        <label for="email" class="">Email Address</label>
                    </div>
                    <div class="mt-2">
                        <input value="{{ old('email', $user->email) }}" type="email"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                            name="email" {{ $user->id > 0 ? 'readonly disabled' : '' }} id="email"
                            placeholder="&nbsp;&nbsp;&nbsp;&nbsp;Email Address">
                    </div>
                    @error('email')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex justify-between company">
                @if (Auth::user()->role === 'Super Admin')
                    <div class="mt-3 w-[49%]">
                        <div class=" text-left mr-12">
                            <label for="company" class="">Company Name</label>
                        </div>
                        <div class="mt-2">
                            <select name="company" id="company"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    <option {{ old('company', $user->company_id) == $company->id ? 'selected' : '' }}
                                        value="{{ $company->id }}">
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company')
                                <span class="text-red-700">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="mt-3 w-[49%]">
                    <div class=" text-left mr-12">
                        <label for="role" class="">User Type</label>
                        {{ old('role') }}
                    </div>
                    <div class="mt-2">
                        <select required name="role" id="role"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="">Choose a type</option>
                            @php
                                $roles = config('smm.roles');
                                if ($currentrole === 'Super Admin') {
                                    array_unshift($roles, 'Admin');
                                }
                            @endphp
                            @foreach ($roles as $role)
                                @if (
                                    !(
                                        ($currentrole == 'Processor' && $role == 'Processor') ||
                                        ($currentrole == 'Associate' && in_array($role, ['Associate', 'Processor'])) ||
                                        ($currentrole == 'Junior Associate' && in_array($role, ['Junior Associate', 'Associate', 'Processor'])) ||
                                        (in_array($currentrole, ['Processor', 'Associate', 'Junior Associate']) && $role == 'Admin')
                                    ))
                                    <option {{ old('role', $user->role) == $role ? 'selected' : '' }}
                                        value="{{ $role }}">
                                        {{ $role }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                @if (Auth::user()->role !== 'Super Admin')
                    <div class="mt-3 w-[49%] borrowerDiv {{ old('role', $user->role) !== 'Assistant' ? 'hidden' : '' }}">
                        <div class=" text-left mr-12">
                            <label for="role" class="">Select Deal</label>
                        </div>
                        <div class="mt-2">
                            <select name="deal" id="deal" required
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                                <option value="">Select Deal</option>
                                @foreach ($teams as $team)
                                    @foreach ($team->projects as $project)
                                        @if (Auth::user()->role !== 'Admin' && $project->creater->id !== auth()->id())
                                            @continue
                                        @endif
                                        <option {{ old('deal', $projectid ?? 0) == $project->id ? 'selected' : '' }}
                                            value="{{ $project->id }}">
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        @error('deal')
                            <span class="text-red-700">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>

            @if (Auth::user()->role !== 'Super Admin')
                @php
                    $hiddenClass =
                        old('role', $user->role) === 'Borrower' ||
                        old('role') === 'Assistant' ||
                        $user->role === 'Borrower' ||
                        $user->role === 'Assistant'
                            ? 'hidden'
                            : '';
                @endphp
                <div class="flex justify-between">
                    <div class="border-2 rounded-lg p-1.5 mt-3 w-[100%] teamDiv {{ $hiddenClass }}">
                        <div class=" text-left mr-12">
                            <label for="role" class="">Team Name </label>
                        </div>
                        <div class="mt-2 grid grid-cols-3 gap-2">

                            @foreach ($teams as $team)
                                <div>
                                    <input {{ in_array($team->id, $oldteams ?? []) ? 'checked' : '' }} type="checkbox"
                                        id="{{ $team->id }}" value="{{ $team->id }}" name="team[]">
                                    <label for="{{ $team->id }}">{{ $team->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="flex justify-between">
                <div class="mt-3 w-[49%]" id="finance-div"
                    style="{{ in_array($user->role, ['Processor', 'Associate', 'Junior Associate']) ? 'display: none' : '' }}">
                    <div class=" text-left mr-12">
                        <label for="finance_type" class="">Finance Type</label>
                    </div>
                    <div class="mt-2">
                        <select id="finance_type" name="finance_type"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="" class="">Choose a value</option>
                            <option {{ old('finance_type', $user->finance_type) == 'Purchase' ? 'selected' : '' }}
                                value="Purchase" class="">Purchase</option>
                            <option {{ old('finance_type', $user->finance_type) == 'Refinance' ? 'selected' : '' }}
                                value="Refinance" class="">Refinance</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3 w-[49%]" id="loan_type_div"
                    style="{{ in_array($user->role, ['Processor', 'Associate', 'Junior Associate']) ? 'display: none' : '' }}">
                    <div class=" text-left mr-12">
                        <label for="loan_type" class="">Loan Type</label>
                    </div>
                    <div class="mt-2">
                        <select id="loan_type" name="loan_type"
                            class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                            <option value="" class="">Choose a value {{ $user->loan_type }}</option>
                            <option {{ old('loan_type', $user->loan_type) == 'Private Loan' ? 'selected' : '' }}
                                value="Private Loan" class="">Private Loan</option>
                            <option {{ old('loan_type', $user->loan_type) == 'Full Doc' ? 'selected' : '' }}
                                value="Full Doc" class="">Full Doc</option>
                            <option {{ old('loan_type', $user->loan_type) == 'Non QM' ? 'selected' : '' }} value="Non QM"
                                class="">Non QM</option>
                        </select>
                    </div>
                </div>
            </div>
            @if (empty($user->id))
                <div class="mt-5 text-left mr-12">
                    <input type="checkbox" {{ old('sendemail') == 'on' ? 'checked' : '' }} name="sendemail"
                        id="sendemail">
                    <label for="sendemail">Send Welcome Email</label>
                </div>
            @endif
            <span id="passwordParent">
                <div class="flex justify-between">
                    <div class="mt-3 w-[49%]">
                        <div class="text-left mr-12">
                            <label for="password" class="flex">{{ $user->id > 0 ? 'Update' : 'Create' }}
                                Password
                                <!--Code Block for indigo tooltip starts-->
                                <a tabindex="0" role="link" aria-label="tooltip 2"
                                    class="ml-2 inline-flex items-centerfocus:outline-none focus:ring-gray-300 rounded-full focus:ring-offset-2 focus:ring-2 focus:bg-gray-200 relative"
                                    onmouseover="showTooltip(2)" onfocus="showTooltip(2)" onmouseout="hideTooltip(2)">
                                    <div class=" cursor-pointer">
                                        <svg aria-haspopup="true" xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-info-circle" width="25"
                                            height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#A0AEC0"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <circle cx="12" cy="12" r="9" />
                                            <line x1="12" y1="8" x2="12.01" y2="8" />
                                            <polyline points="11 12 12 12 12 16 13 16" />
                                        </svg>
                                    </div>
                                    <div id="tooltip2" role="tooltip"
                                        class="bg-gradient-to-b from-gradientStart to-gradientEnd hidden z-20 -mt-[3.4rem] w-64 absolute transition duration-150 ease-in-out left-0 ml-8 shadow-lg  p-4 rounded">
                                        <svg class="absolute left-0 -ml-2 bottom-0 top-0 h-full" width="9px"
                                            height="16px" viewBox="0 0 9 16" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <g id="Tooltips-" transform="translate(-874.000000, -1029.000000)"
                                                    fill="#4c51bf">
                                                    <g id="Group-3-Copy-16" transform="translate(850.000000, 975.000000)">
                                                        <g id="Group-2" transform="translate(24.000000, 0.000000)">
                                                            <polygon id="Triangle"
                                                                transform="translate(4.500000, 62.000000) rotate(-90.000000) translate(-4.500000, -62.000000) "
                                                                points="4.5 57.5 12.5 66.5 -3.5 66.5"></polygon>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <p class="text-sm font-bold text-white pb-1">Tip!</p>
                                        <p class="text-xs leading-4 text-white pb-3">Your password must be 12 characters
                                            long. Should contain at-least 1 uppercase 1 lowercase 1 Numeric and 1 special
                                            character.</p>

                                    </div>
                                </a>
                            </label>
                            <!--Code Block for indigo tooltip ends-->
                        </div>
                        <div class="mt-2">
                            <input type="password"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400"
                                name="password" id="password" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;********">
                        </div>
                        @error('password')
                            <span class="text-red-700">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3 w-[49%]">
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
                </div>
            </span>
            @isset($user->pic)
                <div class="mt-3 mx-auto">
                    <div class=" text-left mr-12">
                        <label for="file" class="">Profile Picture</label>
                    </div>
                    <div class="mt-2">
                        <img class="w-1/5" src="{{ asset($user->pic) }}" alt="">
                        <input type="file" name="file" id="file" accept="image/*">
                    </div>
                </div>
            @endisset
            <div class="mt-10 flex justify-center">
                <button type="submit"
                    class="w-[30%] bg-gradient-to-b from-gradientStart to-gradientEnd capitalize rounded-md px-10 py-2  focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400 text-white">
                    {{ !empty($user->id) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
@endsection
@section('foot')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function showTooltip(flag) {
            switch (flag) {
                case 1:
                    document.getElementById("tooltip1").classList.remove("hidden");
                    break;
                case 2:
                    document.getElementById("tooltip2").classList.remove("hidden");
                    break;
                case 3:
                    document.getElementById("tooltip3").classList.remove("hidden");
                    break;
            }
        }

        function hideTooltip(flag) {
            switch (flag) {
                case 1:
                    document.getElementById("tooltip1").classList.add("hidden");
                    break;
                case 2:
                    document.getElementById("tooltip2").classList.add("hidden");
                    break;
                case 3:
                    document.getElementById("tooltip3").classList.add("hidden");
                    break;
            }
        }
        $("#sendemail").on('change', function(e) {
            e.preventDefault();
            if ($(this).is(":checked")) {
                $("[name='password']").attr('disabled', true);
                $("[name='password_confirmation']").attr('disabled', true);
                $("#passwordParent").addClass('hidden');
            } else {
                $("[name='password_confirmation']").removeAttr('disabled');
                $("#passwordParent").removeClass('hidden');
                $("#passwordParent").removeClass('hidden');
            }
        });
        if ($("#sendemail").is(":checked")) {
            $("#passwordParent").addClass('hidden');
        } else {
            $("[name='password']").removeAttr('disabled');
        }
        let role = document.querySelector('#role');
        let financeDiv = document.querySelector('#finance-div');
        let loanDiv = document.querySelector('#loan_type_div');
        let financeType = document.querySelector('#finance_type');
        role.addEventListener("change", function() {
            if (this.value !== 'Borrower') {
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
            if (role.value == 'Processor' || role.value == 'Admin') {
                if (confirm('Are you sure you want to add a ' + role.value + '?')) {
                    form.submit();
                }
                return;
            }
            return form.submit();
        }
    </script>
    @if (Auth::user()->role !== 'Super Admin')
        <script>
            $('#role').change(function(e) {
                e.preventDefault();
                var role = $(this).val();
                $('.userForm').off('submit');
                if (role === 'Assistant') {
                    $('.userForm').attr('action', "{{ url(getRoutePrefix() . '/share-items/-1') }}");
                    $('.borrowerDiv').removeClass('hidden');
                    $('.teamDiv').addClass('hidden');
                    $('.userForm').submit(function(e) {
                        e.preventDefault();
                        shareItemWithAssistant('-1')
                    });
                } else if (role === 'Borrower') {
                    $('.userForm').attr('action', "{{ url(getRoutePrefix() . '/do-user/-1') }}");
                    $('.borrowerDiv').addClass('hidden');
                    $('.teamDiv').addClass('hidden');
                } else {
                    $('.userForm').attr('action', "{{ url(getRoutePrefix() . '/do-user/-1') }}");
                    $('.borrowerDiv').addClass('hidden');
                    $('.teamDiv').removeClass('hidden');
                }
            });
        </script>
    @endif
    @if (Auth::user()->role === 'Super Admin')
        <script>
            $(document).ready(function() {
                var arr = ['Admin', 'Borrower', 'Assistant'];
                $('#company').change(function() {
                    var companyid = ($(this).val() !== "Select Company") ? $(this).val() : null;
                    ajaxCompanyChange(companyid);
                });

                function removeDivs() {
                    $('.teamDiv').remove();
                    $('.borrowerDiv').remove();
                }


                $('#role').change(function() {
                    var companyid = ($('#company').val() !== "Select Company") ? $('#company').val() : null;
                    ajaxRoleChange(companyid);
                    if ($('#role').val() != 'Assistant') {
                        $('.userForm').attr('action',
                            "{{ empty($user->id) ? url(getRoutePrefix() . (old('role', $user->role) == 'Assistant' ? '/share-items/' : '/do-user/') . '-1') : url(getRoutePrefix() . (old('role', $user->role) == 'Assistant' ? '/share-items/' : '/do-user/') . $user->id) }}"
                        );
                    }
                });


                function ajaxCompanyChange(companyid) {
                    var role = $('#role').val();
                    if (role === 'Assistant' && companyid) {
                        ajaxCompanyBorrowers(companyid);
                    } else if (['Processor', 'Associate', 'Junior Associate'].includes(role) && companyid) {
                        ajaxCompanyTeams(companyid);
                    } else {
                        removeDivs();
                    }
                }

                function ajaxRoleChange(companyid) {
                    var role = $('#role').val();
                    $('.userForm').off('submit');
                    if (role === 'Assistant' && companyid) {
                        ajaxCompanyBorrowers(companyid);
                    } else if (['Processor', 'Associate', 'Junior Associate'].includes(role) && companyid) {
                        ajaxCompanyTeams(companyid);
                    } else {
                        removeDivs();
                    }
                    if (role !== 'Assistant') {
                        $('.userForm').submit(function(e) {
                            $('.userForm').submit();
                        });
                    } else {
                        $('.userForm').submit(function(e) {
                            e.preventDefault();
                            shareItemWithAssistant("{{ $user->id ?? -1 }}")
                        });
                    }
                }
                @if ($user->id > 0)
                    if ($("#role").val() && $('#company').val() > 0) {
                        ajaxRoleChange($('#company').val());
                    } else if ($("#role").val() !== 'Assistant' || $("#role").val() !== 'Borrower' || $("#role")
                        .val() !== 'Admin' && $('#company').val() > 0) {

                    }
                @endif
                function ajaxCompanyBorrowers(companyid) {
                    $('.jq-loader-for-ajax').removeClass('hidden');
                    $.ajax({
                        url: `{{ getRoutePrefix() }}/get-company-borrowers/${companyid}`, // Replace with the actual URL for retrieving users by team
                        type: 'GET',
                        success: function(data) {
                            // var dataArray = Object.values(data);
                            removeDivs();
                            var selectOptions = '<option value="">Select deal</option>';
                            var selected = false;
                            data.forEach(function(project) {
                                @if ($user->id > 0 && isset($projectid))
                                    selected = project.id ===
                                        @json($projectid);
                                @endif
                                selectOptions +=
                                    `<option ${selected ? 'selected' : ''} value="${project.id}">${project.name}</option>`;
                            });
                            $('.company').after(`
                    <div class="mt-3 w-[49%] borrowerDiv">
                        <div class=" text-left mr-12">
                            <label for="user" class="">Deal Name</label>
                        </div>
                        <div class="mt-2">
                            <select name="deal" id="user"
                                class="rounded-md py-2 w-full focus:outline-none focus:border-none  focus:ring-1 focus:ring-blue-400">
                                ${selectOptions}
                            </select>
                        </div>
                    </div>
                `);
                            $('.jq-loader-for-ajax').addClass('hidden');

                        }
                    });
                }

                function ajaxCompanyTeams(companyid) {
                    $('.jq-loader-for-ajax').removeClass('hidden');
                    $.ajax({
                        url: `{{ getRoutePrefix() }}/get-company-teams/${companyid}`, // Replace with the actual URL for retrieving users by team
                        type: 'GET',
                        success: function(data) {
                            removeDivs();
                            var oldteams = @json($oldteams ?? []);
                            var selectOptions = [];
                            data.forEach(function(team) {
                                var isChecked = oldteams.includes(team.id);
                                selectOptions +=
                                    `<div>
                                        
                                     <input ${isChecked ? 'checked' : ''} type="checkbox" id="${team.id}" value="${team.id}"
                                        name="team[]">
                                    <label class="mr-3 mt-3" for="${team.id}">${ team.name }</label>
                                    </div>`;
                            });
                            $('.company').after(`
                                <div class="border-2 rounded-lg p-1.5 w-[100%] mt-5 teamDiv">
                                    <div class=" text-left mr-12">
                                        <label class="">Team Name</label>
                                    </div>
                                    <div class="mt-2 grid grid-cols-3 gap-2">
                                            ${selectOptions}             
                                    </div>
                                </div>
                            `);
                            $('.jq-loader-for-ajax').addClass('hidden');

                        }
                    });
                }
            });
        </script>
    @endif


    <script>
        function shareItemWithAssistant(assistantId) {
            $('.jq-loader-for-ajax').removeClass('hidden');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ url(getRoutePrefix() . '/share-items') }}" + '/' + assistantId,
                data: $('.userForm').serialize(), // Send data as an object
                success: function(response) {
                    $("div[role='alert']").remove();
                    $('.errors').empty();
                    console.log(response);
                    $('.jq-loader-for-ajax').addClass('hidden');
                    if (response === 'sucess') {
                        $('#newProjectModal').toggleClass('hidden');
                        if (assistantId > 0) {
                            window.location.href =
                                "{{ url(getRoutePrefix() . '/redirect/back/assistant-updated-successfully') }}";
                        } else {
                            window.location.href =
                                "{{ url(getRoutePrefix() . '/redirect/back/assistant-created-successfully') }}";
                        }
                    }
                    $.each(response.error, function(index, message) {
                        $('.errors').append(`<div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    <span class="font-medium">Error!</span>
                                     ${message}
                                    </div>`
                            // `<li class="text-red-700">${message}</li>`
                        );
                    });
                },
                error: function(data) {
                    $('.jq-loader-for-ajax').addClass('hidden');
                    console.log(data);
                }
            });
        }
    </script>
@endsection
