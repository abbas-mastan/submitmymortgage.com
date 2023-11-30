<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@foreach ($teams as $team)
    <script>
        new DataTable("#{{ Str::slug($team->name) }}-table{{ $team->id }}");
        $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_length").css('display', 'none');
        $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_filter").css('display', 'none');
        $("#{{ Str::slug($team->name) }}-table{{ $team->id }}_wrapper").css('box-shadow', '0px 0px 11px 0px gray');
        $(`select[name="{{ Str::slug($team->name) }}-table{{ $team->id }}_length"]`).addClass('w-16');
        $(`select[name="{{ Str::slug($team->name) }}-table{{ $team->id }}_length"]`).addClass('mb-3');
    </script>
@endforeach

@if ($currentrole === 'Super Admin' || $currentrole === 'Admin' || $currentrole === 'Processor' )
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
    $('.addNewAssociate ,.backToAssociate').click(function(e) {
        e.preventDefault();
        handleNewAssociate();
    });

    function handleNewAssociate() {
        $('.associate').toggleClass('hidden');
        $('.associateForm').toggleClass('hidden');
        if ($('.associateForm').hasClass('hidden')) {
            $('.modalTitle').text('Add an Associate');
        } else {
            $('.modalTitle').text('Create New Associate');
        }
        $('.associateForm input').attr('required', true);
    }

    $('.associateForm').submit(function(e) {
        e.preventDefault();
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

                if (response === 'success') {
                    handleNewAssociate();
                    getAssociates();
                    $('.associate').before(
                        `<span class="associcateSuccess text-green-700">Associate created successfully!</span>`
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

    function getAssociates() {
        $('.jq-loader-for-ajax').removeClass('hidden');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.jq-loader-for-ajax').removeClass('hidden');
        $.ajax({
            type: "post",
            url: "{{ getRoutePrefix() . '/get-associates' }}",
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
                    var button = `<span class="inputLabel mr-1">${$btnText}</span>`;
                    $(button).appendTo(buttonText);
                });
            } else {
                $(buttonText).text("Select " + input);
            }
        });

    });

    var teamsData = {!! json_encode($teams) !!};
    $('.newProject, .closeModal').click(function(e) {
        e.preventDefault();
        $('#newProjectModal').toggleClass('hidden');
        $('#newProjectModal').toggleClass('items-center');
        $('#newProjectModal div:first').toggleClass('md:top-44 max-sm:top-44 sm:top-36');

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
        function closeDropdowns() {
            $('.associateDropdown, .jrAssociateDropdown, .processorDropdown').addClass('hidden');
        }
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
                    `{{ url(getRoutePrefix() . '/teams') }}/${$('#selecTeam').find(':checked').val()}`
                )
                removeError('name');
                $('.modalTitle').text('Add an Processor');
                $('.createTeam').addClass('hidden');
                $('.processor').removeClass('hidden');
            }
        } else {
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
                    removeError('name');
                    $('.modalTitle').text('Add an Processor');
                    $('.createTeam').addClass('hidden');
                    $('.processor').removeClass('hidden');
                }
            }
        }
    });
    // @if ($currentrole !== 'Super Admin' || $currentrole !== 'Admin')
    //     $('.processorContinue').click(function(e) {
    //         e.preventDefault();
    //         var selectedProcessorValues = [];
    //         $('input[name="processor[]"]:checked').each(function() {
    //             selectedProcessorValues.push($(this).val());
    //         });
    //         var selectedProcessors = $('input[name="processor[]"]:checked');
    //         if (selectedProcessors.length === 0) {
    //             $('#processor_error').text('Please select at least one processor');
    //             return;
    //         } else {
    //             $('.associateButtonText').text('Select Associate');
    //             $('#processor_error').text('');
    //             $(".associateDropdown").empty();
    //             $(document).ready(function() {
    //                 $.ajax({
    //                     url: `{{ getRoutePrefix() }}/getUsersByProcessor/${selectedProcessorValues}/${teamid}`, // Replace with the actual URL for retrieving users by team
    //                     type: 'GET',
    //                     success: function(data) {
    //                         if (data == 'processorerror') {
    //                             $('#processor_error').text(
    //                                 'this processor is already exists');
    //                         } else {
    //                             var associates = [];
    //                             $.each(data, function(index, associate) {
    //                                 if (associate.role === 'Associate') {
    //                                     associates.push(associate);
    //                                 }
    //                             });
    //                             $.each(associates, function(index, associate) {
    //                                 if (index > 3) {
    //                                     $('.associateDropdown').addClass(
    //                                         'h-56 overflow-y-auto')
    //                                 }
    //                                 $(".associateDropdown").append(`<div class="py-1">
    //                             <label
    //                                 class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
    //                                 role="option">
    //                                 <input type="checkbox" name="associate[]"
    //                                     class="associateinput form-checkbox h-4 w-4 text-blue-600 mr-2" value="${associate.id}">
    //                                 ${associate.name }
    //                             </label>
    //                         </div>`);
    //                             });

    //                             $('.modalTitle').text('Add an Associate');
    //                             $('.processor').addClass('hidden');
    //                             $('.associate').removeClass('hidden');
    //                         }
    //                     },
    //                     error: function(error) {
    //                         console.log(error);
    //                     }
    //                 });
    //             });
    //         }
    //     });

    //     $('.associateContinue').click(function(e) {
    //         e.preventDefault();
    //         $('.associcateSuccess').empty();
    //         var selectedAssociateValues = [];
    //         $('input[name="associate[]"]:checked').each(function() {
    //             selectedAssociateValues.push($(this).val());
    //         });
    //         var selectedAssociates = $('input[name="associate[]"]:checked');
    //         if (selectedAssociates.length === 0) {
    //             $('#associate_error').text('Please select at least one associate');
    //             return;
    //         } else {
    //             $('#associate_error').text('');
    //             $(".jrAssociateDropdown").empty();
    //             $(document).ready(function() {
    //                 $.ajax({
    //                     url: `{{ getRoutePrefix() }}/getUsersByProcessor/${selectedAssociateValues}/${teamid}`, // Replace with the actual URL for retrieving users by team
    //                     type: 'GET',
    //                     success: function(data) {
    //                         if (data == 'processorerror') {
    //                             $('.associateContinue').attr('disabled', 'disabled');
    //                             $('#associate_error').text(
    //                                 'this associate is already exists');
    //                         } else {
    //                             var jrassociates = [];
    //                             $.each(data, function(index, associate) {
    //                                 if (associate.role === 'Junior Associate') {
    //                                     jrassociates.push(associate);
    //                                 }
    //                             });
    //                             $.each(jrassociates, function(index, associate) {
    //                                 if (index > 3) {
    //                                     $('.jrAssociateDropdown').addClass(
    //                                         'h-56 overflow-y-auto')
    //                                 }
    //                                 $(".jrAssociateDropdown").append(`<div class="py-1">
    //                             <label
    //                                 class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
    //                                 role="option">
    //                                 <input type="checkbox" name="jrAssociate[]"
    //                                     class="form-checkbox h-4 w-4 text-blue-600 mr-2" value="${associate.id}">
    //                                 ${associate.name }
    //                             </label>
    //                         </div>`);
    //                             });

    //                             $('.modalTitle').text('Add an Jr Associate');
    //                             $('.associate').addClass('hidden');
    //                             $('.jrAssociate').removeClass('hidden');
    //                         }
    //                     },
    //                     error: function(error) {
    //                         console.log(error);
    //                     }
    //                 });
    //             });
    //         }
    //     });

    // @endif

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
        $('.associcateSuccess').empty();
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
