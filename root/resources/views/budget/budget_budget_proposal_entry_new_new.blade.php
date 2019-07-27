@extends('_main')
@if($isnew)
  @php
      $_bc = [
          ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
          ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Appropriation Entry','icon'=>'none','st'=>true],
          ['link'=>url("budget/budget-proposal-entry/new"),'desc'=>'New','icon'=>'none','st'=>true]
      ];
      $_ch = "Budget Appropriation Entry"; // Module Name
  @endphp
@else
  @php
      $_bc = [
          ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
          ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Appropriation Entry','icon'=>'none','st'=>true],
          ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Edit','icon'=>'none','st'=>true]
      ];
      $_ch = "Budget Appropriation Entry"; // Module Name
  @endphp
@endif
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">

{{-- Start Print Content --}}
    <div class="row printable">
      <div class="row">  
          <div class="col-sm-12">
            <center><b>Republic of the Philippines<br> Province of Negros Oriental<br> LGU-City of Guihulngan<br><br>
              <u><span id="print-fund"></span></u></b><br>
            </center>
          </div>
      </div>
      <br> 
      <div class="row">
        <center>
          <div class="col-sm-12">
            <table style="border: 1px solid #000;">
              <thead>
              <tr>
                <th height="50" style="border: 1px solid #000; width:15%; "><center>Account Code</center></th>
                <th height="50" style="border: 1px solid #000; width:80%; "><center>Function/Program/Project</center></th>
                <th height="50" style="border: 1px solid #000; width:20%; "><center>Amount</center></th>
              </tr>
              </thead>
              <tbody>
                <tr class="noborder">
                  <td></td>
                  <td height="50"><b><u><center>CURRENT YEAR APPROPRIATION</center></u></b></td>
                  <td></td>
                </tr>
                <tr class="noborder">
                  <td><center><b><span id="print-funcid"></span></b></center></td>
                  <td height="50" style="text-indent: 20px;"><b><span id="print-funcdesc"></span></b></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </center>
      </div>
    {{--
      <br> 
      <div class="row">
        <center>
        <div class="col-sm-12">
          <table class="table table-bordered" style="border: 1px solid #000;">
            <thead>
              <tr>
                <th height="50" style="border: 1px solid #000; width:15%; "><center>Account Code</center></th>
                <th height="50" style="border: 1px solid #000; width:80%; "><center>Function/Program/Project</center></th>
                <th height="50" style="border: 1px solid #000; width:20%; "><center>Amount</center></th>
              </tr>
            </thead>
            <tbody>
              <tr class="noborder">
                <td></td>
                <td height="50"><b><u><center>CURRENT YEAR APPROPRIATION</center></u></b></td>
                <td></td>
              </tr>
              <tr class="noborder">
                <td><center><b>{{$Header->funcid}}</b></center></td>
                <td height="50" style="text-indent: 20px;"><b>{{strtoupper($Header->function)}}</b></td>
                <td></td>
              </tr>
              <tr class="noborder">
                <td><center><b>{{$Header->office_code}}</b></center></td>
                <td><b><u>{{strtoupper($Header->office)}}</u></b></td>
                <td ></td>
              </tr>
              @isset($PPA)
                @php
                $total_amt = 0.00;
                @endphp

                @foreach($PPA as $P)
                  <tr class="noborder">
                    <td></td>
                    <td height="50" style="text-indent: 10px; vertical-align: bottom;"><b>{{$P->subgrpdesc}}</b></td>
                    <td></td>
                  </tr>
                  @foreach($Line as $L)
                  @if($P->subgrpid == $L->grpid)
                  <tr class="noborder noborder2">
                    <td><center>{{$L->at_code}}</center></td>
                    <td>{{$L->at_desc}}</td>
                    <td align="right">{{number_format($L->appro_amnt, 2)}}</td>
                  </tr>
                  @endif
                  @endforeach
                  <tr class="noborder noborder3">
                    <td></td>
                    <td><b>Total {{$P->subgrpdesc}}</b></td>
                    <td align="right"><b>{{number_format($P->total_amt, 2)}}</b></td>
                  </tr>
                  @php
                  $total_amt += $P->total_amt;
                  @endphp
                @endforeach
                  
                  <tr class="noborder noborder3">
                    <td></td>
                    <td height="50" style="vertical-align: bottom;"><b>GRAND TOTAL</b></td>
                    <td align="right" height="50" style="vertical-align: bottom;"><b>{{number_format($total_amt, 2)}}</b></td>
                  </tr>
              @endisset
            </tbody>
          </table>
        </div>
      </center>
      </div>   --}}      
    </div>
{{-- End Print Here --}}

    <div class="box box-default non-printable">
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
                <div class="col-md-4" style="display:none">
                    <div class="form-group">
                        <label>Budget Appropriation Entry #</label>
                        @if($isnew)
                          <input type="text" class="form-control" name="" disabled="">
                        @else
                          <input type="text" class="form-control" name="hdr_b_num" disabled="" value="@isset($approHeader){{$approHeader->b_num}}@endisset">
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Year <span style="color:red"><strong>*</strong></span></label>
                            {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                            <select class="form-control select2 select2-hidden-accessible" name="fy" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." data-parsley-errors-container="#budget_fy_span" required>
                                @if($isnew)
                                  @isset($data[0])
                                      <option value="">Select Year...</option>
                                      @foreach($data[0] as $x3)
                                        <option value="{{$x3->fy}}">{{$x3->fy}}</option>
                                      @endforeach
                                  @else
                                      <option value="">No Year registered...</option>
                                  @endisset
                                @else
                                  @isset($data[0])
                                      @foreach($data[0] as $x3)
                                        @if($x3->fy == $approHeader->fy)
                                          <option selected="selected" value="{{$x3->fy}}">{{$x3->fy}}</option>
                                        @else
                                          <option value="{{$x3->fy}}">{{$x3->fy}}</option>
                                        @endif
                                      @endforeach
                                  @else
                                      <option value="">No Year registered...</option>
                                  @endisset
                                @endif
                            </select>
                            <span id="budget_fy_span"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Function <span style="color:red"><strong>*</strong></span></label>
                            <select class="form-control select2 select2-hidden-accessible" name="hdr_func" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_func_span" data-parsley-required-message="<strong>Function</strong> is required." required onchange="getOffice()">
                            @if(!$isnew)
                              @isset($data[12])
                                @foreach($data[12] as $func)
                                  @if($func->funcid == $approHeader->funcid)
                                    <option selected="selected" value="{{$func->funcid}}">{{$func->funcdesc}}</option>
                                  @else
                                    <option value="{{$func->funcid}}">{{$func->funcdesc}}</option>
                                  @endif
                                  @endforeach
                              @else
                                <option value="">No Function registered...</option>
                              @endisset
                            @endif
                            </select>
                            <span id="hdr_func_span"></span>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fund <span style="color:red"><strong>*</strong></span></label>
                            {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_fid_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_fid" disabled style="display: none"> --}}
                            <select class="form-control select2 select2-hidden-accessible" name="hdr_fid" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>Fund</strong> is required." required>
                                @if($isnew)
                                  @isset($data[1])
                                      <option value="">Select Fund...</option>
                                      @foreach($data[1] as $fund)
                                          <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                                      @endforeach
                                  @else
                                      <option value="">No Fund registered...</option>
                                  @endisset
                                @else
                                  @isset($data[1])
                                      @foreach($data[1] as $fund)
                                        @if($fund->fid == $approHeader->fid)
                                          <option selected="selected" value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                                        @else
                                          <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                                        @endif  
                                      @endforeach
                                  @else
                                      <option value="">No Fund registered...</option>
                                  @endisset
                                @endif
                            </select>
                            <span id="hdr_fid_span"></span>
                        </div>                        
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Office <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_cc_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_cc" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_cc" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_cc_span" data-parsley-required-message="<strong>Office</strong> is required." required>
                            @if($isnew)
                              @isset($data[2])
                                <option value="">Select Office..</option>
                                @foreach($data[2] as $m08)
                                    <option value="{{$m08->cc_code}}">{{$m08->cc_desc}}</option>
                                @endforeach
                              @else
                                <option value="">No Office registered...</option>
                              @endisset
                            @else
                              @isset($data[2])
                                <option value="">Select Office..</option>
                                @foreach($data[2] as $m08)
                                  @if($m08->cc_code == $approHeader->cc_code)
                                    <option selected="selected" value="{{$m08->cc_code}}">{{$m08->cc_desc}}</option>
                                  @else
                                    <option value="{{$m08->cc_code}}">{{$m08->cc_desc}}</option>
                                  @endif
                                @endforeach
                              @else
                                <option value="">No Office registered...</option>
                              @endisset
                            @endif
                        </select>
                        <span id="hdr_cc_span"></span>
                    </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Sector <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_sec_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_sec" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_sec" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_sec_span" data-parsley-required-message="<strong>Sector</strong> is required." required onchange="getFunction()">
                            @if($isnew)
                              @isset($data[3])
                                <option value="">Select Sector...</option>
                                @foreach($data[3] as $sector)
                                      <option value="{{$sector->secid}}">{{$sector->secdesc}}</option>
                                  @endforeach
                              @else
                                <option value="">No Sector registered...</option>
                              @endisset
                            @else
                              @isset($data[3])
                                @foreach($data[3] as $sector)
                                  @if($sector->secid == $approHeader->secid)
                                    <option selected="selected" value="{{$sector->secid}}">{{$sector->secdesc}}</option>
                                  @else
                                    <option value="{{$sector->secid}}">{{$sector->secdesc}}</option>
                                  @endif
                                  @endforeach
                              @else
                                <option value="">No Sector registered...</option>
                              @endisset
                            @endif
                        </select>
                        <span id="hdr_sec_span"></span>
                    </div>                        
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                    @isset($data[10])
                    @foreach ($data[10] as $p)
                    <div class="row">
                       <div class="col-md-4" style="margin-bottom: 5px;">
                            <label>{{$p->subgrpid}}</label>
                        </div>
                        <div class="col-md-8" style="margin-bottom: 5px;">
                            <input type="text" class="form-control" disabled="" name="sub_total_{{$p->subgrpid}}" value="Php 0.00">
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div class="row">
                       <div class="col-md-4" style="margin-top: 10px;">
                            <label>TOTAL</label>
                        </div>
                        <div class="col-md-8" style="margin-top: 10px;">
                            <input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <div class="row non-printable">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Budget Entries</h3>
                    {{-- <button id="BudgetEntriesAdd" type="button" class="btn btn-primary" onclick="addMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add item</button> --}}
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
		                                                        @isset($data[8])
		                                                        	<option value="">Select Account Title...</option>
		                                                        	@foreach ($data[8] as $m4)
		                                                        		<option value="{{$m4->at_code}}" id="at_{{$m4->at_code}}" m04_at_desc="{{urlencode($m4->at_desc)}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>
		                                                        	@endforeach
		                                                        @endisset
		                                                    </select>
		                                                    <span id="itm_acc_title_span"></span>
		                                                </div>
		                                            </div>
                                                    {{-- <div class="col-sm-1">
                                                        <label for="">&nbsp;</label>
                                                            <button data-toggle="popover" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Set Account Title as Description" type="button" class="btn btn-warning" onclick=""><i class="fa fa-copy"></i></button>
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
		                                                        @isset($data[10])
		                                                        	<option value="">Select PPA...</option>
		                                                        	@foreach ($data[10] as $ppasggrp)
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
                    <form id="LineForm" data-parsley-validate novalidate>
                    
                    @isset($data[10])
                    <ul id="TheNavBar" class="nav nav-tabs">
                        @for($i = 0; $i < count($data[10]); $i++)
                            @if($i == 0)
                                <li id="tabhead_{{$data[10][$i]->subgrpid}}" class="tabHD active" lePPA="{{$data[10][$i]->subgrpid}}"><a data-toggle="tab"  href="#tab_{{$data[10][$i]->subgrpid}}">{{$data[10][$i]->subgrpdesc}}</a>
                            @else
                                <li id="tabhead_{{$data[10][$i]->subgrpid}}" class="tabHD" lePPA="{{$data[10][$i]->subgrpid}}"><a data-toggle="tab"  href="#tab_{{$data[10][$i]->subgrpid}}">{{$data[10][$i]->subgrpdesc}}</a>
                            @endif
                        @endfor
                    </ul>
                    @endisset
                    @isset($data[10])
                        <div class="tab-content">
                            
                            @for($i = 0; $i < count($data[10]); $i++)
                                @if($i == 0)
                                    <div data-toggle="tab" id="tab_{{$data[10][$i]->subgrpid}}" class="tab-pane fade in active">
                                @else
                                    <div data-toggle="tab" id="tab_{{$data[10][$i]->subgrpid}}" class="tab-pane fade in">
                                @endif
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success pull-right" onclick="addItem()"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                                <br>
                                    <table id="table_{{$data[10][$i]->subgrpid}}" class="table table-bordered table-striped data_table">
                                        <thead>
                                            <tr>
                                                {{-- <th style="display: none">#</th> --}}
                                                <th>Account Code</th>
                                                <th>Account Title/ PPA</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                {{-- <th><center>Allocated</center></th> --}}
                                                <th width="10%"><center>Options</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$isnew)
                                              @foreach($approLine as $al)
                                               @if($data[10][$i]->subgrpid == $al->grpid)
                                                <?php $ln_num = 1; ?>
                                                <tr>
                                                  {{-- '<input list="select_acctCode" name="select_acctCode" subgrpid="'+SelectedTabPPA+'" style="width: 100%;" onchange="getAccountTitleDesc(value)"> <datalist id="select_acctCode">@foreach($data[8] as $m4) <option value="{{$m4->at_code}}"> @endforeach</datalist>',

                '<input list="select_acctDesc" name="select_acctDesc" style="width: 100%;" onchange="getAccountCode(value)" data-parsley-required-message="Please input Account Title/PPA." data-parsley-errors-container="#validate_select_acctDesc'+ SelectedTabPPA+line+'" required> <datalist id="select_acctDesc">@foreach($data[8] as $m4) <option value="{{$m4->at_desc}}"> @endforeach</datalist> <span id="validate_select_acctDesc'+ SelectedTabPPA+line+'"></span>', --}}
                                                    <td style="width: 100px;">
                                                       <input list="select_acctCode" name="select_acctCode" value="{{$al->at_code}}" subgrpid="{{$data[10][$i]->subgrpid}}" style="width: 100%;" onchange="getAccountTitleDesc(value)"> <datalist id="select_acctCode">@foreach($data[8] as $m4) <option value="{{$m4->at_code}}"> @endforeach</datalist>
                                                    </td>
                                                    <td>
                                                      <input list="select_acctDesc" name="select_acctDesc" value="{{$al->at_desc}}" style="width: 100%;" onchange="getAccountCode(value)" data-parsley-required-message="Please input Account Title/PPA." data-parsley-errors-container="#validate_select_acctDesc{{$data[10][$i]->subgrpid}}{{$ln_num}}" required> <datalist id="select_acctDesc">@foreach($data[8] as $m4) <option value="{{$m4->at_desc}}"> @endforeach</datalist> <span id="validate_select_acctDesc{{$data[10][$i]->subgrpid}}{{$ln_num}}"></span>
                                                    </td>
                                                    {{-- <td>
                                                        <select class="form-control select2 select2-hidden-accessible test" id="select_acctCode" name="select_acctCode" subgrpid="{{$data[10][$i]->subgrpid}}" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="Please select Account Title/PPA." data-parsley-errors-container="#validate_select_acctCode{{$data[10][$i]->subgrpid}}{{$ln_num}}" required>
                                                          @foreach ($data[8] as $m4)
                                                            @if($m4->at_code == $al->at_code)
                                                              <option selected="selected" value="{{$m4->at_code}}" id="at_{{$m4->at_code}}" m04_at_desc="{{urlencode($m4->at_desc)}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>
                                                            @else
                                                              <option value="{{$m4->at_code}}" id="at_{{$m4->at_code}}" m04_at_desc="{{urlencode($m4->at_desc)}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>
                                                            @endif
                                                          @endforeach
                                                        </select>
                                                        <span id="validate_select_acctCode{{$data[10][$i]->subgrpid}}{{$ln_num}}"></span>
                                                    </td> --}}
                                                    <td>
                                                        <textarea class="form-control" id="txt_desc" name="txt_desc" style="width:100%" type="text">{{$al->seq_desc}}</textarea>
                                                    </td>
                                                    <td style="width: 100px;">
                                                        <input class="form-control" id="txt_amt" name="txt_amt" style="width:100%" type="text" value="{{number_format($al->appro_amnt, 2)}}" data-parsley-required-message="Amount is required." data-parsley-errors-container="#validate_txt_amt{{$data[10][$i]->subgrpid}}{{$ln_num}}" required> 
                                                        <span id="validate_txt_amt{{$data[10][$i]->subgrpid}}{{$ln_num}}"></span>
                                                    </td>
                                                    <td>
                                                        <center><button class="btn btn-danger removebtn"><i class="fa fa-minus-circle"></i></button></center>
                                                    </td>
                                                </tr>
                                                <?php $ln_num++ ?>
                                               @endif
                                              @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-8">&nbsp;</div>
                                        <div class="col-sm-4">
                                            <div class="col-sm-4">
                                                <label for="">SUB-TOTAL:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled="" name="sub_total_{{$data[10][$i]->subgrpid}}" value="Php 0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            
                        </div>
                    @endisset
                    </div>
                    
                <!-- /.box-body -->
                    </form>
            </div>
            <!-- /.box -->
            <div class="row">
            	<div class="col-sm-4">
            		<div class="col-sm-3">
            			<label for="">GRAND TOTAL:</label>
            		</div>
            		<div class="col-sm-9">
            			<input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">
            		</div>
            	</div>
                <div class="col-sm-8">
                    @if($isnew)
                      {{-- <div class="col-sm-3">
                          <button id="btnPrint" type="button" class="btn btn-default" onclick="print_preview();">Print</button>
                      </div> --}}
                      <div class="col-sm-4">
                          <button type="button" class="btn btn-block btn-warning" onclick="SaveAddMoreProposal()"><i class="fa fa-save"></i> Save & Add More</button>
                      </div>
                      <div class="col-sm-4">
                          <button type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save</button>
                      </div>
                      <div class="col-sm-4">
                          <button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>
                      </div>
                    @else
                      <div class="col-sm-6">
                          <button type="button" class="btn btn-block btn-success" onclick="EditSaveProposal()"><i class="fa fa-save"></i> Save</button>
                      </div>
                      <div class="col-sm-6">
                          <button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>
                      </div>
                    @endif
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
  var checkAcctDescExist = true;

    $(document).on('keypress',function(e) {
    if(e.which == 13)
        {
            if($('#modal-default').hasClass('in'))
            {
                if($('#MOD_MODE').text() == '(ADD)') {
                    if($('#ItmForm').parsley().validate())
                    {
                        InsModiItem(0);
                    }
                }
            }
        }

        
        let howMany = $('li.tabHD').length;
        let SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(let i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }
        
        loadTotal();
        loadSubTotal(SelectedTabPPA);
    });

	$(document).ready(function(){

            $('#SideBar_Budget').addClass('active');
            $('#SideBar_Budget_Budget_Proposal_Entry').addClass('text-green');
            let today = new Date().toISOString().slice(0, 10);
		    $('input[name="hdr_date"]').val(today);
            @if(isset($data[9]))
            	//$('select[name="hdr_fid"]').val('{{$data[9]}}').trigger('change');
            @endif
            @if(isset($data[5]))
                $('select[name="fy"]').val('{{$data[5]}}').trigger('change');
            @endif
            emptyHeader();
            // $('#modal-default2').modal('toggle');
            $('table').DataTable();

            loadTotal();
            @isset($data[10])
            @foreach ($data[10] as $p)
                loadSubTotal('{{$p->subgrpid}}');
            @endforeach
            @endif
        });

	@isset($data[10])
        @foreach ($data[10] as $d)
            $('#table_{{$d->subgrpid}} tbody').on( 'click', 'tr', function () {
                
                var table = $('#table_{{$d->subgrpid}}').DataTable();
                selectedId = table.row( this ).index() ;
            } );
        @endforeach
    @endisset

    // Remove row.
    @isset($data[10])
        @foreach ($data[10] as $d)
            $('#table_{{$d->subgrpid}} tbody').on( 'click', '.removebtn', function () {
                let table = $('#table_{{$d->subgrpid}}').DataTable();
                let index = $(this).closest('tr').index();
                
                removeItem(index);
            } );
        @endforeach
    @endisset

    // if input amount change
      // $('#txt_amt').keyup(function(event)
      // {
      //   loadTotal();
      //   @isset($data[10])
      //   @foreach ($data[10] as $p)
      //       loadSubTotal('{{$p->subgrpid}}');
      //   @endforeach
      //   alert('fromdocukeyup');
      //   @endif
      // });

    /* modify by: DAN 07/16/19
     * Item Per Line Form
     */
    function addItem()
    {
        var howMany = $('li.tabHD').length;
        var SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(var i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }

        var line = ($('#table_'+SelectedTabPPA).DataTable().rows().count()) + 1;
        var table = $('#table_'+SelectedTabPPA).DataTable();

        if(checkAcctDescExist)
        {
           table.row.add([
                // line,<span class="cc_code" subgrpid="'+subgrpid+'" cc-code="'+code+'" desc="'+encodeURI(desc)+'">'+desc+'</span>
                '<input list="select_acctCode" name="select_acctCode" subgrpid="'+SelectedTabPPA+'" style="width: 100%;" onchange="getAccountCode(value); getAccountTitleDesc(value);"> <datalist id="select_acctCode">@foreach($data[8] as $m4) <option value="{{$m4->at_code}}"> @endforeach</datalist>',

                '<input list="select_acctDesc" name="select_acctDesc" style="width: 100%;" onchange="getAccountCode(value); checkIfAcctDescExist('+line+', value);" data-parsley-required-message="Please input Account Title/PPA." data-parsley-errors-container="#validate_select_acctDesc'+ SelectedTabPPA+line+'" required> <datalist id="select_acctDesc">@foreach($data[8] as $m4) <option value="{{$m4->at_desc}}"> @endforeach</datalist> <span id="validate_select_acctDesc'+ SelectedTabPPA+line+'"></span> <span id="validate_ifAlreadyExist'+ SelectedTabPPA+line+'" style="color: red;"></span>',

                // '<select class="form-control select2 select2-hidden-accessible selectbtn" id="select_acctCode" name="select_acctCode" subgrpid="'+SelectedTabPPA+'" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="getAccountTitleDesc(value)" data-parsley-required-message="Please select Account Title/PPA." data-parsley-errors-container="#validate_select_acctCode'+ SelectedTabPPA+line+'" required>'+ '<option value="">Select Account Title...</option>@foreach ($data[8] as $m4)<option value="{{$m4->at_code}}" id="at_{{$m4->at_code}}" m04_at_desc="{{urlencode($m4->at_desc)}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>@endforeach' +
                // '</select><span id="validate_select_acctCode'+ SelectedTabPPA+line+'"></span>',

                '<textarea class="form-control" id="txt_desc" name="txt_desc" style="width:100%" type="text"></textarea>',

                '<input class="form-control" id="txt_amt" name="txt_amt" style="width: 100%;" type="text" data-parsley-required-message="Amount is required." data-parsley-errors-container="#validate_txt_amt'+ SelectedTabPPA+line+'" required> <span id="validate_txt_amt'+ SelectedTabPPA+line+'"></span>',
                '<center><button class="btn btn-danger removebtn"><i class="fa fa-minus-circle"></i></button></center>'
            ]).draw();
           $('select.select2').select2();
        }
        else
        {
          alert('Entered Account Title/PPA already exists.');
        }
    }


   /* Add item per line.
    * src code of Mhel.
    * comment by: DAN 07/16/19

    function addItem()
    {
        var howMany = $('li.tabHD').length;
        var SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(var i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }



        // var line = ($('#table_'+SelectedTabPPA).DataTable().data().count()/ 5) + 1;
        var table = $('#table_'+SelectedTabPPA).DataTable();
        table.row.add([
                // line,
                '<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">'+ '<option value="">Select Account Title...</option>@foreach ($data[8] as $m4)<option value="{{$m4->at_code}}" id="at_{{$m4->at_code}}" m04_at_desc="{{urlencode($m4->at_desc)}}">{{$m4->at_code}} - {{$m4->at_desc}}</option>@endforeach' +
                '</select>',
                '<input class="form-control" style="width:100%" type="text">',
                '<input class="form-control" style="width:100%" type="text">',
                '<center><button class="btn btn-danger" onclick="removeItem(this)"><i class="fa fa-minus-circle"></i></button></center>'
            ]).draw();
        $('select.select2').select2();
    }
    */


    function removeItem(ln_num)
    {
        var howMany = $('li.tabHD').length;
        var SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(var i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }

        var table = $('#table_'+SelectedTabPPA).DataTable();

        table.row(ln_num).remove().draw();

        loadTotal();
        loadSubTotal(SelectedTabPPA);
    }

    function getFunction()
    {
        if($('select[name="hdr_sec"]').val() != '')
        {
            $.ajax({
                url : '{{url('budget/budget-proposal-entry/getFunctions')}}',
                data : {_token : $('meta[name="csrf-token"]').attr('content'), id : $('select[name="hdr_sec"]').val()},
                success : function(d)
                {
                    $('select[name="hdr_func"]').empty();
                    if(d.length> 0)
                    {
                        $('select[name="hdr_func"]').append('<option value="">Select Function...</option>');
                        for(var i = 0; i < d.length;i++)
                        {
                            $('select[name="hdr_func"]').append('<option value="'+d[i].funcid+'">'+d[i].funcdesc+'</option>');
                        }
                    } else {
                        $('select[name="hdr_func"]').append('<option value="">No Function registered...</option>');
                    }
                },
                error : function(a, b, c){}
            });
        }
    }

    function getOffice()
    {
        if($('select[name="hdr_func"]').val() != '')
        {
          var selectedFunc = $('select[name="hdr_func"]').val();
          $.ajax({
          url: '{{asset('budget/budget-proposal-entry/getOffices')}}/'+selectedFunc,
                 method: 'GET',
                 success : function(d)
                           {
                             $('select[name="hdr_cc"]').empty();
                             if(d.length> 0)
                             {
                                 $('select[name="hdr_cc"]').append('<option value="">Select Office...</option>');
                                 for(var i = 0; i < d.length;i++)
                                 {
                                     $('select[name="hdr_cc"]').append('<option value="'+d[i].cc_code+'">'+d[i].cc_desc+'</option>');
                                 }
                             } 
                             else {
                               $('select[name="hdr_cc"]').append('<option value="">No Offices registered...</option>');
                             }
                           }
          });
        }
    }

    /* modify by: DAN 07/19/19
     */
    function loadTotal()
    {
        var tempAmount = 0; 
        var amt = $('input[name="txt_amt"]').map(function(){return $(this).val();}).get();


        if(amt.length > 0)
        {
            for(let i = 0; i < amt.length; i++)
            {
                if(amt[i] != null && amt[i] != '')
                {
                  tempAmount = tempAmount + parseFloat(amt[i].replace(/[^0-9.-]+/g,""));
                }
            }
            
            $('input[name="total_line"]').val(formatNumberToMoney(tempAmount));
        }
        else
        {
          $('input[name="total_line"]').val(formatNumberToMoney(tempAmount));
        }  
    }

    /* src code of Mhel
     * comment by: DAN 07/19/19
     *
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
    */


    /* modify by: DAN 07/19/19
     */
    function loadSubTotal(acct_id)
    {
        var tempAmount = 0; 

        var amt = $("#table_"+acct_id+" tbody td").map(function() {
              return $('input[name="txt_amt"]', this).val(); // else return text content
            }).get();

        if(amt.length > 0)
        {
            for(let i = 0; i < amt.length; i++)
            {
                 if(amt[i] != null && amt[i] != '')
                 {
                   tempAmount = tempAmount + parseFloat(amt[i].replace(/[^0-9.-]+/g,""));
                 }
            }
            
            $('input[name="sub_total_'+acct_id+'"]').val(formatNumberToMoney(tempAmount));
        } 
        else 
        {
            $('input[name="sub_total_'+acct_id+'"]').val(formatNumberToMoney(0));
        }
    }

    /* src code of Mhel
     * comment by: DAN 07/19/19
     *
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

    */

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
        var howMany = $('li.tabHD').length;
        var SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(var i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }



        $('select[name="itm_ppa"]').val(SelectedTabPPA).trigger('change');
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
            $('select[name="itm_ppa"]').val(SelectedTabPPA).trigger('change');
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
                        // line,
                        '<span class="cc_code" subgrpid="'+subgrpid+'" cc-code="'+code+'" desc="'+encodeURI(desc)+'">'+desc+'</span>', acc_title2_desc, '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
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
				// 	for(let i = 0, x = 1; i < ($('#example1').DataTable().data().count()/ 5); i++, x++){
				// 		// AllData[i]
				// 		table.row(i).data([
				// 				x, AllData[i][1], AllData[i][2], AllData[i][3], AllData[i][4], AllData[i][5]
				// 			]).draw();
				// 	}
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

    /* modify by Dan 07/16/19
     */
    function SaveProposal()
    {
     if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('.table').DataTable().rows().count()) != 0)
                {
                    if($('#LineForm').parsley().validate())
                    {
                      if(checkAcctDescExist) // check account title that has a double entry
                      {
                         var codes = $('input[name="select_acctCode"]').map(function(){return $(this).val();}).get();
                         var at_desc = $('input[name="select_acctDesc"]').map(function(){return $(this).val();}).get();
                         var subgrpid = $('input[name="select_acctCode"]').map(function(){return $(this).attr("subgrpid");}).get();

                         var desc = $('textarea[name="txt_desc"]').map(function(){return $(this).val();}).get();
                         var amt = $('input[name="txt_amt"]').map(function(){return $(this).val();}).get();
                         var data = {
                                 _token : $('meta[name="csrf-token"]').attr('content'),
                                 codes : codes,
                                 at_desc : at_desc,
                                 amt : amt,
                                 subgrpid : subgrpid,
                                 desc: desc,
                                 fy : $('select[name="fy"]').val(),
                                 fid : $('select[name="hdr_fid"]').val(),
                                 cc_code : $('select[name="hdr_cc"]').val(),
                                 secid : $('select[name="hdr_sec"]').val(),
                                 funct : $('select[name="hdr_func"]').val(),
                             };

                         $.ajax({
                             url : '{{ url('budget/budget-proposal-entry/save') }}',
                             method : 'POST',
                             data : data,
                             success : function(d){
                                 if(d == 'true'){
                                     alert('Successfully Added new Budget Appropriation Entry');
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
                        alert('Entered Account Title/PPA already exists.');
                      }
                    }
                    else
                    {
                        alert('Please fill the required fields in item/line entry.');
                    }
                }
                else
                {
                    alert("There's no item(s) to add. Please entry item(s).");
                }
            }
            else
            {
                alert('Please fill the required fields in header entry.');
            }
        }
        else
        {
             alert('Please select Budget Appropriation ');
        }
    }

    function EditSaveProposal()
    {
     if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('.table').DataTable().rows().count()) != 0)
                {
                    if($('#LineForm').parsley().validate())
                    {
                      if(checkAcctDescExist) // check account title that has a double entry
                      {
                         var codes = $('input[name="select_acctCode"]').map(function(){return $(this).val();}).get();
                         var at_desc = $('input[name="select_acctDesc"]').map(function(){return $(this).val();}).get();
                         var subgrpid = $('input[name="select_acctCode"]').map(function(){return $(this).attr("subgrpid");}).get();

                         var desc = $('textarea[name="txt_desc"]').map(function(){return $(this).val();}).get();
                         var amt = $('input[name="txt_amt"]').map(function(){return $(this).val();}).get();
                         var data = {
                                 _token : $('meta[name="csrf-token"]').attr('content'),
                                 codes : codes,
                                 at_desc : at_desc,
                                 amt : amt,
                                 subgrpid : subgrpid,
                                 desc: desc,
                                 fy : $('select[name="fy"]').val(),
                                 fid : $('select[name="hdr_fid"]').val(),
                                 cc_code : $('select[name="hdr_cc"]').val(),
                                 secid : $('select[name="hdr_sec"]').val(),
                                 funct : $('select[name="hdr_func"]').val(),
                                 b_num :  $('input[name="hdr_b_num"]').val(),
                             };

                         $.ajax({
                             url : '{{ url('budget/budget-proposal-entry/update') }}',
                             method : 'POST',
                             data : data,
                             success : function(d){
                                 if(d == 'true')
                                 {
                                     alert('Successfully Modified Budget Appropriation Entry');
                                     location.href= "{{ url('budget/budget-proposal-entry') }}";
                                 } 
                                 else 
                                 {
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
                        alert('Entered Account Title/PPA already exists.');
                      }
                    }
                    else
                    {
                        alert('Please fill the required fields in item/line entry.');
                    }
                }
                else
                {
                    alert("There's no item(s) to add. Please entry item(s).");
                }
            }
            else
            {
                alert('Please fill the required fields in header entry.');
            }
        }
        else
        {
             alert('Please select Budget Appropriation ');
        }
    }

    /* source code of Mhel
     * comment by: DAN 07/16/19
     *
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
                            // budget_period : $('select[name="budget_period"]').val(),
                            fid : $('select[name="hdr_fid"]').val(),
                            cc_code : $('select[name="hdr_cc"]').val(),
                            secid : $('select[name="hdr_sec"]').val(),
                            funct : $('select[name="hdr_func"]').val(),
                            // brid : $('input[name="hdr_br"]').val(),
                            // t_date : $('input[name="hdr_date"]').val(),
                            // t_desc : $('input[name="hdr_desc"]').val(),
                            // bgtps_bnum : $('input[name="hdr_bgtps01"]').val(),
                        };
                    $.ajax({
                        url : '{{ url('budget/budget-proposal-entry/save') }}',
                        method : 'POST',
                        data : data,
                        success : function(d){
                            if(d == 'DONE'){
                                alert('Successfully Added new Budget Appropriation Entry');
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
    */


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

    function SaveAddMoreProposal()
    {
     if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('.table').DataTable().rows().count()) != 0)
                {
                    if($('#LineForm').parsley().validate())
                    {
                      if(checkAcctDescExist) // check account title that has a double entry
                      {
                         var codes = $('input[name="select_acctCode"]').map(function(){return $(this).val();}).get();
                         var at_desc = $('input[name="select_acctDesc"]').map(function(){return $(this).val();}).get();
                         var subgrpid = $('input[name="select_acctCode"]').map(function(){return $(this).attr("subgrpid");}).get();

                         var desc = $('textarea[name="txt_desc"]').map(function(){return $(this).val();}).get();
                         var amt = $('input[name="txt_amt"]').map(function(){return $(this).val();}).get();
                         var data = {
                                 _token : $('meta[name="csrf-token"]').attr('content'),
                                 codes : codes,
                                 at_desc : at_desc,
                                 amt : amt,
                                 subgrpid : subgrpid,
                                 desc: desc,
                                 fy : $('select[name="fy"]').val(),
                                 fid : $('select[name="hdr_fid"]').val(),
                                 cc_code : $('select[name="hdr_cc"]').val(),
                                 secid : $('select[name="hdr_sec"]').val(),
                                 funct : $('select[name="hdr_func"]').val(),
                             };
                         $.ajax({
                             url : '{{ url('budget/budget-proposal-entry/saveaddmore') }}',
                             method : 'POST',
                             data : data,
                             success : function(d){
                                 if(d != 'false')
                                 {
                                     alert('Successfully Added new Budget Appropriation Entry');
                                     location.href ='{{ url('budget/budget-proposal-entry/new') }}/'+ d  + '';
                                 } 
                                 else 
                                 {
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
                        alert('Entered Account Title/PPA already exists.');
                      }
                    }
                    else
                    {
                        alert('Please fill the required fields in item/line entry.');
                    }
                }
                else
                {
                    alert("There's no item(s) to add. Please entry item(s).");
                }
            }
            else
            {
                alert('Please fill the required fields in header entry.');
            }
        }
        else
        {
             alert('Please select Budget Appropriation ');
        }
    }

    function getAccountTitleDesc(at_code)
    {
        var howMany = $('li.tabHD').length;
        var SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(var i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }


        $('#table_'+SelectedTabPPA+' tbody').on( 'click',  function () {
                let table = $('#table_'+SelectedTabPPA+'').DataTable();
                let index = $(this).closest('tr').index();
                
            } );

        var line = '0';
        var table = $('#table_'+SelectedTabPPA).DataTable();
        
        $.ajax({
          url: '{{asset('budget/get_acctdesc')}}/'+at_code,
                 method: 'GET',
                 success : function(data)
                           {
                             if(data != null && data != '')
                             {  
                                table.cell({row:selectedId, column:2}).data('<textarea class="form-control" id="txt_desc" name="txt_desc" style="width:100%" type="text">'+data+'</textarea>');
                             }
                           }
        });
    }

    function getAccountCode(at_desc)
    {
        var howMany = $('li.tabHD').length;
        var SelectedTabPPA = '';
        if(howMany > 0)
        {
            for(var i = 0; i < howMany;i++)
            {
                if($($('li.tabHD')[i]).hasClass('active'))
                {
                    SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                    break;
                }
            }
        }


        $('#table_'+SelectedTabPPA+' tbody').on( 'click',  function () {
                let table = $('#table_'+SelectedTabPPA+'').DataTable();
                let index = $(this).closest('tr').index();
                
            } );

        var line = '0';
        var table = $('#table_'+SelectedTabPPA).DataTable();
        var data = {  _token : $('meta[name="csrf-token"]').attr('content'),
                      at_desc : at_desc,
                    };
        
        $.ajax({
                 data: data,
                 url : '{{ url('budget/get_acctcode') }}',
                 method: 'POST',
                 success : function(data)
                           {
                             if(data != null && data != '')
                             {
                                table.cell({row:selectedId, column:0}).data('<input list="select_acctCode" name="select_acctCode" subgrpid="'+SelectedTabPPA+'" style="width: 100%;" value="'+data+'" onchange="getAccountTitleDesc(value)"> <datalist id="select_acctCode">@foreach($data[8] as $m4) <option value="{{$m4->at_code}}"> @endforeach</datalist>');

                                getAccountTitleDesc(data);
                             }
                           }
        });
    }

    function checkIfAcctDescExist(line, value)
    {
      var subgrpid = $('input[name="select_acctCode"]').map(function(){return $(this).attr("subgrpid");}).get();
      var at_desc = $('input[name="select_acctDesc"]').map(function(){return $(this).val();}).get();

      var howMany = $('li.tabHD').length;
      var SelectedTabPPA = '';

      if(howMany > 0)
      {
          for(var i = 0; i < howMany;i++)
          {
              if($($('li.tabHD')[i]).hasClass('active'))
              {
                  SelectedTabPPA = $($('li.tabHD')[i]).attr('leppa');
                  break;
              }
          }
      }

      var check = false;
      var row = 0;

      for(i=0; i < at_desc.length; i++)
      {
        if(subgrpid[i] == SelectedTabPPA)
        {
          row += 1;
        }

        // check if value already exist
        if(at_desc[i].toUpperCase() == value.toUpperCase() && subgrpid[i] == SelectedTabPPA && row != line) 
        {
          check = true;
        }

        if(check) // if exist, display a message
        {
          checkAcctDescExist = false;
          alert('Entered Account Title/PPA already exists.');
          $('#validate_ifAlreadyExist'+SelectedTabPPA+line).text('Entered Account Title/PPA already exists.');
        }
        else
        {
          checkAcctDescExist = true;
          $('#validate_ifAlreadyExist'+SelectedTabPPA+line).text('');
        }
      }
    }

    function print_preview()
    {
      // // var fund = $('select[name="hdr_fid"]').select2('data')[0].text;
      // // var funcid = $('select[name="hdr_func"]').val();
      // // var funcdesc = $('select[name="hdr_func"]').select2('data')[0].text;
      // // var cc_code = $('select[name="hdr_func"]').val();
      // // var cc_desc = $('select[name="hdr_func"]').select2('data')[0].text;
      // var codes = $('input[name="select_acctCode"]').map(function(){return $(this).val();}).get();

      // // $('#print-fund').text(fund);
      // // $('#print-funcid').text(funcid);
      // // $('#print-funcdesc').text(funcdesc.toUpperCase());

      // var data;
      // //var data = [fund, funcid, funcdesc, cc_code, cc_desc, codes];

      // var test = new Array();
      // test['code'] = new Array(codes);


      // data = test;

      // alert(data);

      // //window.print();

      // //location.href ='{{ url('budget/budget-proposal-entry/print') }}/'+ b_num;
      // window.open('{{ url('budget/budget-appro/print-entry') }}/'+ data);
    }


    // document.getElementById("btnPrint").onclick = function () 
    // {
    //    printElement(document.getElementById("printThis"));
    
    // var modThis = document.querySelector("#printSection");
    // //modThis.appendChild(document.createTextNode(" new"));
    
    // window.print();
    // }

    // function printElement(elem) 
    // {
    // var domClone = elem.cloneNode(true);
    
    // var $printSection = document.getElementById("printSection");
    
    // if (!$printSection) {
    //     var $printSection = document.createElement("div");
    //     $printSection.id = "printSection";
    //     document.body.appendChild($printSection);
    // }
    
    // $printSection.innerHTML = "";
    
    // $printSection.appendChild(domClone);
    // }

</script>
<style>
  @media screen {
  #printSection {
      display: none;
  }
}
.printable { display: none; }

@media print {
  body * {
    /*visibility:hidden;*/
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
  .printable { display: block; }

  .non-printable { display: none; }
}



</style>
@endsection
