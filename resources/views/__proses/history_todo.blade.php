@extends('templates.main')
@section('title', 'Overview History To Do Proccess')
@section('header-title-content', 'Overview History To Do Proccess')
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <div class="card-title">
                Overview History Process DMS No {{ $idd }}
              </div>
            </div>
              <div class="card-body">
                <div class="col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header p-2">
                      <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#headerdms" data-toggle="tab">Header</a></li>
                        <li class="nav-item"><a class="nav-link" href="#detaildms" data-toggle="tab">Detail</a></li>
                        <li class="nav-item"><a class="nav-link" href="#subdetaildms" data-toggle="tab">SubDetail</a></li>
                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">

                        <!--DMS Header -->
                        <div class="active tab-pane" id="headerdms">
                          <form class="form-horizontal" id="formHeader">
                            @csrf
                            @method('POST')

                            <div class="row">

                                <!-- left field -->
                                <div style="width: 50%; padding: 10px">
                                    <div class="form-group row">
                                        <p for="dms_no" class="col-md-4 col-form-label col-form-label-sm">DMS No:</p>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="dms_no" name="dms_no"
                                                value="{{ $isdata->dms_no }}" readOnly
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="created_date" class="col-sm-4 col-form-label col-form-label-sm">Created Date:</p>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control
                                                form-control-sm default-input" id="created_date"
                                                name="created_date" style="width: 50%"
                                                value="{{ $isdata->created_date }}"
                                                readOnly
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="dms_focus" class="col-sm-4 col-form-label col-form-label-sm">DMS Focus:</p>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control
                                                form-control-sm default-input" id="dms_focus"
                                                name="dms_focus" style="width: 50%"
                                                value="{{ $isdata->dms_focus }}"
                                                readOnly
                                            >
                                        </div>
                                    </div>

                                    {{-- parameter and value --}}
                                    <div class="form-group row">
                                        <p for="parameter" class="col-md-2 col-form-label col-form-label-sm">Parameter:</p>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control
                                                form-control-sm default-input" id="paramter"
                                                name="parameter" style="width: 50%"
                                                value="{{ $isdata->parameter }}"
                                                readOnly
                                            >
                                        </div>
                                        <p for="value" class="col-md-2 col-form-label col-form-label-sm">
                                            Value:
                                        </p>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control form-control-sm"
                                                id="value" name="value"
                                                value="{{ $isdata->value }}"
                                                readonly
                                            >
                                        </div>
                                    </div>
                                    {{-- end of parameter and value --}}

                                    <div class="card">
                                        <div class="card-header" style="height: 2rem; display: flex; align-items: center; ">
                                            Applied To
                                        </div>
                                        <div class="card-body" style="padding: 1rem">
                                            <div class="mr-5 form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input"
                                                    id="all_product_group" name="all_product_group"
                                                    value="{{ $isdata->all_product_grp }}" disabled
                                                    @if($isdata->all_product_grp == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="all_product_group">All Product Group</label>
                                            </div>
                                            <div class="mr-5 form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input"
                                                    id="rma_not_allowed" name="rma_not_allowed"
                                                    value={{ $isdata->rma_not_allowed }} disabled
                                                    @if($isdata->rma_not_allowed == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="rma_not_allowed">RMA Not Allowed</label>
                                            </div>
                                            <div class="mr-5 form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input"
                                                    id="all_product" name="all_product"
                                                    value="{{ $isdata->all_product }}" disabled
                                                    @if($isdata->all_product == "Y")
                                                        checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="form-check-label" for="all_product">All Product</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mr-5 form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input"
                                            id="hna_flag" name="hna_flag" value="{{ $isdata->hna_flag }}"
                                            style="margin-left: 1rem" disabled
                                            @if($isdata->hna_flag == "Y")
                                                checked
                                            @else
                                            @endif
                                        >
                                        <label class="form-check-label" for="hna_flag">HNA Flag</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input"
                                            id="netto_flag" name="netto_flag"
                                            value=true disabled
                                            @if($isdata->netto_flag == "Y")
                                                checked
                                            @else
                                            @endif
                                        >
                                        <label class="form-check-label" for="netto_flag">Netto Flag</label>
                                    </div>

                                </div>

                                <!-- right field -->
                                <div style="width: 48%; padding: 10px; margin-left: 1rem">
                                    <div class="form-group row">
                                        <p for="state" class="col-md-3 col-form-label col-form-label-sm">State:</p>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control form-control-sm
                                                default-input" id="state" name="state"
                                                readOnly value="{{ $isdata->state }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p for="dms_type" class="col-md-3 col-form-label col-form-label-sm">DMS Type:</p>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control form-control-sm
                                                default-input" id="dms_type" name="dms_type"
                                                readonly value="{{ $isdata->dms_type }}"
                                            >
                                        </div>

                                        <p for="contract_no" class="col-md-3 pl-md-4 col-form-label col-form-label-sm">
                                            Contract No:
                                        </p>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control form-control-sm"
                                                id="contract_no" name="contract_no"
                                                value="{{ $isdata->contract_no }}" readonly
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="site" class="col-md-3 col-form-label col-form-label-sm">Site Requester:</p>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control form-control-sm
                                                default-input" id="site" name="site"
                                                readonly  value="{{ $isdata->site }}"
                                            >
                                        </div>

                                        <p for="contract_value" class="col-md-3 pl-md-4 col-form-label col-form-label-sm">
                                            Contract Value:
                                        </p>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control form-control-sm"
                                                id="contract_value" name="contract_value" readonly
                                                value="{{ $isdata->contract_value }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="from_date" class="col-md-3 col-form-label col-form-label-sm">From Date:</p>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control form-control-sm
                                                default-input easyui-datebox" id="from_date"
                                                name="from_date" style="width: 99%"
                                                value="{{ $isdata->date_from }}" readonly
                                            >
                                        </div>
                                        <p for="to_date" class="col-md-3 pl-md-4 col-form-label col-form-label-sm">To Date:</p>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control form-control-sm"
                                                id="to_date" name="to_date" style="width: 99%"
                                                value="{{ $isdata->date_to }}" readonly
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="division" class="col-md-3 col-form-label col-form-label-sm">Division:</p>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control form-control-sm"
                                                id="division" name="division" readonly
                                                value="{{ $isdata->code_c }}"
                                            >
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control form-control-sm"
                                                id="division_desc" name="division_desc" readOnly
                                                value="{{ $isdata->division }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="principal" class="col-md-3 col-form-label col-form-label-sm">Principal:</p>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control form-control-sm"
                                                id="principal" name="principal" readonly
                                                value="{{ $isdata->principal }}"
                                            >
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control form-control-sm"
                                                id="principal_name" value="{{ $isdata->principal }}"
                                                readonly
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="ref_no" class="col-md-3 col-form-label col-form-label-sm">Ref No:</p>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="ref_no" name="ref_no" readonly
                                                value="{{ $isdata->ref_no }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p for="note_text" class="col-md-3 col-form-label col-form-label-sm">Note Text:</p>
                                        <div class="col-md-8">
                                            <textarea type="text" class="form-control form-control-sm"
                                                id="note_text" name="note_text" readonly
                                                value="{{ $isdata->note_text }}"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                          </form>
                        </div>
                        <!-- /.tab-pane DMS Header -->

                        {{-- detailDms --}}
                        <div class="tab-pane" id="detaildms">
                          <div class="row">
                            <div class="col-15 table-responsive">
                              <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Part No</th>
                                  <th>Prod Description</th>
                                  <th>Min Qty</th>
                                  <th>Max Qty</th>
                                  <th>Part Bonus</th>
                                  <th>Bonus Description</th>
                                  <th>Bonus</th>
                                  <th>Kelipatan</th>
                                  <th>Disc Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($isdetailprod as $item)
                                        <tr>
                                        <td style="text-align:left" >{{ $item->part_no }}</td>
                                        <td style="text-align:left" >{{ $item->keterangan }}</td>
                                        <td style="text-align:right" >{{ number_format($item->min_qty) }}</td>
                                        <td style="text-align:right" >{{ number_format($item->max_qty) }}</td>
                                        <td style="text-align:left" >{{ $item->bonus_part }}</td>
                                        <td style="text-align:right" ></td>
                                        <td style="text-align:right" >{{ number_format($item->bonus_qty) }}</td>
                                        <td style="text-align:right" >{{ $item->kelipatan }}</td>
                                        <td style="text-align:left" >
                                            {{ $item->ket_disc }}
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        {{-- end of detailDms --}}

                        <div class="tab-pane" id="subdetaildms">
                          <div class="row">
                            <div class="col-15 table-responsive">
                                {{-- order type --}}
                                <table class="table table-striped" width="100%">
                                    ORDER TYPE
                                    <thead>
                                        <tr>
                                            <th width="25%">Order Type</th>
                                            <th width="25%">Exclude / Include</th>
                                            <th width="25%">Description</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($orderTypes) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($orderTypes as $orderType)
                                            <tr>
                                                <td width="25%">
                                                    {{ $orderType->order_type }}
                                                </td>
                                                <td width="25%">
                                                    {{ $orderType->exclude_include }}
                                                </td>
                                                <td width="25%"></td>
                                                <td width="25%"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- end of order type --}}

                                {{-- product group --}}
                                <table class="table table-striped" width="100%">
                                    PRODUCT GROUP
                                    <thead>
                                        <tr>
                                            <th width="25%">Product Group</th>
                                            <th width="25%">Exclude / Include</th>
                                            <th width="25%">Description</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($productGroups) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($productGroups as $productGroup)
                                            <tr>
                                                <td width="25%">
                                                    {{ $productGroup->sales_group }}
                                                </td>
                                                <td width="25%">
                                                    {{ $productGroup->exclude_include }}
                                                </td>
                                                <td width="25%"></td>
                                                <td width="25%"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- end of product group --}}

                                {{-- customer group --}}
                                <table class="table table-striped" width="100%">
                                    CUSTOMER GROUP
                                    <thead>
                                        <tr>
                                            <th width="25%">Customer Group</th>
                                            <th width="25%">Exclude / Include</th>
                                            <th width="25%">Description</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($customer_group) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($customer_group as $cust_group)
                                            <tr>
                                                <td width="25%">
                                                    {{ $cust_group->cust_group }}
                                                </td>
                                                <td width="25%">
                                                    {{ $cust_group->exclude_include }}
                                                </td>
                                                <td width="25%"></td>
                                                <td width="25%"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- customer chain --}}
                                <table class="table table-striped" width="100%%">
                                    CUSTOMER CHAINS
                                    <thead>
                                        <tr>
                                            <th width="25%">Customer Chain</th>
                                            <th width="25%">Exclude / Include</th>
                                            <th width="25%">Description</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($customer_chains) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($customer_chains as $cust_chain)
                                            <tr>
                                                <td width="25%">
                                                    {{ $cust_chain->cust_chain }}
                                                </td>
                                                <td width="25%">
                                                    {{ $cust_chain->exclude_include }}
                                                </td>
                                                <td width="25%"></td>
                                                <td width="25%"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- customer --}}
                                <table class="table table-striped" width="100%">
                                    CUSTOMER
                                    <thead>
                                        <tr>
                                            <th width="25%">Customer Id</th>
                                            <th width="25%">Exclude / Include</th>
                                            <th width="25%">Customer Name</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($customers) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($customers as $customer)
                                            <tr>
                                                <td width="25%">
                                                    {{ $customer->customer_id }}
                                                </td>
                                                <td width="25%">
                                                    {{ $customer->exclude_include }}
                                                </td>
                                                <td width="25%">
                                                    {{ str_replace('""', '', $customer->customer_name) }}
                                                </td>
                                                <td width="25%"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Order value --}}
                                <table class="table table-striped" width="100%">
                                    ORDER VALUE
                                    <thead>
                                        <tr>
                                            <th width="20%">Line No</th>
                                            <th width="20%">Min Value</th>
                                            <th width="20%">Max Value</th>
                                            <th width="20%">Type Discount</th>
                                            <th width="20%">Discount Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($orderValues) <= 0)
                                            <tr>
                                                <td colspan="5" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($orderValues as $value)
                                            <tr>
                                                <td width="20%">
                                                    {{ $value->line_no }}
                                                </td>
                                                <td width="20%">
                                                    {{ $value->min_value }}
                                                </td>
                                                <td width="20%">
                                                    {{ $value->max_value }}
                                                </td>
                                                <td width="20%">
                                                    {{ $value->discount_type }}
                                                </td>
                                                <td width="20%">
                                                    {{ $value->discount_value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Mix Bonus --}}
                                <table class="table table-striped" width="100%">
                                    MIXED BONUS
                                    <thead>
                                        <tr>
                                            <th width="25%">Min Qty Bonus</th>
                                            <th width="25%">Max Qty Bonus</th>
                                            <th width="25%">Bonus Qty</th>
                                            <th width="25%">Discount Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mixPersen) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($mixBonus as $bonus)
                                            <tr>
                                                <td width="25%">
                                                    {{ $bonus->min_qty }}
                                                </td>
                                                <td width="25%">
                                                    {{ $bonus->max_qty }}
                                                </td>
                                                <td width="25%">
                                                    {{ $bonus->bonus_qty }}
                                                </td>
                                                <td width="25%">
                                                    {{ $bonus->note }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- mix persen --}}
                                <table class="table table-striped" width="100%">
                                    MIXED PERSEN
                                    <thead>
                                        <tr>
                                            <th width="25%">Min Qty</th>
                                            <th width="25%">Max Qty</th>
                                            <th width="25%">Discount Description</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mixPersen) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($mixPersen as $persen)
                                            <tr>
                                                <td width="25%">
                                                    {{ $persen->min_qty }}
                                                </td>
                                                <td width="25%">
                                                    {{ $persen->max_qty }}
                                                </td>
                                                <td width="25%">
                                                    {{ $persen->note }}
                                                </td>
                                                <td width="25%">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- signature By --}}
                                <table class="table table-striped" width="100%">
                                    SIGNATURE BY
                                    <thead>
                                        <tr>
                                            <th width="25%">Person Id</th>
                                            <th width="25%">Name Signature</th>
                                            <th width="25%">Description</th>
                                            <th width="25%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($signatureBy) <= 0)
                                            <tr>
                                                <td colspan="4" class="text-left">No Data Found</td>
                                            </tr>
                                        @endif
                                        @foreach($signatureBy as $signature)
                                            <tr>
                                                <td width="25%">
                                                    {{ $signature->person_id }}
                                                </td>
                                                <td width="25%">
                                                    {{ $signature->name }}
                                                </td>
                                                <td width="25%">
                                                    {{ $signature->notes }}
                                                </td>
                                                <td width="25%"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->

                          <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            DMS yg sudah Approved By Principal atau KPST. Silahkan di Proses jika setuju Click Approved dan jika tidak Click Cancel.
                          </div>

                        </div>


                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">
                            <!-- The timeline -->
                            @foreach ($sqldmshist as $item)
                              <div class="timeline timeline-inverse">
                                  <!-- timeline time label -->
                                  <div class="time-label">
                                  <span class="bg-danger">
                                      {{ date('F jS Y, h:i:s', strtotime($item->date_entered)) }}
                                  </span>
                                  </div>
                                  <!-- /.timeline-label -->
                                  <!-- timeline item -->
                                  <div>
                                  <i class="fas fa-envelope bg-primary"></i>
                                  <div class="timeline-item">
                                      <span class="time">
                                          <i class="far fa-clock"></i> : @php
                                              $date = Carbon\Carbon::parse($item->date_entered);
                                              $elapsed = $date->diffForHumans(Carbon\Carbon::now());
                                              echo $elapsed;
                                          @endphp
                                      </span>
                                      <h3 class="timeline-header"><a href="#">{{ $item->state }}</a> Proses by : {{ $item->userid }}</h3>
                                      <div class="timeline-body">
                                          <p>
                                              History No : {{ $item->history_no }}
                                          </p>
                                          <p>
                                              {{ $item->message_text }}
                                          </p>
                                      </div>
                                      <!--<div class="timeline-footer">
                                      <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                      <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                      </div>-->
                                  </div>
                                  </div>
                                  <!-- END timeline item -->
                                  <!-- END timeline item -->
                                  <!--<div>
                                  <i class="far fa-clock bg-gray"></i>
                                  </div>-->
                              </div>
                            @endforeach

                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="mb-2">
                    <a class="btn btn-success text-white" onclick="proccessApproveOrCancel()"
                        data-shuffle id="btnApprove"
                    > Closed </a>
                    <a class="btn btn-danger text-white" href="{{ route('history') }}"
                        data-shuffle id="btnCancel"
                    > Back </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@include('templates.loader')
@endsection
@push('script')
<script>

    function disableButtonApproveAndCancel()
    {
        $("#btnApprove").attr('disabled', true);
        $("#btnCancel").attr('disabled', true);
    }

    function enabledButtonApproveAndCancel()
    {
        $("#btnApprove").removeAttr('disabled');
        $("#btnCancel").removeAttr('disabled');
        $("#btnApprove").html('Closed');
    }

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

    });

    function proccessApproveOrCancel()
    {
        $('#exampleModal').modal('show');
        disableButtonApproveAndCancel();
        $("#btnApprove").html('<i class="fas fa-spinner fa-spin text-white"></i>');
        let values = {};
        $.each($('#formHeader').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });

        $.ajax({
            url: `{{ url('history/close') }}`,
            method: 'POST',
            data: values,
            success: (result) => {
                $('#exampleModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: `${result.code} : Success`,
                    text: `${result.message}`,
                    // footer: '<a href="">Why do I have this issue?</a>'
                });
                enabledButtonApproveAndCancel();
                setTimeout(() => {
                    window.location.href = "/history";
                }, 1200);

            },
            error: (xhr, ajaxOptions, thrownError) =>{
                $('#exampleModal').modal('hide');
                enabledButtonApproveAndCancel();
                if(xhr.status == 500)
                {
                    Swal.fire({
                        icon: 'error',
                        title: `${xhr.status} : ${xhr.statusText}`,
                        text: `${xhr.responseJSON.message.substr(0, 110)}`,
                        // footer: '<a href="">Why do I have this issue?</a>'
                    });

                } else if(xhr.status == 422)
                {
                    errorPrincipal = xhr.responseJSON.message.principal ?
                        xhr.responseJSON.message.principal[0] : null;
                    errorDmsNo = xhr.responseJSON.message.dms_no ?
                        xhr.responseJSON.message.dms_no[0] : null;

                    let message = `${errorDmsNo ? errorDmsNo : ''} \n ${errorPrincipal ? errorPrincipal : ''}`;

                    Swal.fire({
                        icon: 'error',
                        title: `${xhr.status} : ${xhr.statusText}`,
                        text: `${message}`,
                        // footer: '<a href="">Why do I have this issue?</a>'
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: `${xhr.status} : ${xhr.statusText}`,
                        text: `${xhr.statusText}`,
                        // footer: '<a href="">Why do I have this issue?</a>'
                    });

                }
            }
        });
    }

  </script>
@endpush
