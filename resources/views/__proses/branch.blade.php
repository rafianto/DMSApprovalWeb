@extends('templates.main')
@section('title', 'Overview Branch')
@section('header-title-content', 'Overview Branch')
@section('main-content')
<!-- Main content -->
<section class="content">
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

        <div class="card">

          <!-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
          </div>-->

          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
                <table id="tbl_branch" class="table table-bordered table-striped" width="100%">
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
</div>
<!-- /.content-wrapper -->
@endsection
@push('script')
    <script src="{{ asset('assets/js/overview_branch.js') }}"></script>
@endpush
