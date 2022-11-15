<!DOCTYPE html>
<html lang="en">
<head>  
  @include('__header.__header',['title' => 'Admin']) 
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('__header.__navbar', ['some' => 'data'])
    
  <!-- Menu Bar -->
  @include('__header.__menubar',['pilih' => 'admin']) 
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Branch To-Do Proses</h1>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                  Process Email {{ $idd }}
                </div>
              </div>              
              <form id="admin_ubah"  method="post" enctype="multipart/form-data" novalidate onsubmit="return false" >
                <div class="card-body">
                  <div class="col-md-9">
                    <div class="card">
                      <div class="card-header p-2">
                        <ul class="nav nav-pills">
                          <li class="nav-item"><a class="nav-link active" href="#headerdms" data-toggle="tab">Setting</a></li>
                          <li class="nav-item"><a class="nav-link" href="#detaildms" data-toggle="tab">Dashboard</a></li>
                          <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>                          
                        </ul>
                      </div><!-- /.card-header -->
                      <div class="card-body">                        
                          <div class="tab-content">
                            <!--DMS Header -->
                            <div class="active tab-pane" id="headerdms">                            
                                <div class="form-group row">
                                  <label for="inputadminseqno" class="col-sm-2 col-form-label">Seqence No</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadminseqno" placeholder="sequencenomor">
                                  </div>
                                  <label for="inputadminname" class="col-sm-2 col-form-label">Name</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadminname" placeholder="name">
                                  </div>
                                  <label for="inputadminemail" class="col-sm-2 col-form-label">Email</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadminemail" placeholder="email">
                                  </div>                                
                                  <label for="inputadmincreatedate" class="col-sm-2 col-form-label">Create_date</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadmincreatedate" placeholder="create date">
                                  </div>
                                  <label for="inputadminupdatedate" class="col-sm-2 col-form-label">Update_date</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadminupdatedate" placeholder="update date">
                                  </div>         
                                </div>
                                <div class="form-group row">
                                  <label for="inputadminprinc" class="col-sm-2 col-form-label">Principal</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadminprinc" placeholder="principal">
                                  </div>
                                  <label for="inputadminsite" class="col-sm-2 col-form-label">Site</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadminsite" placeholder="site">
                                  </div>
                                  <label for="inputadmingroupprod" class="col-sm-2 col-form-label">Group Product</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputadmingroupprod" placeholder="groupproduct">
                                  </div>
                                </div>                            
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                Setting Up Data Pilihan pembatas untuk Site dan product Group (,) koma.
                            </div>
                            <!-- /.tab-pane DMS Header -->
                            <div class="tab-pane" id="detaildms">
                              <div class="row">
                                <div class="col-15 table-responsive">
                                </div>
                              </div>
                              <div class="callout callout-info">
                                  <div class="form-group row">
                                      <label for="inputadminovwbranch" class="col-sm-2 col-form-label">Overview Branch</label>
                                      <div class="col-sm-10">
                                        <input maxlength='1' type="text" class="form-control" id="inputadminovwbranch" placeholder="overviewbranch">
                                      </div>      
                                      <label for="inputadminovwsent" class="col-sm-2 col-form-label">Overview Sent</label>
                                      <div class="col-sm-10">
                                        <input maxlength='1' type="text" class="form-control" id="inputadminovwsent" placeholder="overviewsent">
                                      </div>      
                                      <label for="inputadminovwhisto" class="col-sm-2 col-form-label">Overview History</label>
                                      <div class="col-sm-10">
                                        <input maxlength='1' type="text" class="form-control" id="inputadminovwhisto" placeholder="overviewhistory">
                                      </div>
                                      <label for="inputadminreporting" class="col-sm-2 col-form-label">Reporting</label>
                                      <div class="col-sm-10">
                                        <input maxlength='1' type="text" class="form-control" id="inputadminreporting" placeholder="reporting">
                                      </div>
                                  </div>                                  
                                  <h5><i class="fas fa-info"></i> Note:</h5>Setting Up Data Pilihan (Y/N).
                              </div>                          
                            </div>
                            <div class="tab-pane" id="timeline">
                            </div>
                          </div>    
                        </div><!-- /.card-body -->                      
                    </div>
                    <!-- /.card -->
                  </div>
                  <div class="mb-2">
                    <a class="btn btn-secondary" name="save" id="save" href="javascript:void(0)" onclick="prosesupdated()" > Updated </a>
                    <!--<button type="submit" name="submit" id="submit" onclick="prosesupdated()" > Updated </button>-->
                  </div>
                </div>
              </form>
              </div>              
            </div>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
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
<!-- Filterizr-->
<script src="{{asset('assets/plugins/filterizr/jquery.filterizr.min.js')}}"></script>
<!-- Page specific script -->
<script>

  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })

  $(document).ready(function(){
    @if ($isdata)
      $('#inputadminname').text('readonly',false);
      document.getElementById("inputadminname").disabled = true;
      document.getElementById("inputadminemail").disabled = true;
      document.getElementById("inputadmincreatedate").disabled = true;
      document.getElementById("inputadminupdatedate").disabled = true;

      $('#inputadminseqno').val('{{ $isdata->id }}');
      $('#inputadminname').val('{{ $isdata->name }}');
      $('#inputadminemail').val('{{ $isdata->email }}');
      $('#inputadmincreatedate').val('{{ $isdata->created_at }}');
      $('#inputadminupdatedate').val('{{ $isdata->updated_at }}');

      $('#inputadminprinc').val('{{ $isdata->principal }}');
      $('#inputadminsite').val('{{ $isdata->site }}');
      $('#inputadmingroupprod').val('{{ $isdata->grp_prod }}');

      $('#inputadminovwbranch').val('{{ $isdata->isbranc }}');
      $('#inputadminovwsent').val('{{ $isdata->isprinc }}');
      $('#inputadminovwhisto').val('{{ $isdata->ishisto }}');
      $('#inputadminreporting').val('{{ $isdata->isrept }}');

    @endif

  });

  function prosesupdated() {
    $('#admin_ubah').form('submit',{
        url: '{{route("admintodo.update")}}',
        onSubmit: function(param){
          param._token = '{{ csrf_token() }}';
          param._modul = 'update';
          //var isValid = $(this).form('validate');
          //if(!isValid) console.log('xfsclose');
          //return isValid;
        },
        success: function(result){
          var result = eval('('+result+')');
          console.log(result);
          if(result.success) {
            console.log('succes');
          } else {
            console.log('no success');
          }
        }
    }); 
  }
    

</script>

</body>
</html>