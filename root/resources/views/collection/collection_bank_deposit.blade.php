@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'City Treasurer','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Collection Entry','icon'=>'none','st'=>false],
        ['link'=>url("accounting/collection/bank_deposit"),'desc'=>'Bank Deposit','icon'=>'none','st'=>true]
    ];
    $_ch = "Bank Deposit"; // Module Name
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
        					<h3 class="box-title">Bank Deposit List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Bank Deposit <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">ID <span class="text-red" style="display: none">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" class="form-control" placeholder="ID" readonly="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Date <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="date" name="txt_date" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Bank <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select class="form-control" name="txt_bnk" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#txt_bnk_span" data-parsley-required-message="<strong>Bank</strong> is required." required="">
                                                                    @isset($bank)
                                                                        <option value="">Select Bank..</option>
                                                                        @foreach($bank AS $b)
                                                                            <option value="{{$b->b_code}}">{{$b->b_name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Bank registered..</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="txt_bnk_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Account # <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_acct_num" class="form-control" placeholder="Account #" data-parsley-required-message="<strong>Account #</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Account Name <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_acct_num_name" class="form-control" placeholder="Account Name" data-parsley-required-message="<strong>Account Name</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Reference # <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_ref" class="form-control" placeholder="Reference #" data-parsley-required-message="<strong>Reference #</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Amount <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" class="form-control" name="txt_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Bank Deposit list?
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
                                        <th>Account #</th>
                                        <th>Account Name</th>
                                        <th>Bank</th>
                                        <th>Reference #</th>
                                        <th><center>Amount</center></th>
                                        <th>Date Deposited</th>
                                        {{-- <th>Description</th> --}}
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($bank_dep)
                                        @foreach($bank_dep as $fund)
                                            <tr>
                                                <th>{{$fund->bd_id}}</th>
                                                <td>{{$fund->acc_num}}</td>
                                                <td>{{$fund->acc_name}}</td>
                                                <td>{{$fund->b_name}}</td>
                                                <td>{{$fund->ref_num}}</td>
                                                <td><center>Php {{number_format(floatval($fund->amount), 2, ".", ", ")}}</center></td>
                                                <td>{{$fund->bd_date_desc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$fund->bd_id}}', '{{$fund->bd_date}}', '{{$fund->b_code}}', '{{$fund->acc_num}}', '{{$fund->acc_name}}', '{{$fund->ref_num}}', '{{$fund->amount}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$fund->bd_id}}', '{{$fund->bd_id}}', '{{$fund->amount}}');"><i class="fa fa-trash "></i></a>
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
            // $('#SideBar_MFile_Accounting').addClass('text-green');
            // $('#SideBar_MFile_Accounting_Fund').addClass('text-green');
            // $('#TreeView_MasterFile_Accounting').addClass('menu-open');
            // $('#TreeView_MasterFile_Accounting2').css('display', 'block');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('accounting/collection/bank_deposit') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('required');
            // $('input[name="txt_name"]').val('');
            // $('input[name="txt_name"]').attr('required', '');

            $('input[name="txt_date"]').val('');
            $('input[name="txt_date"]').attr('required', '');
            $('select[name="txt_bnk"]').val('').trigger('change');
            $('select[name="txt_bnk"]').attr('required', '');
            $('input[name="txt_acct_num"]').val('');
            $('input[name="txt_acct_num"]').attr('required', '');
            $('input[name="txt_acct_num_name"]').val('');
            $('input[name="txt_acct_num_name"]').attr('required', '');
            $('input[name="txt_ref"]').val('');
            $('input[name="txt_ref"]').attr('required', '');
            $('input[name="txt_amt"]').val('');
            $('input[name="txt_amt"]').attr('required', '');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, db_date, b_code, acc_num, acc_name, ref_num, amt)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('accounting/collection/bank_deposit') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            // $('input[name="txt_name"]').val(desc);
            // $('input[name="txt_name"]').attr('required', '');

            $('input[name="txt_date"]').val(db_date);
            $('input[name="txt_date"]').attr('required', '');
            $('select[name="txt_bnk"]').val(b_code).trigger('change');
            $('select[name="txt_bnk"]').attr('required', '');
            $('input[name="txt_acct_num"]').val(acc_num);
            $('input[name="txt_acct_num"]').attr('required', '');
            $('input[name="txt_acct_num_name"]').val(acc_name);
            $('input[name="txt_acct_num_name"]').attr('required', '');
            $('input[name="txt_ref"]').val(ref_num);
            $('input[name="txt_ref"]').attr('required', '');
            $('input[name="txt_amt"]').val(amt);
            $('input[name="txt_amt"]').attr('required', '');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc , amt)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('accounting/collection/bank_deposit') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');

            $('input[name="txt_date"]').removeAttr('required');
            $('select[name="txt_bnk"]').removeAttr('required');
            $('input[name="txt_acct_num"]').removeAttr('required');
            $('input[name="txt_acct_num_name"]').removeAttr('required');
            $('input[name="txt_ref"]').removeAttr('required');
            $('input[name="txt_amt"]').removeAttr('required');

            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection