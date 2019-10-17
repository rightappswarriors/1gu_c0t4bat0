@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Generate Biology Report','icon'=>'none','st'=>true]
    ];
    $_ch = "Biology Report"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
 <div class="box box-default">
 <div class="box-header with-border">
    <br>
    <form id="generate-form" action="{{route('report.generatebioreport')}}" method="POST" data-parsley-validate novalidate>
    {{csrf_field()}}
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label>Kind Of Animal</label>
            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="koa" data-parsley-errors-container="#validate_select_fy" data-parsley-required-message="<strong>Kind of Animal is required.</strong>" required>
              <option value="" selected="selected">--- Select Kind Of Animal ---</option>
              @foreach($data as $d)
              <option value="{{$d->kindofanimals}}">{{$d->kindofanimals}}</option>
              @endforeach
            </select>
            <span class="validate_select_fy"></span>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="form-group">
          <label>Fund</label>
            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="fund" data-parsley-errors-container="#validate_select_fund" data-parsley-required-message="<strong>Fund is required.</strong>" required>
              <option value="" selected="selected">--- Select Fund ---</option>
              @foreach($data as $f)
              <option value="{{$f->fund}}">{{$f->fund}}</option>
              @endforeach
            </select>
            <span class="validate_select_fund"></span>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-3">
        <button type="submit" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Generate Biology Report</button>
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
                     koa: $('select[name="koa"]').val(),
                     fund: $('select[name="fund"]').val(),
                   };
        $.ajax({
                 url: '{{route('report.generatebioreport')}}',
                 method: 'POST',
                 data: data,
                 success : function(flag)
                          {
                             if(flag == 'true')
                             {
                               //location.href= "{{route('report.generatebioreport')}}";
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