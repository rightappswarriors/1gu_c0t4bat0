@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Generate SAAOB Report','icon'=>'none','st'=>true]
    ];
    $_ch = "SAAOB Report"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
 <div class="box box-default">
 <div class="box-header with-border">
    <br>
    <form id="generate-form" action="{{route('report.generatesaaob')}}" method="POST" data-parsley-validate novalidate>
    {{csrf_field()}}
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label>Financial Year</label>
            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_fy" data-parsley-errors-container="#validate_select_fy" data-parsley-required-message="<strong>Financial Year is required.</strong>" required>
              <option value="" selected="selected">--- Select Financial Year ---</option>
              @foreach($financialyear as $fy)
              <option value="{{$fy->fy}}">{{$fy->fy}}</option>
              @endforeach
            </select>
            <span class="validate_select_fy"></span>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="form-group">
          <label>Fund</label>
            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_fund" data-parsley-errors-container="#validate_select_fund" data-parsley-required-message="<strong>Fund is required.</strong>" required>
              <option value="" selected="selected">--- Select Fund ---</option>
              @foreach($fund as $f)
              <option value="{{$f->fid}}">{{$f->fdesc}}</option>
              @endforeach
            </select>
            <span class="validate_select_fund"></span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
          <div class="form-group">
              <label>From</label>
              <select type="text" class="form-control" name="mo1" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_from_span" aria-hidden="true" data-parsley-required-message="<strong>From month</strong> is required." required>
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
              <select type="text" class="form-control" name="mo2" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_to_span" aria-hidden="true" data-parsley-required-message="<strong>To month</strong> is required." required>
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
    </div>
    <hr>
    <div class="row">
      <div class="col-md-3">
        <button type="submit" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Generate SAAOB Report</button>
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

function generate()
{
     if($('#generate-form').parsley().validate()) // check appro form
     {
        var data = { 
                     _token : $('meta[name="csrf-token"]').attr('content'),
                     fy: $('select[name="select_fy"]').select2('data')[0].id,
                     fund: $('select[name="select_fund"]').select2('data')[0].id,
                   };
        $.ajax({
                 url: '{{route('report.generatesaaob')}}',
                 method: 'POST',
                 data: data,
                 success : function(flag)
                          {
                             if(flag == 'true')
                             {
                               //location.href= "{{route('budget.allotment')}}";
                             }
                             else
                             {
                               alert('SYSTEM ERROR:\n'+flag);
                             }
                          }
                 });           
     }
}

</script>
</section>
@endsection