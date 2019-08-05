 @extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/cost-center"),'desc'=>'Office','icon'=>'none','st'=>true]
    ];
    $_ch = "Office"; // Module Name
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
        					<h3 class="box-title">Offices List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Office <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">ID <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" class="form-control" placeholder="ID" readonly="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Function <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="func_type" style="width: 100%" data-parsley-errors-container="#sel_type_span" data-parsley-required-message="<strong>Function</strong> is required." required>
                                                                    @isset($func)
                                                                        <option value="">Select Function..</option>
                                                                        @foreach($func as $f)
                                                                            <option value="{{$f->funcid}}">{{$f->funcdesc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Function registered.</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_type_span"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Office list?
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
                                        <th>Function</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($m08)
                                        @foreach($m08 as $m8)
                                            <tr>
                                                <td>{{$m8->cc_code}}</td>
                                                <td>{{$m8->cc_desc}}</td>
                                                <td>{{$m8->funcdesc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$m8->cc_code}}');"></i></a>

                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$m8->cc_code}}', '');"><i class="fa fa-trash"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Function</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </tfoot>
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
            $('#SideBar_MFile_Accounting_Cost_Center').addClass('text-green');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/cost-center') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id)
        {
            $.ajax({
                 url: '{{asset('master-file/accounting/cost-center/getupdatedetails/')}}/'+id,
                 method: 'GET',
                 success : function(data)
                           {
                             $('#MOD_MODE').text('(Edit)');
                             $('#AddForm').attr('action', '{{ url('master-file/accounting/cost-center') }}/update');
                             $('input[name="txt_id"]').val(data[0].cc_code);
                             $('input[name="txt_id"]').attr('required', '');
                             $('input[name="txt_id"]').attr('readonly', '');
                             $('input[name="txt_name"]').val(data[0].cc_desc);
                             $('input[name="txt_name"]').attr('required', '');
                             $('select[name="func_type"]').attr('required', '');
                             $('select[name="func_type"]').val(data[0].funcid).trigger('change');
                             $('.AddMode').show();
                             $('.DeleteMode').hide();
                           }
              });
            
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/cost-center') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').removeAttr('required', '');
            $('select[name="func_type"]').removeAttr('required');
            $('#DeleteName').text(id);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection