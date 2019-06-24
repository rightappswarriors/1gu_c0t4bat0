@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/charges"),'desc'=>'Charges','icon'=>'none','st'=>true]
    ];
    $_ch = "Charges"; // Module Name
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
        					<h3 class="box-title">Charges List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Charges <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input  type="text" maxlength="3" name="txt_id" class="form-control" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Charge Number</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_chg_num" maxlength="8" class="form-control" placeholder="Charge Number" data-parsley-required-message="<strong>Charge Number</strong> is required." value="00000001">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Default Price</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="txt_dfl_pri" class="form-control" placeholder="Default Price" data-parsley-required-message="<strong>Default Number</strong> is required." step="0.01" value="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>.">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <label for="" class="col-sm-4 control-label">Type </label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="select_typ" style="width: 100%;" data-parsley-errors-container="#select_typ_span" data-parsley-required-message="<strong>Type</strong> is required." class="form-control">
                                                                    <option value="">Select Type..</option>
                                                                    <option value="C">Charge</option>
                                                                    <option value="P">Payment</option>
                                                                </select>
                                                                <span id="select_typ_span"></span>
                                                            </div>
                                                        </div> --}}
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 control-label">Account Title</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                 <select name="select_act_ttl" style="width: 100%;" data-parsley-errors-container="#select_act_ttl_span"  data-parsley-required-message="<strong>Account Title</strong> is required." class="form-control">
                                                                    @isset($m04)
                                                                        <option value="">Select Account Title...</option>
                                                                        @foreach($m04 as $m4)
                                                                            <option value="{{$m4->at_code}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Account Title registered...</option>
                                                                    @endisset
                                                                 </select>
                                                                 <span id="select_act_ttl_span"></span>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <label for="" class="col-sm-4 control-label">Cost Center</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="select_cc_code" style="width: 100%" onchange="getSubCostCenter()" data-parsley-errors-container="#select_cc_code_span"  data-parsley-required-message="<strong>Cost Center</strong> is required." class="form-control" >
                                                                    @isset($m08)
                                                                        <option value="">Select Cost Center...</option>
                                                                        @foreach($m08 as $m8)
                                                                            <option value="{{$m8->cc_code}}">{{$m8->cc_code}} - {{$m8->cc_desc}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">No Cost Center registered...</option>
                                                                    @endisset
                                                                </select>
                                                                <span id="select_cc_code_span"></span>
                                                            </div>
                                                        </div> --}}
                                                        {{-- <div class="form-group">
                                                            <label for="" class="col-sm-4 control-label">Sub Cost Center</label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="select_scc_code" style="width: 100%" data-parsley-errors-container="#select_scc_code_span"  data-parsley-required-message="<strong>Sub Cost Center</strong> is required." class="form-control">
                                                                </select>
                                                                <span id="select_scc_code_span"></span>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Charges list?
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
                                        <th><center>Charge #</center></th>
                                        <th><center>Default Price</center></th>
                                        <th><center>Type</center></th>
                                        <th><center>Account Title</center></th>
                                        {{-- <th><center>Cost Center</center></th> --}}
                                        {{-- <th><center>Sub Cost Center</center></th> --}}
                                        <th width="10%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($charge)
                                        @foreach ($charge as $c)
                                            <tr>
                                                <th>{{$c->chg_code}}</th>
                                                <td>{{$c->chg_desc}}</td>
                                                <td><center>{{$c->chg_num}}</center></td>
                                                <td><center>Php {{number_format($c->price, 2, ".", ", ")}}</center></td>
                                                <td>
                                                    <center>
                                                        @if($c->chg_type == 'P')
                                                            {{'Payment'}}
                                                        @else
                                                            {{'Charge'}}
                                                        @endif
                                                    </center>
                                                </td>
                                                <td><center>@isset($c->at_desc){{$c->at_desc}}@else&nbsp;@endisset</center></td>
                                                {{-- <td><center>@isset($c->cc_desc){{$c->cc_desc}}@else&nbsp;@endisset</center></td> --}}
                                                {{-- <td><center>@isset($c->scc_desc){{$c->scc_desc}}@else&nbsp;@endisset</center></td> --}}
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$c->chg_code}}', '{{urlencode($c->chg_desc)}}', '{{$c->chg_num}}', '{{floatval($c->price)}}', '{{$c->chg_type}}', '{{$c->at_code}}', '{{$c->cc_code}}', '{{$c->scc_code}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$c->chg_code}}', '{{urlencode($c->chg_desc)}}');"><i class="fa fa-trash "></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                	@isset($data[0])
                                        @foreach($data[0] as $fund)
                                            <tr>
                                                <th>{{$fund->fid}}</th>
                                                <td>{{$fund->fdesc}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$fund->fid}}', '{{$fund->fdesc}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$fund->fid}}', '{{$fund->fdesc}}');"><i class="fa fa-trash "></i></a>
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
            $('#TreeView_MasterFile_Accounting').addClass('menu-open');
            $('#TreeView_MasterFile_Accounting_Menu').css('display', 'block');
            $('#SideBar_MFile_Accounting').addClass('text-green');
            $('#SideBar_MFile_Accounting_Charge').addClass('text-green');
            // $('#SideBar_MFile_Accounting_Charge').focus();
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/charges') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').attr('required');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');

            $('input[name="txt_chg_num"]').val('00000001');
            $('input[name="txt_dfl_pri"]').val('0.00');
            $('select[name="select_typ"]').val('').trigger('change');
            $('select[name="select_act_ttl"]').val('').trigger('change');
            $('select[name="select_cc_code"]').val('').trigger('change');
            $('select[name="select_scc_code"]').val('').trigger('change');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        {{-- '{{$c->chg_code}}', '{{$c->chg_desc}}', '{{$c->chg_num}}', '{{floatval($c->price)}}', '{{$c->chg_type}}', '{{$c->at_code}}', '{{$c->cc_code}}', '{{$c->scc_code}}' --}}
        function EditMode(id, desc, chg_num, price, typ, at_code, cc_code, scc_code)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/charges') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(urldecode(desc));
            $('input[name="txt_name"]').attr('required', '');

            $('input[name="txt_chg_num"]').val(chg_num);
            $('input[name="txt_dfl_pri"]').val(parseFloat(price));
            $('select[name="select_typ"]').val(typ).trigger('change');
            $('select[name="select_act_ttl"]').val(at_code).trigger('change');
            $('select[name="select_scc_code"]').empty();
            $('select[name="select_cc_code"]').val(cc_code).trigger('change');
            setTimeout(function(){$('select[name="select_scc_code"]').val(scc_code).trigger('change');},800);
            // $('select[name="select_scc_code"]').val(scc_code).trigger('change');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/charges') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(urldecode(desc));
            $('input[name="txt_name"]').attr('required', '');
            $('#DeleteName').text(urldecode(desc));
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
        function getSubCostCenter()
        {
            var cc_code  = $('select[name="select_cc_code"]').val();
            if(cc_code != '')
            {
                $.ajax({
                    url : "{{ url('master-file/accounting/charges/getSubCostCenter') }}",
                    data : {_token: $('meta[name="csrf-token"]').attr('content'), cc_code : cc_code},
                    success : function(data){
                        $('select[name="select_scc_code"]').empty();
                        if(data.length > 0 ){
                            $('select[name="select_scc_code"]').append('<option value="">Select Sub Cost Center...</option>');
                            for(let i = 0; i < data.length; i++){
                                $('select[name="select_scc_code"]').append('<option value="'+data[i].scc_code+'">'+data[i].scc_desc+'</option>');
                            }
                        } else {
                            $('select[name="select_scc_code"]').append('<option value="">No Sub Cost Center registered...</option>');
                        }
                        $('select[name="select_scc_code"]').val('').trigger('change');
                    },
                    error : function(a, b, c){
                        console.log(c);
                        alert('An error occured during the retrieving of the data');
                    }
                });
            }

        }
    </script>
@endsection