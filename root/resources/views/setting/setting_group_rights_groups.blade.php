@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Setting','icon'=>'none','st'=>false],
        ['link'=>url("settings/group-rights"),'desc'=>'Group Rights','icon'=>'none','st'=>true],
        ['link'=>url("settings/group-rights/groups"),'desc'=>'Groups','icon'=>'none','st'=>true]
    ];
    $_ch = "Groups"; // Module Name
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
        					<div class="row">
                                <div class="col-sm-5">
                                    <h3 class="box-title">Group List</h3>
                                    <button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
                                </div>
                            </div>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Groups <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" maxlength="8" style="text-transform: uppercase;" name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" name="txt_name" class="form-control" placeholder="Name" data-parsley-required-message="<strong>Description</strong> is required." data-parsley-errors-container="#name_requirement" required>
                                                            <span id="name_requirement"></span>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label class="col-sm-4 control-label">User <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" name="txt_user[]" class="form-control" placeholder="Path" data-parsley-errors-container="#name_requirement4" multiple="multiple">
                                                            <span id="name_requirement4"></span>
                                                        </div>
                                                    </div> --}}
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Group list?
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
                                        <th width="auto">Code</th>
                                        <th width="auto">Description</th>
                                        <th width="auto"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($group_rights)
                                        @foreach($group_rights as $d)
                                            <tr>
                                                <th>{{$d->grp_id}}</th>
                                                <td>{{$d->grp_desc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$d->grp_id}}', '{{urlencode($d->grp_desc)}}');"></i></a>
                                                       {{-- <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$d->grp_id}}', '{{$d->grp_desc}}');"><i class="fa fa-trash "></i></a> --}}
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
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights/groups') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="txt_path"').val('');
            $('input[name="txt_path"]').attr('required', '');
            $('#OFFICE').val(null).trigger('change');
            $('#USERS').val().trigger('change');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        
        function EditMode(id, name)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights/groups') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(urldecode(name));
            $('input[name="txt_name"]').attr('required', '');
            // $('select[name="txt_grp"]').val(grpid).trigger('change');
            // $('select[name="txt_grp"]').attr('required', '');
            // $('input[name="txt_pass1"]').val(pwd);
            // $('input[name="txt_pass2"]').val(pwd);
            // $('input[name="txt_pass1"]').attr('required', '');
            // $('input[name="txt_pass2"]').attr('required', '');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights/groups') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection