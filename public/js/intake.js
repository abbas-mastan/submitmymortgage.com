$('.intakeForm').submit(function (e) {
    e.preventDefault();
    $('[id$="_error"]').text('');
    $('.jq-loader-for-ajax').removeClass('hidden');
    errors = ['email', 'first_name', 'last_name', 'address', 'phone', 'loantype'];
    $.each(errors, function (indexInArray, error_tag) {
        $(`#${error_tag}`).empty();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function (response) {
            console.log(response);
            $('.jq-loader-for-ajax').addClass('hidden');
            if (response === 'success') {
                $('#newProjectModal').toggleClass('hidden');
                window.location.href = routePrefix + '/redirect/dashboard/form-submitted-successfully';
            }
            $.each(response.error, function (index, error) {
                var fieldId = `.${error.field}_error`;
                var errorMessage = error.message;
                $(fieldId).text(errorMessage);
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
});


$('.textInput').on('keyup', function() {
    // Get the current value of the input
    var input = $(this).val();

    // Use a regular expression to remove numbers and special characters
    var filteredInput = input.replace(/[^a-zA-Z\s]/g, '');

    // Set the filtered value back to the input
    $(this).val(filteredInput);
});

$('.personalinfo input').attr('required', true);
$('input[name=address]').attr('required', true);

$('.newProject, .closeModal').click(function (e) {
    e.preventDefault();
    $('#newProjectModal').toggleClass('hidden');
    $('#newProjectModal div:first').removeClass('md:top-44');
    $('#newProjectModal div:first').toggleClass('md:top-9');
});

// this code is the shorter version of below commented code
$('.finance_type').change(function (e) {
    e.preventDefault();
    changeLoantype($(this).val());
});

function changeLoantype(loanType) {
    const selectedValue = loanType;
    const sections = {
        'Purchase': 'purchase',
        'Cash Out': 'cashout',
        'Fix & Flip': 'fix-flip',
        'Refinance': 'refinance'
    };
    for (const section in sections) {
        $("#isItRentalProperty").prop('disabled', selectedValue !== 'Cash Out');
        $("#isItRentalPropertyRefinance").prop('disabled', selectedValue !== 'Refinance');
        $("#isRepairFinanceNeeded").prop('disabled', selectedValue !== 'Fix & Flip');

        if (selectedValue === section) {
            $(`.${sections[section]}`).removeClass('hidden');
            $(`.${sections[section]} input`).removeAttr('disabled');
        } else {
            $(`.${sections[section]}`).addClass('hidden');
            $(`.${sections[section]} input`).attr('disabled', true);
        }
    }
    $('select[name=finance_type]').val(selectedValue);
}

$('#is_there_co_borrower').change(function (e) {
    e.preventDefault();
    borrowerPresent();
});

function borrowerPresent() {
    if ($("#is_there_co_borrower").val() === 'Yes') {
        $('.there_is_co_borrower').removeClass('hidden');
        // Enable inputs and selects when "Yes" is selected
        $('.there_is_co_borrower input, .there_is_co_borrower select').prop('disabled', false);
    } else {
        $('.there_is_co_borrower').addClass('hidden');
        // Disable inputs and selects when not "Yes"
        $('.there_is_co_borrower input, .there_is_co_borrower select').prop('disabled', true);
    }
}

$('.property_type').change(function (e) {
    e.preventDefault();
    // Get the selected value from the changed select
    const selectedValue = $(this).val();
    // Change all other property_type selects to the selected value
    $('.property_type').not(this).val(selectedValue);
});

$('.loan_type').change(function (e) {
    e.preventDefault();
    // Get the selected value from the changed select
    const selectedValue = $(this).val();
    // Change all other loan_type selects to the selected value
    $('.loan_type').not(this).val(selectedValue);
});

$('.property_profile').change(function (e) {
    e.preventDefault();
    // Get the selected value from the changed select
    const selectedValue = $(this).val();
    // Change all other property_profile selects to the selected value
    $('.property_profile').not(this).val(selectedValue);
});



$('#isItRentalProperty').change(function (e) {
    e.preventDefault();
    if ($(this).val() === 'Yes') {
        $('#monthly_rental_income').parent().parent().parent().removeClass('hidden');
        $('#monthly_rental_income').removeAttr('disabled', true);
    } else {
        $('#monthly_rental_income').attr('disabled', true);
        $('#monthly_rental_income').parent().parent().parent().addClass('hidden');
    }
});

$('#isItRentalPropertyRefinance').change(function (e) {
    e.preventDefault();
    if ($(this).val() === 'Yes') {
        $('#monthly_rental_income_refinance').parent().parent().parent().removeClass('hidden');
        $('#monthly_rental_income_refinance').removeAttr('disabled', true);
    } else {
        $('#monthly_rental_income_refinance').attr('disabled', true);
        $('#monthly_rental_income_refinance').parent().parent().parent().addClass('hidden');
    }
});

$('#isRepairFinanceNeeded').change(function (e) {
    e.preventDefault();
    if ($(this).val() === 'Yes') {
        $('.repairfinanceamountdiv').removeClass('hidden');
    } else {
        $('.repairfinanceamountdiv').addClass('hidden');
    }
});

$("#start-upload-btn").click(function (e) {
    e.preventDefault();
    if ($('input[name="attachment[]"]').length > 0) {
        var checkedBoxes = $('input[name="attachment[]"]:checked');
        var checkedValues = checkedBoxes.map(function () {
            return $(this).val();
        }).get();
        if ($('#category').val() === "") {
            alert('Please choose document type');
            return;
        }
        if (!file && checkedValues == 0) {
            alert('Please select or drag a file to upload. Or select at least one file from Gmail');
            return;
        }
        $("#start-upload-div").toggleClass("hidden");
        $("#file-progress").toggleClass("hidden");
        $("#file-name-progress").text(file?.name ?? '');
        uploadToPHPServer(checkedValues);
    } else {
        if ($('#category').val() === "") {
            alert('Please choose document type');
            return;
        }
        if (!file) {
            alert('Please select or drag a file to upload.');
            return;
        }
        $("#start-upload-div").toggleClass("hidden");
        $("#file-progress").toggleClass("hidden");
        $("#file-name-progress").text(file.name);
        uploadToPHPServer();
    }
});

$('.company').change(function (e) {
    e.preventDefault();
    $('.teams').empty();
    $(".teams").append(`
    <option value="">Select Team</option>
    `);
    console.log($(this).val());
    $.ajax({
        url: `/superadmin/get-company-teams/${$(this).val()}`,
        type: 'GET',
        success: function (data) {
            $.each(data, function (index, associate) {
                $(".teams").append(`
                <option value="${associate.id}">${associate.name}</option>
                `);
            });
        }
    });
});