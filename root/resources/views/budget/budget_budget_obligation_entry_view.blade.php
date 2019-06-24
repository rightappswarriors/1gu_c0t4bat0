@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-obligation-entry"),'desc'=>'Approved Entry','icon'=>'none','st'=>true],
        ['link'=>url("budget/budget-obligation-entry/new"),'desc'=>'View','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Obligation Entry"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Header</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
        	<form id="HdrForm" data-parsley-validate novalidate>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Period <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control" name="" disabled="" value="@if(isset($bgt01) &&  isset($mo_desc)){{$bgt01->fy}}-{{$mo_desc}}@endif">
                        {{-- <select class="form-control select2 select2-hidden-accessible" name="fymo" value="@if(isset($fy) &&  isset($mo)){{$fy}}-{{$mo}}@endif" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        	@isset($data[0])
			                    <option value="">Select Period...</option>
			                    @foreach($data[0] as $x03)
			                      <option value="{{$x03->fy}}-{{$x03->mo}}">{{$x03->fy}}-{{$x03->month_desc}}</option>
			                    @endforeach
			                @else
			                    <option value="">No Period registered...</option>
			                @endisset
                        </select> --}}
                        <input type="text" name="hdr_fy" readonly="" style="display: none" value="@isset($bgt01){{$bgt01->fy}}@endisset">
                        <input type="text" name="hdr_mo" readonly="" style="display: none" value="@isset($bgt01){{$bgt01->mo}}@endisset">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Reference Number</label>
                        <input type="text" class="form-control" name="hdr_b_num" disabled="" value="@isset($bgt01){{$bgt01->j_num}}@endisset">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date <span style="color:red"><strong>*</strong></span></label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" name="hdr_date" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fund <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetProposal" name="hdr_fid_txt" disabled>
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_fid" style="width: 100%; display: none" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>Fund</strong> is required." required>
                            @isset($fund)
                            	<option value="">Select Fund...</option>
                            	@foreach($fund as $f)
		                            <option value="{{$f->fid}}">{{$f->fdesc}}</option>
		                        @endforeach
		                    @else
		                    	<option value="">No Fund registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_fid_span"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cost Center <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetProposal" name="hdr_cc_txt" disabled>
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_cc" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_cc_span" data-parsley-required-message="<strong>Cost Center</strong> is required." required>
                            @isset($m08)
                            	<option value="">Select Cost Center..</option>
                            	@foreach($m08 as $m8)
                            		<option value="{{$m8->cc_code}}">{{$m8->cc_desc}}</option>
                            	@endforeach
                            @else
                            	<option value="">No Cost Center registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_cc_span"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sector <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetProposal" name="hdr_sec_txt" disabled>
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_sec" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_sec_span" data-parsley-required-message="<strong>Sector</strong> is required." required>
                            @isset($sector)
                            	<option value="">Select Sector...</option>
								@foreach($sector as $s)
		                            <option value="{{$s->secid}}">{{$s->secdesc}}</option>
		                        @endforeach
                           	@else
                           		<option value="">No Sector registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_sec_span"></span>
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Branch <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetProposal" name="hdr_br_txt" disabled>
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_br" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_br_span" data-parsley-required-message="<strong>Branch</strong> is required." required>
                            @isset($branch)
                            	<option value="">Select Branch...</option>
                            	@foreach($branch as $b)
                            	@endforeach
                            @else
                            	<option value="">No Branch registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_br_span"></span>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Description <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetProposal" name="hdr_desc_txt" value="@isset($bgt01){{$bgt01->t_desc}}@endisset" disabled>
                        <input type="text" class="form-control EditBudgetProposal" style="display: none" name="hdr_desc" data-parsley-required-message="<strong>Description</strong> is required." required value="@isset($bgt01){{$bgt01->t_desc}}@endisset">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Approved Budget Reference # <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetProposal" name="hdr_bgtps01" value="@isset($bgt01){{$bgt01->bgt01_bnum}}@endisset" disabled>
                    </div>
                </div>
                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Finalized</label>
                        @isset($bgt01)
                            @if($bgt01->finalized == 'Y')
                                <center><i class="fa fa-check" style="font-size:25px;color:green"></i></center>
                            @else
                                <center><i class="fa fa-times" style="font-size:25px;color:red"></i></center>
                            @endif
                        @endisset
                    </div>
                </div> --}}
                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Closed</label>
                        @isset($bgt01)
                            @if($bgt01->closed == 'Y')
                                <center><i class="fa fa-check" style="font-size:25px;color:green"></i></center>
                            @else
                                <center><i class="fa fa-times" style="font-size:25px;color:red"></i></center>
                            @endif
                        @endisset
                    </div>
                </div> --}}
            </div>
            </form>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Budget Entries</h3>
                    <button type="button" style="display: none" class="btn btn-primary EditBudgetProposal" onclick="addMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add item</button>
                    <div class="modal fade in" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                	<h4 class="modal-title">Item <span id="MOD_MODE"></span></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box-body">
                                    	<form id="ItmForm" novalidate data-parsley-validate>
	                                        <span class="AddMode">
	                                        	<div class="row">
		                                            <div class="col-sm-6">
		                                                <div class="form-group">
		                                                    <label>Line</label>
		                                                    <input type="text" class="form-control" disabled="" name="itm_line">
		                                                </div>
		                                            </div>
		                                            <div class="col-sm-6">
		                                                <div class="form-group">
		                                                    <label>Code</label>
		                                                    <input type="text" class="form-control"  disabled="" name="itm_code">
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="row">
		                                            <div class="col-sm-12">
		                                                <div class="form-group">
		                                                    <label>Account Title <span style="color:red"><strong>*</strong></span></label>
		                                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_acc_title" data-parsley-required-message="<strong>Account Title</strong> is required." onchange="getAccountTitleCode()" required>
		                                                        @isset($m04)
		                                                        	<option value="">Select Account Title...</option>
		                                                        	@foreach ($m04 as $m4)
		                                                        		<option value="{{$m4->at_code}}">{{$m4->at_desc}}</option>
		                                                        	@endforeach
		                                                        @endisset
		                                                    </select>
		                                                    <span id="itm_acc_title_span"></span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="row">
		                                            <div class="col-sm-12">
		                                                <div class="form-group">
		                                                    <label>PPA <span style="color:red"><strong>*</strong></span></label>
		                                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_ppa" data-parsley-required-message="<strong>PPA</strong> is required."  required>
		                                                        @isset($ppa)
		                                                        	<option value="">Select PPA...</option>
		                                                        	@foreach ($ppa as $ppasggrp)
		                                                        		<option value="{{$ppasggrp->subgrpid}}">{{$ppasggrp->subgrpdesc}}</option>
		                                                        	@endforeach
		                                                        @endisset
		                                                    </select>
		                                                    <span id="itm_acc_title_span"></span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="row">
		                                            <div class="col-sm-12">
		                                                <div class="form-group">
		                                                    <label>Amount <span style="color:red"><strong>*</strong></span></label>
		                                                    <input type="number" class="form-control" name="itm_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        {{-- <div class="row">
		                                            <div class="col-sm-12">
		                                                <div class="form-group">
		                                                    <label>Notes</label>
		                                                    <textarea class="form-control"></textarea>
		                                                </div>
		                                            </div>
		                                        </div> --}}
	                                        </span>
	                                        <span class="DeleteMode"  style="display: none">
	                                            <center>
	                                                <h4 class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
	                                                from Item list?
	                                                </h4>
	                                            </center>
	                                        </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <span class="AddMode">
                                        <button type="button" onclick="InsModiItem()" class="btn btn-success"><i id="ItemButtonNameButton" class="fa fa-plus"></i> <span id="ItemButtonName">Add</span></button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                    </span>
                                    <span class="DeleteMode" style="display: none">
                                        <button type="button" onclick="InsModiItem()" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                    </span>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @isset($ppa)
                    <ul id="TheNavBar" class="nav nav-tabs">
                        @for($i = 0; $i < count($ppa); $i++)
                            @if($i == 0)
                                <li id="tabhead_{{$ppa[$i]->subgrpid}}" class="active"><a data-toggle="tab"  href="#tab_{{$ppa[$i]->subgrpid}}">{{$ppa[$i]->subgrpdesc}}</a>
                            @else
                                <li id="tabhead_{{$ppa[$i]->subgrpid}}"><a data-toggle="tab"  href="#tab_{{$ppa[$i]->subgrpid}}">{{$ppa[$i]->subgrpdesc}}</a>
                            @endif
                        @endfor
                    </ul>
                    @endisset
                    @isset($ppa)
                        <div class="tab-content">
                            @for($i = 0; $i < count($ppa); $i++)
                                @if($i == 0)
                                    <div data-toggle="tab" id="tab_{{$ppa[$i]->subgrpid}}" class="tab-pane fade in active">
                                @else
                                    <div data-toggle="tab" id="tab_{{$ppa[$i]->subgrpid}}" class="tab-pane fade in">
                                @endif
                                <br>
                                    <table id="table_{{$ppa[$i]->subgrpid}}" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Line</th>
                                                <th>Code</th>
                                                <th>Account Title</th>
                                                <th>PPA</th>
                                                <th><center>Approved Amount</center></th>
                                                <th><center>Obligation Amount</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($bgt02)
                                                @for($j = 0; $j < count($bgt02); $j++)
                                                    @if($ppa[$i]->subgrpid == $bgt02[$j]->grpid)
                                                        <tr>
                                                            <td>{{$bgt02[$j]->seq_num}}</td>
                                                            <td>
                                                                <span class="cc_code" cc-code="{{$bgt02[$j]->at_code}}">{{$bgt02[$j]->at_code}}</span>
                                                            </td>
                                                            <td>{{$bgt02[$j]->at_desc}}</td>
                                                            <td>
                                                                <span class="subgrpid" subgrpid="{{$bgt02[$j]->grpid}}">{{$bgt02[$j]->subgrpdesc}}</span>
                                                            </td>
                                                            <td>
                                                                <center class="amt" amt="{{$bgt02_data[$i]->allot_amnt}}">Php {{number_format($bgt02_data[$i]->allot_amnt, 2, ".", ", ")}}</center>
                                                            </td>
                                                            <td>
                                                                <center class="obli" obli="{{$bgt02[$j]->debit}}">Php {{number_format($bgt02[$j]->debit, 2, ".", ", ")}}</center>
                                                            </td>
                                                            {{-- <td @if(isset($bgt01) && $bgt01->closed == 'Y'){{'style="display:none"'}}@endif>
                                                                <center>
                                                                    <a class="btn btn-social-icon btn-warning EditBudgetProposal" style="display: none"><i class="fa fa-pencil" onclick="EditMode( '{{$bgt02[$j]->seq_num}}', '{{$bgt02[$j]->at_code}}', '{{$bgt02[$j]->appro_amnt}}', '{{$bgt02[$j]->grpid}}');"></i></a>&nbsp;
                                                                    <a class="btn btn-social-icon btn-danger EditBudgetProposal" style="display: none" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$bgt02[$j]->at_desc}}', '{{$bgt02[$j]->at_code}}', '{{$bgt02[$j]->appro_amnt}}', '{{$bgt02[$j]->grpid}}');"><i class="fa fa-trash "></i></a>
                                                                </center>
                                                            </td> --}}
                                                        </tr>
                                                    @endif
                                                @endfor
                                            @endisset
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-8">&nbsp;</div>
                                        <div class="col-sm-4">
                                            <div class="col-sm-4">
                                                <label for="">SUB-TOTAL:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled="" name="sub_total_{{$ppa[$i]->subgrpid}}" value="Php 0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endisset
                    {{-- <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Line</th>
                                <th>Code</th>
                                <th>Account Title</th>
                                <th>PPA</th>
                                <th><center>Approved Amount</center></th>
                                <th><center>Obligation Amount</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($bgt02) && isset($bgt02_data))
                            @for($i = 0; $i < count($bgt02); $i++)
                                <tr>
                                    <td>{{$bgt02[$i]->seq_num}}</td>
                                    <td>
                                        <span class="cc_code" cc-code="{{$bgt02[$i]->at_code}}">{{$bgt02[$i]->at_code}}</span>
                                    </td>
                                    <td>{{$bgt02[$i]->at_desc}}</td>
                                    <td>
                                        <span class="subgrpid" subgrpid="{{$bgt02[$i]->subgrpid}}">{{$bgt02[$i]->subgrpdesc}}</span>
                                    </td>
                                    <td>
                                        <center class="amt" amt="{{$bgt02_data[$i]->allot_amnt}}">Php {{number_format($bgt02_data[$i]->allot_amnt, 2, ".", ", ")}}</center>
                                    </td>
                                    <td>
                                        <center class="obli" obli="{{$bgt02[$i]->debit}}">Php {{number_format($bgt02[$i]->debit, 2, ".", ", ")}}</center>
                                    </td>
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table> --}}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="row">
            	<div class="col-sm-6">
            		<div class="col-sm-2">
            			<label for="">BALANCE:</label>
            		</div>
            		<div class="col-sm-10">
            			<input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">
            		</div>
            	</div>
                <div class="col-sm-6">
                    <div class="col-sm-6">
                        {{-- @isset($bgt01) --}}
                            {{-- @if ($bgt01->finalized != 'Y' && $bgt01->closed != 'Y')
                                <span class="EditBudgetProposal">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-warning" onclick="EditModeNow()"><i class="fa fa-edit"></i> Edit</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-success" onclick="setSelectedMode(1);SaveProposal()"><i class="fa fa-save"></i> Finalized</button>
                                    </div>
                                </span>
                                <span class="EditBudgetProposal" style="display: none">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-success" onclick="setSelectedMode(0);SaveProposal()"><i class="fa fa-save"></i> Update</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-danger" onclick="EditModeNow()"><i class="fa fa-times"></i> Cancel</button>
                                    </div>
                                </span>
                            @elseif($bgt01->finalized == 'Y' && $bgt01->closed != 'Y') --}}
                            {{-- <button type="button" class="btn btn-block btn-success" onclick="setSelectedMode(2);SaveProposal()"><i class="fa fa-lock"></i> Close Budget Proposal </button> --}}
                                {{-- <span class="EditBudgetProposal">
                                        <button type="button" class="btn btn-block btn-warning" onclick="EditModeNow()"><i class="fa fa-edit"></i> Edit</button>
                                </span>
                                <span class="EditBudgetProposal" style="display: none">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-success" onclick="setSelectedMode(0);SaveProposal()"><i class="fa fa-save"></i> Update</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-danger" onclick="EditModeNow()"><i class="fa fa-times"></i> Cancel</button>
                                    </div>
                                </span> --}}
                            {{-- @endif --}}
                        {{-- @endisset --}}
                        {{-- <span class="EditBudgetProposal">
                            <button type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save Budget Proposal Entry</button>
                        </span> --}}
                        {{-- <button type="button" class="btn btn-block btn-success" onclick=""><i class="fa fa-check"></i> Finalized Budget Proposal </button> --}}
                        {{-- <button type="button" class="btn btn-block btn-success" onclick=""><i class="fa fa-lock"></i> Close Budget Proposal </button> --}}
                    </div>
                    <div class="col-sm-6">
                    	<button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script>
	var selectedId = 0, SelectedMode = 0;
	$(document).ready(function(){

            $('#SideBar_Budget').addClass('active');
            $('#SideBar_Budget_Budget_Obligation_Entry').addClass('text-green');
            // let today = new Date().toISOString().slice(0, 10);
		    // $('input[name="hdr_date"]').val(today);
        @isset($bgt01)
            @isset($bgt01->fid)
                // var fid
                $('select[name="hdr_fid"]').val('{{$bgt01->fid}}').trigger('change');
                $('input[name="hdr_fid_txt"]').val('{!!$bgt01->fdesc!!}');
            @endisset
            @isset($bgt01->cc_code)
                 $('select[name="hdr_cc"]').val('{{$bgt01->cc_code}}').trigger('change');
                 $('input[name="hdr_cc_txt"]').val('{!!$bgt01->cc_desc!!}');
            @endisset
            @isset($bgt01->secid)
                $('select[name="hdr_sec"]').val('{{$bgt01->secid}}').trigger('change');
                $('input[name="hdr_sec_txt"]').val('{!!$bgt01->secdesc!!}');
            @endisset
            @isset($bgt01->branch)
                $('select[name="hdr_br"]').val('{{$bgt01->branch}}').trigger('change');
                $('input[name="hdr_br_txt"]').val('{!!$bgt01->name!!}');
            @endisset
            @isset($bgt01->t_date)
                $('input[name="hdr_date"]').val('{{$bgt01->t_date}}').trigger('change');
            @endisset

            $('.select2-container').css('display','none');
            $('.select2-container').addClass('EditBudgetProposal');
        @endisset
            $('table').DataTable();
        @isset($ppa)
            @foreach ($ppa as $p)
                loadSubTotal('{{$p->subgrpid}}');
            @endforeach
        @endif
        loadTotal();
        // setTimeout(hideAll,2500);
        });
	$('#example1 tbody').on( 'click', 'tr', function () {
		var table = $('#example1').DataTable();
	    selectedId = table.row( this ).index() ;
	} );
    function setSelectedMode(num)
    {
        SelectedMode = num;
    }
    function hideAll(){
        $('.select2-container').css('display','none');
        $('.select2-container').addClass('EditBudgetProposal');
    }
    function EditModeNow()
    {
        $('.EditBudgetProposal').toggle();
    }
	function getAccountTitleCode()
	{
		$('input[name="itm_code"]').val($('select[name="itm_acc_title"]').val());
	}
    function loadSubTotal(acct_id)
    {
        var tempAmount = 0, obliAmount = 0, Bal = 0;
        var amt = $("#table_"+acct_id+" .amt").map(function(){return $(this).attr("amt");}).get();
        var obli = $("#table_"+acct_id+" .obli").map(function(){return $(this).attr("obli");}).get();
        if(amt.length > 0){
            for(let i = 0; i < amt.length; i++){
                tempAmount = tempAmount + parseFloat(amt[i]);
                obliAmount = obliAmount + parseFloat(obli[i]);
            }
            Bal = tempAmount - obliAmount;
            $('input[name="sub_total_'+acct_id+'"]').val(formatNumberToMoney(Bal));
        }
    }
	function loadTotal()
    {
        var tempAmount = 0, obliAmount = 0, Bal = 0;
        var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
        var obli = $(".obli").map(function(){return $(this).attr("obli");}).get();
        if(amt.length > 0 && obli.length > 0){
            for(let i = 0; i < amt.length; i++){
                tempAmount = tempAmount + parseFloat(amt[i]);
                obliAmount = obliAmount + parseFloat(obli[i]);
            }
            Bal = tempAmount - obliAmount;
            $('input[name="total_line"]').val(formatNumberToMoney(Bal));
        }
    }
	function addMode()
	{
		var line = ($('#example1').DataTable().data().count()/ 6) + 1;
		$('input[name="itm_line"]').val(line);
		$('input[name="itm_code"]').val('');
		$('select[name="itm_acc_title"]').val('').trigger('change');
		$('input[name="itm_amt"]').val('');
		$('select[name="itm_ppa"]').val('').trigger('change');

		$('.DeleteMode').hide();
		$('.AddMode').show();

	    $('#ItemButtonNameButton').removeClass('fa-save');
	    $('#ItemButtonNameButton').addClass('fa-plus');
		$('#ItemButtonName').text('Add');
		$('#MOD_MODE').text('(ADD)');
	}
	function InsModiItem()
	{
		var line = $('input[name="itm_line"]').val();
		var code = $('input[name="itm_code"]').val();
		var acc_title_desc = $('select[name="itm_acc_title"]').select2('data')[0].text;
		var acc_title_id = $('select[name="itm_acc_title"]').select2('data')[0].id;
		var subgrpdesc = $('select[name="itm_ppa"]').select2('data')[0].text;
		var subgrpid = $('select[name="itm_ppa"]').select2('data')[0].id;
		var amt = $('input[name="itm_amt"]').val();
		var table = $('#example1').DataTable();
		if($('#ItmForm').parsley().validate())
		{
			if($('#MOD_MODE').text() == '(ADD)')
			{
				table.row.add([
						line, '<span class="cc_code" cc-code="'+code+'">'+code+'</span>', acc_title_desc, '<span class="subgrpid" subgrpid="'+subgrpid+'">' +subgrpdesc + '</span>', '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
						'<center>' +
							'<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+acc_title_desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
						'</center>'
					]).draw();

				alert('Added '+acc_title_desc+' to List');
			} else if($('#MOD_MODE').text() == '(EDIT)'){
				table.row(selectedId).data([
						line, '<span class="cc_code" cc-code="'+code+'">'+code+'</span>', acc_title_desc, '<span class="subgrpid" subgrpid="'+subgrpid+'">' +subgrpdesc + '</span>', '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
						'<center>' +
							'<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+acc_title_desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
						'</center>'
					]).draw();
				alert('Successfully modified '+acc_title_desc+'.');
			} else {
				table.row(selectedId).remove().draw();

				var test = ($('#example1').DataTable().data().count()/ 6) ;
				var AllData = $('#example1').DataTable().rows().data();
				if(($('#example1').DataTable().data().count()/ 6) > 0 )
				{
					for(let i = 0, x = 1; i < ($('#example1').DataTable().data().count()/ 6); i++, x++){
						// AllData[i]
						table.row(i).data([
								x, AllData[i][1], AllData[i][2], AllData[i][3], AllData[i][4], AllData[i][5]
							]).draw();
					}
				}

				alert('Successfully modified '+acc_title_desc+'.');
			}

			loadTotal();
			$('#modal-default').modal('toggle');
		}
	}
	function EditMode(acc_title_id, amt, subgrpid)
	{
		$('input[name="itm_line"]').val('');
		$('input[name="itm_line"]').val((selectedId + 1));
		$('select[name="itm_ppa"]').val(subgrpid).trigger('change');
		$('input[name="itm_amt"]').val(amt);
		$('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');
	    $('#ItemButtonNameButton').removeClass('fa-plus');
		$('#ItemButtonNameButton').addClass('fa-save');
		$('.DeleteMode').hide();
		$('.AddMode').show();
		$('#ItemButtonName').text('Save');
		$('#MOD_MODE').text('(EDIT)');

		$('#modal-default').modal('toggle');
	}
	function DeleteMode(desc, acc_title_id, amt, subgrpid)
	{
		$('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');
		$('select[name="itm_ppa"]').val(subgrpid).trigger('change');
		$('input[name="itm_amt"]').val(amt);
		$('#DeleteName').text(desc);
		$('#MOD_MODE').text('(DELETE)');
		$('.AddMode').hide();
		$('.DeleteMode').show();
	}
    function SaveProposal()
    {
        if($('#HdrForm').parsley().validate())
        {
            if(($('#example1').DataTable().data().count()/ 6) != 0)
            {
                var codes = $(".cc_code").map(function(){return $(this).attr("cc-code");}).get();
                var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
                var subgrpid = $(".subgrpid").map(function(){return $(this).attr("subgrpid");}).get();
                var data = {
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        codes : codes,
                        amt : amt,
                        subgrpid : subgrpid,
                        fy : $('input[name="hdr_fy"]').val(),
                        mo : $('input[name="hdr_mo"]').val(),
                        b_num :  $('input[name="hdr_b_num"]').val(),
                        fid : $('select[name="hdr_fid"]').val(),
                        cc_code : $('select[name="hdr_cc"]').val(),
                        secid : $('select[name="hdr_sec"]').val(),
                        brid : $('select[name="hdr_br"]').val(),
                        t_date : $('input[name="hdr_date"]').val(),
                        t_desc : $('input[name="hdr_desc"]').val(),
                        sel_mod : SelectedMode,
                    };
                $.ajax({
                    url : '{{ url('budget/budget-proposal-entry/update') }}',
                    method : 'POST',
                    data : data,
                    success : function(d){
                        if(d == 'DONE'){
                            if(SelectedMode == 0) // alert('Successfully added new Budget Proposal');
                            {
                                alert('Successfully Modified Budget Proposal');
                            }
                            else if (SelectedMode == 1)
                            {
                                alert('Successfully Finalized Budget Proposal');
                            }
                            else {

                            }
                            javascript:history.go(-1);

                        } else {
                            alert('ERROR! an unknown error occured during saving process.');
                        }
                    },
                    error : function(a, b, c){
                        console.log(c);
                    }
                });
            }
            else
            {
                alert('No items to be saved.');
            }
        }
    }
</script>
@endsection