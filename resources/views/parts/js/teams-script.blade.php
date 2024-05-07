<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@foreach ($enableTeams as $team)
    <script>
        new DataTable("#{{ Str::slug($team->name) }}-table{{ $team->id }}");
        $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_length").css('display', 'none');
        $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_filter").css('display', 'none');
        $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_wrapper").css('box-shadow', '0px 0px 11px 0px gray');
        $(`select[name="{{ Str::slug($team->name) }}-table{{ $team->id }}_length"]`).addClass('w-16');
        $(`select[name="{{ Str::slug($team->name) }}-table{{ $team->id }}_length"]`).addClass('mb-3');
    </script>
@endforeach
@can('isSuperAdmin')
    @foreach ($disableTeams as $team)
        <script>
            new DataTable("#{{ Str::slug($team->name) }}-table{{ $team->id }}");
            $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_length").css('display', 'none');
            $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_filter").css('display', 'none');
            $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_wrapper").css('box-shadow', '0px 0px 11px 0px gray');
            $(`select[name="{{ Str::slug($team->name) }}-table{{ $team->id }}_length"]`).addClass('w-16');
            $(`select[name="{{ Str::slug($team->name) }}-table{{ $team->id }}_length"]`).addClass('mb-3');
        </script>
    @endforeach
@endcan
@if ($currentrole === 'Super Admin' || $currentrole === 'Admin' || $currentrole === 'Processor')
    <script>
        if ($('.associateDropdown > div').length > 5) {
            $('.associateDropdown').addClass('h-56 overflow-y-auto');
        }
        if ($('.jrAssociateDropdown > div').length > 5) {
            $('.jrAssociateDropdown').addClass('h-56 overflow-y-auto');
        }
        $('.associateContinue').click(function(e) {
            e.preventDefault();
            $('.associcateSuccess').empty();
            $('.modalTitle').text('Add an Jr Associate');
            $('.associate').addClass('hidden');
            $('.jrAssociate').removeClass('hidden');
        });
        $('.processorContinue').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Add an Associate');
            $('.processor').addClass('hidden');
            $('.associate').removeClass('hidden');
        });
    </script>
@endif
<script>
    $(document).ready(function() {

        @if (Auth::user()->role !== 'Super Admin')
            if ($('.processorcount').val() === undefined) {
                $('.processorDropdown').append(`
                <span class="text-red-700 text-sm text-center p-1">No data available</span>`);
            }
            if ($('.associatecount').val() === undefined) {
                $('.associateDropdown').append(`
                <span class="text-red-700 text-sm text-center p-1">No data available</span>`);
            }
            if ($('.juniorassociatecount').val() === undefined) {
                $('.jrAssociateDropdown').append(`
                <span class="text-red-700 text-sm text-center p-1">No data available</span>`);
            }
        @endif

        $('.addNewAssociate ,.backToAssociate ,.closeModal',).click(function(e) {
            e.preventDefault();
            handleNewAssociate();
        });
        var companyid = null;
        $('.addMembers').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').toggleClass('hidden');
            $('#newProjectModal').toggleClass('items-center');
            $('#newProjectModal div:first').toggleClass('md:top-44 max-sm:top-44 sm:top-36');
            var EditTeamId = $(this).attr('id');
            $('#teamForm').attr('action', `{{ url(getRoutePrefix() . '/teams') }}/${EditTeamId}`);
            $('input[name="name"]').val($(this).attr('name'));
            $('.modalTitle').text('Add Members');
            $('.createTeam').addClass('hidden');
            $('.processor').removeClass('hidden');
            companyid = $(this).attr('company');
            fetchCompanyUsers(companyid);
        });
        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('.jrAssociateButton').val('Select jrAssociate');
            $('input[name="name"]').val('');
            $('#teamForm').attr('action', `{{ url(getRoutePrefix() . '/teams/-1') }}`);
            $('#newProjectModal').toggleClass('hidden');
            $('#newProjectModal').toggleClass('items-center');
            $('#newProjectModal div:first').toggleClass('md:top-44 max-sm:top-44 sm:top-36');
            $('.createTeam').removeClass('hidden');
            $('.processor').addClass('hidden');

        });
        $('#company').change(function(e) {
            e.preventDefault();
            if ($('#company').find(':checked').html() !== "Select Company") {
                companyid = ($('#company').find(':checked').val());
                fetchCompanyUsers(companyid);
            }
        });

        function fetchCompanyUsers(companyid) {
            $(".processorDropdown").empty();
            $(".associateDropdown").empty();
            $(".jrAssociateDropdown").empty();
            $.ajax({
                url: `{{ getRoutePrefix() }}/getUsersByCompany/${companyid}`, // Replace with the actual URL for retrieving users by team
                type: 'GET',
                success: function(data) {
                    var associates = [];
                    var juniorAssociates = [];
                    var processors = [];
                    $.each(data, function(index, associate) {
                        if (associate.role === 'Associate') {
                            associates.push(associate);
                        } else if (associate.role === 'Junior Associate') {
                            juniorAssociates.push(associate);
                        } else if (associate.role === 'Processor') {
                            processors.push(associate);
                        }
                    });
                    function appendEmptyText(dropdown) {
                        $("." + dropdown).append(
                            `<span class="text-red-700 text-sm text-center p-1">No data available</span>`
                        );
                    }
                    if (associates < 1) appendEmptyText('associateDropdown');
                    if (juniorAssociates < 1) appendEmptyText('jrAssociateDropdown');
                    if (processors < 1) appendEmptyText('processorDropdown');
                    $.each(associates, function(index, associate) {
                        if (index > 3) {
                            $('.associateDropdown').addClass(
                                'h-56 overflow-y-auto')
                        }
                        $(".associateDropdown").append(`<div class="py-1">
                            <label
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                role="option">
                                <input type="checkbox" name="associate[]"
                                class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="${associate.id}">
                                ${associate.name}
                                </label>
                                </div>`);
                    });

                    $.each(juniorAssociates, function(index, associate) {
                        if (index > 3) {
                            $('.jrAssociateDropdown').addClass(
                                'h-56 overflow-y-auto')
                        }
                        $(".jrAssociateDropdown").append(`<div class="py-1">
                            <label
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                role="option">
                                <input type="checkbox" name="jrAssociate[]"
                                    class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="${associate.id}">
                                ${associate.name}
                            </label>
                        </div>`);
                    });
                    $.each(processors, function(index, associate) {

                        if (index > 3) {
                            $('.processorDropdown').addClass(
                                'h-56 overflow-y-auto')
                        }
                        $(".processorDropdown").append(`<div class="py-1">
                            <label
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                role="option">
                                <input type="checkbox" name="processor[]"
                                    class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="${associate.id}">
                                ${associate.name}
                            </label>
                        </div>`);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function handleNewAssociate() {
            $('.associate').toggleClass('hidden');
            $('.associateForm').toggleClass('hidden');
            $('.createTeam').addClass('hidden');
            $('.processor').addClass('hidden');
            
            if ($('.associateForm').hasClass('hidden')) {
                $('.processor').removeClass('hidden');
                $('.modalTitle').text('Add an Members');
            } else {
                @if (Auth::user()->role === 'Super Admin')
                    companyid = ($('#company').find(':checked').val());
                    $('.associateForm').append(`<input type="hidden" name="company" value="${companyid}">`);
                @endif
                $('.modalTitle').text('Create New Associate');
            }
            $('.associateForm input').attr('required', true);
        }

        $('.associateForm').submit(function(e) {
            $('.associcateSuccess').remove();
            $('.max_user_error').remove();
            e.preventDefault();
            @if (Auth::user()->role === 'Super Admin')
                var companyid = {!! Auth::user()->role === 'Super Admin' ? "$('#company').find(':checked').val()" : Auth::user()->company_id !!};
            @endif
            $('.jq-loader-for-ajax').removeClass('hidden');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('.jq-loader-for-ajax').addClass('hidden');
                    console.log(response);
                    if(response.maximum_users){
                        $('.modalTitle').after(`<div class="max_user_error text-red-700 mt-2 text-center">${response.maximum_users}!</div>`);
                    }
                    if (response === 'success') {
                        handleNewAssociate();
                        getAssociates(companyid);
                        $('.associate').before(
                            `<span class="associcateSuccess text-green-700">Associate created successfully!</span>
                            <br>
                            `
                        );
                    }
                    $.each(response.error, function(index, error) {
                        var fieldId = `#${error.field}_error`;
                        var errorMessage = error.message;
                        $(fieldId).text(errorMessage);
                    });
                }
            });
        });

        function getAssociates(companyid) {
            companyid = companyid ?? @json(Auth::user()->company_id);
            console.log(companyid);
            $('.jq-loader-for-ajax').removeClass('hidden');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.jq-loader-for-ajax').removeClass('hidden');
            $.ajax({
                type: "post",
                url: "{{ getRoutePrefix() . '/get-associates' }}" + '/' + companyid,
                data: {},
                success: function(data) {
                    $('.jq-loader-for-ajax').addClass('hidden');
                    $('.associateDropdown').empty();
                    var associates = [];
                    $.each(data, function(index, associate) {
                        if (associate.role === 'Associate') {
                            associates.push(associate);
                        }
                    });
                    $.each(associates, function(index, associate) {
                        if (index > 3) {
                            $('.associateDropdown').addClass(
                                'h-56 overflow-y-auto')
                        }
                        $(".associateDropdown").append(`<div class="py-1">
                            <label
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                            role="option">
                            <input type="checkbox" name="associate[]"
                                    class="associateinput form-checkbox h-4 w-4 text-blue-600 mr-2" value="${associate.id}">
                                ${associate.name }
                            </label>
                        </div>`);
                    });
                },
                error: function(error) {
                    $('.jq-loader-for-ajax').addClass('hidden');
                }
            });
        }

        $.each(['associate', 'processor', 'jrAssociate'], function(indexInArray, input) {
            $(document).on('change', "input[name='" + input + "[]']", function(e) {
                e.preventDefault();
                var buttonText = '.' + input + 'ButtonText';
                var $selectedItems = $("input[name='" + input + "[]']:checked");
                if ($selectedItems.length > 0) {
                    $(buttonText).empty(); // Clear existing content
                    $selectedItems.each(function() {
                        var $btnText = $(this).parent().text();
                        var button =
                            `<span class="inputLabel mr-1">${$btnText}</span>`;
                        $(button).appendTo(buttonText);
                    });
                } else {
                    $(buttonText).text("Select " + input);
                }
            });

        });

        var teamsData = {!! json_encode($teams) !!};



        var teamid = 0;
        $('.teamContinue').click(function(e) {
            if ($('#new').hasClass('hidden')) {
                if ($('#selecTeam').find(':checked').html() !== "Select Team") {
                    teamid = $('#selecTeam').find(':checked').val()
                }
            }
        });

        if ($('.processorcount').last().val() > 4) {
            $('.processorDropdown').addClass('overflow-y-auto h-56');
        }

        function closeDropdowns() {
            $('.associateDropdown, .jrAssociateDropdown, .processorDropdown').addClass(
                'hidden');
        }
        $(document).on('click', function(e) {
            if (!$(e.target).closest(
                    '.associateButton, .jrAssociateButton, .processorButton').length &&
                !$(e.target).closest(
                    '.associateDropdown, .jrAssociateDropdown, .processorDropdown')
                .length) {
                closeDropdowns();
            }
        });


        $.each(['processor', 'associate', 'jrAssociate'], function(index, btnclass) {
            var selector = '.' + btnclass;
            $(selector + 'Button').click(function(e) {
                e.preventDefault();
                $(selector + 'Dropdown').toggleClass('hidden');
            });
        });

        $('.teamContinue').click(function(e) {
            e.preventDefault();
            if ($('#name').val() === '') {
                showError('name');
            } else {
                // Iterate through teamsData to check for name existence
                var nameExists = false;
                $.each(teamsData, function(index, team) {
                    if ($('#name').val() === team.name) {
                        nameExists = true;
                        showError('name', ' is already exists');
                        return false; // Exit the loop early
                    }
                });
                if (!nameExists) {
                    @if ($currentrole === $superadminrole)
                        if ($('#company').find(':checked').html() === "Select Company") {
                            showError('company');
                            return false
                        } else {
                            removeError('company');
                        }
                    @endif
                    removeError('name');
                    $('.modalTitle').text('Add an Processor');
                    $('.createTeam').addClass('hidden');
                    $('.processor').removeClass('hidden');
                }
            }
        });

        function showError(id, error = " field is required") {
            $('#' + id).addClass('border-red-700 border-2');
            $('#' + id + "_error").text(id + error);
            return false;
        }

        function removeError(id) {
            $('#' + id).removeClass('border-red-700 border-2');
            $('#' + id + '_error').text('');
            return true;
        }

        $('.jrAssociateContinue').click(function(e) {
            e.preventDefault();
            var selectedAssociates = $('input[name="jrAssociate[]"]:checked');
            $('#teamForm').submit();
        });


        if ($('#newInput').is(':checked')) {
            $('#new').removeClass('hidden');
            $('#existing').addClass('hidden');
            $('#new input').removeAttr('disabled'); // Correct the selector and method
            $('#existing select').attr('disabled',
                'disabled'); // Correct the selector and method
        }

        $('.backToCreateTeam').click(function(e) {
            e.preventDefault();
            $('.modalTitle').text('Create New Team');
            $('.createTeam').removeClass('hidden');
            $('.processor').addClass('hidden');
        });

        if ($('.enableTeams').val() > 0) {
            $('.enableTeamsHeader').removeClass('hidden');
        } else {
            $('.enableTeamsHeader').addClass('hidden');
        }
        if ($('.disableTeams').val() > 0) {
            $('.disableTeamsHeader').removeClass('hidden');
        } else {
            $('.disableTeamsHeader').addClass('hidden');
        }


        // $('#user-table').DataTable({
        //     pageLength: 30,
        //     lengthMenu: [10, 20, 30, 50, 100, 200],
        // });
        $('#unverified').html($('.unverifiedSerial:last').html());
        $('#verified').html($('.verifiedSerial:last').html());
        $('#deleted').html($('.deletedSerial:last').html());
    });
</script>
