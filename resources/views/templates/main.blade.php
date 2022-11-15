@include('templates.header')

<div class="wrapper">
    @include('templates.navbar')

    @include('templates.menubar')

    {{-- Main Content --}}
        <div class="content-wrapper page">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('header-title-content') - DMS</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">
                                    @if(request()->segment(1) == 'admin')
                                        Administrator
                                    @elseif(request()->segment(1) == 'branch')
                                        Overview Branch
                                    @elseif(request()->segment(1) == 'overview')
                                        Overview Sent
                                    @elseif(request()->segment(1) == 'history')
                                        Overview History
                                    @elseif(request()->segment(1) == 'changepassword')
                                        Change Password
                                    @elseif(request()->segment(1) == 'report')
                                        Reporting
                                    @elseif(request()->segment(1) == 'branchtodo')
                                        Branch To Do Proccess
                                    @elseif(request()->segment(1) == 'adminviewtodo')
                                        Admin To Do Proccess
                                    @elseif(request()->segment(1) == 'overviewtodo')
                                        Overview Sent To Do Proccess
                                    @elseif(request()->segment(1) == 'historytodo')
                                        Overview History To Do Proccess
                                    @elseif(request()->segment(1) == 'home')
                                        Dashboard
                                    @endif
                                </li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            @yield('main-content')
        </div>
    {{-- End Of Main Content --}}

    @include('templates.controlside')

    @include('templates.footer_teks')

</div>

@include('templates.footer')
