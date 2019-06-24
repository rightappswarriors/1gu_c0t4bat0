@extends('_main')
@section('content')
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
        <div class="box-body" style="">
          <div id="dbsErr"></div>
          <div class="row">
            <div class="col-md-9">
              <center><label>ISSUANCE OR</label></center>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-8">
              <select class="form-control" name="or_type">
                <option value hidden selected disabled>Select OR Types</option>
                @foreach($or_types AS $each)
                <option value="{{$each->or_type}}">{{$each->or_code}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <input type="date" class="form-control" name="date_issued">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <input type="number" class="form-control" name="or_no" placeholder="OR No. From">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <input type="number" class="form-control" name="or_no_to" placeholder="OR No. To">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              {{-- <input type="number" class="form-control" name="collector" placeholder="Collector"> --}}
              <select class="form-control" name="collector">
                <option value hidden selected disabled>Select Cashier</option>
                @foreach($cashiers AS $cashierseach)
                <option value="{{$cashierseach->uid}}">{{$cashierseach->opr_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          {{-- <hr>
          <div class="row">
            <div class="col-md-12">
              <input type="number" class="form-control" name="amount" placeholder="Amount">
            </div>
          </div> --}}
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