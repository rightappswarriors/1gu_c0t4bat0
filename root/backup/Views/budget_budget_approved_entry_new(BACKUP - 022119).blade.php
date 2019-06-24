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
                            <select type="text" class="form-control" name="sel_fy" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_fy_span" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." required>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button type="button" onclick="SearchNow();" class="btn form-control btn-info"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button type="button" onclick="LoadData()" class="btn form-control btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Load</button>
                            </div>
                        </div>
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
                            <th width="20%">Reference #</th>
                            <th>Cost Center</th>
                            <th>Sector</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <span id="AllDataHere">
        
    </span>
</section>
<!-- /.content -->
<script>
    $(document).ready(function(){
        $('table').DataTable();
        @isset($fy)
            $('select[name="sel_fy"]').val('{{$fy}}').trigger('change');
        @else
            $('select[name="sel_fy"]').val('').trigger('change');
        @endisset
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
    });
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
                                '<center><input class="chcBx" type="checkbox" name="sel_bnum[]" b_num="'+data[i].b_num+'"></center>',
                                data[i].b_num,
                                data[i].cc_desc,
                                data[i].secdesc,
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
       var test =  $(".chcBx:checked").map(function(){return $(this).attr("b_num");}).get();
       if(test.length != 0)
       {
            $('#my-box-widget').boxWidget('toggle');
            $.ajax({
                url : "{{url('budget/budget-approved-entry/getProposalEntries2')}}",
                data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : test},
                method : 'POST',
                success: function(data){
                    if(data.length > 0)
                    {
                        $('#AllDataHere').empty();
                        for(var i = 0; i < test.length;i++)
                        {
                            $('#AllDataHere').append
                            (
                                '<div class="box box-default" id="box_'+test[i]+'">' +
                                    '<div class="box-header with-border">' +
                                        '<h3 class="box-title">'+test[i]+'</h3>' + 
                                            '<div class="box-tools pull-right">' +
                                                '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>' +
                                            '</div>' +
                                    '</div>' +
                                    '<div class="box-body" style="">' +
                                        '<div class="row">' +
                                            '<div class="col-md-3">' +
                                                '<div class="form-group">' +
                                                    '<label></label>' +
                                                    '<input type="text" class="form-control" name="" disabled>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>'
                            );
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
</script>
@endsection