@extends('templates.main')
@section('title', 'Overview Sent')
@section('header-title-content', 'Overview Sent')
@section('main-content')
<!-- Main content -->
<section class="content mb-5">
    <div class="row">
      <div class="col-12">

        {{-- accordion --}}
        <!-- <div class="accordion" id="accordionExample">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button"
                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne" id="click-print-toggle"
                    >
                        Print To PDF&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-down" id="icon-accordion"></i>
                    </button>
                </h2>
              </div>

              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">

                            <div class="form-group">
                                <label for="dms_no">
                                    DMS No <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="dms_no" id="dms_no">
                            </div>
                            <button type="button" class="btn btn-sm btn-success float-right"
                                id="print-pdf"
                            >
                                <i class="fas fa-print"></i> Print Pdf
                            </button>

                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div> -->
        {{-- end of accordion --}}

          <!-- /.card-header -->
          <!-- /.card -->

        <div class="card">

          <!-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
          </div>-->

          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
                <table id="tblOverviewSent" class="table table-bordered table-striped" width="100%">
                    <thead>
                    <tr>
                        <th>DMS No</th>
                        <th>Created Date</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Principal</th>
                        <th>Site</th>
                        <th>Ce Max</th>
                        <th>Pe Max</th>
                        <th>Product Group Major</th>
                        <th>State</th>
                        <th>Proccess</th>
                    </tr>

                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>

        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
@endsection
@push('script')
    <script>
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

        $("#tblOverviewSent").DataTable({
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
                url: "/overview/get-all-data",
                type: 'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "_method": "POST",
                },
            },
            columns: [
                { data: 'dms_no', name: 'dms_no', orderable: false},
                { data: 'created_date', name: 'created_date', orderable: true},
                { data: 'date_from', name: 'date_from', orderable: true},
                { data: 'date_to', name: 'date_to', orderable: true},
                { data: 'principal', name: 'principal', orderable: false},
                { data: 'site', name: 'site', orderable: false},
                { data: 'cemax', name: 'cemax', orderable: false},
                { data: 'pemax', name: 'pemax', orderable: false},
                { data: 'prdgrpm', name: 'prdgrpm', orderable: false},
                { data: 'state', name: 'state', orderable: true},
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

        // print pdf
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

        window.open(`/overviewpdf/${base64DmsNo}`, "_blank");

    });
    </script>
@endpush
