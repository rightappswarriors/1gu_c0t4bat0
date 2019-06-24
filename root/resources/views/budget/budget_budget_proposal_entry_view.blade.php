@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Appropriation Entry','icon'=>'none','st'=>true],
        ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Edit','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Appropriation Entry"; // Module Name
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
                <div class="col-md-6" style="display: none">
                    <div class="form-group">
                        <label>Budget Appropriation Entry #</label>
                        <input type="text" class="form-control" name="hdr_b_num" disabled="" value="@isset($bgt01){{$bgt01->b_num}}@endisset">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Year <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="fy" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." data-parsley-errors-container="#budget_fy_span" required>
                            @isset($fy)
                                <option value="">Select Year...</option>
                                @foreach($fy as $x3)
                                  <option value="{{$x3->fy}}">{{$x3->fy}}</option>
                                @endforeach
                            @else
                                <option value="">No Year registered...</option>
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
                        <select class="form-control select2 select2-hidden-accessible" name="budget_period" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Budget Period</strong> is required." data-parsley-errors-container="#budget_period_span" required>
                            @isset($data[11])
                                <option value="">Select Budget Period...</option>
                                @foreach($data[11] as $bp)
                                  <option value="{{$bp->budget_code}}">{{$bp->budget_desc}}</option>
                                @endforeach
                            @else
                                <option value="">No Budget Period registered...</option>
                            @endisset
                        </select>
                        <span id="budget_period_span"></span>
                    </div>
                </div> --}}
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Date <span style="color:red"><strong>*</strong></span></label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" name="hdr_date" data-parsley-required-message="<strong>Date</strong> is required." required>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fund <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_fid_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_fid" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_fid" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>Fund</strong> is required." required>
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Office <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_cc_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_cc" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_cc" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_cc_span" data-parsley-required-message="<strong>Office</strong> is required." required>
                            @isset($m08)
                                <option value="">Select Office..</option>
                                @foreach($m08 as $m8)
                                    <option value="{{$m8->cc_code}}">{{$m8->cc_desc}}</option>
                                @endforeach
                            @else
                                <option value="">No Office registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_cc_span"></span>
                    </div>
                </div>
                <div class="col-md-6">
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
                        <label>Branch <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_br_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_br" disabled style="display: none">
                    </div>
                </div> --}}
            </div>
            <div class="row">
                {{-- <div class="col-md-8">
                    <div class="form-group">
                        <label>Description <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control" name="hdr_desc" data-parsley-required-message="<strong>Description</strong> is required." required>
                    </div>
                </div> --}}
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
                    <h3 class="box-title">Budget Entries</h3>
                    <button id="BudgetEntriesAdd" type="button" class="btn btn-primary" onclick="addMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add item</button>
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
                                                <div class="row" style="display: none">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>#</label>
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
                                                            <label>Account Title/ PPA<span style="color:red"><strong>*</strong></span></label>
                                                            {{-- <input type="text" class="form-control" name="itm_acc_title_txt" readonly=""> --}}
                                                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_acc_title" data-parsley-required-message="<strong>Account Title</strong> is required." onchange="getAccountTitleCode();ChargeDesc();" required>
                                                                @isset($m04)
                                                                    <option value="">Select Account Title...</option>
                                                                    @foreach ($m04 as $m4)
                                                                        <option value="{{$m4->at_code}}" id="at_{{$m4->at_code}}" m04_at_desc="{{urlencode($m4->at_desc)}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>
                                                                    @endforeach
                                                                @endisset
                                                            </select>
                                                            <span id="itm_acc_title_span"></span>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-sm-1">
                                                        <label for="">&nbsp;</label>
                                                            <button data-toggle="popover" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Set Account Title as Description" type="button" class="btn btn-warning" onclick="ChargeDesc()"><i class="fa fa-copy"></i></button>
                                                    </div> --}}
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Description<span style="color:red"><strong>*</strong></span></label>
                                                            <input type="text" class="form-control" name="itm_desc" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>PPA Group<span style="color:red"><strong>*</strong></span></label>
                                                            {{-- <input type="text" class="form-control" name="itm_ppa_txt" readonly=""> --}}
                                                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_ppa_span" name="itm_ppa" data-parsley-required-message="<strong>PPA</strong> is required."  required>
                                                                @isset($ppa)
                                                                    <option value="">Select PPA...</option>
                                                                    @foreach ($ppa as $ppasggrp)
                                                                        <option value="{{$ppasggrp->subgrpid}}">{{$ppasggrp->subgrpdesc}}</option>
                                                                    @endforeach
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
                                    <span class="AddMode">
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
                                    <table id="table_{{$ppa[$i]->subgrpid}}" class="table table-bordered table-striped data_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                {{-- <th>Code</th> --}}
                                                <th>Description</th>
                                                <th>Account Title/ PPA</th>
                                                <th><center>Amount</center></th>
                                                {{-- <th><center>Allocated</center></th> --}}
                                                <th><center>Options</center></th>
                                            </tr>
                                        </thead>
                                        {{-- line, 
                                        '<span class="cc_code" subgrpid="'+subgrpid+'" cc-code="'+code+'" desc="'+encodeURI(desc)+'">'+desc+'</span>',
                                         acc_title2_desc, 
                                         '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+line+'\', \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>' --}}
                                        <tbody>
                                            @isset($bgt02)
                                                @for($j = 0; $j < count($bgt02); $j++)
                                                    @if($ppa[$i]->subgrpid == $bgt02[$j]->grpid)
                                                    <tr>
                                                         <td>{{$bgt02[$j]->seq_num}}</td>
                                                         <td>
                                                             <span class="cc_code" subgrpid="{{$bgt02[$j]->grpid}}" cc-code="{{$bgt02[$j]->at_code}}" desc="{{urlencode($bgt02[$j]->seq_desc)}}">{{$bgt02[$j]->seq_desc}}</span>
                                                         </td>
                                                         <td>{{$bgt02[$j]->at_desc}}</td>
                                                         <td>
                                                             <center class="amt" amt="{{$bgt02[$j]->appro_amnt}}">Php {{number_format($bgt02[$j]->appro_amnt, 2, ".", ", ")}}</center>
                                                         </td>
                                                         <td>
                                                             <center>
                                                                 <a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( '{{$bgt02[$j]->seq_num}}', '{{$bgt02[$j]->at_code}}', '{{floatval($bgt02[$j]->appro_amnt)}}', '{{$bgt02[$j]->grpid}}', '{{urlencode($bgt02[$j]->seq_desc)}}');"></i></a>&nbsp;
                                                                 <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{urlencode($bgt02[$j]->seq_desc)}}', '{{$bgt02[$j]->at_code}}', ''{{floatval($bgt02[$j]->appro_amnt)}}, '{{$bgt02[$j]->grpid}}');"><i class="fa fa-trash "></i></a>
                                                             </center>
                                                         </td>
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
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="col-sm-3">
                        <label for="">GRAND TOTAL:</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-6">
                        {{-- <div class="form-group" style="display: flex;"> --}}
                        <button type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save</button>
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
            $('#SideBar_Budget_Budget_Proposal_Entry').addClass('text-green');
            let today = new Date().toISOString().slice(0, 10);
            $('input[name="hdr_date"]').val(today);
            @isset($bgt01)
            @isset($bgt01->fy)
                $('select[name="fy"]').val('{{$bgt01->fy}}').trigger('change');
            @endisset
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

            @if($bgt01->closed == 'Y')

                // $('select[name="hdr_fid"]').select2('enable', false);
                // $('select[name="hdr_cc"]').select2('enable', false);
                // $('select[name="hdr_sec"]').select2('enable', false);
                // $('select[name="hdr_br"]').select2('enable', false);
            @endif
            // $('.select2-container').css('display','none');
            // $('.select2-container').addClass('EditBudgetProposal');
        @endisset
        @isset($bgt02)
            loadTotal();
        @endisset

        @isset($ppa)
            @foreach ($ppa as $p)
                loadSubTotal('{{$p->subgrpid}}');
            @endforeach
        @endif
            emptyHeader();
            // $('#modal-default2').modal('toggle');
            $('table').DataTable();
        });
    @isset($ppa)
        @foreach ($ppa as $d)
            $('#table_{{$d->subgrpid}} tbody').on( 'click', 'tr', function () {
                var table = $('#table_{{$d->subgrpid}}').DataTable();
                selectedId = table.row( this ).index() ;
            } );
        @endforeach
    @endisset
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
        $('input[name="itm_code"]').val($('select[name="itm_acc_title"]').val());
    }
    function ChargeDesc()
    {
        var charge_code = $('select[name="itm_acc_title"]').val();
        if(charge_code != '') {
            $('input[name="itm_desc"]').val(urldecode($('#at_'+charge_code).attr('m04_at_desc')));
        } else {
            $('input[name="itm_desc"]').val('');
            // alert('No Account Title Selected Selected...');
        }
    }
    function addMode(selected)
    {
        var line = ($('.data_table').DataTable().data().count()/ 5) + 1;
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
        var acc_title_desc = $('select[name="itm_acc_title"]').select2('data')[0].text;
        var acc_title_id = $('select[name="itm_acc_title"]').select2('data')[0].id;
        var subgrpdesc = $('select[name="itm_ppa"]').select2('data')[0].text;
        var subgrpid = $('select[name="itm_ppa"]').select2('data')[0].id;
        var amt = $('input[name="itm_amt"]').val(); // balance
        var table = $('#table_' + subgrpid).DataTable();
        var desc = $('input[name="itm_desc"]').val();
        var old_ppa = $('input[name="itm_old_ppa"]').val();
        if($('#ItmForm').parsley().validate())
        {
        var acc_title2_desc = urldecode($('#at_'+acc_title_id).attr('m04_at_desc'))
            if($('#MOD_MODE').text() == '(ADD)')
            {
                table.row.add([
                    //acc_title_desc,  '<span class="subgrpid" subgrpid="'+subgrpid+'">' +subgrpdesc + '</span>',
                        //, code, 
                        line, '<span class="cc_code" subgrpid="'+subgrpid+'" cc-code="'+code+'" desc="'+encodeURI(desc)+'">'+desc+'</span>', acc_title2_desc, '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+line+'\', \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>'
                    ]).draw();

                alert('Added '+acc_title_desc+' to List');
            } else if($('#MOD_MODE').text() == '(EDIT)'){
                if (old_ppa == subgrpid){
                    table.row(selectedId).data([
                        // line, code,
                        line, '<span class="cc_code" subgrpid="'+subgrpid+'" cc-code="'+code+'" desc="'+encodeURI(desc)+'">'+desc+'</span>', acc_title2_desc, '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+line+'\', \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>'
                    ]).draw();
                } else {
                    var table2 = $('#table_' + old_ppa).DataTable();
                    table2.row(selectedId).remove().draw();
                    table.row.add([
                        //line, code, 
                        line, '<span class="cc_code" subgrpid="'+subgrpid+'" cc-code="'+code+'" desc="'+encodeURI(desc)+'">'+desc+'</span>', acc_title2_desc, '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center>' +
                            '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+line+'\', \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\', \''+encodeURI(desc)+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+desc+'\', \''+code+'\', \''+parseFloat(amt)+'\', \''+subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                        '</center>'
                    ]).draw();
                    loadSubTotal(old_ppa);
                }
                
                alert('Successfully modified '+acc_title_desc+'.');
            } else {
                table.row(selectedId).remove().draw();

                var test = ($('#example1').DataTable().data().count()/ 5) ;
                var AllData = $('#example1').DataTable().rows().data();
                // if(($('#example1').DataTable().data().count()/ 5) > 0 )
                // {
                //  for(let i = 0, x = 1; i < ($('#example1').DataTable().data().count()/ 5); i++, x++){
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
        // $('input[name="true_bal"]').val(true_bal);
        $('input[name="itm_line"]').val(line);
        $('select[name="itm_ppa"]').val(subgrpid).trigger('change');
        $('input[name="itm_amt"]').val(amt);
        $('input[name="itm_desc"]').val(urldecode(desc));
        $('input[name="itm_old_ppa"]').val(subgrpid); 
        // $('select[name="itm_ppa"]').next().css('display','none');
        // $('select[name="itm_acc_title"]').next().css('display','none');
        $('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');
        $('#ItemButtonNameButton').removeClass('fa-plus');
        $('#ItemButtonNameButton').addClass('fa-save');
        $('.DeleteMode').hide();
        $('.AddMode').show();
        $('#ItemButtonName').text('Save');
        $('#MOD_MODE').text('(EDIT)');
        // $('input[name="itm_amt"]').attr('readonly', '');
        // $('input[name="itm_alot"]').val(allot);
        // $('input[name="itm_acc_title_txt"]').val($('select[name="itm_acc_title"]').select2('data')[0].text);
        // $('input[name="itm_ppa_txt"]').val($('select[name="itm_ppa"]').select2('data')[0].text);
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
        if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('.table').DataTable().data().count()/ 5) != 0)
                {
                    var codes = $(".cc_code").map(function(){return $(this).attr("cc-code");}).get();
                    var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
                    // var at_code = $(".at_code").map(function(){return $(this).attr("at_code");}).get();
                    var subgrpid = $(".cc_code").map(function(){return $(this).attr("subgrpid");}).get();
                    var desc = $(".cc_code").map(function(){return urldecode($(this).attr("desc"));}).get();
                    var data = {
                            _token : $('meta[name="csrf-token"]').attr('content'),
                            codes : codes,
                            amt : amt,
                            subgrpid : subgrpid,
                            desc: desc,
                            fy : $('select[name="fy"]').val(),
                            b_num :  $('input[name="hdr_b_num"]').val(),
                            // budget_period : $('select[name="budget_period"]').val(),
                            fid : $('select[name="hdr_fid"]').val(),
                            cc_code : $('select[name="hdr_cc"]').val(),
                            secid : $('select[name="hdr_sec"]').val(),
                            // brid : $('input[name="hdr_br"]').val(),
                            // t_date : $('input[name="hdr_date"]').val(),
                            // t_desc : $('input[name="hdr_desc"]').val(),
                            // bgtps_bnum : $('input[name="hdr_bgtps01"]').val(),
                        };
                    $.ajax({
                        url : '{{ url('budget/budget-proposal-entry/update') }}',
                        method : 'POST',
                        data : data,
                        success : function(d){
                            if(d == 'DONE'){
                                alert('Successfully Modified Budget Appropriation');
                                location.href= "{{ url('budget/budget-proposal-entry') }}";
                                // javascript:history.go(-1);

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
    function Insertapproved()
    {
        var b_num = $('select[name="bgt_b_num"]').val();
        if(b_num != '')
        {
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
                            if(d[i].deduct != null && d[i].allot != null && d[i].appro_amnt){
                                test = d[i].deduct;
                            } else if (d[i].deduct == null && d[i].allot != null && d[i].appro_amnt){
                                test = d[i].allot;
                            } else {
                                test = d[i].appro_amnt;
                            }


                            var table = $('#table_'+d[i].subgrpid).DataTable();
                            table.clear().draw();
                            table.row.add([
                                j,
                                '<span class="cc_code" cc-code="'+d[i].at_code+'">'+d[i].at_code+'</span>',
                                d[i].at_desc,
                                '<span class="subgrpid" subgrpid="'+d[i].subgrpid+'">' +d[i].subgrpdesc + '</span>',
                                '<center class="appro" appro="'+parseFloat(d[i].act_deduct)+'">'+formatNumberToMoney(parseFloat(d[i].act_deduct))+'</center>',
                                '<center class="amt truebal" truebal="'+parseFloat(d[i].act_deduct)+'" amt="'+parseFloat(0)+'">'+formatNumberToMoney(parseFloat(0))+'</center>',
                                '<center>' +
                                    '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode(\''+j+'\', \''+d[i].at_code+'\', \''+d[i].appro_amnt+'\', \''+d[i].subgrpid+'\', \''+parseFloat(0)+'\', \''+parseFloat(d[i].act_deduct)+'\');"></i></a>&nbsp;' +
                                    '<a style="display:none" class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+d[i].at_desc+'\', \''+d[i].at_code+'\', \''+parseFloat(d[i].appro_amnt)+'\', \''+d[i].subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
                                '</center>'
                                ]).draw();
                            loadSubTotal(d[i].subgrpid);
                        }
                        loadTotal();
                    }
                },
                error : function(a, b, c){
                    console.log(c);
                }
            });

            $.ajax({
                url : '{{ url('budget/budget-approved-entry/getProposal') }}',
                method : 'POST',
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
                success : function(d){
                    if(d.length > 0)
                    {
                        $('input[name="hdr_fy_mo"]').val(d[0].fy + '-' + d[0].month_desc);
                        $('input[name="hdr_fy"]').val(d[0].fy);
                        $('input[name="hdr_mo"]').val(d[0].mo);
                        $('input[name="hdr_fid_txt"]').val(d[0].fdesc);
                        $('input[name="hdr_fid"]').val(d[0].fid);
                        $('input[name="hdr_cc_txt"]').val(d[0].cc_desc);
                        $('input[name="hdr_cc"]').val(d[0].cc_code);
                        $('input[name="hdr_sec_txt"]').val(d[0].secdesc);
                        $('input[name="hdr_sec"]').val(d[0].secid);
                        // $('input[name="hdr_br_txt"]').val(d[0].name);
                        // $('input[name="hdr_br"]').val(d[0].code);
                        $('input[name="hdr_desc_txt"]').val(d[0].t_desc);
                        $('input[name="hdr_desc"]').val(d[0].t_desc);
                        $('input[name="hdr_bgtps01"]').val(d[0].b_num);
                    }
                },
                error : function (a, b, c){
                    console.log(c);
                }
            });

            $.ajax({
                url : '{{ url('budget/budget-approved-entry/getRemainingBalance') }}',
                method : 'POST',
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
                success : function(data){
                    if(data.length > 0){
                        if(data[0].deduct != null){
                            $('input[name="hdr_total_view"]').val(formatNumberToMoney(parseFloat(data[0].deduct)));
                            $('input[name="hdr_total"]').val(parseFloat(data[0].deduct));
                        } else if (data[0].allot_amt != null) {
                            $('input[name="hdr_total_view"]').val(formatNumberToMoney(parseFloat(data[0].allot_amt)));
                            $('input[name="hdr_total"]').val(parseFloat(data[0].allot_amt));
                        } else if(data[0].appro_amnt != null){
                            $('input[name="hdr_total_view"]').val(formatNumberToMoney(parseFloat(data[0].appro_amnt)));
                            $('input[name="hdr_total"]').val(parseFloat(data[0].appro_amnt));
                        }
                    }
                    else{
                        $('input[name="hdr_total_view"]').val('N/A');
                        $('input[name="hdr_total"]').val(parseFloat(0));
                        // formatNumberToMoney(0);
                    }
                },
                error : function(a, b, c){

                }
            });
            // $('#BudgetEntriesAdd').show();
            alert('Successfully loaded approved');
            $('#modal-default2').modal('toggle');
        }
        else
        {
            alert('Select Budget Appropriation');
        }
    }
</script>
@endsection