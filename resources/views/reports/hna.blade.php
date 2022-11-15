@extends('templates.main')
@section('title', 'Reporting HNA')
@section('header-title-content', 'Reporting HNA')
@section('main-content')
<!-- Main content -->
<section class="content mb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="callout callout-info">
                <h5>
                    <i class="fas fa-info"></i> Note
                </h5>
                <p>
                    The first data displayed is <b>{{ date('F') }}</b>.
                </p>
                <span class="badge badge-info p-2">Please use search/filter to find more.</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="mt-2 mb-5">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <form id="formFilterHna" class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="date" class="form-control"
                                                placeholder="Start date" name="awal" id="awal"
                                                required
                                            >

                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control"
                                                placeholder="End date" name="akhir" id="akhir"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="my-3 float-right">
                                        <button type="button" id="filter"
                                            class="btn btn-sm btn-success" onclick="filtered()"
                                        >
                                            <i class="fas fa-search"></i>&nbsp;&nbsp;Filter
                                        </button>
                                        <button type="button" id="export"
                                            class="btn btn-sm btn-success" onclick="exportToExcel()"
                                        >
                                            <i class="fas fa-file-excel"></i>&nbsp;&nbsp;Export To Excel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="table-responsive">
                        <table id="tblReportHna" class="table table-bordered table-striped" width="100%"
                        >
                            <thead class="text-center">
                                <tr>
                                    <th>
                                        Cabang
                                    </th>
                                    <th>
                                        Principal
                                    </th>
                                    <th>
                                        Product Group
                                    </th>
                                    <th>
                                        Total HNA
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
    <script>

        $(() => {
            getAllData(null);
        });

        function filtered()
        {
            let data = {};
            $.each($('#formFilterCbp').serializeArray(), function(i, field) {
                data[field.name] = field.value;
            });

            let awal = Date.parse(new Date(data.awal));
            let akhir = Date.parse(new Date(data.akhir));
            // validation check tgl
            if(awal > akhir)
            {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: `Tanggal awal tidak bisa lebih besar dari akhir.`,
                    footer: ''
                });
                return false;
            }

            data._token = TOKEN;
            data._method = "POST";

            getAllData(data);


        }

        function getAllData(data = null)
        {
            if(data == null) {
                data = {
                    "_token":  `{!! csrf_token() !!}`,
                    "_method" : "POST",
                };
            }

            let table = $("#tblReportHna").DataTable({
                responsive: false,
                processing: true,
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
                    url: "/report/hna",
                    type:'POST',
                    data: data,
                },
                columns: [
                    { data: 'branch', name: 'branch', orderable: true,},
                    { data: 'principal', name: 'principal', orderable: true,},
                    { data: 'pgroup', name: 'pgroup', orderable: true, searchable: false},
                    { data: 'total_hna', name: 'total_hna', orderable: true, searchable: false, className:'text-right'},
                ],
                columnDefs: [

                ],
                select: {
                    info: true
                },
                buttons: [],
                bDestroy: true,
            });
        }

        function exportToExcel()
        {
            let data = {};
            $.each($('#formFilterHna').serializeArray(), function(i, field) {
                data[field.name] = field.value;
            });

            let awal = Date.parse(new Date(data.awal));
            let akhir = Date.parse(new Date(data.akhir));
            console.log(awal,akhir);
            // validasi jika kosong
            if(isNaN(awal) || isNaN(akhir)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: `Tanggal awal dan akhir tidak boleh kosong.`,
                    footer: ''
                });
                return false;
            }

            // validation check tgl
            if(awal > akhir)
            {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: `Tanggal awal tidak bisa lebih besar dari akhir.`,
                    footer: ''
                });
                return false;
            }

            window.open(`/report/hna/export?awal=${data.awal}&akhir=${data.akhir}`, '_blank');
        }
    </script>
@endpush
