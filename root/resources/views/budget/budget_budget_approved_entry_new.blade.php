@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Allotment Entry','icon'=>'none','st'=>true],
        ['link'=>url("budget/budget-approved-entry/new"),'desc'=>'New','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Allotment Entry"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
    <div class="box box-default" id="my-box-widget">
        <div class="box-header with-border">
            <h3 class="box-title">Appropriation Entries</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body" style="">
            <div class="row">
                <form id="chcHeader" data-parsley-validate novalidate>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Financial Year</label>
                            <select type="text" class="form-control" name="sel_fy" onchange="SearchNow()" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_fy_span" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." required>
                                @isset($x03)
                                    <option value="">Select Year...</option>
                                    @foreach($x03 as $x3)
                                      <option value="{{$x3->fy}}">{{$x3->fy}}</option>
                                    @endforeach
                                @else
                                    <option value="">No Year registered...</option>
                                @endisset
                            </select>
                            <span id="sel_fy_span"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>From</label>
                            <select type="text" class="form-control" name="sel_frm" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_from_span" aria-hidden="true" data-parsley-required-message="<strong>From month</strong> is required." required>
                                <option value="">Select from month..</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <span id="sel_from_span"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>To</label>
                            <select type="text" class="form-control" name="sel_to" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_to_span" aria-hidden="true" data-parsley-required-message="<strong>To month</strong> is required." required>
                                <option value="">Select from month..</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <span id="sel_to_span"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button type="button" onclick="SearchNow();" class="btn form-control btn-info"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                            </div>
                        </div> --}}
                        
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="SearchTbl" class="table table-bordered table-striped">
                        <thead>
                            <th width="10%">
                                <center><input id="laAllChck" type="checkbox" onclick="chckAll()"></center>
                            </th>
                            <th width="20%">Appropriation Ref. #</th>
                            <th>Cost Center/ Office</th>
                            <th>Sector</th>
                            <th>Fund</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="button" onclick="LoadData()" class="btn form-control btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Load Selected Appropiration Entries</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span id="AllDataHere">
    </span>
    <div class="modal fade in" id="ShoWSaveAllotment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Save Allotment </h4>
                </div>
                <div class="modal-body">
                    <center>
                        <h4 class="text-transform: uppercase;">Are you sure you want to save Budget Allotments?</h4>
                    </center>
                </div>
                <div class="modal-footer">
                        <button type="button" onclick="SaveProposal()" class="btn btn-success"><i id="ItemButtonNameButton" class="fa fa-save"></i> <span id="ItemButtonName">Save</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
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
                                            <input type="text" class="form-control" name="itm_acc_title_txt" readonly="">
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
                                            <label>PPA Group<span style="color:red"><strong>*</strong></span></label>
                                            <input type="text" class="form-control" name="itm_ppa_txt" readonly="">
                                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_ppa_span" name="itm_ppa" data-parsley-required-message="<strong>PPA</strong> is required."  required>
                                                @isset($ppa)
                                                    <option value="">Select PPA...</option>
                                                    @foreach ($ppa as $ppasggrp)
                                                        <option value="{{$ppasggrp->subgrpid}}">{{$ppasggrp->subgrpdesc}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <span id="itm_ppa_span"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Balance <span style="color:red"><strong>*</strong></span></label>
                                            <input type="number" class="form-control" name="itm_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Allocated <span style="color:red"><strong>*</strong></span></label>
                                            <input type="number" class="form-control" name="itm_alot" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
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
                        <button type="button" onclick="InsModiItem()" class="btn btn-success"><i id="ItemButtonNameButton" class="fa fa-floppy-o"></i> <span id="ItemButtonName">Save</span></button>
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
</section>
<!-- /.content -->
<script>
    var selectedId = 0;
    var selectedB_num = [];
    var gago = '';
    var AllB_Num = '';
    var ppa = [@isset($ppa)@foreach($ppa as $p)'{{$p->subgrpid}}', @endforeach @endisset];
    var ppa_desc = [@isset($ppa)@foreach($ppa as $p)'{{$p->subgrpdesc}}', @endforeach @endisset];
    $(document).ready(function(){
        $('table').DataTable();
        @isset($dt_frm)
            $('select[name="sel_frm"]').val('{{$dt_frm}}').trigger('change');
        @else
            $('select[name="sel_frm"]').val('').trigger('change');
        @endisset
         @isset($dt_to)
            $('select[name="sel_to"]').val('{{$dt_to}}').trigger('change');
        @else
            $('select[name="sel_to"]').val('').trigger('change');
        @endisset
        @isset($fy)
            $('select[name="sel_fy"]').val('{{$fy}}').trigger('change');
        @else
            $('select[name="sel_fy"]').val('').trigger('change');
        @endisset
        $('select[name="sel_frm"]').attr('disabled', '');
        $('select[name="sel_to"]').attr('disabled', '');
    });
    // $("#example tbody").on('click', '.editButton', function() {
    //     alert('Row index: ' + $(this).closest('tr').index());
    // });

    // $("table tr button").on('click', function(){
    //     var test = $(this).closest('td').parent()[0].sectionRowIndex;
    //    console.log(test);
    // })
    $('table').on( 'click', 'tr', function () {
        var table = $('table').DataTable();
        selectedId = table.row( this ).index() ;
        // console.log(this);
    });
    // $('.ppa').on( 'click', 'tr', function () {
    //     var table = $('table').DataTable();
    //     selectedId = table.row( this ).index() ;
    // } );
    // $("tr").click(function (){
    //    selectedId = $('tr', $(this).closest("table")).index(this);
    // });
    $('input[name="sel_bnum[]"]').on('change', function(e){
            console.log(this);
            if($(this).prop('checked') == false){
                $('#laAllChck').prop("checked", false);
            }
        });
    function SearchNow()
    {
        var tbl = $('#SearchTbl').DataTable();
        if ($('#chcHeader').parsley().validate())
        {
            tbl.clear().draw();
            $.ajax({
                url : '{{ url('budget/budget-approved-entry/get2') }}',
                data : {_token : $('meta[name="csrf-token"]').attr('content'), fy : $('select[name="sel_fy"]').val(), dt_frm : $('select[name="sel_frm"]').val(), dt_to: $('select[name="sel_to"]').val()},
                success: function(data){
                    if(data.length > 0)
                    {
                        for(let i = 0; i < data.length; i++){
                            tbl.row.add([
                                '<center><input class="chcBx" type="checkbox" name="sel_bnum[]" b_num="'+data[i].b_num+'" cc_code="'+data[i].cc_code+'" cc_desc="'+encodeURI(data[i].cc_desc)+'" secid="'+data[i].secid+'" secdesc="'+encodeURI(data[i].secdesc)+'" fid="'+data[i].fid+'" fdesc="'+encodeURI(data[i].fdesc)+'">' +
                                '</center>',
                                data[i].b_num,
                                data[i].cc_desc,
                                data[i].secdesc,
                                data[i].fdesc,
                            ]).draw();
                        }
                    }
                },
                error:function(a, b, c){},
            });
        }
    }
    function chckAll()
    {
        if($('#laAllChck').prop("checked") == true)
        {
            $('.chcBx').prop('checked', true);
        } else
        {
            $('.chcBx').prop('checked', false);
        }
    }
    function LoadData()
    {
       var test =  $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? $(this).attr('b_num'): null;}).get();
       var cc_codes = $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? $(this).attr('cc_code'): null;}).get();
       var cc_desc = $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? urldecode($(this).attr('cc_desc')): null;}).get();
       var secid = $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? $(this).attr('secid'): null;}).get();
       var secdesc = $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? urldecode($(this).attr('secdesc')): null;}).get();
       var fid = $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? $(this).attr('fid'): null;}).get();
       var fdesc = $('#SearchTbl').DataTable().$('input[type="checkbox"]').map(function(){return ($(this).prop('checked')) ? urldecode($(this).attr('fdesc')): null;}).get();

       if(test.length != 0)
       {
            selectedB_num = test;
            $('#my-box-widget').boxWidget('toggle');
            $.ajax({
                url : "{{url('budget/budget-approved-entry/getProposalEntries2')}}",
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : test, fy : $('select[name="sel_fy"]').val()},
                method : 'POST',
                success: function(data){
                    if(data.length > 0)
                    {
                        $('#AllDataHere').empty();
                        $('#AllDataHere').append(
                                '<div class="box box-default" id="LeAllBox">' +
                                    '<div class="box-body" id="AllBoxBody">' +
                                        '<ul id="TheNavBar" class="nav nav-tabs">' +
                                        '</ul>' +
                                        '<div class="tab-content" id="TheBodyArea">' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                               ' <div class="row">' +
                                    '<div class="col-sm-6">&nbsp;' +
                                    '</div>' +
                                    '<div class="col-sm-6">' +
                                        '<div class="col-sm-6">' +
                                            {{-- <div class="form-group" style="display: flex;"> --}}
                                            '<button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#ShoWSaveAllotment"><i class="fa fa-save"></i> Save</button>'+
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>'
                            );
                        for(var i = 0; i < test.length;i++)
                        {
                            $('#TheNavBar').append(
                                    '<li id="tabhead_'+test[i]+'" class=""><a data-toggle="tab"  href="#tab_'+test[i]+'">'+cc_desc[i]+'</a>'
                                );
                            $('#TheBodyArea').append(
                                        '<div data-toggle="tab" id="tab_'+test[i]+'" class="tab-pane fade in">' +
                                            '<span id="hdr_'+test[i]+'"><br>'+
                                                '<div class="row">' +
                                                    '<div class="col-md-4">' +
                                                        '<div class="form-group">' +
                                                            '<label>Budget Allotment Entry #</label>' +
                                                            '<input type="text" class="form-control" value="" disabled>' +
                                                        '</div>' +
                                                    '</div>'+
                                                    '<div class="col-md-4">' +
                                                        '<div class="form-group">' +
                                                            '<label>Approriation Entry Reference #</label>' +
                                                            '<input type="number" class="form-control" hdr_appr="'+test[i]+'" value="'+test[i]+'" disabled>' +
                                                        '</div>' +
                                                    '</div>'+
                                                    '<div class="col-md-4">' +
                                                        '<div class="form-group">' +
                                                            '<label>Cost Center/ Office</label>' +
                                                            '<input type="text" class="form-control" name="hdr_cc_'+test[i]+'" hdr_cc_code_val="'+cc_codes[i]+'" value="'+cc_desc[i]+'" disabled>' +
                                                        '</div>' +
                                                    '</div>'+
                                                '</div>' +
                                                '<div class="row">' +
                                                    '<div class="col-md-4">' +
                                                        '<div class="form-group">' +
                                                            '<label>Fund</label>' +
                                                            '<input type="text" class="form-control" name="hdr_fid_'+test[i]+'" hdr_fid_val="'+fid[i]+'" value="'+fdesc[i]+'" disabled>' +
                                                        '</div>' +
                                                    '</div>'+
                                                    '<div class="col-md-4">' +
                                                        '<div class="form-group">' +
                                                            '<label>Sector</label>' +
                                                            '<input type="text" class="form-control" name="hdr_secid_'+test[i]+'" hdr_secid_val="'+secid[i]+'" value="'+secdesc[i]+'" disabled>' +
                                                        '</div>' +
                                                    '</div>'+
                                                    '<div class="col-md-4">' +
                                                        '<div class="form-group">' +
                                                            '<label>Reference #</label>' +
                                                            '<input type="text" name="ref_val_'+test[i]+'" class="form-control ref_NUM" value="" required>' +
                                                        '</div>' +
                                                    '</div>'+
                                                '</div>' +
                                            '</span>' +
                                            '<ul id="navBar_'+test[i]+'" class="nav nav-tabs">' +

                                            '</ul>' +
                                            '<div class="tab-content" id="bodyDiv_'+test[i]+'">' +
                                            '</div>' +
                                        '</div>'
                                    );

                           if(i == 0){
                                $('#tabhead_'+test[i]).addClass('active');
                                $('#tab_'+test[i]).addClass('active');
                            }

                            for(let j = 0, length1 = ppa.length; j < length1; j++){
                                $('#navBar_'+test[i]).append(
                                        '<li id="tabhead_'+test[i]+'_'+ppa[j]+'" class=""><a data-toggle="tab"  href="#tab_'+test[i]+'_'+ppa[j]+'">'+ppa_desc[j]+'</a>'
                                    );
                                $('#bodyDiv_'+test[i]).append(
                                        '<div data-toggle="tab" id="tab_'+test[i]+'_'+ppa[j]+'" class="tab-pane fade in">' +
                                            '<br>' +
                                            '<table id="table_'+test[i]+'_'+ppa[j]+'" class="table table-bordered table-striped ppa">' +
                                                '<thead>' +
                                                    '<tr>' +
                                                        '<th>Line</th>' +
                                                        '<th>Code</th>' +
                                                        '<th>Account Title/ PPA</th>' +
                                                        '<th><center>Balance</center></th>' +
                                                        '<th><center>Allocated</center></th>' +
                                                        '<th><center>Options</center></th>' +
                                                    '</tr>' +
                                                '</thead>' +
                                                '<tbody>' +
                                                '</tbody>' +
                                            '</table>' +
                                            '<div class="row">' +
                                                '<div class="col-sm-5">&nbsp;</div>' +
                                                '<div class="col-sm-7">' +
                                                    '<div class="col-sm-7">' +
                                                        '<label for="">'+ppa_desc[j].toUpperCase()+' TOTAL:</label>' +
                                                    '</div>' +
                                                    '<div class="col-sm-5">' +
                                                        '<input type="text" class="form-control" disabled="" name="sub_total_'+test[i]+'_'+ppa[j]+'" value="Php 0.00">'+
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>'

                                    );
                                $('#table_'+test[i]+'_'+ppa[j]).DataTable();
                                var temp = $('#table_'+test[i]+'_'+ppa[j]).DataTable();
                                // $('#table_'+test[i]+'_'+ppa[j]+ ' tbody').on( 'click', 'tr', function () {
                                //     var table = $('#table_'+test[i]+'_'+ppa[j]).DataTable();
                                //     selectedId = table.row( this ).index() ;
                                // } );
                                temp.clear().draw();
                                loadLeData(data[i], test[i], ppa[j]);
                                // for(let k = 0, length1 = data.length; k < length1; k++){
                                //     if(data[i][k].subgrpid != ''){
                                //         if(ppa[j] == data[i][k].subgrpid){
                                //             temp.row.add([
                                //                     k,
                                //                     '<span class="cc_code" cc-code="'+data[i][k].at_code+'">'+data[i][k].at_code+'</span>',
                                //                     data[i][k].at_desc,
                                //                     '<center class="appro" appro="'+parseFloat(data[i][k].act_deduct)+'">'+formatNumberToMoney(parseFloat(data[i][k].act_deduct))+'</center>',
                                //                     '<center class="amt truebal" truebal="'+parseFloat(data[i][k].act_deduct)+'" amt="'+parseFloat(0)+'">'+formatNumberToMoney(parseFloat(0))+'</center>',
                                //                     '<center>' +
                                //                         '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode();"></i></a>&nbsp;' +
                                //                     '</center>'
                                //                 ]).draw();
                                //         }
                                //     }
                                // }
                                // temp.row.add([]).draw();
                                if(j == 0){
                                    $('#tabhead_'+test[i]+'_'+ppa[j]).addClass('active');
                                    $('#tab_'+test[i]+'_'+ppa[j]).addClass('active');
                                }
                                loadSubTotal(ppa[j], test[i]);

                            }
                            $('#tab_'+test[i]).append(
                                    '<hr><br><div class="row">' +
                                        '<div class="col-sm-6">' +
                                            '<div class="col-sm-3">' +
                                                '<label for="">Total Balance:</label>' +
                                            '</div>'+
                                            '<div class="col-sm-9">' +
                                                '<input type="text" class="form-control" disabled="" name="total_line_'+test[i]+'" value="Php 0.00">' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col-sm-6">&nbsp;' +
                                            // '<div class="col-sm-6">' +
                                                // '<button type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save</button>' +
                                            // '</div>' +
                                        '</div>' +
                                    '</div>'
                                );
                            loadTotal(test[i]);
                        }
                    }
                },
                error: function(a, b, c){}

            });
       }
       else
       {
            alert('No Selected Budget Appropriation');
       }
    }
    function loadLeData(data, b_num, ppa)
    {
        var temp = $('#table_'+b_num+'_'+ppa).DataTable();
        for(var i = 0; i < data.length;i++)
        {
            if(data[i].subgrpid == ppa)
            {
                var deducted = 0, bal = 0;
                //appro_amnt/(12/(mo_to - mo_from))
                // appro_amnt * ((100/(12/((mo_to - mo_from) + 1)))*0.01)
            // var autoDeduct = (parseFloat(data[i].act_deduct) > 0) ? parseFloat(data[i].act_deduct)/2 : 0;
                if(parseFloat(data[i].act_deduct) > 0){
                //     var temp = parseFloat(data[i].act_deduct)/2;
                //     amt = temp; truBal = temp;
                    // deducted =  parseFloat(data[i].act_deduct)/(12/(parseFloat($('select[name="sel_to"]').val()) - parseFloat($('select[name="sel_frm"]').val())));
                    deducted =  parseFloat(data[i].act_deduct)*((100/(12/((parseFloat($('select[name="sel_to"]').val()) - parseFloat($('select[name="sel_frm"]').val())) + 1)))*0.01);
                    bal = parseFloat(data[i].act_deduct) - deducted;
                    // console.log(deducted);
                } else {
                    bal = parseFloat(data[i].act_deduct);
                    deducted = 0;
                }
            temp.row.add([
                    i + 1,
                    '<span class="cc_code" cc-code="'+data[i].at_code+'">'+data[i].at_code+'</span>',
                    data[i].at_desc,
                    '<center class="appro subgrpid" subgrpid="'+data[i].subgrpid+'" appro="'+parseFloat(bal).toFixed(2)+'">'+formatNumberToMoney(parseFloat(bal))+'</center>',
                    '<center class="amt truebal" truebal="'+parseFloat(data[i].act_deduct)+'" amt="'+parseFloat(deducted).toFixed(2)+'">'+formatNumberToMoney(parseFloat(deducted))+'</center>',
                    '<center>' +
                        '<a class="btn btn-social-icon btn-warning" id="edt_'+b_num+'_'+ppa+'_'+(i+1)+'" onclick="EditMode(\''+(i + 1)+'\', \''+data[i].at_code+'\', \''+parseFloat(data[i].appro_amnt)+'\', \''+data[i].subgrpid+'\', \''+parseFloat(deducted).toFixed(2)+'\', \''+parseFloat(data[i].act_deduct)+'\', \''+b_num+'\');getIndexNow(\''+b_num+'_'+ppa+'_'+(i + 1)+'\', \'table_'+b_num+'_'+ppa+'\');"><i class="fa fa-pencil"></i></a>&nbsp;' +
                    '</center>'
                ]).draw();
            }
        }
    }
    // $('table').on( 'click', 'tr', function () {
    //     var table = $('table').DataTable();
    //     selectedId = table.row( this ).index() ;
    //     console.log(this);
    // } );
    function getIndexNow(inx, tbl){
        var table = $(tbl).DataTable();
        selectedId = $('#edt_'+inx).closest('tr').index();
        gago = inx;
    }
    function EditMode(line, acc_title_id, amt, subgrpid, allot, true_bal, b_num)
    {
        $('input[name="true_bal"]').val(true_bal);
        $('input[name="itm_line"]').val(line);
        $('select[name="itm_ppa"]').val(subgrpid).trigger('change');
        $('input[name="itm_amt"]').val(true_bal);
        $('select[name="itm_ppa"]').next().css('display','none');
        $('select[name="itm_acc_title"]').next().css('display','none');
        $('select[name="itm_acc_title"]').val(acc_title_id).trigger('change');
        $('#ItemButtonNameButton').removeClass('fa-plus');
        $('#ItemButtonNameButton').addClass('fa-save');
        $('.DeleteMode').hide();
        $('.AddMode').show();
        $('#ItemButtonName').text('Save');
        $('#MOD_MODE').text('(EDIT)');
        $('input[name="itm_amt"]').attr('readonly', '');
        $('input[name="itm_alot"]').val(allot);
        $('input[name="itm_acc_title_txt"]').val($('select[name="itm_acc_title"]').select2('data')[0].text);
        $('input[name="itm_ppa_txt"]').val($('select[name="itm_ppa"]').select2('data')[0].text);
        $('#modal-default').modal('toggle');
        AllB_Num = b_num;
    }
    function getAccountTitleCode()
    {
        $('input[name="itm_code"]').val($('select[name="itm_acc_title"]').val());
    }
    function loadSubTotal(ppa, b_num)
    {
        var totalBal = 0;
        var truebal = $("#table_"+b_num+"_"+ppa+" .truebal").map(function(){return $(this).attr("truebal");}).get();
        var amt = $("#table_"+b_num+"_"+ppa+" .amt").map(function(){return $(this).attr("amt");}).get();
        if(amt.length > 0){
            for(let i = 0; i < amt.length; i++){
                 totalBal = parseFloat(truebal[i]) - parseFloat(amt[i]);
            }
            // totalBal = parseFloat(appr) - parseFloat(tempAmount);
            $('input[name="sub_total_'+b_num+'_'+ppa+'"]').val(formatNumberToMoney(totalBal));
        }
    }
    function loadTotal(b_num)
    {
        // bodyDiv_'+test[i]
        var totalBal = 0;
        var truebal = $("#bodyDiv_"+b_num+" .truebal").map(function(){return $(this).attr("truebal");}).get();
        // var appro = $(".appro").map(function(){return $(this).attr("appro");}).get();
        var amt = $("#bodyDiv_"+b_num+" .amt").map(function(){return $(this).attr("amt");}).get();
        if(amt.length > 0){
            for(let i = 0; i < amt.length; i++){
                totalBal = totalBal + (parseFloat(truebal[i]) - parseFloat(amt[i]));
                // appr = appr + parseFloat(appro[i]);
            }
            // totalBal = parseFloat(appr) - parseFloat(tempAmount);
            $('input[name="total_line_'+b_num+'"]').val(formatNumberToMoney(totalBal));
        }
    }
    function InsModiItem()
    {
        var line = $('input[name="itm_line"]').val();
        var code = $('input[name="itm_code"]').val();
        var acc_title_desc = $('select[name="itm_acc_title"]').select2('data')[0].text;
        var acc_title_id = $('select[name="itm_acc_title"]').select2('data')[0].id;
        // var subgrpdesc = $('select[name="itm_ppa"]').select2('data')[0].text;
        var subgrpid = $('select[name="itm_ppa"]').select2('data')[0].id;
        var amt = $('input[name="itm_amt"]').val(); // balance
        var alot = $('input[name="itm_alot"]').val(); // allotment
        var table = $('#table_'+AllB_Num+'_' + subgrpid).DataTable();
        var truebal = $('input[name="true_bal"]').val();
        if($('#ItmForm').parsley().validate())
        {
            if($('#MOD_MODE').text() == '(ADD)')
            {
                // temp.row.add([
                //     i + 1,
                //     '<span class="cc_code" cc-code="'+data[i].at_code+'">'+data[i].at_code+'</span>',
                //     data[i].at_desc,
                //     '<center class="appro" appro="'+parseFloat(data[i].act_deduct)+'">'+formatNumberToMoney(parseFloat(data[i].act_deduct))+'</center>',
                //     '<center class="amt truebal" truebal="'+parseFloat(data[i].act_deduct)+'" amt="'+parseFloat(0)+'">'+formatNumberToMoney(parseFloat(0))+'</center>',
                //     '<center>' +
                //         '<a class="btn btn-social-icon btn-warning" id="edt_'+b_num+'_'+ppa+'_'+(i+1)+'" onclick="EditMode(\''+(i + 1)+'\', \''+data[i].at_code+'\', \''+parseFloat(data[i].appro_amnt)+'\', \''+data[i].subgrpid+'\', \''+parseFloat(0)+'\', \''+parseFloat(data[i].act_deduct)+'\', \''+b_num+'\');getIndexNow(\''+b_num+'_'+ppa+'_'+(i + 1)+'\', \'table_'+b_num+'_'+ppa+'\');"><i class="fa fa-pencil"></i></a>&nbsp;' +
                //     '</center>'
                // ]).draw();

                // alert('Added '+acc_title_desc+' to List');
                // EditMode(\''+(i + 1)+'\', \''+data[i].at_code+'\', \''+parseFloat(data[i].appro_amnt)+'\', \''+data[i].subgrpid+'\', \''+parseFloat(0)+'\', \''+parseFloat(data[i].act_deduct)+'\', \''+b_num+'\')
            } else if($('#MOD_MODE').text() == '(EDIT)'){
                if(parseFloat(amt) < parseFloat(alot) ){
                    alert('Allocated amount should not be greater than the remaining balance of the item');
                    $('input[name="itm_alot"]').focus();
                }
                else
                {
                    var newBal = parseFloat(truebal) - parseFloat(alot);
                    table.row(selectedId).data([
                     line,
                     '<span class="cc_code" cc-code="'+code+'">'+code+'</span>',
                     acc_title_desc,
                     '<center class="appro subgrpid" subgrpid="'+subgrpid+'" appro="'+parseFloat(newBal)+'">'+formatNumberToMoney(parseFloat(newBal))+'</center>',
                     '<center class="amt truebal" truebal="'+parseFloat(truebal)+'" amt="'+parseFloat(alot)+'">'+formatNumberToMoney(parseFloat(alot))+'</center>',
                     '<center>' +
                         '<a class="btn btn-social-icon btn-warning" id="edt_'+AllB_Num+'_'+subgrpid+'_'+line+'" onclick="EditMode( \''+line+'\', \''+acc_title_id+'\', \''+parseFloat(alot)+'\', \''+subgrpid+'\', \''+parseFloat(alot)+'\', \''+parseFloat(truebal)+'\', \''+AllB_Num+'\');getIndexNow(\''+AllB_Num+'_'+subgrpid+'_'+line+'\', \'table_'+AllB_Num+'_'+subgrpid+'\');"><i class="fa fa-pencil"></i></a>&nbsp;' +
                     '</center>'
                 ]).draw();
                alert('Successfully modified '+acc_title_desc+'.');
                }
                loadSubTotal(subgrpid, AllB_Num);
                loadTotal(AllB_Num);
                $('#modal-default').modal('toggle');
            }
            // loadSubTotal(subgrpid, AllB_Num);
            // loadTotal(AllB_Num);
            // $('#modal-default').modal('toggle');
        }
    }
    function SaveProposal()
    {
        // var apr_entries = []; selectedB_num
        var cost_centers = [];funds = [];sectors = []; ref_num = []; at_codes = []; amt = []; subgrpid = [];
        // HEADERS
        for(var i = 0; i <  selectedB_num.length; i++)
        {
            cost_centers.push($('input[name="hdr_cc_'+selectedB_num[i]+'"]').attr('hdr_cc_code_val'));
            funds.push($('input[name="hdr_fid_'+selectedB_num[i]+'"]').attr('hdr_fid_val'));
            sectors.push($('input[name="hdr_secid_'+selectedB_num[i]+'"]').attr('hdr_secid_val'));
            ref_num.push($('input[name="ref_val_'+selectedB_num[i]+'"]').val());

            var codes = $("#bodyDiv_"+selectedB_num[i]+" .cc_code").map(function(){return $(this).attr("cc-code");}).get();
             at_codes.push(codes);

            var temp_amt = $("#bodyDiv_"+selectedB_num[i]+" .amt").map(function(){return $(this).attr("amt");}).get();
            amt.push(temp_amt);

            var temp_subgrpid = $("#bodyDiv_"+selectedB_num[i]+" .subgrpid").map(function(){return $(this).attr("subgrpid");}).get();
            subgrpid.push(temp_subgrpid);
        }

        // for(var i = 0; i <  selectedB_num.length; i++){
        //      var codes = $("#bodyDiv_"+selectedB_num[i]+" .cc_code").map(function(){return $(this).attr("cc-code");}).get();
        //      at_codes.push(codes);
        // }

        var data = {
            _token : $('meta[name="csrf-token"]').attr('content'),
            codes : at_codes,
            amt : amt,
            subgrpid : subgrpid,
            fy : $('select[name="sel_fy"]').val(),
            fid : funds,
            cc_code : cost_centers,
            secid : sectors,
            bgtps_bnum : selectedB_num,
            ref_num : ref_num,
            mo1 : $('select[name="sel_frm"]').val(),
            mo2 : $('select[name="sel_to"]').val(),
        };

        $.ajax({
            url : '{{ url('budget/budget-approved-entry/save2') }}', method : 'POST', data : data,
            success : function(d){
                if(d == 'DONE'){
                                alert('Successfully Approved Budget Proposal');
                                location.href= "{{ url('budget/budget-approved-entry') }}";

                            } else {
                                alert('ERROR! an unknown error occured during saving process.');
                            }
            },
            error: function(a, b, c)
            {
                console.log(c);
            }
        });
    }
</script>
@endsection