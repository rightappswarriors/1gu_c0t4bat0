@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("master-file/inventory/item_category"),'desc'=>'Item Category','icon'=>'none','st'=>true]
    ];
    $_ch = "Item Categories"; // Module Name
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
        					<h3 class="box-title">Item Category List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Item Category <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" maxlength="8" name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Next Number<span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_next" class="form-control" placeholder="Next Number" data-parsley-required-message="<strong>Next Number</strong> is required." value="00001" required>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Group Type<span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_typ" style="width: 100%" data-parsley-errors-container="#sel_typ_span" data-parsley-required-message="<strong>Group Type</strong> is required." required>
                                                                    @isset($outlettyp)
                                                                        <option value="">Select Group Type..</option>
                                                                        @foreach ($outlettyp as $o)
                                                                            <option value="{{$o->ottyp}}">{{$o->ot_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Group Type Registered..</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_typ_span"></span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <label class="col-sm-12 control-label">&nbsp;</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-12 control-label">Accounting </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <hr class="col-sm-12">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Stocks<span class="text-red" hidden>*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_stock" style="width: 100%" data-parsley-errors-container="#sel_typ_span" data-parsley-required-message="<strong>Group Type</strong> is required.">
                                                                    @isset($m04)
                                                                        <option value="">Select Stock..</option>
                                                                        @foreach ($m04 as $o)
                                                                            <option value="{{$o->at_code}}">{{$o->at_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Stock Registered..</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_stock_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Sales<span class="text-red" hidden>*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_sale" style="width: 100%" data-parsley-errors-container="#sel_typ_span" data-parsley-required-message="<strong>Group Type</strong> is required.">
                                                                    @isset($m04)
                                                                        <option value="">Select Sales..</option>
                                                                        @foreach ($m04 as $o)
                                                                            <option value="{{$o->at_code}}">{{$o->at_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Sales Registered..</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_sale_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Cost of Sales<span class="text-red" hidden>*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_cost" style="width: 100%" data-parsley-errors-container="#sel_typ_span" data-parsley-required-message="<strong>Group Type</strong> is required.">
                                                                    @isset($m04)
                                                                        <option value="">Select Cost of Sales..</option>
                                                                        @foreach ($m04 as $o)
                                                                            <option value="{{$o->at_code}}">{{$o->at_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Cost of Sales Registered..</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_cost_span"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Item Category list?
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
                                        <th>Account Stocks</th>
                                        <th>Account Sales</th>
                                        <th>Account Cost</th>
                                        <th>Type</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($itmgrp)
                                        @foreach($itmgrp as $fund)
                                            <tr>
                                                <th >{{$fund->item_grp}}</th>
                                                <td>{{$fund->grp_desc}}</td>
                                                <td testx="{!!$fund->acct_stks!!}">{{(($fund->acct_stks != '') ? $fund->acct_stks_desc : 'N/A')}}</td>
                                                <td>{{(($fund->acct_sales != '') ? $fund->acct_sales_desc : 'N/A')}}</td>
                                                <td>{{(($fund->acct_cost != '') ? $fund->acct_cost_desc : 'N/A')}}</td>
                                                <td>{{$fund->ot_desc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$fund->item_grp}}', '{{urlencode($fund->grp_desc)}}', '{{$fund->acct_stks}}', '{{$fund->acct_sales}}', '{{$fund->acct_cost}}', '{{$fund->grptype}}', '{{$fund->next_num}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$fund->item_grp}}', '{{$fund->grp_desc}}');"><i class="fa fa-trash "></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
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
            $('#SideBar_MFile_ITEM_CATEGORY').addClass('text-green');
            $('#TreeView_MasterFile_Inventory_Menu').addClass('menu-open');
            $('#TreeView_MasterFile_Inventory_Menu2').css('display', 'block');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/item_category') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');

            $('input[name="txt_next"]').val('00001');
            $('input[name="txt_next"]').attr('required', '');
            $('select[name="sel_typ"]').val('').trigger('change');
            $('select[name="sel_typ"]').attr('required', '');
            $('select[name="sel_stock"]').val('').trigger('change');
            $('select[name="sel_sale"]').val('').trigger('change');
            $('select[name="sel_cost"]').val('').trigger('change');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, desc, stock, sale, cost, grp_type, next_num)
        {
            // {{$fund->item_grp}}', '{{urlencode($fund->grp_desc)}}', '{{$fund->acct_stks}}', '{{$fund->acct_sales}}', '{{$fund->acct_cost}}', '{{$fund->grptype}}', '{{$fund->next_num}}
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/item_category') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(urldecode(desc));
            $('input[name="txt_name"]').attr('required', '');

            $('input[name="txt_next"]').val(next_num);
            $('input[name="txt_next"]').attr('required', '');
            $('select[name="sel_typ"]').val(grp_type).trigger('change');
            $('select[name="sel_typ"]').attr('required', '');
            $('select[name="sel_stock"]').val(stock).trigger('change');
            $('select[name="sel_sale"]').val(sale).trigger('change');
            $('select[name="sel_cost"]').val(cost).trigger('change');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/item_category') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_next"]').removeAttr('required');
            $('select[name="sel_typ"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection