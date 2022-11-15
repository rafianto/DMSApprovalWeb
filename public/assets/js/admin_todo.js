$(() => {

    $(".site-multiple").select2({
        placeholder: '-- Select Site --'
    });

    $(".division-select").select2({
        placeholder: 'Select a divison',
        allowClear: true,
        tags: true,
    });

    $(".wemail-select").select2({
        placeholder: 'Select a email',
        allowClear: false,
        tags: true,
    });

    $(".wccemail-select").select2({
        placeholder: 'Select a email',
        allowClear: false,
        tags: true,
    });

    $(".principal-multiple").select2({
        placeholder: '-- Select Principal --',
    });

    $(".product-multiple").select2({
        placeholder: '-- Select Product --'
    });

    $(".principal-multiple").on('change', (e) => {
        let html = '';
        let principal = $(".principal-multiple").val();
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/ref/batch/product-group',
            method: "POST",
            data: {
                _method: "POST",
                _token: `${TOKEN}`,
                principal: principal,
            },
            success: (result) => {
                console.log(result);
                let lengthData = result.data ? result.data.length : 0;

                if (lengthData > 0) {
                    result.data.forEach((value, index) => {
                        html += `<option value=${value.catalog_group}>
                            ${value.catalog_group} - ${value.group_name}
                        </option>`;
                    });
                }

                $("#product").append(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error(`Error: ${xhr.status}, ${thrownError}\n${xhr.responseJSON.message}`);
            }
        });
    });

});