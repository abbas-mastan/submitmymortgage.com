$('.intakeForm').submit(function(e) {
    e.preventDefault();
    $('[id$="_error"]').text('');
    $('.jq-loader-for-ajax').removeClass('hidden');
    errors = ['email', 'first_name', 'last_name', 'address', 'phone', 'loantype'];
    $.each(errors, function(indexInArray, error_tag) {
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
        success: function(response) {
            console.log(response);
            $('.jq-loader-for-ajax').addClass('hidden');
            if (response === 'success') {
                $('#newProjectModal').toggleClass('hidden');
                window.location.href =
                    "{{ url(getRoutePrefix() . '/redirect/dashboard/form-submitted-successfully') }}";
            }
            $.each(response.error, function(index, error) {
                var fieldId = `#${error.field}_error`;
                var errorMessage = error.message;
                $(fieldId).text(errorMessage);
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$('.personalinfo input').attr('required', true);
$('input[name=address]').attr('required', true);

$('.newProject, .closeModal').click(function(e) {
    e.preventDefault();
    $('#newProjectModal').toggleClass('hidden');
    $('#newProjectModal div:first').removeClass('md:top-44');
    $('#newProjectModal div:first').toggleClass('md:top-9');
});

// this code is the shorter version of below commented code
$('.loantype').change(function(e) {
    e.preventDefault();
    const selectedValue = $(this).val();
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
    $('select[name=loan_type]').val(selectedValue);
});

$('#isItRentalProperty').change(function(e) {
    e.preventDefault();
    if ($(this).val() === 'Yes') {
        $('#monthly_rental_income').parent().parent().parent().removeClass('hidden');
        $('#monthly_rental_income').removeAttr('disabled', true);
    } else {
        $('#monthly_rental_income').attr('disabled', true);
        $('#monthly_rental_income').parent().parent().parent().addClass('hidden');
    }
});

$('#isItRentalPropertyRefinance').change(function(e) {
    e.preventDefault();
    if ($(this).val() === 'Yes') {
        $('#monthly_rental_income_refinance').parent().parent().parent().removeClass('hidden');
        $('#monthly_rental_income_refinance').removeAttr('disabled', true);
    } else {
        $('#monthly_rental_income_refinance').attr('disabled', true);
        $('#monthly_rental_income_refinance').parent().parent().parent().addClass('hidden');
    }
});

$('#isRepairFinanceNeeded').change(function(e) {
    e.preventDefault();
    if ($(this).val() === 'Yes') {
        $('.repairfinanceamountdiv').removeClass('hidden');
    } else {
        $('.repairfinanceamountdiv').addClass('hidden');
    }
});

$("#start-upload-btn").click(function(e) {
    e.preventDefault();
    if ($('input[name="attachment[]"]').length > 0) {
        var checkedBoxes = $('input[name="attachment[]"]:checked');
        var checkedValues = checkedBoxes.map(function() {
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