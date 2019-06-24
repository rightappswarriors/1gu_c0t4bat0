@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-proposal-entry-new"),'desc'=>'Proposal Entry','icon'=>'none','st'=>true],
        ['link'=>url("budget/budget-proposal-entry-new/new"),'desc'=>'View','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Proposal Entry"; // Module Name
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
                        <label>Budget Proposal Entry #</label>
                        <input type="text" class="form-control" name="b_num" value="@isset($bgtprop01){{$bgtprop01->b_num}}@endisset" readonly="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Financial Year <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control" name="fy_txt" disabled="" value=""> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="fy" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Period</strong> is required." data-parsley-errors-container="#budget_fy_span" required>
                        	@isset($period)
			                    <option value="">Select Period...</option>
			                    @foreach($period as $x3)
			                      <option value="{{$x3->fy}}">{{$x3->fy}}</option>
			                    @endforeach
			                @else
			                    <option value="">No Period registered...</option>
			                @endisset
                        </select>
                        <span id="budget_fy_span"></span>
                        {{-- <input type="text" name="hdr_fy" readonly="" style="display: none" value="@if(isset($data[5])){{$data[5]}}@endif">
                        <input type="text" name="hdr_mo" readonly="" style="display: none" value="@if(isset($data[6])){{$data[6]}}@endif"> --}}
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Budget Period <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control" name="budget_period_txt" disabled="" value="">
                        <select class="form-control select2 select2-hidden-accessible" name="budget_period" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Budget Period</strong> is required." data-parsley-errors-container="#budget_period_span" required>
                            @isset($budget)
                                <option value="">Select Budget Period...</option>
                                @foreach($budget as $bp)
                                  <option value="{{$bp->budget_code}}">{{$bp->budget_desc}}</option>
                                @endforeach
                            @else
                                <option value="">No Budget Period registered...</option>
                            @endisset
                        </select>
                        <span id="budget_period_span"></span>
                    </div>
                </div> --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date <span style="color:red"><strong>*</strong></span></label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" name="hdr_date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fund <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_fid_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_fid" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_fid" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>Fund</strong> is required." required>
                            @isset($fund)
                            	<option value="">Select Fund...</option>
                            	@foreach($fund as $fund)
		                            <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
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
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_cc_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_cc" disabled style="display: none"> --}}
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
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_sec_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_sec" disabled style="display: none"> --}}
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
                        <label>Account Title/ PPA Group <span style="color:red"><strong>*</strong></span></label>
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_sec" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_sec_span" data-parsley-required-message="<strong>Sector</strong> is required." required>
                            @isset($data[3])
                                <option value="">Select Sector...</option>
                                @foreach($data[3] as $sector)
                                    <option value="{{$sector->secid}}">{{$sector->secdesc}}</option>
                                @endforeach
                            @else
                                <option value="">No Sector registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_sec_span"></span>
                    </div>
                </div> --}}
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Branch <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_br_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_br" disabled style="display: none">
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Description <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_desc_txt" value=""> --}}
                        <input type="text" class="form-control" name="hdr_desc" data-parsley-required-message="<strong>Description</strong> is required." value="@isset($bgtprop01){{$bgtprop01->t_desc}}@endisset">
                    </div>
                </div>
                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <label>Proposal Reference # <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control" name="hdr_bgtps01" value="" disabled>
                    </div>
                </div> --}}
                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <label>Remaining Budget <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control" name="hdr_total_view" value="" disabled>
                        <input type="text" class="form-control" name="hdr_total" value="" disabled style="display: none">
                    </div>
                </div> --}}
                {{-- <div class="col-md-5">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" data-toggle="modal" data-target="#modal-default2" onclick="Loadapproved()" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Select Budget Appropriation</button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-block btn-default" onclick="ViewProposal()"><i class="fa fa-eye"></i> View Appropriation</button>
                            </div>
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
                    <h3 class="box-title">Items List</h3>
                    <button id="BudgetEntriesAdd" type="button" class="btn btn-primary" onclick="addMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add Item</button>
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
                                            <span class="AddMode EditMode">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Line</label>
                                                            <input type="text" class="form-control" disabled="" name="itm_line">
                                                            <input type="text" class="form-control" disabled="" name="true_bal" style="display:none">
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
                                                            <label>Charge<span style="color:red"><strong>*</strong></span></label>
                                                            {{-- <input type="text" class="form-control" name="itm_acc_title_txt" readonly=""> --}}
                                                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_acc_title" data-parsley-required-message="<strong>Account Title</strong> is required." onchange="getAccountTitleCode()" required>
                                                                @isset($charge)
                                                                    <option value="">Select Charge...</option>
                                                                    @foreach ($charge as $c)
                                                                        <option value="{{$c->chg_code}}" id="chg_{{$c->chg_code}}" m04_at_code="{{$c->at_code}}" m04_at_desc="{{urlencode($c->at_desc)}}" c_desc="{{urlencode($c->chg_desc)}}">{{$c->chg_code}} - {{$c->chg_desc}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No Charges registered..</option>
                                                                @endisset
                                                            </select>
                                                            <span id="itm_acc_title_span"></span>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-sm-1">
                                                            <label for="">&nbsp;</label>
                                                            <button data-toggle="popover" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Set Charge as Description" type="button" class="btn btn-warning" onclick="ChargeDesc()"><i class="fa fa-bookmark"></i></button>
                                                    </div> --}}
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Account Title<span style="color:red;display: none"><strong>*</strong></span></label>
                                                            <input type="text" class="form-control" name="acct_title_desc" disabled>
                                                            <input type="text" class="form-control" name="acct_title_id" style="display: none" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Description<span style="color:red"><strong>*</strong></span></label>
                                                            <input type="text" class="form-control" name="itm_desc" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>PPA Group<span style="color:red;"><strong>*</strong></span></label>
                                                            <select name="itm_ppa" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_ppa_span" data-parsley-required-message="<strong>PPA Group</strong> is required." required>
                                                                @isset($ppa)
                                                                    <option value="">Select PPA Group...</option>
                                                                    @foreach ($ppa as $p)
                                                                        <option value="{{$p->subgrpid}}">{{$p->subgrpdesc}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No PPA Group/s registered..</option>
                                                                @endisset
                                                            </select>
                                                            <span id="itm_ppa_span"></span>
                                                            <input type="text" style="display: none" value="" name="itm_old_ppa">
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
                                                            <label>Allocated <span style="color:red"><strong>*</strong></span></label>
                                                            <input type="number" class="form-control" name="itm_alot" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
                                                        </div>
                                                    </div>
                                                </div> --}}
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
                                    <span class="AddMode EditMode">
                                        <button type="button" onclick="InsModiItem(0)" class="btn btn-success AddMode"><i id="" class="fa fa-plus"></i> <span id="">Save & Add More</span></button>
                                        <button type="button" onclick="InsModiItem(1)" class="btn btn-success AddMode EditMode"><i id="ItemButtonNameButton" class="fa fa-plus"></i> <span id="ItemButtonName">Save & Close</span></button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                    </span>
                                    <span class="DeleteMode" style="display: none">
                                        <button type="button" onclick="InsModiItem(1)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
                                    <table id="table_{{$ppa[$i]->subgrpid}}" class="table table-bordered table-striped data_table" tbl_subgrpid="{{$ppa[$i]->subgrpid}}">
                                        <thead>
                                            <tr>
                                                <th>Line</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                {{-- <th>PPA Group</th> --}}
                                                <th><center>Account Title</center></th>
                                                <th><center>Amount</center></th>
                                                <th><center>Options</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($bgtprop02)
                                                @for($j = 0; $j < count($bgtprop02); $j++)
                                                    @if($ppa[$i]->subgrpid == $bgtprop02[$j]->grpid)
                                                        <tr>
                                                            <th>{{$bgtprop02[$j]->seq_num}}</th>
                                                            <td><span class="cc_code" cc-code="{{$bgtprop02[$j]->chg_code}}">{{$bgtprop02[$j]->chg_code}}</span></td>
                                                            <td>{{ (isset($bgtprop02[$j]->seq_desc) ? $bgtprop02[$j]->seq_desc : $bgtprop02[$j]->chg_desc)}}</td>
                                                            <td>
                                                                <center class="at_code subgrpid" subgrpid="{{$bgtprop02[$j]->grpid}}" at_code="{{$bgtprop02[$j]->at_code}}" desc="{{urlencode($bgtprop02[$j]->seq_desc)}}">{{$bgtprop02[$j]->at_desc}}</center>
                                                            </td>
                                                            <td>
                                                                <center class="amt" amt="{{floatval($bgtprop02[$j]->appro_amnt)}}">Php {{number_format(floatval($bgtprop02[$j]->appro_amnt), 2, ".", ", ")}}</center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$bgtprop02[$j]->seq_num}}', '{{$bgtprop02[$i]->chg_code}}', '{{floatval($bgtprop02[$j]->appro_amnt)}}', '{{$bgtprop02[$j]->grpid}}');"></i></a>&nbsp;
                                                                    <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$bgtprop02[$j]->chg_desc}}', '{{$bgtprop02[$j]->chg_code}}', '{{floatval($bgtprop02[$j]->appro_amnt)}}', '{{$bgtprop02[$j]->grpid}}');"><i class="fa fa-trash "></i></a>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endfor
                                            @endisset
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-5">&nbsp;</div>
                                        <div class="col-sm-7">
                                            <div class="col-sm-6">
                                                <label for="">TOTAL {{strtoupper($ppa[$i]->subgrpdesc)}}:</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" disabled="" name="sub_total_{{$ppa[$i]->subgrpid}}" value="Php 0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endisset
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="row">
            	<div class="col-sm-6">
            		<div class="col-sm-3">
            			<label for="">Grand Total:</label>
            		</div>
            		<div class="col-sm-9">
            			<input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">
            		</div>
            	</div>
                <div class="col-sm-6">
                    <div class="col-sm-6">
                    	{{-- <div class="form-group" style="display: flex;"> --}}
                        <button style="" type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save</button>
                    </div>
                    <div class="col-sm-6">
                    	<button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="modal fade in" id="modal-default2">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Select Budget Appropriation <span id="MOD_MODE"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <form id="approved" novalidate data-parsley-validate>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Budget Appropriations</label>
                                        <select class="form-control" id="" name="bgt_b_num" onchange="getapprovedEntries()" style="width:100%"></select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Line</th>
                                                <th>Code</th>
                                                <th width="40%">Account Title/ PPA</th>
                                                <th>PPA Group</th>
                                                <th><center>Amount Balance</center></th>
                                                {{-- <th><center>Options</center></th> --}}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <select name="" id=""></select>
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="Insertapproved()" class="btn btn-success"><i id="ItemButtonNameButton" class="fa fa-plus"></i> <span id="ItemButtonName">Select Budget Appropriation</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script>
	var selectedId = 0;
	$(document).ready(function(){

            $('#SideBar_Budget').addClass('active');
            $('#SideBar_Budget_Budget_Proposal_Entry_New').addClass('text-green');
            let today = new Date().toISOString().slice(0, 10);
		    $('input[name="hdr_date"]').val(today);
            @if(isset($fid))
            	$('select[name="hdr_fid"]').val('{{$fid}}').trigger('change');
                // alert('{{$fid}}');
            @endif
            @if(isset($fy))
                $('select[name="fy"]').val('{{$fy}}').trigger('change');
            @endif
            @if(isset($budget_code))
                $('select[name="budget_period"]').val('{{$budget_code}}').trigger('change');
            @endif
            @isset($bgtprop01)
                @isset($bgtprop01->fid)
                // var fid
                    $('select[name="hdr_fid"]').val('{{$bgtprop01->fid}}').trigger('change');
                    $('input[name="hdr_fid_txt"]').val('{!!$bgtprop01->fdesc!!}');
                @endisset
                @isset($bgtprop01->cc_code)
                     $('select[name="hdr_cc"]').val('{{$bgtprop01->cc_code}}').trigger('change');
                     $('input[name="hdr_cc_txt"]').val('{!!$bgtprop01->cc_desc!!}');
                @endisset
                @isset($bgtprop01->secid)
                    $('select[name="hdr_sec"]').val('{{$bgtprop01->secid}}').trigger('change');
                    $('input[name="hdr_sec_txt"]').val('{!!$bgtprop01->secdesc!!}');
                @endisset
                @isset($bgtprop01->fy)
                    $('select[name="fy"]').val('{{$bgtprop01->fy}}').trigger('change');
                    $('input[name="fy_txt"]').val('{!!$bgtprop01->fy!!}');
                @endisset
                @isset($bgtprop01->budget_period)
                    $('select[name="budget_period"]').val('{{$bgtprop01->budget_period}}').trigger('change');
                    $('input[name="budget_period_txt"]').val('{!!$bgtprop01->budget_desc!!}');
                @endisset
            @endisset
            @isset($ppa)
                @foreach ($ppa as $p)
                    loadSubTotal('{{$p->subgrpid}}');
                @endforeach
            @endif
            // $('.select2-container').css('display','none');
            // $('.select2-container').addClass('EditBudgetProposal');
            $('table').DataTable();
            loadTotal();
        });
        @isset($ppa)
            @foreach ($ppa as $d)
                $('#table_{{$d->subgrpid}} tbody').on( 'click', 'tr', function () {
                    var table = $('#table_{{$d->subgrpid}}').DataTable();
                    selectedId = table.row(this).index() ;
                } );
            @endforeach
        @endisset
    function ChargeDesc()
    {
        var charge_code = $('select[name="itm_acc_title"]').val();
        if(charge_code != '') {
            $('input[name="itm_desc"]').val(urldecode($('#chg_'+charge_code).attr('c_desc')));
        } else {
            alert('No Charge Selected...');
        }
    }
    function loadTotal()
    {
        var tempAmount = 0; // appr = 0, totalBal = 0
        // var truebal = $(".truebal").map(function(){return $(this).attr("truebal");}).get();
        // var appro = $(".appro").map(function(){return $(this).attr("appro");}).get();
        var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
        if(amt.length > 0){
            for(let i = 0; i < amt.length; i++){
                tempAmount = tempAmount + parseFloat(amt[i]);
                // appr = appr + parseFloat(appro[i]);
            }
            // totalBal = parseFloat(appr) - parseFloat(tempAmount);
            $('input[name="total_line"]').val(formatNumberToMoney(tempAmount));
        } else {
            $('input[name="total_line"]').val(formatNumberToMoney(0));
        }
    }
    function loadSubTotal(acct_id)
    {
        var tempAmount = 0; // , appr = 0, totalBal = 0
        // var truebal = $("#table_"+acct_id+" .truebal").map(function(){return $(this).attr("truebal");}).get();
        // var appro = $("#table_"+acct_id+" .appro").map(function(){return $(this).attr("appro");}).get();
        var amt = $("#table_"+acct_id+" .amt").map(function(){return $(this).attr("amt");}).get();
        if(amt.length > 0){
            for(let i = 0; i < amt.length; i++){
                 tempAmount = tempAmount + parseFloat(amt[i]);
            }
            // totalBal = parseFloat(appr) - parseFloat(tempAmount);
            $('input[name="sub_total_'+acct_id+'"]').val(formatNumberToMoney(tempAmount));
        } else {
            $('input[name="sub_total_'+acct_id+'"]').val(formatNumberToMoney(0));
        }
    }
    function emptyHeader()
    {
        $('input[name="hdr_fy_mo"]').val('');
        $('input[name="hdr_fy"]').val('');
        $('input[name="hdr_mo"]').val('');
        $('input[name="hdr_fid_txt"]').val('');
        $('input[name="hdr_fid"]').val('');
        $('input[name="hdr_cc_txt"]').val('');
        $('input[name="hdr_cc"]').val('');
        $('input[name="hdr_sec_txt"]').val('');
        $('input[name="hdr_br_txt"]').val('');
        $('input[name="hdr_br"]').val('');
        $('input[name="hdr_desc_txt"]').val('');
        $('input[name="hdr_desc"]').val('');
        $('input[name="hdr_bgtps01"]').val('');
    }
    function ViewProposal()
    {
        var test = $('input[name="hdr_bgtps01"]').val();
        if(test != ''){
            location.href = "{{ url('budget/budget-proposal-entry') }}/" + test;
        } else {
            alert('Please select Budget Appropriation.');
        }
    }
	function getAccountTitleCode()
    {
        // m04_at_code
        // m04_at_desc
        var charge_code = $('select[name="itm_acc_title"]').val();
        if(charge_code != '')
        {
            $('input[name="itm_code"]').val(charge_code);
            // $('input[name="acct_desc"]').val(urldecode($('#chg_'+charge_code).attr('c_desc')));
            $('input[name="acct_title_desc"]').val(urldecode($('#chg_'+charge_code).attr('m04_at_desc')));
            $('input[name="acct_title_id"]').val($('#chg_'+charge_code).attr('m04_at_code'));
        }
        else {
            // $('input[name="acct_desc"]').val('');
            $('input[name="itm_code"]').val('');
            $('input[name="acct_title_desc"]').val('');
            $('input[name="acct_title_id"]').val('');
        }
    }
	function addMode()
	{
		var line = ($('#example1').DataTable().data().count()/ 5) + 1;
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
    function addMode(selected)
    {
        var line = ($('.data_table').DataTable().data().count()/ 6) + 1;
        $('input[name="itm_line"]').val(line);
        $('input[name="itm_code"]').val('');
        $('select[name="itm_acc_title"]').val('').trigger('change');
        $('input[name="itm_amt"]').val('');
        $('input[name="itm_desc"]').val('');
        // name="acct_desc"

        $('.DeleteMode').hide();
        $('.AddMode').show();

        $('#ItemButtonNameButton').removeClass('fa-save');
        $('#ItemButtonNameButton').addClass('fa-plus');
        $('#ItemButtonName').text('Save & Close');
        $('#MOD_MODE').text('(ADD)');
        if(selected != 0){
            $('select[name="itm_ppa"]').val('').trigger('change');
        }
    }
	function InsModiItem(selected)
    {
        var line = $('input[name="itm_line"]').val();
        var code = $('input[name="itm_code"]').val();
        var acc_title_desc = $('select[name="itm_acc_title"]').select2('data')[0].text; // Charge
        var acc_title_id = $('select[name="itm_acc_title"]').select2('data')[0].id;
        var acc_title2_desc = urldecode($('input[name="acct_title_desc"]').val());
        var acc_title2_id = $('input[name="acct_title_id"]').val();
        var desc = urldecode($('#chg_'+acc_title_id).attr('c_desc'));
        // var desc = $('input[name="itm_desc"]').val();
        // var subgrpdesc = $('select[name="itm_ppa"]').select2('data')[0].text;
        var subgrpid = $('select[name="itm_ppa"]').select2('data')[0].id;
        var amt = $('input[name="itm_amt"]').val(); // balance
        var table = $('#table_' + subgrpid).DataTable();
        var old_ppa = $('input[name="itm_old_ppa"]').val();
        if($('#ItmForm').parsley().validate())
        {
            if($('#MOD_MODE').text() == '(ADD)')
            {
                table.row.add([
                        line, '<span class="cc_code" cc-code="'+code+'">'+code+'</span>', desc,
                            '<center class="at_code subgrpid" subgrpid="'+subgrpid+'" at_code="'+acc_title2_id+'" desc="'+encodeURI(desc)+'">'+acc_title2_desc+'</center>',
                            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+line+'\', \''+acc_title_id+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+acc_title_desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>'
                    ]).draw();

                alert('Added '+acc_title_desc+' to List');
            } else if($('#MOD_MODE').text() == '(EDIT)'){
                if (old_ppa == subgrpid){
                    table.row(selectedId).data([
                        line, '<span class="cc_code" cc-code="'+code+'">'+code+'</span>', desc,
                            '<center class="at_code subgrpid" subgrpid="'+subgrpid+'" at_code="'+acc_title2_id+'" desc="'+encodeURI(desc)+'">'+acc_title2_desc+'</center>',
                            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+line+'\', \''+acc_title_id+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+acc_title_desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>'
                    ]).draw();
                }
                else
                {
                    var table2 = $('#table_' + old_ppa).DataTable();
                    table2.row(selectedId).remove().draw();
                    table.row.add([
                        line, '<span class="cc_code" cc-code="'+code+'">'+code+'</span>', desc,
                            '<center class="at_code subgrpid" subgrpid="'+subgrpid+'" at_code="'+acc_title2_id+'" desc="'+encodeURI(desc)+'">'+acc_title2_desc+'</center>',
                            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+line+'\', \''+acc_title_id+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+acc_title_desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>'
                    ]).draw();
                    loadSubTotal(old_ppa);
                }
                alert('Successfully modified '+acc_title_desc+'.');
            } else if ($('#MOD_MODE').text() == '(DELETE)') {
                alert('TESt');
                table.row(selectedId).remove().draw();

                // var test = ($('.data_table').DataTable().data().count()/ 6) ;
                // var AllData = $('.data_table').DataTable().rows().data();
                // if(($('#example1').DataTable().data().count()/ 6) > 0 )
                // {
                //  for(let i = 0, x = 1; i < ($('#example1').DataTable().data().count()/ 6); i++, x++){
                //      // AllData[i]
                //      table.row(i).data([
                //              x, AllData[i][1], AllData[i][2], AllData[i][3], AllData[i][4], AllData[i][5]
                //          ]).draw();
                //  }
                // }

                alert('Successfully modified '+acc_title_desc+'.');
            }
            loadSubTotal(subgrpid);
            loadTotal();
            $('a[href="#tab_'+subgrpid+'"]').tab('show');
            if(selected == 1)
            {
                $('#modal-default').modal('toggle');
            } else {
                addMode(0);
            }
        }
    }
	function EditMode(line, acc_title_id, amt, subgrpid, desc)
    {
        // alert(acc_title_id);
        // $('input[name="true_bal"]').val(true_bal);
        $('input[name="itm_line"]').val(line);
        $('select[name="itm_ppa"]').val(subgrpid).trigger('change');
        $('input[name="itm_old_ppa"]').val(subgrpid);
        $('input[name="itm_amt"]').val(amt);
        // $('select[name="itm_ppa"]').next().css('display','none');
        // $('select[name="itm_acc_title"]').next().css('display','none');
        $('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');
        $('#ItemButtonNameButton').removeClass('fa-plus');
        $('#ItemButtonNameButton').addClass('fa-save');
        $('.DeleteMode').hide();
        $('.AddMode').hide();
        $('#MOD_MODE').text('(EDIT)');
        $('.EditMode').show();
        $('#ItemButtonName').text('Save');
        $('input[name="itm_desc"]').val(urldecode(desc));
        // $('input[name="itm_amt"]').attr('readonly', '');
        // $('input[name="itm_alot"]').val(allot);
        // $('input[name="itm_acc_title_txt"]').val($('select[name="itm_acc_title"]').select2('data')[0].text);
        // $('input[name="itm_ppa_txt"]').val($('select[name="itm_ppa"]').select2('data')[0].text);
        // $('#modal-default').modal('toggle');
    }
	function DeleteMode(desc, acc_title_id, amt)
	{
		$('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');
		// $('select[name="itm_ppa"]').val(subgrpid).trigger('change');
		$('input[name="itm_amt"]').val(amt);
		$('#DeleteName').text(desc);
		$('#MOD_MODE').text('(DELETE)');
		$('.AddMode').hide();
		$('.DeleteMode').show();
	}
	function SaveProposal()
	{
		if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('.table').DataTable().data().count()/ 5) != 0)
                {
                    var codes = $(".cc_code").map(function(){return $(this).attr("cc-code");}).get();
                    var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
                    var at_code = $(".at_code").map(function(){return $(this).attr("at_code");}).get();
                    var subgrpid = $(".subgrpid").map(function(){return $(this).attr("subgrpid");}).get();
                    // var desc = $(".subgrpid").map(function(){return urldecode($(this).attr("desc"));}).get();
                    var data = {
                            _token : $('meta[name="csrf-token"]').attr('content'),
                            b_num :$('input[name="b_num"]').val(),
                            codes : codes,
                            amt : amt,
                            at_code : at_code,
                            subgrpid : subgrpid,
                            // desc : desc,
                            fy : $('select[name="fy"]').val(),
                            // budget_period : $('select[name="budget_period"]').val(),
                            fid : $('select[name="hdr_fid"]').val(),
                            cc_code : $('select[name="hdr_cc"]').val(),
                            secid : $('select[name="hdr_sec"]').val(),
                            // brid : $('input[name="hdr_br"]').val(),
                            t_date : $('input[name="hdr_date"]').val(),
                            t_desc : $('input[name="hdr_desc"]').val(),
                            // bgtps_bnum : $('input[name="hdr_bgtps01"]').val(),
                        };
                    $.ajax({
                        url : '{{ url('budget/budget-proposal-entry-new/update') }}',
                        method : 'POST',
                        data : data,
                        success : function(d){
                            if(d == 'DONE'){
                                alert('Successfully Added new Budget Proposal Entry');
                                location.href= "{{ url('budget/budget-proposal-entry-new') }}";
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
                    alert('No Charges to be saved.');
                }
            }
        }
        else
        {
             alert('Please select Budget Appropriation ');
        }
	}
    function Loadapproved()
    {
        $.ajax({
            url : '{{ url('budget/budget-approved-entry/getAllProposals') }}',
            data : {_token: $('meta[name="csrf-token"]').attr('content')},
            success : function(data){
                $('select[name="bgt_b_num"]').empty();
                if(data.length > 0){
                    $('select[name="bgt_b_num"]').append('<option value="">Select Budget Appropriation...</option>');
                    for(let i = 0; i < data.length; i++){
                        $('select[name="bgt_b_num"]').append('<option value="'+data[i].b_num+'">'+data[i].b_num+'-'+data[i].t_desc+'</option>');
                    }
                } else {
                    $('select[name="bgt_b_num"]').append('<option value="">No Budget Appropriation/s finalized.</option>'); 
                }
                 $('select[name="bgt_b_num"]').val('').trigger('change');
            },
            error : function(a, b, c){

            },
        });
    }
    function getapprovedEntries()
    {
        var b_num = $('select[name="bgt_b_num"]').val();
        var table = $('#example2').DataTable(); 
        table.clear().draw();
        if(b_num != ''){
            $.ajax({
                url : '{{ url('budget/budget-approved-entry/getProposalEntries') }}',
                method : 'POST',
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
                success : function(d){
                    if(d.length > 0)
                    {
                        for(let i = 0, j = 1; i < d.length; i++, j++)
                        {
                            var test = 0;
                            // if(d[i].deduct != null && d[i].allot != null && d[i].appro_amnt){
                            //     test = d[i].deduct;
                            // } else if (d[i].deduct == null && d[i].allot != null && d[i].appro_amnt){
                            //     test = d[i].allot;
                            // } else {
                            //     test = d[i].appro_amnt;
                            // }
                            table.row.add([
                                j,
                                d[i].at_code,
                                d[i].at_desc,
                                d[i].subgrpdesc,
                                '<center>'+formatNumberToMoney(parseFloat(d[i].act_deduct))+'</center>'
                                ]).draw();
                        }
                    }
                },
                error : function(a, b, c){
                }
            });
        }
    }
</script>
@endsection