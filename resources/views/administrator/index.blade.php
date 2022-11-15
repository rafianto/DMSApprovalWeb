@extends('templates.main')
@section('title', 'Administrator')
@section('header-title-content', 'Overview Admin')
@section('main-content')
    <!-- Main content -->
    <section class="content mb-5">
        <div class="row">
          <div class="col-12">

              <!-- /.card-header -->
              <!-- /.card -->

            <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>-->

              <!-- /.card-header -->
              <div class="card-body">
                <form id="filterFormSearch">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label for="isactive">
                            Filter Active
                        </label>
                        <select name="isactive" id="isactive"
                             class="form-control form-control-sm"
                             style="width: 20% !important;"
                        >
                            <option value="{{ null }}" selected>--Select an option--</option>
                            <option value="Y">Active</option>
                            <option value="N">Not Active</option>
                        </select>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Principal</th>
                                <th>Site</th>
                                <th>Product Group</th>
                                <th>Active</th>
                                <th>Modul Admin</th>
                                <th>Overview Branch</th>
                                <th>Overview Principal</th>
                                <th>Overview History</th>
                                <th>Modul Reporting</th>
                                <th>#</th>
                            </tr>

                        </thead>
                        <tbody></tbody>
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
    @include('templates.loader')
@endsection
@push('script')
    <!-- page script -->
    <script>
        // const TOKEN = $('meta[name="csrf-token"]').attr('content');
        function resetPassword(id)
        {
            $('#exampleModal').modal('show');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('reset.password') }}`,
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: "POST",
                            id: id,
                        },
                        success: (result) => {
                            Swal.fire(
                                'Success',
                                'Password was reset.',
                                'success'
                            )
                            $("#example1").DataTable().ajax.reload();
                            $('#exampleModal').modal('hide');
                        },
                        error: (xhr, ajaxOptions, thrownError) => {
                            Swal.fire({
                                icon: 'error',
                                title: `${xhr.status} : ${xhr.statusText}`,
                                text: `${xhr.statusText}`,
                                // footer: '<a href="">Why do I have this issue?</a>'
                            });
                            $('#exampleModal').modal('hide');
                        }
                    });
                }
            })
        }

        $(function () {

            $("#example1").DataTable({
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
                    url: "{{ route('admin.get.all.data') }}",
                    type:'POST',
                    data: {
                        "_token":  `{!! csrf_token() !!}`,
                    },
                },
                columns: [
                    { data: 'id', name: 'id', orderable: true,},
                    { data: 'name', name: 'name', orderable: false},
                    { data: 'email', name: 'email', orderable: false},
                    { data: 'principal', name: 'principal', orderable: false},
                    { data: 'site', name: 'site', orderable: false},
                    { data: 'grp_prod', name: 'grp_prod', orderable: false},
                    { data: 'isactive', name: 'isactive', orderable: false},
                    { data: 'isadmin', name: 'isadmin', orderable: false},
                    { data: 'isbranc', name: 'isbranc', orderable: false},
                    { data: 'isprinc', name: 'isprinc', orderable: false},
                    { data: 'ishisto', name: 'ishisto', orderable: false},
                    { data: 'isrept', name: 'isrept', orderable: false},
                    { data: 'action', name: 'action', orderable: false},
                ],
                "columnDefs":[
                    {
                        targets:[0],
                        orderable: false,
                    },
                    {
                        targets:[6],
                        orderable: false,
                        className: 'text-center',
                    },
                    {
                        targets:[7],
                        orderable: false,
                        className: 'text-center',
                    },
                    {
                        targets:[8],
                        orderable: false,
                        className: 'text-center',
                    },
                    {
                        targets:[9],
                        orderable: false,
                        className: 'text-center',
                    },
                    {
                        targets:[10],
                        orderable: false,
                        className: 'text-center',
                    },
                    {
                        targets:[11],
                        orderable: false,
                        className: 'text-center',
                    },
                ],
                select: {
                    info: true
                },
                buttons: [],
                bDestroy: true,
            });

            $("#isactive").change(() => {
                let status = $("#isactive").val();
                $("#example1").DataTable({
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
                        url: "{{ route('admin.get.all.data') }}",
                        type:'POST',
                        data: {
                            "_token":  `{!! csrf_token() !!}`,
                            "isactive" : status,
                        },
                    },
                    columns: [
                        { data: 'id', name: 'id', orderable: true,},
                        { data: 'name', name: 'name', orderable: false},
                        { data: 'email', name: 'email', orderable: false},
                        { data: 'principal', name: 'principal', orderable: false},
                        { data: 'site', name: 'site', orderable: false},
                        { data: 'grp_prod', name: 'grp_prod', orderable: false},
                        { data: 'isactive', name: 'isactive', orderable: false},
                        { data: 'isadmin', name: 'isadmin', orderable: false},
                        { data: 'isbranc', name: 'isbranc', orderable: false},
                        { data: 'isprinc', name: 'isprinc', orderable: false},
                        { data: 'ishisto', name: 'ishisto', orderable: false},
                        { data: 'isrept', name: 'isrept', orderable: false},
                        { data: 'action', name: 'action', orderable: false},
                    ],
                    "columnDefs":[
                        {
                            targets:[0],
                            orderable: false,
                        },
                        {
                            targets:[6],
                            orderable: false,
                            className: 'text-center',
                        },
                        {
                            targets:[7],
                            orderable: false,
                            className: 'text-center',
                        },
                        {
                            targets:[8],
                            orderable: false,
                            className: 'text-center',
                        },
                        {
                            targets:[9],
                            orderable: false,
                            className: 'text-center',
                        },
                        {
                            targets:[10],
                            orderable: false,
                            className: 'text-center',
                        },
                        {
                            targets:[11],
                            orderable: false,
                            className: 'text-center',
                        },
                    ],
                    select: {
                        info: true
                    },
                    buttons: [],
                    bDestroy: true,
                });
            });

        });

        function deleteUser(id, status)
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    if(status == "N")
                    {
                        $('#exampleModal').modal('show');
                        deleteData(`{{ route('admin.delete') }}`, { _token: TOKEN, _method: "POST", id: id })
                        .then(data => {
                            $('#exampleModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: `${data.code}`,
                                text: `${data.message}`,
                                footer: ''
                            });
                            $("#example1").DataTable().ajax.reload();
                        }).catch(error => {
                            $('#exampleModal').modal('hide');
                            Swal.fire({
                                icon: 'error',
                                title: `${error.code}`,
                                text: `${error.message}`,
                                footer: ''
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: `Tidak bisa menghapus data. Karena status user masih aktif.`,
                            footer: ''
                        });
                    }
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                }
            })

        }

        async function deleteData(url = '', data = {}){
            try{
                const response = await fetch(url, {
                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    mode: 'cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    credentials: 'same-origin', // include, *same-origin, omit
                    headers: {
                    'Content-Type': 'application/json'
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    redirect: 'follow', // manual, *follow, error
                    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                    body: JSON.stringify(data) // body data type must match "Content-Type" header
                });
                return response.json(); // parses JSON response into native JavaScript objects
            } catch(error) {
                return error;
            }
        }

    </script>
@endpush
