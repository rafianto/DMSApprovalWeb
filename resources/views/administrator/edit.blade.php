@extends('templates.main')
@section('title', 'Administrator')
@section('header-title-content', 'Administrator To Do Proccess')
@section('main-content')

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
            <form id="admin_ubah"  method="post"
                enctype="multipart/form-data" action="{{ route('admintodo.update') }}"
                class="needs-validation" novalidate
            >
            @csrf
            @method('POST')
              <div class="card-body">
                <div class="col-md-9">
                  <div class="card">
                    <div class="card-header p-2">
                      <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#headerdms" data-toggle="tab">Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#detaildms" data-toggle="tab">Dashboard</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                        </li> -->
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                          <!--DMS Header -->
                          <div class="active tab-pane" id="headerdms">

                            <div class="form-group row">
                                <label for="inputadminseqno"
                                    class="col-sm-2 col-form-label"
                                >Seqence No</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('id')
                                        is-invalid
                                    @enderror"
                                        id="inputadminseqno"
                                        placeholder="sequencenomor" value="{{ $isdata->id }}"
                                        name="id" readonly
                                    >

                                    @error('id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="inputadminname" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name')
                                        is-invalid
                                    @enderror" id="inputadminname"
                                        placeholder="name" value="{{ $isdata->name }}"
                                        name="name"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputadminemail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('email')
                                        is-invalid
                                    @enderror"
                                        id="inputadminemail" placeholder="email"
                                        value="{{ $isdata->email}}"
                                        name="email" readonly
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="site"
                                    class="col-sm-2 col-form-label"
                                >
                                    Site
                                </label>
                                <div class="col-sm-10">
                                    <select class="site-multiple form-control @error('site')
                                            is-invalid
                                        @enderror" name="site[]"
                                        id="site" multiple="multiple"
                                    >
                                        @foreach ($sites as $site )

                                            @if(in_array($site->contract, $user_sites))
                                                <option value="{{ $site->contract }}" selected>
                                                    {{ $site->contract }} - {{ $site->description }}
                                                </option>
                                            @else
                                                <option value="{{ $site->contract }}">
                                                    {{ $site->contract }} - {{ $site->description }}
                                                </option>
                                            @endif

                                        @endforeach
                                    </select>
                                    @error('site')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="principal"
                                    class="col-sm-2 col-form-label"
                                >
                                    Principal
                                </label>
                                <div class="col-sm-10">
                                    <select class="principal-multiple form-control @error('principal')
                                        is-invalid
                                    @enderror"
                                        name="principal[]"
                                        id="principal" multiple="multiple"
                                    >

                                        @foreach ($principals as $principal )

                                            @if(in_array($principal->supplier_id, $user_principals))
                                                <option value="{{ $principal->supplier_id }}" selected>
                                                    {{ $principal->supplier_id }} - {{ $principal->name }}
                                                </option>
                                            @else
                                                <option value="{{ $principal->supplier_id }}">
                                                    {{ $principal->supplier_id }} - {{ $principal->name }}
                                                </option>
                                            @endif

                                        @endforeach
                                    </select>
                                    @error('principal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="group-product"
                                    class="col-sm-2 col-form-label"
                                >
                                    Group Product
                                </label>
                                <div class="col-sm-10">
                                    <select class="product-multiple form-control @error('grp_prod')
                                        is-invalid
                                    @enderror"
                                        name="product[]"
                                        id="product" multiple="multiple"
                                    >
                                        @if(count($group_parts) > 0)
                                            @foreach ($group_parts as $group_part)

                                                @if(in_array($group_part->catalog_group, $user_group_parts))
                                                    <option value="{{ $group_part->catalog_group }}" selected>
                                                        {{ $group_part->catalog_group }} - {{ $group_part->group_name }}
                                                    </option>
                                                @else
                                                <option value="{{ $group_part->catalog_group }}">
                                                    {{ $group_part->catalog_group }} - {{ $group_part->group_name }}
                                                </option>
                                                @endif

                                            @endforeach
                                        @endif
                                    </select>
                                    @error('grp_prod')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- division --}}
                            <div class="form-group row">
                                <label for="division"
                                    class="col-sm-2 col-form-label"
                                >
                                    Division
                                </label>
                                <div class="col-sm-10">
                                    <select class="division-select form-control "
                                        name="division"
                                        id="division"
                                    >
                                    <option value="{{ null }}"></option>
                                    @foreach ($divisions as $divisi)
                                        @if($isdata->divisi == $divisi->division_code)
                                            <option value="{{ $divisi->division_code }}" selected>
                                                {{ $divisi->part_division_code }} - {{ $divisi->part_division_description }}
                                            </option>
                                        @else
                                            <option value="{{ $divisi->division_code }}">
                                                {{ $divisi->part_division_code }} - {{ $divisi->part_division_description }}
                                            </option>
                                        @endif

                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- end of division --}}

                            {{-- min PE dan max pe --}}
                            <div class="form-group row">
                                <label for="pemindisc"
                                    class="col-sm-2 col-form-label"
                                >PE Min</label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" max="100" class="form-control"
                                        id="pemindisc"
                                        placeholder="Min PE"
                                        name="pemindisc" value="{{ $isdata->pemindisc }}"
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pemaxdisc"
                                    class="col-sm-2 col-form-label"
                                >PE Max</label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" max="100" class="form-control"
                                        id="pemaxdisc"
                                        placeholder="Max PE"
                                        name="pemaxdisc" value="{{ $isdata->pemaxdisc }}"
                                    >
                                </div>
                            </div>
                            {{-- end of min PE dan max pe--}}

                            {{-- wemail --}}
                            <div class="form-group row">
                                <label for="wemail"
                                    class="col-sm-2 col-form-label"
                                >W Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        id="wemail"
                                        placeholder="jika penulisan lebih dari satu, pisahkan dengan (;). ex:exampl@mail.com;example2@mail.com"
                                        name="wemail" value="{{ $isdata->wemail }}"
                                    >
                                </div>
                            </div>
                            {{-- end of wemail --}}

                            {{-- wccemail --}}
                            <div class="form-group row">
                                <label for="wemail"
                                    class="col-sm-2 col-form-label"
                                >WCC Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        id="wccemail"
                                        placeholder="jika penulisan lebih dari satu, pisahkan dengan (;). ex:exampl@mail.com;example2@mail.com"
                                        name="wccemail" value="{{ $isdata->wccmail }}"
                                    >
                                </div>
                            </div>
                            {{-- end of wccemail --}}

                            {{-- Internal User --}}
                                <div class="form-group row">
                                    <label
                                        class="col-sm-3 col-form-label"
                                    >
                                        Internal User
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                value="Y" id="InternalYes"
                                                name="internal_user"
                                                @if($isdata->internal_user == "Y")
                                                    checked
                                                @else
                                                @endif
                                            >
                                            <label class="form-check-label" for="InternalYes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                value="N" name="internal_user" id="internalNo"
                                                @if($isdata->internal_user != "Y")
                                                    checked
                                                @else
                                                @endif
                                            >
                                            <label class="form-check-label" for="internalNo">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            {{-- end of Internal User --}}

                            {{-- Activated User --}}
                                <div class="form-group row">
                                    <label
                                        class="col-sm-3 col-form-label"
                                    >
                                        Activated User
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                value="Y"
                                                name="isactive"
                                                @if($isdata->isactive == "Y")
                                                    checked
                                                @else
                                                @endif
                                            >
                                            <label class="form-check-label" for="inlineCheckbox1">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                value="N" name="isactive"
                                                @if($isdata->isactive == "N")
                                                    checked
                                                @else
                                                @endif
                                            >
                                            <label class="form-check-label" for="inlineCheckbox2">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            {{-- end of Activated User --}}

                          </div>
                          <!-- /.tab-pane DMS Header -->
                          {{-- detail md --}}
                          <div class="tab-pane" id="detaildms">
                            <div class="callout callout-info">
                                {{-- overview branch --}}
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3 col-form-label"
                                        >
                                            Overview Branch
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="Y"
                                                    name="overview_branch"
                                                    @if($isdata->isbranc == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="N" name="overview_branch"
                                                    @if($isdata->isbranc == "N")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                {{-- end of overview branch --}}
                                {{-- overview sent --}}
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3 col-form-label"
                                        >
                                            Overview Sent
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="Y"
                                                    name="overview_sent"
                                                    @if($isdata->isprinc == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="N" name="overview_sent"
                                                    @if($isdata->isprinc == "N")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                {{-- end of overview sent --}}
                                {{-- overview history --}}
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3 col-form-label"
                                        >
                                            Overview History
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="Y"
                                                    name="overview_history"
                                                    @if($isdata->ishisto == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="N" name="overview_history"
                                                    @if($isdata->ishisto == "N")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                {{-- end of overview history --}}
                                {{-- overview reporting --}}
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3 col-form-label"
                                        >
                                            Reporting
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="Y"
                                                    name="overview_report"
                                                    @if($isdata->isrept == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="N" name="overview_report"
                                                    @if($isdata->isrept == "N")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                {{-- end of overview reporting --}}
                                {{-- overview admin --}}
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3 col-form-label"
                                        >
                                            Overview Admin
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="Y"
                                                    name="overview_admin"
                                                    @if($isdata->isadmin == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="N" name="overview_admin"
                                                    @if($isdata->isadmin == "N")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                {{-- end of admin --}}

                                {{-- overview chart --}}
                                    {{-- <div class="form-group row">
                                        <label
                                            class="col-sm-3 col-form-label"
                                        >
                                            Chart Sales
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="Y"
                                                    name="ischart" id="ischart"
                                                    @if($isdata->ischart == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    value="N" name="ischart" id="ischart"
                                                    @if($isdata->ischart == "N")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="inlineCheckbox2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div> --}}
                                {{-- end of chart --}}
                            </div>
                          </div>
                          {{-- end of tab detail mds --}}
                          {{-- timeline --}}
                          <!-- <div class="tab-pane" id="timeline">
                          </div> -->
                          {{-- end of timeline --}}
                        </div>
                      </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <div class="mb-2">
                    <button class="btn btn-success" type="submit"
                        id="save"
                    > Updated </button>
                    <a class="btn btn-secondary" href="{{ route('admin') }}"
                    >
                        Back
                    </a>
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
@endsection
@push('script')
    <script src="{{ asset('assets/js/admin_todo.js') }}"></script>
@endpush
