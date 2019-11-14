@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Reports','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Collection','icon'=>'none','st'=>true],
        ['link'=>'#','desc'=>'Abstract Report','icon'=>'none','st'=>true]
    ];
    $_ch = "Statement of Collections"; // Module Name
@endphp
@section('content')
  @include('layout._contentheader')
  <section class="content">
      <div class="box box-default">
 
      <!-- /.box-header -->
      <div class="box-body" style="">
        <div class="col-md-6">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Period From<span class="text-danger">*</span></div>

                <input type="date" name="dateFrom" class="form-control" value="{{Date('Y-m-01')}}">

            </div>
            <div class="col-md-6">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Period To<span class="text-danger">*</span></div>

                <input type="date" name="dateTo" class="form-control" value="{{Date('Y-m-d')}}">

            </div>
            <div class="row" >
              <div class="col-md-4" style="padding-top: 1%;"></div>
              <div class="col-md-4" style="padding-top: 1%;"> <a id="generate" class="btn btn-block btn-primary">Generate Report</a></div>
              <div class="col-md-4" style="padding-top: 1%;"></div>
            </div>
      </div>
      <!-- /.box-body -->
    </div>

        
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
  <script type="text/javascript">
      
    $("#generate").click(function function_name (argument) {
      if($.trim($("[name=dateFrom]").val()) != "" && $.trim($("input[name=dateTo]").val())){
        $("#generate").attr('href','{{url('reports/collection/Statement-Of-Collection')}}'+ '/' + $.trim($("[name=dateFrom]").val()) +'/'+ $.trim($("input[name=dateTo]").val()))
      } else {
        alert('Please select all fields and try again.');
      }
    })
  </script>
@endsection