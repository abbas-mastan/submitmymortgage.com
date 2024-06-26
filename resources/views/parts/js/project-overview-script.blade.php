<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script>
    window.returnBack = "{{ url(getRoutePrefix() . '/redirect/back/file-uploaded-successfully') }}";
</script>
<script src="{{ asset('js/upload.js') }}"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    @if (!empty($id))
        var userId = {{ $id }};
        var cat = '';
        var uploadUrl = '{{ url(getRoutePrefix() . '/file-upload') }}';
    @endif

    $('.closealertbox').click(function(e) {
        e.preventDefault();
        $('.alertbox').toggleClass('hidden');
    });

    $('.requestButton ,.backButton').click(function(e) {
        e.preventDefault();
        $('.firstTable, .secondTable,.requestButton').toggleClass('hidden');
    });

    $('.newProject, .closeModal').click(function(e) {
        e.preventDefault();
        $('#newProjectModal').toggleClass('hidden');
        $('#newProjectModal div:first').toggleClass('md:top-44 max-sm:top-44 sm:top-36');
        $('#newProjectModal').toggleClass('items-center');
    });

    $('.submitPart .back').click(function(e) {
        e.preventDefault();
        $('.submitPart').addClass('hidden');
        $('.firstTable').removeClass('hidden');
    });
    var textArray;
    $('.nextButton').click(function(e) {
        e.preventDefault();
        if ($('.firstTable').hasClass('hidden')) {
            $('.firstTable').removeClass('hidden');
            $('.secondTable').addClass('hidden');
            $('.requestButton').removeClass('hidden');
        } else {
            $('.modalTitle').text('Share Submit Link');
            $('.firstTable').addClass('hidden');
            $('.submitPart').removeClass('hidden');
            var text = $('.itemsToShare td').text();
            textArray = text.split('\n').map(function(item) {
                return item.trim();
            }).filter(function(item) {
                return item !== '';
            });
        }
    });

    var isAssistantAvailable = @json(count($assistants));
    $('.assistant').on('change', function() {
        var selected = $('.assistant').val();
        if (selected !== '') {
            var text = $('.itemsToShare td').text();
            textArray = text.split('\n').map(function(item) {
                return item.trim();
            }).filter(function(item) {
                return item !== '';
            });
            var formUrl = $('.assistantForm').attr('action');
            $('.assistantForm').attr('action', formUrl + '/' + selected);
            console.log($('.assistantForm').attr('action'));
            $('.firstTableButtonsParent .updateButton').removeClass('hidden');
            $('.firstTableButtonsParent .nextButton').addClass('hidden');
        } else {
            $('.firstTableButtonsParent .updateButton').addClass('hidden');
            $('.firstTableButtonsParent .nextButton').removeClass('hidden');
        }
    });

    $('.updateButton').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: $('.assistantForm').attr('action'),
            data: {
                items: textArray,
            }, // Send data as an object
            success: function(response) {
                console.log(response);
                $('.jq-loader-for-ajax').addClass('hidden');
                if (response === 'success') {
                    $('#newProjectModal').toggleClass('hidden');
                    window.location.href =
                        "{{ url(getRoutePrefix() . '/redirect/back/assistant-updated-successfully') }}";
                }
                $.each(response.error, function(index, message) {
                    $('.submitPart .errors').append(
                        `<li class="text-red-700">${message}</li>`);
                });
            },
            error: function(data) {
                console.log(data);
                $('.jq-loader-for-ajax').addClass('hidden');
            }
        });
    });

    $(document).on('change', '.secondTable input[type="checkbox"]', function() {
        if ($('.secondTable input[type="checkbox"]:checked').length > 0) {
            $('.backButton').addClass('hidden');
            if (isAssistantAvailable > 0) {
                $('.assistantForm').removeClass('hidden');
            }
            $('.secondTableButtonsParent').removeClass('justify-between');
            $('.secondTableButtonsParent').addClass('justify-end');
        } else {
            if (isAssistantAvailable > 0) {
                $('.assistantForm').addClass('hidden');
            }
            $('.backButton').removeClass('hidden');
            $('.secondTableButtonsParent').removeClass('justify-end');
            $('.secondTableButtonsParent').addClass('justify-between');
        }
    });

    $(document).on('change', '.secondTable input[type="checkbox"]', function(e) {
        e.preventDefault();
        var checkboxValue = $(this).val();
        var bgcolor = $('.itemsToShare tr:last').hasClass('bg-gray-100') ? null : 'bg-gray-100';
        if ($(this).prop('checked')) {
            if ($('.itemsToShare').length > 0) {
                var newRow = `<tr class="deleteItemTr items-center text-center ${bgcolor}">
            <td class="py-2 border border-1 border-gray-300">${checkboxValue}</td>
            <td class="py-2 flex justify-center text-center border border-1 border-gray-300">
                <a class="deleteItem"> <img class="bg-themered p-3" src="{{ asset('icons/trash.svg') }}"></a>
            </td>
        </tr>`;
                $('.itemsToShare').append(newRow);
            }
        } else {
            $('.itemsToShare td:contains(' + checkboxValue + ')').closest('tr').remove();
        }
    });

    $(document).on('click', '.deleteItem', function(e) {
        e.preventDefault(); // Prevent the default link behavior
        $(this).closest('tr').remove();
        var value = $(this).closest('tr').find('td:first').text();
        var bgColor = 'bg-gray-100';
        if ($('.secondTableTbody').find('tr:last').hasClass('bg-gray-100')) {
            bgColor = null;
        }
        var removedRow = `<tr class='items-center text-center ${bgColor}'>
                        <td class="py-1.5 flex justify-center text-center border border-1 border-gray-300">
                            <input type="checkbox" value="${value}" name="category[]" id="${value}">
                        </td>
                        <td class="py-0.5 border border-1 border-gray-300">${value}</td>
                    </tr>`;
        $(".secondTableTbody td:contains(" + value + ")").closest('tr').remove();
        $('.secondTableTbody').append(removedRow);
    });

    $('.submitPart form').submit(function(e) {
        e.preventDefault();

        $('.jq-loader-for-ajax').removeClass('hidden');
        $('.errors').empty();
        var inputs = $('.submitPart form input[name="email"]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                email: inputs,
                items: textArray,
                userId: userId
            }, // Send data as an object
            success: function(response) {
                console.log(response);
                $('.jq-loader-for-ajax').addClass('hidden');
                if (response === 'sucess') {
                    $('#newProjectModal').toggleClass('hidden');
                    window.location.href =
                        "{{ url(getRoutePrefix() . '/redirect/back/link-shared-successfully') }}";
                }
                $.each(response.error, function(index, message) {
                    $('.submitPart .errors').append(
                        `<li class="text-red-700">${message}</li>`);
                });
            },
            error: function(data) {
                console.log(data);
                $('.jq-loader-for-ajax').addClass('hidden');
            }
        });
    });

    $(document).ready(function() {
        $("input[type=search]").css("background", "#991b1b");
        $("input[type=search]").attr("placeholder", "search");
        $("input[type=search]").addClass('serachinput');
        $("input[type=search]").addClass('bg-red-800');
        $('#user-table').removeClass("no-footer dataTable");
    });

    $(document).on("click", function(e) {
        if (!$(e.target).closest(".categoryContainer").length) {
            // Clicked outside of the .categoryContainer
            $('.categoryMenu').addClass('hidden');
        }
    });

    $(".categoryButton").click(function(e) {
        e.stopPropagation(); // Prevent the document click event from firing
        $('.categoryMenu').toggleClass('hidden'); // Toggle visibility
    });

    $(document).on("click", function(e) {
        if (!$(e.target).closest(".dropdownContainer").length) {
            // Clicked outside of the .dropdownContainer
            $('.dropdownMenu').addClass('hidden');
        }
    });

    $(".dropdownButton").click(function(e) {
        e.stopPropagation(); // Prevent the document click event from firing
        $('.dropdownMenu').toggleClass('hidden'); // Toggle visibility
    });

    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".searchablediv").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // (function() {
    //     let textarea = document.querySelectorAll(".comments");
    //     for (let i = 0; i < textarea.length; i++) {
    //         textarea[i].addEventListener("click", () => {
    //             textarea[i].setAttribute("rows", 5);
    //         });
    //         textarea[i].addEventListener("focusin", () => {
    //             textarea[i].setAttribute("rows", 5);
    //         });
    //         textarea[i].addEventListener("focusout", () => {
    //             textarea[i].setAttribute("rows", 1);
    //         });
    //     }
    // })();

    $(document).ready(function() {
        @if ($user->finance_type == 'Purchase')
            let purchasePrice = $('#purchase-price').text();
            let purchaseDp = $('#purchase-dp').text();
            let loanAmount = $('#loan-amount').text();
            //Remove commas
            purchasePrice = purchasePrice.replaceAll(",", "");
            purchaseDp = purchaseDp.replaceAll(",", "");
            loanAmount = loanAmount.replaceAll(",", "");
            //Remove dollars sign
            purchasePrice = purchasePrice.replaceAll("$", "");
            purchaseDp = purchaseDp.replaceAll("$", "");
            loanAmount = loanAmount.replaceAll("$", "");
            //Remove spaces
            purchasePrice = purchasePrice.replaceAll(" ", "");
            purchaseDp = purchaseDp.replaceAll(" ", "");
            loanAmount = loanAmount.replaceAll(" ", "");
            $('#purchase-price').text("$ " + formatNumbers(purchasePrice));
            $('#purchase-dp').text("$ " + formatNumbers(purchaseDp));
            $('#loan-amount').text("$ " + formatNumbers(loanAmount));
        @endif
        @if ($user->finance_type == 'Refinance')
            let mortgage1 = $('#mortage1').html();
            let mortgage2 = $('#mortage2').text();
            let value = $('#value').text();
            console.log($('#mortage1').text());
            //Remove commas
            mortgage1 = mortgage1.replaceAll(",", "");
            mortgage2 = mortgage2.replaceAll(",", "");
            value = value.replaceAll(",", "");
            //Remove dollars sign
            mortgage1 = mortgage1.replaceAll("$", "");
            mortgage2 = mortgage2.replaceAll("$", "");
            value = value.replaceAll("$", "");
            //Remove spaces
            mortgage1 = mortgage1.replaceAll(" ", "");
            mortgage2 = mortgage2.replaceAll(" ", "");
            value = value.replaceAll(" ", "");
            $('#mortage1').text("$ " + formatNumbers(mortgage1));
            $('#mortage2').text("$ " + formatNumbers(mortgage2));
            $('#value').text("$ " + formatNumbers(value));
        @endif
    });

    function formatNumbers(number) {
        number += '';
        x = number.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $('.removeAccess').click(function(e) {
        e.preventDefault();
        var $span = $(this); // Store a reference to the clicked span
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $span.attr('data-id');
        $.ajax({
            type: "get",
            url: "{{ url(getRoutePrefix()) }}" + `/remove-access/${id}`,
            data: $span
                .serialize(), // Note: serialize() is typically used with forms, so this may not be necessary
            success: function(response) {
                console.log(response);
                if (response == 'access removed') {
                    $span.parent().remove();
                }
            }
        });
    });
</script>
