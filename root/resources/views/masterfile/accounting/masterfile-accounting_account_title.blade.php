@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/account-title"),'desc'=>'Account Title','icon'=>'none','st'=>true]
    ];
    $_ch = "Account Title"; // Module Name
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
        					<h3 class="box-title">Account Title List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Account Title <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">ID <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" class="form-control" placeholder="ID" readonly="" data-parsley-required-message="<strong>ID</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Account Group <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_type" style="width: 100%" data-parsley-errors-container="#sel_type_span" data-parsley-required-message="<strong>Account Group</strong> is required." required>
                                                                    @isset ($data[0])
                                                                        <option value="">Select Account Group..</option>
                                                                        @foreach($data[0] as $m03)
                                                                          <option value="{{$m03->acc_code}}">{{$m03->acc_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Account Group registered.</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_type_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Type <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_db" style="width: 100%" data-parsley-errors-container="#sel_db_span" data-parsley-required-message="<strong>Type</strong> is required." required>
                                                                    <option value="">Select Type..</option>
                                                                    <option value="D">Debit</option>
                                                                    <option value="C">Credit</option>
                                                                </select>
                                                                <span id="sel_db_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Acronym</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" class="form-control" name="txt_acro">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Long-Description</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <textarea  type="text" class="form-control" name="txt_desc"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-4">
                                                                    <input name="sel_sl" type="checkbox" class="minimal"> Subledger Account
                                                                </label>
                                                                <label class="col-sm-4">
                                                                    <input name="sel_cw" type="checkbox" class="minimal"> Check Writting
                                                                </label>
                                                                <label class="col-sm-4">
                                                                    <input name="sel_py" type="checkbox" class="minimal"> Payment
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <h4 class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Account Title list?
                                                        </h4>
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
                                        <th>Type</th>
                                        <th>SL</th>
                                        <th>CIB</th>
                                        <th>Sub Account</th>
                                        <th>Payment</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($data[1])
                                        @foreach($data[1] as $m04)
                                            <tr>
                                                <th> {{$m04->at_code}}{{--$m04->dr_cr--}}</th>
                                                <td>{{$m04->at_desc}}</td>
                                                <td>
                                                    @isset($m04->dr_cr)
                                                      @if($m04->dr_cr == "D") {{'Debit'}} @else {{'Credit'}} @endif
                                                    @else
                                                    {{'N/A'}}
                                                    @endisset
                                                </td>
                                                <td class="center">
                                                    <center>
                                                        @if ($m04->sl == 'N')
                                                            {{-- <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button> --}}
                                                            <i class="fa fa-times" style="font-size:25px;color:red"></i>
                                                        @else
                                                            <i class="fa fa-check" style="font-size:25px;color:green"></i>
                                                        @endif
                                                    </center>
                                                </td>
                                                <td class="center">
                                                    <center>
                                                        @if ($m04->cib_acct == 'N')
                                                        {{-- <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button> --}}
                                                            <i class="fa fa-times" style="font-size:25px;color:red"></i>
                                                        @else
                                                            <i class="fa fa-check" style="font-size:25px;color:green"></i>
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>
                                                    @isset($m04->acc_code)
                                                        {{{$m04->acc_desc}}}
                                                    @else
                                                         {{'N/A'}}
                                                    @endisset
                                                </td>
                                                <td class="center">
                                                    <center>
                                                        @if ($m04->payment == 'N' || $m04->payment == '')
                                                            <i class="fa fa-times" style="font-size:25px;color:red"></i>
                                                        @else
                                                            <i class="fa fa-check" style="font-size:25px;color:green"></i>
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$m04->at_code}}', '{{$m04->at_desc}}', '{{$m04->acc_code}}', '{{$m04->dr_cr }}', '{{$m04->sl}}', '{{$m04->cib_acct}}', '{{$m04->payment}}', '{{$m04->acro}}', '{{$m04->remarks}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$m04->at_code}}', '{{$m04->at_desc}}');"><i class="fa fa-trash "></i></a>
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
            $('#SideBar_MFile_Accounting_Account_Title').addClass('text-green');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/account-title') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_type"]').attr('required', '');
            $('select[name="sel_type"]').val('').trigger('change');
            $('select[name="sel_db"]').attr('required', '');
            $('select[name="sel_db"]').val('').trigger('change');
            $('input[name="txt_acro"]').val('');
            $('input[name="txt_desc"]').val('');

            $('input[name="sel_sl"]').prop('checked', false);
            $('input[name="sel_cw"]').prop('checked', false);
            $('input[name="sel_py"]').prop('checked', false);

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        // EditMode('{{$m04->at_code}}', '{{$m04->at_desc}}', '{{$m04->acc_code}}', '{{$m04->dr_cr }}', '{{$m04->sl}}', '{{$m04->cib_acct}}', '{{$m04->payment}}');
        function EditMode(id, desc, acc_id, dr_cr, sl, cw, py, acro, longdesc)
        {   
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/account-title') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_type"]').attr('required', '');
            $('select[name="sel_type"]').val(acc_id).trigger('change');
            $('select[name="sel_db"]').attr('required', '');
            $('select[name="sel_db"]').val(dr_cr).trigger('change');
            $('input[name="sel_sl"]').prop('checked', (sl == 'Y'? true : false));
            $('input[name="sel_cw"]').prop('checked', (cw == 'Y'? true : false));
            $('input[name="sel_py"]').prop('checked', (py == 'Y'? true : false));
            $('input[name="txt_acro"]').val(urldecode(acro));
            $('textarea[name="txt_desc"]').text(longdesc);
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/account-title') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_type"]').removeAttr('required');
            $('select[name="sel_db"]').removeAttr('required');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection