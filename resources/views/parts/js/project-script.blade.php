<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@foreach ($projects as $project)
    <script>
        new DataTable("#{{ Str::slug($project->name . $project->id) }}-table");
        $("#{{ Str::slug($project->name . $project->id) }}-table_length").css('display', 'none');
        $("#{{ Str::slug($project->name . $project->id) }}-table_filter").css('display', 'none');
        $("#{{ Str::slug($project->name . $project->id) }}-table_wrapper").css('box-shadow',
            '0px 0px 11px 0px gray');
        $(`select[name="{{ Str::slug($project->name . $project->id) }}-table_length"]`).addClass('w-16');
        $(`select[name="{{ Str::slug($project->name . $project->id) }}-table_length"]`).addClass('mb-3');
    </script>
@endforeach

<script>
    $(document).ready(function() {
        $.each(['associate', 'processor', 'juniorAssociate'], function(indexInArray, input) {
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

        $.each(['processor', 'associate', 'jrAssociate'], function(index, btnclass) {
            var selector = '.' + btnclass;
            $(selector + 'Button').click(function(e) {
                e.preventDefault();
                $(selector + 'Dropdown').toggleClass('hidden');
            });
        });

        $('.AddNewMember').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').toggleClass('items-center');
            $('#newProjectModal div:first').removeClass('md:top-44 sm:top-36 max-sm:top-44');
            $('#newProjectModal').toggleClass('hidden');
            $('.namepart').addClass('hidden');
            $('.teampart').removeClass('hidden');
            $('.teamDiv').addClass('hidden');
            $(':submit').addClass('py-2');
            $('.backTotype').addClass('hidden');
            $('.modalTitle').text('Add Members');
            $('.addProcessorDiv').addClass('mt-2');
            $('.projectForm input[name="projectId"]').remove();
            $('.projectForm').append(
                `<input type="hidden" name="projectId" value="${$(this).attr('data-project-id')}">`);
            fetchUsersForTeam($(this).attr('data-team-id'));
        });

        $('.newProject, .closeModal').click(function(e) {
            e.preventDefault();
            $('.teamDiv').removeClass('hidden');
            $('#newProjectModal').toggleClass('items-center');
            $('#newProjectModal div:first').removeClass('md:top-44 sm:top-36 max-sm:top-44');
            $('#newProjectModal').toggleClass('hidden');
            $('.namepart').removeClass('hidden');
            $('.teampart').addClass('hidden');
            $('.projectForm input[name="projectId"]').remove();
            $('.projectForm').append(`<input type="hidden" name="projectId" value="-1">`);
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
            $('#borroweraddress_error').text($('#borroweraddress').val() === '' ?
                'This field is required' : '');

            if ($('#name_error').text() === '' && $('#email_error').text() == '' && $(
                    '#borroweraddress_error').text() === '') {

                $('#loantype_error').empty();
                $('#financetype_error').empty();
                $('#team_error').empty();
                $('#associate_error').empty();
                $('.namepart').addClass('hidden');
                $('.typepart').removeClass('hidden');
            }
        });

        $('.typeContinue').click(function(e) {
            e.preventDefault();
            var finance = $('#financetype_error').text($('#financetype').find(':checked').html() ===
                "Select Finance Type" ? 'This field is required' : '');
            var loan = $('#loantype_error').text($('#loantype').find(':checked').html() ===
                "Select Loan Type" ?
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

        $("#team").change(function() {
            fetchUsersForTeam($(this).val());
        });

        function fetchUsersForTeam(teamid) {
            $('.jq-loader-for-ajax').removeClass('hidden');
            $(".processorDropdown").empty();
            $(".associateDropdown").empty();
            $(".jrAssociateDropdown").empty();
            $.ajax({
                url: `{{ getRoutePrefix() }}/getUsersByTeam/${teamid}`,
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
                    if (associates < 1) appendEmptyText('associateDropdown',
                        ' No Associate available');
                    if (juniorAssociates < 1) appendEmptyText(
                        'jrAssociateDropdown', ' No Jr.Associate available');
                    if (processors < 1) appendEmptyText('processorDropdown',
                        ' No Processor available');

                    function appendEmptyText(dropdown, message) {
                        $("." + dropdown).append(
                            `<span class="text-red-700 text-sm text-center p-1">${message}</span>`
                        );
                    }
                    $('.jq-loader-for-ajax').addClass('hidden');

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    // Handle the case when there is an AJAX error
                    $('.jq-loader-for-ajax').addClass('hidden');
                }
            });
        }

        $('#sendemail, #email').on('change', function(e) {
            e.preventDefault();
            handleAjaxRequest(-1);
        });
        $('.projectForm').submit(function(e) {
            e.preventDefault();
            handleAjaxRequest($('input[name="projectId"]').val());
        });

        function handleAjaxRequest(projectId) {
            console.log(projectId);
            var errors = ['borroweraddress', 'email', 'name', 'borroweraddress', 'financetype',
                'loantype',
                'team', 'associate', 'juniorAssociate'
            ];
            $('.jq-loader-for-ajax').removeClass('hidden');

            $.each(errors, function(index, error) {
                var field = `#${error}_error`;
                $(field).empty();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ url(getRoutePrefix() . '/store-project') }}" + '/' + projectId,
                data: $('.projectForm').serialize(),
                success: function(response) {
                    console.log(response);
                    $('.jq-loader-for-ajax').addClass('hidden');

                    if (response === 'success') {
                        window.location.href =
                            "{{ url(getRoutePrefix() . '/redirect/back/project-created-successfully') }}";
                    }
                    $.each(response.error, function(index, error) {
                        var fieldId = `#${error.field}_error`;
                        var errorMessage = error.message;
                        $(fieldId).text(errorMessage);
                        $(fieldId).addClass('text-sm');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    // Handle the case when there is an AJAX error
                    $('.jq-loader-for-ajax').addClass('hidden');
                }
            });
        }

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
