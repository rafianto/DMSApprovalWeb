$(() => {
    $('.dataTables_empty').addClass('text-center');
    $("#tbl_branch").DataTable({
        responsive: false,
        processing: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        language: {
            processing: `
                    <div>
                        <h6>
                            <i class="fa fa-spinner fa-spin fa-3x fa-fw text-info"></i>
                        </h6>
                        <p class="text-white font-weight-bold">Loading...</p>
                    </div>
                `,
        },
        serverSide: true,
        ajax: {
            url: "/branch/get-all-data",
            type: 'POST',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "_method": "POST",
            },
        },
        columns: [
            { data: 'dms_no', name: 'dms_no', orderable: false },
            { data: 'created_date', name: 'created_date', orderable: true },
            { data: 'date_from', name: 'date_from', orderable: true },
            { data: 'date_to', name: 'date_to', orderable: true },
            { data: 'principal', name: 'principal', orderable: false },
            { data: 'site', name: 'site', orderable: false },
            { data: 'cemax', name: 'cemax', orderable: false },
            { data: 'pemax', name: 'pemax', orderable: false },
            { data: 'prdgrpm', name: 'prdgrpm', orderable: false },
            { data: 'state', name: 'state', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        "columnDefs": [{
            targets: [0],
            orderable: false,
        }],
        select: {
            info: true
        },

    });

    // click accordion print
    var countClickAccordion = 0;
    $("#click-print-toggle").click(() => {
        countClickAccordion += 1;

        if (countClickAccordion % 2 == 0) {
            $("#icon-accordion").removeClass("fa-arrow-right");
            $("#icon-accordion").addClass("fa-arrow-down");
        } else {
            $("#icon-accordion").removeClass("fa-arrow-down");
            $("#icon-accordion").addClass("fa-arrow-right");
        }
    });

    $("#print-pdf").click(() => {
        let dms_no = $("#dms_no").val() ? $("#dms_no").val() : null;

        // cek validation
        if (dms_no == null) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `<h5 class="text-danger">
                    DMS Number is required. Please fill DMS No for Print PDF!!!
                </h6>`,
                // footer: '<a href="">Why do I have this issue?</a>'
            });
            return false;
        }

        let base64DmsNo = btoa(dms_no);

        window.open(`/branchpdf/${base64DmsNo}`, "_blank");

    });

});