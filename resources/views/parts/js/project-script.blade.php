<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@foreach ($projects as $project)
    <script>
        new DataTable("#{{ str_replace(' ', '', $project->name . $project->id) }}-table");
        $("#{{ str_replace(' ', '', $project->name . $project->id) }}-table_length").css('display', 'none');
        $("#{{ str_replace(' ', '', $project->name . $project->id) }}-table_filter").css('display', 'none');
        $("#{{ str_replace(' ', '', $project->name . $project->id) }}-table_wrapper").css('box-shadow',
            '0px 0px 11px 0px gray');
        $(`select[name="{{ $project->name . $project->id }}-table_length"]`).addClass('w-16');
        $(`select[name="{{ $project->name . $project->id }}-table_length"]`).addClass('mb-3');
    </script>
@endforeach
@can('isAdmin')
    <script>
        $.each(['associate', 'processor', 'juniorAssociate'], function(indexInArray, input) {
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

            $.each(['processor', 'associate', 'jrAssociate'], function(index, btnclass) {
                var selector = '.' + btnclass;
                $(selector + 'Button').click(function(e) {
                    e.preventDefault();
                    $(selector + 'Dropdown').toggleClass('hidden');
                });
            });
        });


        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').toggleClass('hidden');
        });
        $('#email').attr('disabed', 'disabled');
        $("#sendemail").change(function(e) {
            e.preventDefault();
            $('.email').toggleClass('hidden');
            if ($('.email').hasClass('hidden')) {
                $('#email').attr('disabled', 'disabled');
            } else {
                $('#email').removeAttr('disabled');
            }
        });

        $("#addprocessor").change(function(e) {
            e.preventDefault();
            $('.processor').toggleClass('hidden');
            if ($('.processor').hasClass('hidden')) {
                $('#processor').attr('disabled', 'disabled');
            } else {
                $('#processor').removeAttr('disabled');
            }
        });

        $('.nameContinue').click(function(e) {
            e.preventDefault();
            $('#name_error').text($('#name').val() === '' ? 'This field is required' : '');
            if ($('.email').hasClass('hidden')) {
                $('#email_error').text('');
            } else {
                $('#email_error').text($('#email').val() === '' ? 'This field is required' : '');
            }
            $('#borroweraddress_error').text($('#borroweraddress').val() === '' ? 'This field is required' : '');

            if ($('#name_error').text() === '' && $('#email_error').text() === '' && $(
                    '#borroweraddress_error').text() === '') {
                $('.namepart').addClass('hidden');
                $('.typepart').removeClass('hidden');
            }
        });

        $('.typeContinue').click(function(e) {
            e.preventDefault();
            var finance = $('#financetype_error').text($('#financetype').find(':checked').html() ===
                "Select Finance Type" ? 'This field is required' : '');
            var loan = $('#loantype_error').text($('#loantype').find(':checked').html() === "Select Loan Type" ?
                'This field is required' : '');
            if ($('#financetype_error').text() === '' && $('#loantype_error').text() === '') {
                $('.typepart').addClass('hidden');
                $('.teampart').removeClass('hidden');
            }
        });


        $(".backToname").click(function(e) {
            e.preventDefault();
            $('.typepart').addClass('hidden');
            $('.namepart').removeClass('hidden');
        });
        $(".backTotype").click(function(e) {
            e.preventDefault();
            $('.teampart').addClass('hidden');
            $('.typepart').removeClass('hidden');
        });

        $(document).ready(function() {
            $("#team").change(function() {
                $(".processorDropdown").empty();
                $(".associateDropdown").empty();
                $(".jrAssociateDropdown").empty();
                $.ajax({
                    url: `{{ getAdminRoutePrefix() }}/getUsersByTeam/${$(this).val()}`, // Replace with the actual URL for retrieving users by team
                    type: 'GET',
                    success: function(data) {
                        // Clear existing options in the "selecassociate" and "selectJuniorAssociate" selects

                        // Process the data to categorize roles
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

                        // Populate the "selecassociate" select with Associate options
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

                        // Populate the "selectJuniorAssociate" select with Junior Associate options
                        $.each(juniorAssociates, function(index, associate) {
                            if (index > 3) {
                                $('.jrAssociateDropdown').addClass(
                                    'h-56 overflow-y-auto')
                            }
                            $(".jrAssociateDropdown").append(`<div class="py-1">
                            <label
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-100"
                                role="option">
                                <input type="checkbox" name="juniorAssociate[]"
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
            });
        });
    </script>

    <script>
        $('.projectForm').submit(function(e) {
            e.preventDefault();
            var errors = ['borroweraddress', 'email', 'name', 'borroweraddress', 'financetype',
                'loantype',
                'team', 'associate', 'juniorAssociate'
            ];

            $.each(errors, function(index, error) {
                var field = `#${error}_error`;
                $(field).text('');
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ url(getAdminRoutePrefix() . '/store-project') }}",

                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if (response === 'success') {
                        location.reload();
                    }
                    $.each(response.error, function(index, error) {
                        var fieldId = `#${error.field}_error`;
                        var errorMessage = error.message;
                        $(fieldId).text(errorMessage);
                    });
                }
            });
        });
    </script>
@endcan

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
