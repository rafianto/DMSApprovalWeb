@extends('templates.main')
@section('title', 'Dashboard')
@section('header-title-content', 'Dashboard')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">


        {{-- widgetinfo --}}
        <div class="row">

            {{-- branch --}}
            @if (auth()->user()->isbranc == "Y")
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-warehouse"></i>
                        </span>
                        <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="/branch" class="card-link text-dark">Overview Branch</a>
                        </span>
                        <span class="info-box-number">
                            {{ $branch }}
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            {{-- end of branch --}}

            {{-- sent --}}
            @if (auth()->user()->isprinc == "Y")
                <div class="col-sm-12 col-md-2 col-lg-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1">
                            <i class="fas fa-user-cog text-white"></i>
                        </span>
                        <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="/overview" class="card-link text-dark">Overview Sent</a>
                        </span>
                        <span class="info-box-number">
                            {{ $sent }}
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            {{-- end of sent --}}

            {{-- history --}}
            @if (auth()->user()->ishisto == "Y")
                <div class="col-sm-12 col-md-2 col-lg-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-history text-white"></i>
                        </span>
                        <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="/history" class="card-link text-dark">Overview History</a>
                        </span>
                        <span class="info-box-number">
                            {{ $history }}
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            {{-- end of history --}}
            {{-- user aktif --}}
            <div class="col-sm-12 col-md-2 col-lg-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">
                          User Aktif
                      </span>
                      <span class="info-box-number">
                         {{ $usersActive }}
                      </span>
                    </div>
                </div>
            </div>
            {{-- end of user aktif --}}
        </div>
        {{-- end of widget info --}}
        
        {{-- sales data bulan ini --}}
        <div class="row mb-3 mt-3">
            <div class="col-sm-12 col-md-12">
                <!-- Sales data card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Sales Data Current Month</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body"">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="responsive-table" style="overflow-y: auto;
                                    white-space: nowrap;height:350px;"
                                >
                                    <table id="tblSalesData" class="table table-bordered table-hover
                                        dataTable dtr-inline" role="grid" aria-describedby="tblSalesData"
                                        width="100%"
                                    >

                                        <thead>
                                            <tr>
                                                <th class="text-center">Principal</th>
                                                <th class="text-center">Principal Name</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Persentage</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($salesDataCurrent) <= 0)
                                                <tr>
                                                    <th colspan="5" class="text-center"
                                                        style="background-color: rgba(166, 166, 166, .3);"
                                                    >Data Not Found</th>
                                                </tr>
                                            @endif
                                            @foreach ($salesDataCurrent as $row)
                                                <tr>
                                                    <td>
                                                        {{ $row->principal }}
                                                    </td>
                                                    <td>
                                                        {{ $row->principal_name }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($row->total, 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{number_format(($row->total / $totalSalesCurrent) *  100, 2) }}%
                                                    </td>
                                                    <th class="text-center">
                                                        <button type="button" class="btn btn-info"
                                                            data-toggle="modal" data-target="#viewModal"
                                                            onclick="viewCurrentData('{{ $row->principal }}', '{{ $row->principal_name }}', 'current');"
                                                        >
                                                            View
                                                        </button>
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-left">Total</th>
                                                <th class="text-right">{{ number_format($totalSalesCurrent,2) }}</th>
                                                <td class="text-right">
                                                    {{ $totalSalesCurrent ? number_format((float) ($totalSalesCurrent / $totalSalesCurrent) *  100, 2) : 0 }}%
                                                </td>

                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        {{ $salesDataCurrent->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                            <i class="fas fa-square text-info"></i> Sales Data Current Month
                            </span>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- end of Sales data card -->
            </div>
        </div>
        {{-- end of sales data bulan ini --}}

        {{-- sales data --}}
        <div class="row mb-3 mt-3">
            <div class="col-sm-12 col-md-12">
                <!-- Sales data card -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Total Sales Data</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body"">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="responsive-table" style="overflow-y: auto;
                                    white-space: nowrap;height:350px;"
                                >
                                    <table id="tblSalesData" class="table table-bordered table-hover
                                        dataTable dtr-inline" role="grid" aria-describedby="tblSalesData"
                                        width="100%"
                                    >

                                        <thead>
                                            <tr>
                                                <th class="text-center">Principal</th>
                                                <th class="text-center">Principal Name</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Persentage</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($sales_data) <= 0)
                                                <tr>
                                                    <th colspan="5" class="text-center"
                                                        style="background-color: rgba(166, 166, 166, .3);"
                                                    >Data Not Found</th>
                                                </tr>
                                            @endif
                                            @foreach ($sales_data as $row)
                                                <tr>
                                                    <td>
                                                        {{ $row->principal }}
                                                    </td>
                                                    <td>
                                                        {{ $row->principal_name }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($row->total, 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{number_format(($row->total / $total_sales) *  100, 2) }}%
                                                    </td>
                                                    <th class="text-center">
                                                        <button type="button" class="btn btn-primary"
                                                            data-toggle="modal" data-target="#viewModal"
                                                            onclick="viewData('{{ $row->principal }}', '{{ $row->principal_name }}', `all`);"
                                                        >
                                                            View
                                                        </button>
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-left">Total</th>
                                                <th class="text-right">{{ number_format($total_sales,2) }}</th>
                                                <td class="text-right">
                                                    {{number_format((float) ($total_sales / $total_sales) *  100, 2) }}%
                                                </td>

                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        {!! $sales_data->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> Sales Data
                            </span>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- end of Sales data card -->
            </div>
        </div>
        {{-- end of sales data --}}

        {{-- @if(auth()->user()->ischart == "Y") --}}
        <!-- chart-->
            {{-- <div class="row mt-3 mb-5">
                <!-- left -->
                <div class="col-md-6 col-lg-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Total Sales DMS</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="overflow:auto;">
                            <div id="totalSalesDms" style="width: 600px; height: 67vh; "></div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- end of left -->
                <!-- Right -->
                <div class="col-md-6 col-lg-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Sales Bulan Ini</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="overflow:auto;">
                            <div id="salesBulanIni" style="width: 600px; height: 67vh; "></div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- End of Right -->
            </div> --}}
        <!--end of chart-->
        {{-- @endif --}}

    </div>
</section>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1"
    aria-labelledby="viewModalLabel" aria-hidden="true"
>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="viewModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-danger font-weight-bold">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="responsive-table my-4" style="overflow-y: auto;
                white-space: nowrap;"
            >
                <table id="tblSalesDataSite" class="table table-bordered table-hover
                    dataTable dtr-inline" role="grid" aria-describedby="tblSalesDataSite"
                >
                    <thead>
                        <tr>
                            <th class="text-center">Site</th>
                            <th class="text-center">Site Name</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Persentage</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot id="tableFootSalesDataSite"></tfoot>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Of Modal -->

@endsection

@push('script')
<script>
    function viewData(principal, principal_name, state) {
        $("#viewModalLabel").text(`Data Sales (${principal} - ${principal_name})`);
        datatableSalesDataSite(principal, state);
        getTotalSales(principal, state);
    }

    function viewCurrentData(principal, principal_name, state) {
        $("#viewModalLabel").text(`Data Sales (${principal} - ${principal_name})`);
        datatableSalesDataSite(principal, state);
        getTotalSales(principal, state);
    }

    function datatableSalesDataSite(principal, state)
    {
        $("#tblSalesDataSite").DataTable({
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
                url: "/home/sales-data-sites",
                type: 'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "_method": "POST",
                    "principal" : principal,
                    "state" : state,
                },
            },
            columns: [
                { data: 'branch', name: 'branch', orderable: false },
                { data: 'site_name', name: 'site_name', orderable: true, searchable: false },
                { data: 'total', name: 'total', orderable: true, className: 'text-right', searchable: false },
                { data: 'percentage', name: 'percentage', orderable: true, searchable: false,className: 'text-right'},
            ],
            columnDefs: [
                {
                    targets: 2,
                    className: "text-right"
                },
                {
                    targets: 3,
                    className: "text-right"
                }
            ],
            select: {
                info: true
            },
            buttons: [],
            bDestroy: true,
        });
    }

    function getTotalSales(principal, state)
    {
        postData('home/total-sales', {_token: `${TOKEN}`, _method: "POST", principal: principal, state:state})
        .then(response => {
            console.log(response);
            let html = '';
            html += `
                <tr>
                    <th colspan="2" class="text-left">Total</th>
                    <th class="text-right">${response.totalSales}</th>
                    <td class="text-right">
                        ${100}%
                    </td>

                </tr>
            `;
            $("#tableFootSalesDataSite").html(html);
        }).catch(error => {
            console.log(error);
        })
    }
</script>
{{-- @if (auth()->user()->ischart == "Y")
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(totalSalesDms);
    function totalSalesDms() {
        var data = google.visualization.arrayToDataTable({!! $total_sales_dms !!});

        var options = {
            title: '',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('totalSalesDms'));
        chart.draw(data, options);
    }
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(salesBulanIni);
    function salesBulanIni() {
        var data = google.visualization.arrayToDataTable({!! $sales_bulan_ini !!});

        var options = {
            title: '',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('salesBulanIni'));
        chart.draw(data, options);
    }
</script>
@endif --}}
@endpush



