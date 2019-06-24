@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Setting','icon'=>'none','st'=>false],
        ['link'=>url("settings/users"),'desc'=>'Users','icon'=>'none','st'=>true]
    ];
    $_ch = "Users"; // Module Name
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
        					<h3 class="box-title">Users List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog modal-lg">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Users <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <input type="text" maxlength="10" style="text-transform: uppercase;" name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-4 control-label">Office <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <select type="text" style="width: 100%" name="txt_office" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Office</strong> is required." {{-- multiple="multiple" --}} data-parsley-errors-container="#sel_txt_sel" required>
                                                                    @isset($offices)
                                                                        @if(count($offices) > 0)
                                                                            <option value="">Select Office..</option>
                                                                            @foreach ($offices as $o)
                                                                                <option value="{{$o->cc_code}}">{{$o->cc_desc}}</option>
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Office registered..</option>
                                                                        @endif
                                                                        <option value="">No Office registered..</option>
                                                                    @endisset
                                                                    </select>
                                                                    <span id="sel_txt_sel"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label">Password <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <input type="password" id="pw1" minlength="8" maxlength="15" name="txt_pass1" class="form-control" placeholder="********" data-parsley-required-message="<strong>Password</strong> is required." data-parsley-equalto="#pw2" data-parsley-equalto-message="Password Mismatch" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label">Confirm Password <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <input type="password" id="pw2" minlength="8" maxlength="15" name="txt_pass2" class="form-control" placeholder="********" data-parsley-required-message="<strong>Confirm Password</strong> is required." data-parsley-equalto-message="Password Mismatch" data-parsley-equalto="#pw1" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label">Complete Name <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <input type="text" name="txt_name" class="form-control" placeholder="Name" data-parsley-required-message="<strong>Complete Name</strong> is required." data-parsley-errors-container="#name_requirement" required>
                                                                    <span style="font-style: italic;">(Last Name, First Name M.I.)</span>
                                                                    <span id="name_requirement"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="col-sm-4 control-label">Group Rights <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <select style="width:100%" name="txt_grp" class="form-control"data-parsley-required-message="<strong>Group Right</strong> is required." required data-parsley-errors-container="#sel_fy_span">
                                                                        @isset($group_rights)
                                                                            @if(count($group_rights) > 0)
                                                                                <option value="">Select Group Right..</option>
                                                                                @foreach ($group_rights as $gr)
                                                                                    <option value="{{$gr->grp_id}}">{{$gr->grp_desc}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                <option value="">No Group Rights registered..</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="">No Group Rights registered..</option>
                                                                        @endisset
                                                                    </select>
                                                                    <span id="sel_fy_span"></span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Users list?
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Group Right</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($users)
                                        @foreach($users as $d)
                                            <tr>
                                                <th>{{$d->uid}}</th>
                                                <td>{{$d->opr_name}}</td>
                                                <td>{{$d->grp_desc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$d->uid}}', '{{urlencode($d->opr_name)}}', '{{$d->pwd}}', '{{$d->grp_id}}', '{{$d->cc_code}}');"></i></a>
                                                       {{-- <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$d->uid}}', '{{$d->opr_name}}');"><i class="fa fa-trash "></i></a> --}}
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
            // $('#SideBar_MFile').addClass('active');
            // $('#SideBar_MFile_Inventory').addClass('text-green');
            // $('#SideBar_MFile_GENERIC_NAME').addClass('text-green');
            // $('#TreeView_MasterFile_Inventory_Menu').addClass('menu-open');
            // $('#TreeView_MasterFile_Inventory_Menu2').css('display', 'block');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('settings/users') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');

            $('select[name="txt_grp"]').val('').trigger('change');
            $('select[name="txt_grp"]').attr('required', '');
            $('input[name="txt_pass1"]').val('');
            $('input[name="txt_pass2"]').val('');
            $('input[name="txt_pass1"]').attr('required', '');
            $('input[name="txt_pass2"]').attr('required', '');

            $('select[name="txt_office"]').val('').trigger('change');
            $('select[name="txt_office"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, name, pwd, grpid, cc_code)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('settings/users') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(urldecode(name));
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="txt_grp"]').val(grpid).trigger('change');
            $('select[name="txt_grp"]').attr('required', '');
            $('input[name="txt_pass1"]').val(pwd);
            $('input[name="txt_pass2"]').val(pwd);
            $('input[name="txt_pass1"]').attr('required', '');
            $('input[name="txt_pass2"]').attr('required', '');

            $('select[name="txt_office"]').val(cc_code).trigger('change');
            $('select[name="txt_office"]').attr('required', '');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('settings/users') }}/delete');
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