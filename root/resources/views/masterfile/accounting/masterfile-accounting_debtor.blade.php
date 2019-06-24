@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/debtor"),'desc'=>'Customer List','icon'=>'none','st'=>true]
    ];
    $_ch = "Customer"; // Module Name
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
        					<h3 class="box-title">Customer List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Customer <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">ID <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" maxlength="6" class="form-control" placeholder="ID" readonly="" data-parsley-required-message="<strong>ID</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Name <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="" data-parsley-required-message="<strong>Name</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Type <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_type" style="width: 100%" data-parsley-errors-container="#sel_type_span" data-parsley-required-message="<strong>Type</strong> is required." required>
                                                                    <option value="">Select Type..</option>
                                                                    <option value="Customer">Customer</option>
                                                                    <option value="Financer">Financer</option>
                                                                    <option value="Inscurance">Inscurance</option>
                                                                    <option value="Prospect">Prospect</option>
                                                                </select>
                                                                <span id="sel_type_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">No. Street <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_add" class="form-control" data-parsley-required-message="<strong>Address</strong> is required." required="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Barangay <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_brgy" style="width: 100%" data-parsley-errors-container="#sel_brgy_span" data-parsley-required-message="<strong>Barangay</strong> is required." required>
                                                                    @isset($brgy)
                                                                        @if(count($brgy))
                                                                            <option value="">Select Barangay...</option>
                                                                            @foreach($brgy as $m)
                                                                                <option value="{{$m->brgy_id}}">{{$m->brgy_name}}</option>
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Barangay registered.</option>
                                                                        @endif
                                                                    @else
                                                                        <option value="">No Barangay registered.</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_brgy_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Mobile Number <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_mob_num" class="form-control" required="" data-parsley-required-message="<strong>Mobile Number</strong> is required.">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Email Address <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="email" name="txt_email" class="form-control" required="" data-parsley-required-message="<strong>Email Address</strong> is required." data-parsley-type-message="Should be an invalid Email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Phone <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_phn_num" class="form-control" required="" data-parsley-required-message="<strong>Phone</strong> is required.">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">TIN Number </label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_tin_num" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Fax Number </label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_fax_num" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Contact Person </label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_cnt_per" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Mode of Payment <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_mop" style="width: 100%" data-parsley-errors-container="#sel_mop_span" data-parsley-required-message="<strong>Mode of Payment</strong> is required." required>
                                                                    @isset($m10)
                                                                        <option value="">Select Mode of Payment...</option>
                                                                        @foreach($m10 as $m)
                                                                            <option value="{{$m->mp_code}}">{{$m->mp_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Mode of Payment registered.</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="sel_mop_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Credit Limit </label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" maxlength="8" name="txt_crd_lmt" class="form-control" placeholder="0.00">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Sub-ledger <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="sel_sub_led" style="width: 100%" data-parsley-errors-container="#sel_sub_led_span" data-parsley-required-message="<strong>Sub-ledger</strong> is required." required>
                                                                @isset($m04)
                                                                    <option value="">Select Sub-ledger..</option>
                                                                    @foreach($m04 as $m4)
                                                                        <option value="{{$m->at_code}}">{{$m4->at_desc}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No Sub-ledger registered</option>
                                                                @endisset
                                                                </select>
                                                                <span id="sel_sub_led_span"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Remarks </label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <textarea name="txt_rmks" class="form-control" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <h4 class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Customer list?
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
                                        <th>Customer</th>
                                        <th>Address</th>
                                        <th>Mobile #</th>
                                        <th>Fax</th>
                                        <th>Email</th>
                                        <th>Tin</th>
                                        <th>Type</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($m06)
                                        @foreach($m06 as $m6)
                                            <tr>
                                                <th>{{$m6->d_code}}</th>
                                                <td>{{$m6->d_name}}</td>
                                                <td>{{$m6->d_addr2}}</td>
                                                <td>{{$m6->d_tel}}</td>
                                                <td>{{$m6->d_fax}}</td>
                                                <td>{{$m6->d_email}}</td>
                                                <td>{{$m6->d_tin}}</td>
                                                <td>{{$m6->type}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$m6->d_code}}', '{{$m6->d_name}}', '{{$m6->d_addr2}}', '{{$m6->d_tel }}', '{{$m6->d_fax}}', '{{$m6->d_email}}', '{{$m6->d_tin}}', '{{$m6->type}}',  '{{$m6->mp_code}}',  '{{$m6->at_code}}', '{{$m6->d_cntc_no}}', '{{$m6->limit}}', '{!!$m6->remarks!!}', '{{$m6->d_cntc}}', '{{$m6->d_addr1}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$m6->d_code}}', '{{$m6->d_name}}');"><i class="fa fa-trash "></i></a>
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
            $('#SideBar_MFile_Accounting_Debtor').addClass('text-green');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/debtors') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').attr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_type"]').attr('required', '');
            $('select[name="sel_type"]').val('').trigger('change');


            $('input[name="txt_add"]').val('');
            $('input[name="txt_add"]').attr('required', '');
            $('input[name="txt_mob_num"]').val('');
            $('input[name="txt_mob_num"]').attr('required', '');
            $('input[name="txt_email"]').val('');
            $('input[name="txt_email"]').attr('required', '');
            $('input[name="txt_phn_num"]').val('');
            $('input[name="txt_phn_num"]').attr('required', '');


            $('input[name="txt_tin_num"]').val('');
            $('input[name="txt_fax_num"]').val('');
            $('input[name="txt_cnt_per"]').val('');

            $('select[name="sel_mop"]').attr('required', '');
            $('select[name="sel_mop"]').val('').trigger('change');

            $('input[name="txt_crd_lmt"]').val('');

            $('select[name="sel_sub_led"]').attr('required', '');
            $('select[name="sel_sub_led"]').val('').trigger('change');

            $('textarea[name="txt_rmks"]').val('');

            $('select[name="sel_brgy"]').val('').trigger('change');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
    {{-- code, name, addr, tel, fax, email, tin, typ, atcd, sl, mob, lmt --}}
        function EditMode(id, desc,  addr, tel, fax, email, tin, typ, atcd, sl, mob, lmt, rmls, cntpc, brgy)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/debtors') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_type"]').attr('required', '');
            $('select[name="sel_type"]').val(typ).trigger('change');


            $('input[name="txt_add"]').val(addr);
            $('input[name="txt_add"]').attr('required', '');
            $('input[name="txt_mob_num"]').val(mob);
            $('input[name="txt_mob_num"]').attr('required', '');
            $('input[name="txt_email"]').val(email);
            $('input[name="txt_email"]').attr('required', '');
            $('input[name="txt_phn_num"]').val(tel);
            $('input[name="txt_phn_num"]').attr('required', '');


            $('input[name="txt_tin_num"]').val(tin);
            $('input[name="txt_fax_num"]').val(fax);
            $('input[name="txt_cnt_per"]').val(cntpc);

            $('select[name="sel_mop"]').attr('required', '');
            $('select[name="sel_mop"]').val(atcd).trigger('change');

            $('input[name="txt_crd_lmt"]').val(lmt);

            $('select[name="sel_sub_led"]').attr('required', '');
            $('select[name="sel_sub_led"]').val(sl).trigger('change');

            $('textarea[name="txt_rmks"]').val(rmls);
            $('select[name="sel_brgy"]').val(brgy).trigger('change');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/debtors') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');

            $('select[name="sel_type"]').removeAttr('required');
            $('input[name="txt_add"]').removeAttr('required');
            $('input[name="txt_mob_num"]').removeAttr('required');
            $('input[name="txt_email"]').removeAttr('required');
            $('input[name="txt_phn_num"]').removeAttr('required');
            $('select[name="sel_mop"]').removeAttr('required');
            $('select[name="sel_sub_led"]').removeAttr('required');

            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection