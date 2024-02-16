$(document).ready(function () {
    $("#file-upload-btn").on("click", function () {
        $("#file").trigger("click");
    });
    $("#modal-close").on("click", function () {
        $("#default-modal").toggleClass("hidden");
    });
    $("#upload-btn").on("click", function () {
        $("#default-modal").toggleClass("hidden");
    });

});
$('input[type="file"]').change(function (e) {
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

$(document).ready(function () {
    $('#category').val(cat);
    $("#start-upload-btn").on("click", function () {
        if ($('input[name="attachment[]"]').length > 0) {
            var checkedBoxes = $('input[name="attachment[]"]:checked');
            var checkedValues = checkedBoxes.map(function () {
                return $(this).val();
            }).get();
            if ($('#category').val() === "") {
                $("#select_error").empty();
                $("#select_error").append('Please choose document type!');
                return;
            } else {
                $("#select_error").empty();
            }
            if (!file && checkedValues == 0) {
                $("#file_error").empty();
                $("#file_error").append('Please select or drag a file to upload. Or select at least one file from Gmail!');
                // alert('Please select or drag a file to upload. Or select at least one file from Gmail');
                return;
            }
            $("#start-upload-div").toggleClass("hidden");
            $("#file-progress").toggleClass("hidden");
            $("#file-name-progress").text(file?.name ?? '');
            uploadToPHPServer(checkedValues);
        } else {
            if ($('#category').val() === "") {
                $("#select_error").empty();
                $("#select_error").append('Please choose document type!');
                return;
            } else {
                $("#select_error").empty();
            }
            if (!file) {
                $("#file_error").empty();
                $("#file_error").append('Please select or drag a file to upload!');
                return;
            } else {
                $("#file_error").empty();
            }
            $("#start-upload-div").toggleClass("hidden");
            $("#file-progress").toggleClass("hidden");
            $("#file-name-progress").text(file.name);
            uploadToPHPServer();
        }
    });
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
        formData.append('attachment', $.map(checkedValues, function (value, index) { return [value]; }));
    }
    // var upload_url = 'https://your-domain.com/files-uploader/';
    var upload_url = uploadUrl;
    makeXMLHttpRequest(upload_url, formData, function (progress) {
        console.log(progress);
        if (progress !== 'upload-ended') {
            $("#progressbar").css("width", progress);
            $("#file-name-percent").text(progress);
            return;
        }
        window.location.href = window.returnBack;            
    });
}
function makeXMLHttpRequest(url, data, callback) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            if (data.status === 'success') {
                callback('upload-ended');
                uploaded_path = data.url;
                return;
            }
            if (data.status == 'File exists') {
                $("#file_error").empty();
                $("#file_error").append(data.filename + 'already exists!');
                $("#start-upload-div").removeClass("hidden");
            } else {
                $("#file_error").empty();
            }
        }
    }
    request.upload.onloadstart = function () {
        //callback('Upload started...');
    };
    request.upload.onprogress = function (event) {
        callback(Math.round(event.loaded / event.total * 100) + "%");
    };
    request.upload.onload = function () {
        // callback('progress-about-to-end');
    };
    request.upload.onload = function () {
        // callback('Getting File URL..');
    };
    request.upload.onerror = function (error) {
        // callback('Failed to upload to server');
    };
    request.upload.onabort = function (error) {
        // callback('Upload aborted.');
    };
    request.open('POST', url);
    request.send(data);
};

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

