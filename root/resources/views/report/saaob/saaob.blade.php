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
    <form id="generate-form" data-parsley-validate novalidate>
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
    </form>
    <hr>
    <div class="row">
      <div class="col-md-3">
        <button type="button" class="btn btn-block btn-success" onclick="generate();"><i class="fa fa-plus"></i> Generate SAAOB Report</button>
      </div>
    </div>

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