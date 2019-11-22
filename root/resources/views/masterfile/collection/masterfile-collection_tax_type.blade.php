@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Collection','icon'=>'none','st'=>false],
        ['link'=>url("master-file/tax/type"),'desc'=>'Tax Type','icon'=>'none','st'=>true]
    ];
    $_ch = "Tax Type"; // Module Name
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
        					<h3 class="box-title">Tax Type List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Tax Type <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_code" class="form-control" placeholder="Code" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Tax Group <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="tax_grp" style="width: 100%;" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Tax Group</strong> is required." required>
                                                                    <option value="" selected="" hidden disabled>Please Select</option>
                                                                    @isset($tax_group)
                                                                        @foreach($tax_group as $tg)
                                                                        <option value="{{$tg->tax_id}}">{{$tg->tax_desc}}</option>
                                                                        @endforeach
                                                                    @endisset
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">OR Type <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="txt_taxtype_id" style="width: 100%;" class="form-control" placeholder="Description" data-parsley-required-message="<strong>OR TYPE</strong> is required." required>
                                                                    <option value="" selected="" hidden disabled>Please Select</option>
                                                                    @isset($or_types)
                                                                        @foreach($or_types as $ot)
                                                                        <option value="{{$ot->or_type}}">{{$ot->or_code}}</option>
                                                                        @endforeach
                                                                    @endisset
                                                                </select>
                                                            </div>
                                                        </div>
                                                         <div class="form-group" hidden>
                                                            <label class="col-sm-4 control-label">id <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" class="form-control" placeholder="id" data-parsley-required-message="<strong>id</strong> is required." required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Tax Type list?
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
                                        <th>Tax Group</th>
                                        <th>OR Type</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($tax_type)
                                        @foreach($tax_type as $tax)
                                            <tr>
                                                <td>{{$tax->tax_code}}</td>
                                                <td>{{$tax->taxtype_desc}}</td>
                                                <td>{{$tax->tax_desc}}</td>
                                                <td>{{$tax->or_type}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$tax->taxtype_id}}', '{{$tax->taxtype_desc}}', '{{$tax->tax_id}}', '{{$tax->or_type}}', '{{$tax->tax_code}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$tax->taxtype_id}}', '{{$tax->tax_desc}}');"><i class="fa fa-trash "></i></a>
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
            $('#SideBar_MFile_Accounting').addClass('text-green');
            $('#SideBar_MFile_TAXTYPE').addClass('text-green');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/tax/type') }}');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="tax_grp"]').val('');
            $('select[name="tax_grp"]').attr('required', '');
            $('select[name="txt_taxtype_id"]').val('');
            $('select[name="txt_taxtype_id"]').attr('required', '');
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_code"]').val('').trigger('change');
            $('input[name="txt_code"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, desc, groupid, or_code, code)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/tax/type') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="tax_grp"]').val(groupid).trigger('change');
            $('select[name="tax_grp"]').attr('required', '');
            $('select[name="txt_taxtype_id"]').val(or_code).trigger('change');
            $('select[name="txt_taxtype_id"]').attr('required', '');
            $('input[name="txt_code"]').val(code).trigger('change');
            $('input[name="txt_code"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/tax/type') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').removeAttr('required');
            $('input[name="txt_code"]').removeAttr('required');
            $('select[name="tax_grp"]').removeAttr('required');
            $('select[name="txt_taxtype_id"]').removeAttr('required');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection