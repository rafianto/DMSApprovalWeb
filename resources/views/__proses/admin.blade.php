<!DOCTYPE html>
<html lang="en">
<head>  
  @include('__header.__header',['title' => 'Administrator']) 
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('__header.__navbar')
    
  <!-- Menu Bar -->
  @include('__header.__menubar',['pilih' => 'admin']) 
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Overview Admin - DMS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>name</th>
                  <th>email</th>
                  <th>created_at</th>
                  <th>updated_at</th>
                  <th>princ_code</th>
                  <th>site</th>
                  <th>is_admin</th>
                  <th>process</th>
                </tr>
                
                </thead>
                <tbody>
                
                @foreach( $adminut as $ovh)
                  <tr>
                    <?php $datalink = str_replace('/','.',$ovh->email); ?>
                    <td>{{ $ovh->name }}</td>
                    <td><a href="#">{{ $ovh->email }}</a></td>
                    <td>{{ $ovh->created_at }}</td>
                    <td>{{ $ovh->updated_at }}</td>
                    <td>{{ $ovh->principal }}</td>
                    <td>{{ $ovh->site }}</td>
                    <td>{{ $ovh->isadmin }}</td>
                    <td>
                      <button type="button" name="proses" id="proses" onclick="window.location='{{ route('admintodo',['id' => $ovh->email ]) }}'" class="btn btn-block btn-success btn-xs">Proses</button>
                    </td>
                  </tr>
				        @endforeach
					
                </tbody>
                <tfoot>
                
                <!-- <tr>
                  <th>name</th>
                  <th>email</th>
                  <th>created_at</th>
                  <th>updated_at</th>
                  <th>princ_code</th>
                  <th>site</th>
                </tr>-->
                
                </tfoot>
              </table>
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
  
  
  <!-- Control Sidebar -->
  @include('__header.__controlside')  
  
  <!-- Main Footer -->
  @include('__header.__mainfooter')
  
    
</div>
<!-- ./wrapper -->

@include('__header.__script')
<!-- page script -->

<!-- DataTables -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      pageLength: 5,
      lengthMenu: [5, 10, 25, 50],
    });    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>