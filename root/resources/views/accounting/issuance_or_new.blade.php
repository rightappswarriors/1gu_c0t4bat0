@extends('_main')
@section('content')
<style>
  .select2-container--default .select2-selection--single {
    height: 37px !important;
    padding: 10px 25px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 6px;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow b {
      top: 75% !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 20px !important;
  }
  .select2-container--default .select2-selection--single {
      border: 1px solid #CCC !important;
      box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
      transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
  }
</style>
  @include('layout._contentheader')
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <center>
          <h2 class="box-title">Republic of the Philippines</h2><br>
          <h2 class="box-title">Province of Negros Oriental</h2><br>
          <h3 class="box-title"><b>City of Guihulngan</b></h3>
        </center>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
        </div>
      </div>
      <form method="POST">
        {{csrf_field()}}
        <!-- /.box-header -->
        <div class="box-body">
          <div id="dbsErr"></div>
          <div class="row">
            <div class="col-md-12">
              <center><label>ISSUANCE OR</label></center>
            </div>
          </div>
          <hr>
          {{-- issued Date --}}
          <div class="row">
            <div class="col-md-1 p-3">
              <label for="dIssue">Date Issued</label>
            </div>
            <div class="col-md-4">
              <input type="date" value="{{Date('Y-m-d',strtotime('now'))}}" class="form-control" name="date_issued" id="dIssue">
            </div>
          </div>
          {{-- forms --}}
          <div class="row">
            <div class="col-md-1 p-3">
              <label for="or_form">OR Forms</label>
            </div>
            <div class="col-md-4">
               <select class="form-control" name="or_type" id="or_form">
                <option value hidden selected disabled>Select OR Types</option>
                @isset($or_types)
                  @foreach($or_types AS $each)
                  <option value="{{$each->or_type}}">{{$each->or_code}}</option>
                  @endforeach
                @endisset
              </select>
            </div>
          </div>
          {{-- OR FROM AND TO --}}
          
          <div class="row">
            <div class="col-md-6" style="padding-left: 0px!important;">
              <div class="col-md-2 p-2">
                <label for="orFrom" class="pl-1">OR Number From</label>
              </div>
              <div class="col-md-8">
                <input type="number" class="form-control" name="or_no" placeholder="OR No. From" id="orFrom">
              </div>
            </div>
            <div class="col-md-6" style="padding-left: 0px!important;">
              <div class="col-md-1 pt-2">
                <label for="orTo" class="pl-1">To</label>
              </div>
              <div class="col-md-11">
                <input type="number" class="form-control" name="or_no_to" placeholder="OR No. To" id="orTo">
              </div>
            </div>
          </div>

          {{-- Collector --}}
          <div class="row">
            <div class="col-md-1 p-3">
              <label for="collector">Collector</label>
            </div>
            <div class="col-md-4">
               <select class="form-control" name="collector" id="collector">
                <option value hidden selected disabled>Select Cashier</option>
                @isset($cashiers)
                @foreach($cashiers AS $cashierseach)
                <option value="{{$cashierseach->uid}}">{{$cashierseach->opr_name}}</option>
                @endforeach
                @endisset
              </select>
            </div>
          </div>


          <div class="row mt-5">
            <div class="col-md-1 p-3">
              <label for="cUser">Current User</label>
            </div>
            <div class="col-md-4 pt-3" style="font-weight: bolder;">
              <span id="cUser">{{$user['opr_name'] ?? 'NOT SET'}}</span>
            </div>
          </div>
          

        </div>
        <div class="box-footer">
          <div class="pull-left">
            <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Submit form</button>
          </div>
          <div class="pull-right">
            <a href="{{ asset('accounting/collection/or_issuance') }}"><button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</button></a>
          </div>
        </div>
      </form>
    </div>
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
  <script type="text/javascript">
    @isset($or_issuance) @if(count($or_issuance) > 0)
    document.getElementsByName('or_type')[0].value = "{{$or_issuance[0]->or_type}}";
    document.getElementsByName('date_issued')[0].value = "{{$or_issuance[0]->date_issued}}";
    document.getElementsByName('or_no')[0].value = "{{$or_issuance[0]->or_no}}";
    document.getElementsByName('or_no_to')[0].value = "{{$or_issuance[0]->or_no_to}}";
    document.getElementsByName('collector')[0].value = "{{$or_issuance[0]->collector}}";
    @endif @endisset
    @if($message != "")
    insErrMsg('warning', "{{$message}}", 'dbsErr');
    @endif
  </script>
@endsection