@extends('_main')
@section('content')
  @include('layout._contentheader')
  <section class="content">
      <div class="box box-default">
 
      <!-- /.box-header -->
      <div class="box-body" style="">
        <div class="col-md-6">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Collector <span class="text-danger">*</span></div>

                <select name="fpp" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Collector</strong> is required." required>
                  <option value="" hidden disabled selected>Please Select</option>
                  @isset($collectors)
                    @foreach($collectors as $cc)
                    <option value="{{$cc->uid}}">{{$cc->opr_name}}</option>
                    @endforeach
                  @endisset
                </select>

            </div>
            <div class="col-md-6">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Date of Transaction <span class="text-danger">*</span></div>

                <input type="date" name="date" class="form-control" value="{{Date('Y-m-d')}}">

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
      if($.trim($("select[name=fpp]").val()) != "" && $.trim($("input[name=date]").val())){
        $("#generate").attr('href','{{url('reports/collection/RocadDailyUser')}}'+ '/' + $.trim($("select[name=fpp]").val()) +'/'+ $.trim($("input[name=date]").val()))
      } else {
        alert('Please select all fields and try again.');
      }
    })
  </script>
@endsection