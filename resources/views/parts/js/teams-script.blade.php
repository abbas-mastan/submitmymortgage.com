<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@foreach ($teams as $team)
    <script>
        new DataTable("#{{ str_replace(' ', '', $team->name) }}-table");
        $("#{{ str_replace(' ', '', $team->name) }}-table_length").css('display', 'none');
        $("#{{ str_replace(' ', '', $team->name) }}-table_filter").css('display', 'none');
        $("#{{ str_replace(' ', '', $team->name) }}-table_wrapper").css('box-shadow', '0px 0px 11px 0px gray');
        $(`select[name="{{ $team->name }}-table_length"]`).addClass('w-16');
        $(`select[name="{{ $team->name }}-table_length"]`).addClass('mb-3');
    </script>
@endforeach
<script>
    $.each(['associate', 'processor', 'jrAssociate'], function(indexInArray, input) {
        $(document).on('change', "input[name='" + input + "[]']", function(e) {
            e.preventDefault();
            var indexInArray = $("input[name='" + input + "[]']:checked").length;
            var buttonText = '.' + input + 'ButtonText';
            if (indexInArray > 0) {
                $(buttonText).text(indexInArray + " " + input + (indexInArray > 1 ?
                    "s" : "") + " are selected");
            } else {
                $(buttonText).text("Select " + input);
            }
        });
    });


    var teamsData = {!! json_encode($teams) !!};
    $('.newProject, .closeModal').click(function(e) {
        e.preventDefault();
        $('#newProjectModal').toggleClass('hidden');
    });

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

    $(document).ready(function() {
        // Function to close all dropdowns
        function closeDropdowns() {
            $('.associateDropdown, .jrAssociateDropdown, .processorDropdown').addClass('hidden');
        }
        // Click event listener for the document
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.associateButton, .jrAssociateButton, .processorButton').length &&
                !$(e.target).closest('.associateDropdown, .jrAssociateDropdown, .processorDropdown')
                .length) {
                closeDropdowns();
            }
        });
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
        if ($('#new').hasClass('hidden')) {
            if ($('#selecTeam').find(':checked').html() === "Select Team") {
                showError('team')
            } else {
                $('#teamForm').attr('action',
                    `{{ url(getAdminRoutePrefix() . '/teams') }}/${$('#selecTeam').find(':checked').val()}`
                )
                removeError('name');
                $('.modalTitle').text('Add an Processor');
                $('.createTeam').addClass('hidden');
                $('.processor').removeClass('hidden');
            }
        } else {
            if ($('#name').val() === '') {
                showError('name');
            } else if ($('#name').val().length < 8) {
                showError('name', ' must be at least 8 characters');
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
                    removeError('name');
                    $('.modalTitle').text('Add an Processor');
                    $('.createTeam').addClass('hidden');
                    $('.processor').removeClass('hidden');
                }
            }
        }
    });

    $('.processorContinue').click(function(e) {
        e.preventDefault();
        var selectedProcessorValues = [];
        $('input[name="processor[]"]:checked').each(function() {
            selectedProcessorValues.push($(this).val());
        });
        var selectedProcessors = $('input[name="processor[]"]:checked');
        if (selectedProcessors.length === 0) {
            $('#processor_error').text('Please select at least one processor');
            return;
        } else {
            $('#processor_error').text('');
            $(".associateDropdown").empty();
            $(document).ready(function() {
                $.ajax({
                    url: `{{ getAdminRoutePrefix() }}/getUsersByProcessor/${selectedProcessorValues}/${teamid}`, // Replace with the actual URL for retrieving users by team
                    type: 'GET',
                    success: function(data) {
                        if (data == 'processorerror') {
                            $('#processor_error').text(
                                'this processor is already exists');
                        } else {
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

                            $('.modalTitle').text('Add an Associate');
                            $('.processor').addClass('hidden');
                            $('.associate').removeClass('hidden');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        }
    });

    $('.associateContinue').click(function(e) {
        e.preventDefault();
        var selectedAssociateValues = [];
        $('input[name="associate[]"]:checked').each(function() {
            selectedAssociateValues.push($(this).val());
        });
        var selectedAssociates = $('input[name="associate[]"]:checked');
        if (selectedAssociates.length === 0) {
            $('#associate_error').text('Please select at least one associate');
            return;
        } else {
            $('#associate_error').text('');
            $(".jrAssociateDropdown").empty();
            $(document).ready(function() {
                $.ajax({
                    url: `{{ getAdminRoutePrefix() }}/getUsersByProcessor/${selectedAssociateValues}/${teamid}`, // Replace with the actual URL for retrieving users by team
                    type: 'GET',
                    success: function(data) {
                        if (data == 'processorerror') {
                            $('.associateContinue').attr('disabled', 'disabled');
                            $('#associate_error').text(
                                'this associate is already exists');
                        } else {
                            var jrassociates = [];
                            $.each(data, function(index, associate) {
                                if (associate.role === 'Junior Associate') {
                                    jrassociates.push(associate);
                                }
                            });
                            $.each(jrassociates, function(index, associate) {
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
                                ${associate.name }
                            </label>
                        </div>`);
                            });

                            $('.modalTitle').text('Add an Jr Associate');
                            $('.associate').addClass('hidden');
                            $('.jrAssociate').removeClass('hidden');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
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
        if (selectedAssociates.length === 0) {
            $('#jrAssociate_error').text('Please select at least one associate');
            return;
        } else removeError('jrAssociate');

        if ($('#jrAssociateManager').val() === '') {
            showError('jrAssociateManager');
            return;
        } else {
            removeError('jrAssociateManager');
        }
        $('#teamForm').submit();
    });

    $(document).ready(function() {
        if ($('#newInput').is(':checked')) {
            $('#new').removeClass('hidden');
            $('#existing').addClass('hidden');
            $('#new input').removeAttr('disabled'); // Correct the selector and method
            $('#existing select').attr('disabled', 'disabled'); // Correct the selector and method
        }
    });

    function changeInputs() {
        if ($('#newInput').is(':checked')) {
            $('#new').removeClass('hidden');
            $('#existing').addClass('hidden');
            $('#new input').removeAttr('disabled'); // Correct the selector and method
            $('#existing select').attr('disabled', 'disabled'); // Correct the selector and method
        } else {
            $('#new').addClass('hidden');
            $('#existing').removeClass('hidden');
            $('#existing select').removeAttr('disabled'); // Correct the selector and method
            $('#new input').attr('disabled', 'disabled'); // Correct the selector and method
        }
    }

    $('.backToCreateTeam').click(function(e) {
        e.preventDefault();
        $('.modalTitle').text('Create New Team');
        $('.createTeam').removeClass('hidden');
        $('.processor').addClass('hidden');
    });

    $('.backToCreateProcessor').click(function(e) {
        e.preventDefault();
        $('.modalTitle').text('Create New Processor');
        $('.processor').removeClass('hidden');
        $('.associate').addClass('hidden');
    });
    $('.backToCreateAssociate').click(function(e) {
        e.preventDefault();
        $('.modalTitle').text('Add an Associate');
        $('.associate').removeClass('hidden');
        $('.jrAssociate').addClass('hidden');
    });

    $(document).ready(function() {
        $('#user-table').DataTable({
            pageLength: 30,
            lengthMenu: [10, 20, 30, 50, 100, 200],
        });
        $('#unverified').html($('.unverifiedSerial:last').html());
        $('#verified').html($('.verifiedSerial:last').html());
        $('#deleted').html($('.deletedSerial:last').html());
    });
</script>
