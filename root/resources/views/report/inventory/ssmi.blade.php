@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Reports','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'','desc'=>'SSMI Report','icon'=>'none','st'=>true]
    ];
    $_ch = "SUMMARY OF SUPPLIES AND MATERIALS ISSUED REPORT"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
 <div class="box box-default">
 <div class="box-header with-border">
    <br>
    <form id="generate-form" action="{{route('inventoryreports.ssmiprint')}}" method="POST" data-parsley-validate novalidate>
    {{csrf_field()}}
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label>From Date :</label>
          <span id="validate_dtpfrmdate"></span>
          <input type="date" name="dtp_frmdate" class="form-control pull-right" id="datepicker" data-parsley-errors-container="#validate_dtpfrmdate" data-parsley-required-message="<strong>From Date is required.</strong>" required>
        </div>
      </div>  
      <div class="col-sm-3">
        <div class="form-group">
          <label>To Date :</label>
          <span id="validate_dtptodate"></span>
          <input type="date" name="dtp_todate" class="form-control pull-right" id="datepicker" data-parsley-errors-container="#validate_dtptodate" data-parsley-required-message="<strong>To Date is required.</strong>" required>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-5">
        <div class="form-group">
          <label>Item Category</label>
            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_itmgrp" data-parsley-errors-container="#validate_select_itmgrp" data-parsley-required-message="<strong>Item Category is required.</strong>" required>
              <option value="" selected="selected">--- Select Fund ---</option>
              @foreach($itmgrp as $ig)
              <option value="{{$ig->item_grp}}">{{$ig->grp_desc}}</option>
              @endforeach
            </select>
            <span class="validate_select_itmgrp"></span>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-3">
        <button type="submit" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Generate SSMI Report</button>
      </div>
    </div>
    </form>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
 </div>
 <!-- /.box-header -->
 <div class="box-body" style="">
 </div>
 <!-- /.box-body -->
 <!-- /.row -->
</div>

<script>

</script>
</section>
@endsection