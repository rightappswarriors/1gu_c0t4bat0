@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("master-file/inventory/unit_measure"),'desc'=>'Unit Measure','icon'=>'none','st'=>true]
    ];
    $_ch = "Unit Measures"; // Module Name
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
        					<h3 class="box-title">Unit Measure List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Unit Measure <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" maxlength="3" style="text-transform: uppercase;"  name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Short Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_shrt" style="text-transform: uppercase;" class="form-control" placeholder="Short Code" data-parsley-required-message="<strong>Short Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" style="text-transform: uppercase;" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Unit Measure list?
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
                                        <th>Short Code</th>
                                        <th>Description</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($itmunit)
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
            $('#SideBar_MFile_ITEM_UNIT').addClass('text-green');
            $('#TreeView_MasterFile_Inventory_Menu').addClass('menu-open');
            $('#TreeView_MasterFile_Inventory_Menu2').css('display', 'block');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/unit_measure') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="txt_shrt"]').val('');
            $('input[name="txt_shrt"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, desc, shrt)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/unit_measure') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="txt_shrt"]').val(shrt);
            $('input[name="txt_shrt"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/inventory/unit_measure') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="txt_shrt"]').removeAttr('required');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection