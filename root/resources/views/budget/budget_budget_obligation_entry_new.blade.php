@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-obligation-entry"),'desc'=>'Obligation Entry','icon'=>'none','st'=>true],
        ['link'=>url("budget/budget-obligation-entry/new"),'desc'=>'New','icon'=>'none','st'=>true]
    ];
    $_ch = "New Budget Obligation Entry"; // Module Name
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
                        <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value="">
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
                        <input type="text" name="hdr_fy" readonly="" style="display: none" value="@if(isset($data[5])){{$data[5]}}@endif">
                        <input type="text" name="hdr_mo" readonly="" style="display: none" value="@if(isset($data[6])){{$data[6]}}@endif">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Reference Number</label>
                        <input type="text" class="form-control" name="" disabled="">
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
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_fid_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_fid" disabled style="display: none">
                        {{-- <select class="form-control select2 select2-hidden-accessible" name="hdr_fid" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>Fund</strong> is required." required>
                            @isset($data[1])
                            	<option value="">Select Fund...</option>
                            	@foreach($data[1] as $fund)
		                            <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
		                        @endforeach
		                    @else
		                    	<option value="">No Fund registered...</option>
                            @endisset
                        </select> --}}
                        {{-- <span id="hdr_fid_span"></span> --}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cost Center <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_cc_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_cc" disabled style="display: none">
                        {{-- <select class="form-control select2 select2-hidden-accessible" name="hdr_cc" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_cc_span" data-parsley-required-message="<strong>Cost Center</strong> is required." required>
                            @isset($data[2])
                            	<option value="">Select Cost Center..</option>
                            	@foreach($data[2] as $m08)
                            		<option value="{{$m08->cc_code}}">{{$m08->cc_desc}}</option>
                            	@endforeach
                            @else
                            	<option value="">No Cost Center registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_cc_span"></span> --}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sector <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_sec_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_sec" disabled style="display: none">
                        {{-- <select class="form-control select2 select2-hidden-accessible" name="hdr_sec" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_sec_span" data-parsley-required-message="<strong>Sector</strong> is required." required>
                            @isset($data[3])
                            	<option value="">Select Sector...</option>
								@foreach($data[3] as $sector)
		                            <option value="{{$sector->secid}}">{{$sector->secdesc}}</option>
		                        @endforeach
                           	@else
                           		<option value="">No Sector registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_sec_span"></span> --}}
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Description <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_desc_txt" value="@isset($bgt01){{$bgt01->t_desc}}@endisset" disabled>
                        <input type="text" class="form-control" style="display: none" name="hdr_desc" data-parsley-required-message="<strong>Description</strong> is required.">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Approved Budget Reference # <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control" name="hdr_bgtps01" value="" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label>&nbsp;{{-- <span style="color:red"><strong>*</strong></span> --}}</label>
                                <button type="button" data-toggle="modal" data-target="#modal-default2" onclick="Loadapproved()" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Select Approved Budget</button>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>&nbsp;{{-- Test<span style="color:red"><strong>*</strong></span> --}}</label>
                                <button type="button" class="btn btn-block btn-default" onclick="ViewProposal()"><i class="fa fa-eye"></i> View Budget</button>
                            </div>
                        </div>
                </div>
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
                    <button style="display: none" type="button" class="btn btn-primary" onclick="addMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add item</button>
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
                                                            <input type="text" class="form-control" name="itm_acc_title_txt" disabled>
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
                                                            <input type="text" class="form-control" name="itm_ppa_txt" disabled>
		                                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_ppa" data-parsley-required-message="<strong>PPA</strong> is required."  required>
		                                                        @isset($ppasubgrp)
		                                                        	<option value="">Select PPA...</option>
		                                                        	@foreach ($ppasubgrp as $ppa)
		                                                        		<option value="{{$ppa->subgrpid}}">{{$ppa->subgrpdesc}}</option>
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
		                                                    <label>Approved Amount <span style="color:red"><strong>*</strong></span></label>
		                                                    <input type="number" class="form-control" name="itm_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required disabled>
		                                                </div>
		                                            </div>
		                                        </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Obligation Amount <span style="color:red"><strong>*</strong></span></label>
                                                            <input type="number" class="form-control" name="itm_obli" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
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
                    @isset($ppasubgrp)
                    <ul id="TheNavBar" class="nav nav-tabs">
                        @for($i = 0; $i < count($ppasubgrp); $i++)
                            @if($i == 0)
                                <li id="tabhead_{{$ppasubgrp[$i]->subgrpid}}" class="active"><a data-toggle="tab"  href="#tab_{{$ppasubgrp[$i]->subgrpid}}">{{$ppasubgrp[$i]->subgrpdesc}}</a>
                            @else
                                <li id="tabhead_{{$ppasubgrp[$i]->subgrpid}}"><a data-toggle="tab"  href="#tab_{{$ppasubgrp[$i]->subgrpid}}">{{$ppasubgrp[$i]->subgrpdesc}}</a>
                            @endif
                        @endfor
                    </ul>
                    @endisset
                    @isset($ppasubgrp)
                        <div class="tab-content">
                            @for($i = 0; $i < count($ppasubgrp); $i++)
                                @if($i == 0)
                                    <div data-toggle="tab" id="tab_{{$ppasubgrp[$i]->subgrpid}}" class="tab-pane fade in active">
                                @else
                                    <div data-toggle="tab" id="tab_{{$ppasubgrp[$i]->subgrpid}}" class="tab-pane fade in">
                                @endif
                                <br>
                                    <table id="table_{{$ppasubgrp[$i]->subgrpid}}" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Line</th>
                                                <th>Code</th>
                                                <th>Account Title</th>
                                                <th>PPA</th>
                                                <th><center>Approved Amount</center></th>
                                                <th><center>Obligation Amount</center></th>
                                                <th><center>Options</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-8">&nbsp;</div>
                                        <div class="col-sm-4">
                                            <div class="col-sm-4">
                                                <label for="">SUB-TOTAL:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled="" name="sub_total_{{$ppasubgrp[$i]->subgrpid}}" value="Php 0.00">
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
                                <th width="10%">Line</th>
                                <th>Code</th>
                                <th>Account Title</th>
                                <th>PPA</th>
                                <th><center>Approved Amount</center></th>
                                <th><center>Obligation Amount</center></th>
                                <th><center>Options</center></th>
                            </tr>
                        </thead>
                        <tbody>
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
                    	{{-- <div class="form-group" style="display: flex;"> --}}
                        <button type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save Budget Obligation Entry</button>
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
                        <h4 class="modal-title">Select Approved Budget Entry <span id="MOD_MODE"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <form id="approved" novalidate data-parsley-validate>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Approved Budget Entries</label>
                                        <select class="form-control" id="" name="bgt_b_num" onchange="getapprovedEntries()" style="width:100%"></select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Line</th>
                                                <th>Code</th>
                                                <th width="40%">Account Title</th>
                                                <th>PPA</th>
                                                <th><center>Approved Amount</center></th>
                                                {{-- <th><center>Obligation Amount</center></th> --}}
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
                        <button type="button" onclick="Insertapproved()" class="btn btn-success"><i id="ItemButtonNameButton" class="fa fa-plus"></i> <span id="ItemButtonName">Select Approved Budget</span></button>
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
            $('#SideBar_Budget_Budget_Obligation_Entry').addClass('text-green');
            let today = new Date().toISOString().slice(0, 10);
		    $('input[name="hdr_date"]').val(today);
            @if(isset($data[9]))
            	$('select[name="hdr_fid"]').val('{{$data[9]}}').trigger('change');
            @endif
            emptyHeader();
            $('select[name="itm_ppa"]').next().css('display','none');
            $('select[name="itm_acc_title"]').next().css('display','none');
            $('table').DataTable();
            // hideAll();
            // $('#modal-default2').modal('toggle');
            @isset($ppasubgrp)
                @foreach ($ppasubgrp as $d)
                    $('#example1 tbody').on( 'click', 'tr', function () {
                        var table = $('#table_{{$d->subgrpid}}').DataTable();
                        selectedId = table.row( this ).index() ;
                    } );
                @endforeach
            @endisset
        });
	$('#example1 tbody').on( 'click', 'tr', function () {
		var table = $('#example1').DataTable();
	    selectedId = table.row( this ).index() ;
	} );
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
            alert('Please select Budget Proposal to Approve.');
        }
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
        var obli = $('input[name="itm_obli"]').val();
		var table = $('#table_' + subgrpid).DataTable();
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
                // line ,acc_title_id, amt, subgrpid, obli
				table.row(selectedId).data([
						line, '<span class="cc_code" cc-code="'+code+'">'+code+'</span>', acc_title_desc, '<span class="subgrpid" subgrpid="'+subgrpid+'">' +subgrpdesc + '</span>', '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
                        '<center class="obli" obli="'+parseFloat(obli)+'">'+formatNumberToMoney(parseFloat(obli))+'</center>',
						'<center>' +
							'<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+line+'\', \''+acc_title_id+'\', \''+amt+'\', \''+subgrpid+'\', \''+obli+'\');"></i></a>&nbsp;' +
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
            loadSubTotal(subgrpid);
			loadTotal();
			$('#modal-default').modal('toggle');
		}
	}
	function EditMode(line ,acc_title_id, amt, subgrpid, obli)
	{
		$('input[name="itm_line"]').val('');
		$('input[name="itm_line"]').val(line);
		$('select[name="itm_ppa"]').val(subgrpid).trigger('change');
		$('input[name="itm_amt"]').val(amt);
        $('input[name="itm_obli"]').val(obli);
		$('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');

        var acc_title_desc = $('select[name="itm_acc_title"]').select2('data')[0].text;
        var subgrpdesc = $('select[name="itm_ppa"]').select2('data')[0].text;
        $('input[name="itm_acc_title_txt"]').val(acc_title_desc);
        $('input[name="itm_ppa_txt"]').val(subgrpdesc);

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
		if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('table').DataTable().data().count()/ 6) != 0)
                {
                    var codes = $(".cc_code").map(function(){return $(this).attr("cc-code");}).get();
                    var amt = $(".obli").map(function(){return $(this).attr("obli");}).get();
                    var subgrpid = $(".subgrpid").map(function(){return $(this).attr("subgrpid");}).get();
                    var data = {
                            _token : $('meta[name="csrf-token"]').attr('content'),
                            codes : codes,
                            amt : amt,
                            subgrpid : subgrpid,
                            fy : $('input[name="hdr_fy"]').val(),
                            mo : $('input[name="hdr_mo"]').val(),
                            fid : $('input[name="hdr_fid"]').val(),
                            cc_code : $('input[name="hdr_cc"]').val(),
                            secid : $('input[name="hdr_sec"]').val(),
                            // brid : $('input[name="hdr_br"]').val(),
                            t_date : $('input[name="hdr_date"]').val(),
                            t_desc : $('input[name="hdr_desc"]').val(),
                            bgtps_bnum : $('input[name="hdr_bgtps01"]').val(),
                        };
                    $.ajax({
                        url : '{{ url('budget/budget-obligation-entry/save') }}',
                        method : 'POST',
                        data : data,
                        success : function(d){
                            if(d == 'DONE'){
                                alert('Successfully added New Obligation Entry');
                                // location.href= "{{ url('budget/budget-obligation-entry') }}";
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
        else
        {
             alert('Please select Approved Budget..');
        }
	}
    function Loadapproved()
    {
        $.ajax({
            url : '{{ url('budget/budget-obligation-entry/getAllApprove') }}',
            data : {_token: $('meta[name="csrf-token"]').attr('content')},
            success : function(data){
                $('select[name="bgt_b_num"]').empty();
                if(data.length > 0){
                    $('select[name="bgt_b_num"]').append('<option value="">Select Approved Budget...</option>');
                    for(let i = 0; i < data.length; i++){
                        $('select[name="bgt_b_num"]').append('<option value="'+data[i].b_num+'">'+data[i].b_num+'-'+data[i].t_desc+'</option>');
                    }
                } else {
                    $('select[name="bgt_b_num"]').append('<option value="">No Budget has been Approved.</option>'); 
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
                url : '{{ url('budget/budget-obligation-entry/getApproveEntries') }}',
                method : 'POST',
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
                success : function(d){
                    if(d.length > 0)
                    {
                        for(let i = 0; i < d.length; i++)
                        {
                            table.row.add([
                                d[i].seq_num,
                                d[i].at_code,
                                d[i].at_desc,
                                d[i].subgrpdesc,
                                formatNumberToMoney(parseFloat(d[i].allot_amnt)),
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
                url : '{{ url('budget/budget-obligation-entry/getApproveEntries') }}',
                method : 'POST',
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
                success : function(d){
                    if(d.length > 0)
                    {
                        for(let i = 0; i < d.length; i++)
                        {
                            var table = $('#table_' + d[i].subgrpid).DataTable();
                            // table.clear().draw();
                            table.row.add([
                                d[i].seq_num,
                                '<span class="cc_code" cc-code="'+d[i].at_code+'">'+d[i].at_code+'</span>',
                                d[i].at_desc,
                                '<span class="subgrpid" subgrpid="'+d[i].subgrpid+'">' +d[i].subgrpdesc + '</span>',
                                '<center class="amt" amt="'+parseFloat(d[i].allot_amnt)+'">'+formatNumberToMoney(parseFloat(d[i].allot_amnt))+'</center>',
                                '<center class="obli" obli="'+parseFloat(0)+'">' +
                                    formatNumberToMoney(0) +
                                '</center>',
                                '<center>' +
                                    '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode( \''+d[i].seq_num+'\', \''+d[i].at_code+'\', \''+parseFloat(d[i].allot_amnt)+'\', \''+d[i].subgrpid+'\', \'0\');"></i></a>' +
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
                url : '{{ url('budget/budget-obligation-entry/getApprove') }}',
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
            alert('Successfully loaded Approved Budget');
            $('#modal-default2').modal('toggle');
        }
        else
        {
            // alert('Select Budget Proposal');
        }
    }
</script>
@endsection