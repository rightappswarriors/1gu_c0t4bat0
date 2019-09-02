@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Options</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="">
        <div class="row">
          {{-- <div class="col-md-9">
          </div> --}}
          <div class="col-md-2">
            <div class="form-group">
              <center><label>&nbsp;</label></center>

            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group">
             {{--  <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button> --}}
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
      <div class="box box-default">
 
      <!-- /.box-header -->
      <div class="box-body" style="">
        <div class="col-md-4">
              <div class="col-md font-weight-bold" style="font-weight: bold;">FPP <span class="text-danger">*</span></div>

                <select name="fpp" class="form-control" style="width: 100%" data-parsley-required-message="<strong>FPP</strong> is required." required>
                  <option value="" hidden disabled selected>Please Select</option>
                  @isset($dataAll[0])
                    @foreach($dataAll[0] as $cc)
                    <option value="{{$cc}}">{{$cc}}</option>
                    @endforeach
                  @endisset
                </select>

            </div>
            <div class="col-md-4">
              <div class="col-md font-weight-bold" style="font-weight: bold;">CC Code <span class="text-danger">*</span></div>

                <select name="cc_code" class="form-control" style="width: 100%" data-parsley-required-message="<strong>CC Code</strong> is required." required>
                  <option value="" hidden disabled selected>Please Select</option>
                  @isset($dataAll[1])
                    @foreach($dataAll[1] as $cc)
                    <option value="{{$cc}}">{{$cc}}</option>
                    @endforeach
                  @endisset
                </select>
            </div>
            <div class="col-md-4">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Date <span class="text-danger">*</span></div>

                <select name="date" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Date</strong> is required." required>
                  <option value="" hidden disabled selected>Please Select</option>
                  @isset($dataAll[2])
                    @foreach($dataAll[2] as $cc)
                    <option value="{{$cc}}">{{$cc}}</option>
                    @endforeach
                  @endisset
                </select>
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
      if($.trim($("select[name=fpp]").val()) != "" && $.trim($("select[name=cc_code]").val()) && $.trim($("select[name=date]").val())){
        $("#generate").attr('href','{{url('reports/budget/rao/')}}'+ '/' + $.trim($("select[name=fpp]").val()) +'/'+ $.trim($("select[name=cc_code]").val()) + '/' + $.trim($("select[name=date]").val()))
      } else {
        alert('Please select all fields and try again.');
      }
    })
  </script>
@endsection