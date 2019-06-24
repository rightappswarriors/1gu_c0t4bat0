@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("master-file/inventory/item"),'desc'=>'Item','icon'=>'none','st'=>true]
    ];
    $_ch = "Items"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
        <!-- Main content -->
        <section class="content">
        	<div class="row">
        		<div class="col-xs-12">
        			<div class="box">
        				<div class="box-header">
        					<h3 class="box-title">Item List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div id="modalDIALOG" class="modal-dialog modal-lg" {{-- style="width:960px;" --}}>
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Item <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-sm-5" style="display: none">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Code <span class="text-red" hidden>*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text" name="txt_id" class="form-control" data-parsley-required-message="<strong>Code</strong> is required." readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Serial # <span class="text-red" >*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_ser_no" class="form-control" placeholder="Serial #" data-parsley-required-message="<strong>Serial #</strong> is required." required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Property # <span class="text-red" >*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_part_no" class="form-control" placeholder="Property #" data-parsley-required-message="<strong>Property #</strong> is required." required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-2 control-label">Category <span class="text-red">*</span></label>
                                                                    <div class="col-sm-10" style="margin-bottom:10px;">
                                                                        <select name="sel_itmgrp" style="width: 100%" data-parsley-errors-container="#sel_itmgrp_span" data-parsley-required-message="<strong>Category</strong> is required." required>
                                                                            @isset($itemgrp)
                                                                                <option value="">Select Category</option>
                                                                                @foreach ($itemgrp as $cat)
                                                                                    <option value="{{$cat->item_grp}}">{{$cat->grp_desc}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                <option value="">No Category registered..</option>
                                                                            @endisset
                                                                        </select>
                                                                        <span id="sel_itmgrp_span"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label  class="col-sm-2 control-label">Description <span class="text-red">*</span></label>
                                                                    <div class="col-sm-10" style="margin-bottom:10px;">
                                                                        <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" name="is_assembled">IS ASSEMBLED</label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" name="is_modifier">IS MODIFIERS</label>
                                                                    </div>
                                                                    <div class="checkbox">
                                                                        <label><input type="checkbox" name="is_req_modifier">IS REQ MODIFIERS</label>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Brand <span class="text-red" hidden="">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <select name="sel_brand" style="width: 100%" data-parsley-errors-container="#sel_brand_span" data-parsley-required-message="<strong>Brand</strong> is required.">
                                                                            @isset($brand)
                                                                                <option value="">Select Brand..</option>
                                                                                @foreach ($brand as $cat)
                                                                                    <option value="{{$cat->brd_code}}">{{$cat->brd_name}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                <option value="">No Brand registered..</option>
                                                                            @endisset
                                                                        </select>
                                                                        <span id="sel_brand_span"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Item Class <span class="text-red">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <select name="sel_itm_class" style="width: 100%" data-parsley-errors-container="#sel_itm_class_span" data-parsley-required-message="<strong>Item Class</strong> is required." required>
                                                                            <option value="">Select Item Class..</option>
                                                                            <option value="S">Sale</option>
                                                                            <option value="I">Internal</option>
                                                                            <option value="N">None</option>
                                                                        </select>
                                                                        <span id="sel_itm_class_span"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Generic/Model <span class="text-red">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <select name="sel_generic" style="width: 100%" data-parsley-errors-container="#sel_generic_span" data-parsley-required-message="<strong>Generic/Model</strong> is required." required>
                                                                            @isset($generic)
                                                                                <option value="">Select Generic/Model..</option>
                                                                                @foreach ($generic as $cat)
                                                                                    <option value="{{$cat->gen_code}}">{{$cat->gen_name}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                <option value="">No Generic/Model registered..</option>
                                                                            @endisset
                                                                        </select>
                                                                        <span id="sel_generic_span"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Sale Unit <span class="text-red">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <select name="sel_itmunit" style="width: 100%" data-parsley-errors-container="#sel_itmunit_span" data-parsley-required-message="<strong>Sale Unit</strong> is required." required>
                                                                            @isset($itmunit)
                                                                                <option value="">Select Sale Unit..</option>
                                                                                @foreach ($itmunit as $cat)
                                                                                    <option value="{{$cat->unit_id}}">{{$cat->unit_desc}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                <option value="">No Sale Unit registered..</option>
                                                                            @endisset
                                                                        </select>
                                                                        <span id="sel_itmunit_span"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Rack Location <span class="text-red">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_rak_loc" class="form-control" placeholder="Rack Location" data-parsley-required-message="<strong>Rack Location</strong> is required." required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Purchase Unit <span class="text-red">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <select name="sel_purunit" style="width: 100%" data-parsley-errors-container="#sel_purunit_span" data-parsley-required-message="<strong>Purchase Unit</strong> is required." required>
                                                                            @isset($itmunit)
                                                                                <option value="">Select Purchase Unit..</option>
                                                                                @foreach ($itmunit as $cat)
                                                                                    <option value="{{$cat->unit_id}}">{{$cat->unit_desc}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                <option value="">No Purchase Unit registered..</option>
                                                                            @endisset
                                                                        </select>
                                                                        <span id="sel_purunit_span"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            {{-- <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Serial # </label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_ser_no" class="form-control" placeholder="Serial #" data-parsley-required-message="<strong>Rack Location</strong> is required." >
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Tag # </label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_tag_no" class="form-control" placeholder="Tag #" data-parsley-required-message="<strong>Seri</strong> is required." >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Status <span class="text-red">*</span></label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <select name="sel_status" style="width: 100%" data-parsley-errors-container="#sel_status_span" data-parsley-required-message="<strong>Status</strong> is required." required>
                                                                            <option value="T">Active</option>
                                                                            <option value="F">InActive</option>
                                                                        </select>
                                                                        <span id="sel_status_span"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            {{-- <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Tag # </label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_tag_no" class="form-control" placeholder="Tag #" data-parsley-required-message="<strong>Seri</strong> is required." >
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            {{-- <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label  class="col-sm-4 control-label">Property # </label>
                                                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                                                        <input type="text"   name="txt_part_no" class="form-control" placeholder="Property #" data-parsley-required-message="<strong>Seri</strong> is required." >
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="row">
                                                            <label  class="col-sm-12 control-label" style="color:grey;">Price and Other Info</label>
                                                            <hr>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-4">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Cost Price<span class="text-red">*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Cost Price</strong> is required." required=""  required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Ave Cost Price <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_ave_cst_pri" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Ave Cost Price</strong> is required." readonly="" value="0.00">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">FCP <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_fcp" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>FCP</strong> is required." readonly="" value="0.00">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Mark Up (%) <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_mark_up" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Mark Up</strong> is required." readonly="" value="0.00">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">SRP Price<span class="text-red">*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_srp_pro" step="0.01" data-parsley-type="number" placeholder="0.00" oninput="computeGpRate()" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>SRP Price</strong> is required." required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Wholesale Price <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_whl_pri" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Wholesale Price</strong> is required." value="0.00">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Gross Profit <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_grs_prof" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Gross Profit</strong> is required." readonly="" value="0.00">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">GP Rate <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_gp_rate" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>PG Rate</strong> is required." readonly="" value="0.00">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-4" style="margin-bottom:10px;">
                                                                            <label class="col-sm-4">
                                                                                <input name="txt_vat_exempt" type="checkbox" class="minimal" data-parsley-multiple="txt_vat_exempt"> Payment
                                                                            </label>
                                                                            {{-- <label for="txt_vat_exempt" style="display: none"> </label>
                                                                            <input type="checkbox" id="txt_vat_exempt" maxlength="3" style="text-transform: uppercase;float:right"  name="txt_vat_exempt[]"  data-parsley-checkmin="1" value="Y" data-parsley-trigger="click"> --}}
                                                                            {{-- <input type="checkbox" maxlength="3" style="text-transform: uppercase;float:right;display: none"  name="txt_vat_exempt[]"  data-parsley-checkmin="1" value="N" data-parsley-trigger="click" checked> --}}
                                                                        </div>
                                                                        <label class="col-sm-8 control-label">VAT EXEMPT <span class="text-red" hidden>*</span></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Reorder level <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_reorder_lvl" step="100" placeholder="0" data-parsley-required-message="<strong>Reorder level</strong> is required." value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label  class="col-sm-4 control-label">Maximum level <span class="text-red" hidden>*</span></label>
                                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                                            <input type="number" class="form-control" name="itm_max_lvl" step="100" placeholder="0" data-parsley-required-message="<strong>Maximum level</strong> is required." value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Item list?
                                                        </p>
                                                    </center>
                                                </span>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <span class="AddMode">
                                                <button type="button" onclick="$('#AddForm').submit()" class="btn btn-success"><i class="fa fa-plus"></i> Save</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </span>
                                            <span class="DeleteMode" style="display: none">
                                                <button type="button" onclick="$('#AddForm').submit()" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                            </span>
                                        </div>
        							</div><!-- /.modal-content -->
        						</div><!-- /.modal-dialog -->
        					</div><!-- /.modal -->
        				</div><!-- /.box-header -->
        				<div class="box-body">
        					<table id="example1" class="table table-bordered table-striped">
        						<thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Rack Location</th>
                                        <th>Cost Price</th>
                                        <th>SRP Price</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($items)
                                        @foreach($items as $i)
                                            <tr>
                                                <th>{{$i->item_code}}</th>
                                                <td>{{$i->item_desc}}</td>
                                                <td>{{$i->bin_loc}}</td>
                                                <td>Php {{number_format($i->unit_cost, 2, ".", ", ")}}</center></td>
                                                <td>Php {{number_format($i->sell_pric, 2, ".", ", ")}}</center></td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$i->item_code}}', '{{urlencode($i->item_desc)}}', '{{$i->item_grp}}', '{{$i->brd_code}}', '{{$i->item_class}}', '{{$i->gen_code}}', '{{$i->sales_unit_id}}', '{{urlencode($i->bin_loc)}}', '{{$i->purc_unit_id}}', '{{($i->active == TRUE) ? 'Y' : 'N'}}', '{{$i->unit_cost}}', '{{$i->sell_pric}}', '{{$i->vat_exempt}}', '{{$i->tag_no}}', '{{$i->serial_no}}', '{{$i->part_no}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$i->item_code}}', '{{urlencode($i->item_desc)}}');"><i class="fa fa-trash "></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                	{{-- @isset($itmunit)
                                        @foreach($itmunit as $fund)
                                            <tr>
                                                <th>{{$fund->unit_id}}</th>
                                                <td>{{$fund->unit_shortcode}}</td>
                                                <td>{{$fund->unit_desc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$fund->unit_id}}', '{{$fund->unit_desc}}', '{{$fund->unit_shortcode}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$fund->unit_id}}', '{{$fund->unit_desc}}');"><i class="fa fa-trash "></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset --}}
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </tfoot> --}}
        					</table>
        				</div> <!-- /.box-body -->
        			</div> <!-- /.box -->
        		</div> <!-- /.col -->
        	</div> <!-- /.row -->
        </section> <!-- /.content -->
	<script type="text/javascript">
        $(document).ready(function(){
            $('#SideBar_MFile').addClass('active');
            $('#SideBar_MFile_Inventory').addClass('text-green');
            $('#SideBar_MFile_ITEM').addClass('text-green');
            $('#TreeView_MasterFile_Inventory_Menu').addClass('menu-open');
            $('#TreeView_MasterFile_Inventory_Menu2').css('display', 'block');
        });
        function computeGross()
        {
            var cost = parseFloat($('input[name="itm_amt"]').val());
            var sp = parseFloat($('input[name="itm_srp_pro"]').val());
            var gross  = sp-cost;
            $('input[name="itm_grs_prof"]').val(parseFloat(gross));
        }
        function computeMarkUp()
        {
            var markup = 0;
            var cost = parseFloat($('input[name="itm_amt"]').val());
            var sp = parseFloat($('input[name="itm_srp_pro"]').val());
            if(cost!=0 && sp!=0)
            {
                markup = ((sp / cost) * 100) - 100;
            }
            $('input[name="itm_mark_up"]').val(parseInt(markup));
        }
        function computeGpRate()
        {
            computeGross();
            computeMarkUp();
            var forGP = 0;
            var sp = parseFloat($('input[name="itm_srp_pro"]').val());
            var gross = parseFloat( $('input[name="itm_grs_prof"]').val());
            forGp = (gross/sp)*100;
            $('input[name="itm_gp_rate"]').val(parseInt(forGp));
        }
        function AddMode()
        {
            if($( "#modalDIALOG" ).hasClass( "modal-lg" ) == false){
                $( "#modalDIALOG" ).addClass('modal-lg');
            }
            $('#AddForm').parsley().reset();
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/item') }}');
            $('input[name="txt_id"]').val('');

            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            
            $('select[name="sel_itmgrp"]').val('').trigger('change');
            $('select[name="sel_itmgrp"]').attr('required', '');
            $('select[name="sel_brand"]').val('').trigger('change');
            $('select[name="sel_itm_class"]').val('').trigger('change');
            $('select[name="sel_itm_class"]').attr('required', '');
            $('select[name="sel_generic"]').val('').trigger('change');
            $('select[name="sel_generic"]').attr('required', '');
            $('select[name="sel_itmunit"]').val('').trigger('change');
            $('select[name="sel_itmunit"]').attr('required', '');
            $('input[name="txt_rak_loc"]').val('');
            $('input[name="txt_rak_loc"]').attr('required', '');
            $('select[name="sel_purunit"]').val('').trigger('change');
            $('select[name="sel_purunit"]').attr('required', '');
            $('select[name="sel_status"]').val('T').trigger('change');
            $('select[name="sel_status"]').attr('required', '');
            $('input[name="itm_amt"]').val('');
            $('input[name="itm_amt"]').attr('required', '');
            $('input[name="itm_srp_pro"]').val('');
            $('input[name="itm_srp_pro"]').attr('required', '');
            $('input[name="itm_whl_pri"]').val('0.00');
            $('input[name="txt_vat_exempt"]').prop('checked',false);
            $('input[name="itm_grs_prof"]').val('0.00');
            $('input[name="itm_mark_up"]').val('0.00');
            $('input[name="itm_gp_rate"]').val('0.00');
            $('input[name="itm_reorder_lvl"]').val('0');
            $('input[name="itm_max_lvl"]').val('0');
            $('input[name="tag_no"]').val('');
            $('input[name="serial_no"]').val('');
            $('input[name="part_no"]').val('');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, desc, item_grp, brd_code, item_class, gen_code, sales_unit_id,  bin_loc, purc_unit_id, is_active, unit_cost, sell_pric, vat_exempt, tag_no, ser_no, part_no)
        {
            if($( "#modalDIALOG" ).hasClass( "modal-lg" ) == false){
                $( "#modalDIALOG" ).addClass('modal-lg');
            }
            $('#AddForm').parsley().reset();
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/item') }}/update');
            $('input[name="txt_id"]').val(id);

            $('input[name="txt_name"]').val(urldecode(desc));
            $('input[name="txt_name"]').attr('required', '');
            
            $('select[name="sel_itmgrp"]').val(item_grp).trigger('change');
            $('select[name="sel_itmgrp"]').attr('required', '');
            $('select[name="sel_brand"]').val(brd_code).trigger('change');
            $('select[name="sel_itm_class"]').val(item_class).trigger('change');
            $('select[name="sel_itm_class"]').attr('required', '');
            $('select[name="sel_generic"]').val(gen_code).trigger('change');
            $('select[name="sel_generic"]').attr('required', '');
            $('select[name="sel_itmunit"]').val(sales_unit_id).trigger('change');
            $('select[name="sel_itmunit"]').attr('required', '');
            $('input[name="txt_rak_loc"]').val(urldecode(bin_loc));
            $('input[name="txt_rak_loc"]').attr('required', '');
            $('select[name="sel_purunit"]').val(purc_unit_id).trigger('change');
            $('select[name="sel_purunit"]').attr('required', '');
            $('select[name="sel_status"]').val(is_active == 'Y' ? 'T' : 'F').trigger('change');
            $('select[name="sel_status"]').attr('required', '');
            $('input[name="itm_amt"]').val(unit_cost);
            $('input[name="itm_amt"]').attr('required', '');
            $('input[name="itm_srp_pro"]').val(sell_pric);
            $('input[name="itm_srp_pro"]').attr('required', '');
            $('input[name="itm_whl_pri"]').val('0.00');
            $('input[name="txt_vat_exempt"]').prop('checked', vat_exempt == 'Y' ? true : false);
            $('input[name="itm_grs_prof"]').val('0.00');
            $('input[name="itm_mark_up"]').val('0.00');
            $('input[name="itm_gp_rate"]').val('0.00');
            $('input[name="itm_reorder_lvl"]').val('0');
            $('input[name="itm_max_lvl"]').val('0');
            $('input[name="txt_tag_no"]').val(tag_no);
            $('input[name="txt_ser_no"]').val(ser_no);
            $('input[name="txt_part_no"]').val(part_no);

            computeGpRate();
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            if($( "#modalDIALOG" ).hasClass( "modal-lg" ) == true){
                $( "#modalDIALOG" ).removeClass('modal-lg');
            }
            $('#AddForm').parsley().reset()
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/item') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(urldecode(desc));
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_itmgrp"]').removeAttr('required');
            $('select[name="sel_itm_class"]').removeAttr('required');
            $('select[name="sel_generic"]').removeAttr('required');
            $('select[name="sel_itmunit"]').removeAttr('required');
            $('input[name="txt_rak_loc"]').removeAttr('required');
            $('select[name="sel_purunit"]').removeAttr('required');
            $('select[name="sel_status"]').removeAttr('required');
            $('input[name="itm_amt"]').removeAttr('required');
            $('input[name="itm_srp_pro"]').removeAttr('required');
            $('#DeleteName').text(urldecode(desc));
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection