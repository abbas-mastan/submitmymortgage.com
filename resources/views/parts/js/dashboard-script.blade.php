<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
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
                
                $('.jq-loader-for-ajax').addClass('hidden');
                if (response === 'success') {
                    $('#newProjectModal').toggleClass('hidden');
                    window.location.href =
                        "{{ url(getAdminRoutePrefix() . '/redirect/dashboard/form-submitted-successfully') }}";
                }
                $.each(response.error, function(index, error) {
                    var fieldId = `#${error.field}_error`;
                    var errorMessage = error.message;
                    $(fieldId).text(errorMessage);
                });
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
            $('#monthly_rental_income').removeAttr('disabled',true);
        } else {
            $('#monthly_rental_income').attr('disabled',true);
            $('#monthly_rental_income').parent().parent().parent().addClass('hidden');
        }
    });

    $('#isItRentalPropertyRefinance').change(function(e) {
        e.preventDefault();
        if ($(this).val() === 'Yes') {
            $('#monthly_rental_income_refinance').parent().parent().parent().removeClass('hidden');
            $('#monthly_rental_income_refinance').removeAttr('disabled',true);
        } else {
            $('#monthly_rental_income_refinance').attr('disabled',true);
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

    function uploadToPHPServer(checkedValues = null) {
        var formData = new FormData();
        if (file) {
            var blob = file instanceof Blob ? file : file.getBlob();
            blob = new File([blob], file.name.split(".")[1], {
                type: 'application/octet-stream'
            });
            formData.append('filename', file.name);
            formData.append('file', blob);
        }
        formData.append('_token', reConfig.csrfToken);
        if (typeof userId !== 'undefined') {
            formData.append('id', userId);
        }
        formData.append('category', $('#category').val());
        if (checkedValues !== null) {
            formData.append('attachment', $.map(checkedValues, function(value, index) {
                return [value];
            }));
        }
        // var upload_url = 'https://your-domain.com/files-uploader/';
        var upload_url = '{{ url(getUserRoutePrefix() . '/file-upload') }}';
        makeXMLHttpRequest(upload_url, formData, function(progress) {
            console.log(progress);
            if (progress !== 'upload-ended') {
                $("#progressbar").css("width", progress);
                $("#file-name-percent").text(progress);
                return;
            }
            alert('File upload complete.')
            $("#start-upload-div").toggleClass("hidden");
            $("#file-progress").toggleClass("hidden");
            $("#filename").text("");
            location.reload();
        });
    }

    function makeXMLHttpRequest(url, data, callback) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if (data.status === 'success') {
                    callback('upload-ended');
                    uploaded_path = data.url;
                    return;
                }
                if (data.status == 'File exists') {
                    alert(data.filename + ' already exists');
                    $("#start-upload-div").removeClass("hidden");
                }
            }
        };
        request.upload.onloadstart = function() {
            //callback('Upload started...');
        };
        request.upload.onprogress = function(event) {
            callback(Math.round(event.loaded / event.total * 100) + "%");
        };
        request.upload.onload = function() {
            // callback('progress-about-to-end');
        };
        request.upload.onload = function() {
            // callback('Getting File URL..');
        };
        request.upload.onerror = function(error) {
            // callback('Failed to upload to server');
        };
        request.upload.onabort = function(error) {
            // callback('Upload aborted.');
        };
        request.open('POST', url);
        request.send(data);
    }

    $(document).ready(function() {
        $('#user-table_wrapper').css('width', '100%');
        $('select[name="user-table_length"]').css('width', '4rem');
        $("#file-upload-btn").on("click", function() {
            $("#file").trigger("click");
        });
        $("#modal-close").on("click", function() {
            $("#default-modal").toggleClass("hidden");
        });
        $("#upload-btn").on("click", function() {
            $("#default-modal").toggleClass("hidden");
        });
    });
    $('input[type="file"]').change(function(e) {
        file = e.target.files[0];
        var fileName = e.target.files[0].name;
        $("#filename").text(fileName);
        // var reader = new FileReader();
        // reader.onload = function(e) {
        //     // get loaded data and render thumbnail.
        //     // document.getElementById("preview").src = e.target.result;
        // };
        // // read the image file as a data URL.
        // reader.readAsDataURL(this.files[0]);
    });

    var file;

    function dropHandler(ev) {
        console.log('File(s) dropped');
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
        if (ev.dataTransfer.items) {
            // Use DataTransferItemList interface to access the file(s)
            for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                // If dropped items aren't files, reject them
                if (ev.dataTransfer.items[i].kind === 'file') {
                    file = ev.dataTransfer.items[i].getAsFile();
                    console.log('... file[' + i + '].name = ' + file.name);
                    $("#filename").text(file.name);
                    break;
                }
            }
        } else {
            // Use DataTransfer interface to access the file(s)
            for (var i = 0; i < ev.dataTransfer.files.length; i++) {
                console.log('... file[' + i + '].name = ' + ev.dataTransfer.files[i].name);
                file = ev.dataTransfer.files[i];
                $("#filename").text(file.name);
                break;
            }
        }
    }

    function dragOverHandler(ev) {
        ev.preventDefault();
    }
</script>
