@extends('templates.main')
@section('title', 'Administrator | Change Password')
@section('header-title-content', 'Change Password')
@section('main-content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <!-- <div class="col-md-12">-->
        <div class="col-md-6">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Please change your password!<small>.</small></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('postchangepassword') }}" method="post">
               {{ csrf_field() }}
              <div class="card-body">
                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>-->
                <div class="form-group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" name="password" class="form-control @error('password')
                        is-invalid
                    @enderror"
                        id="exampleInputPassword1" placeholder="New Password"
                    >
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword2">Re-Type Password</label>
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation')
                            is-invalid
                        @enderror" id="exampleInputPassword2"
                        placeholder="Password Confirmation"
                    >
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="terms"
                        class="custom-control-input @error('terms')
                            is-invalid
                        @enderror" id="terms"
                        value="{{ old('terms') }}"
                    >
                    <label class="custom-control-label" for="terms">I agree to the Change Password  <a href="#">terms of service</a>.</label>
                  </div>
                  @error('terms')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
          </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

