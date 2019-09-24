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
          <div class="col-md-3">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <a href="{{ asset('accounting/collection/or_issuance/new') }}"><button type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> New OR Issuance</button></a>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Disbursement Record</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th width="10%">Type</th>
                <th>Official Receipt / Serial No. From</th>
                <th>Official Receipt / Serial No. To</th>
                <th>Collector</th>
                <th width="10%">Options</th>
              </tr>
              </thead>
              <tbody>
                @isset($or_issuance) @foreach($or_issuance AS $each)
                <tr>
                  <td>{{$each->or_code}}</td>
                  <td>{{$each->or_no}}</td>
                  <td>{{$each->or_no_to}}</td>
                  <td>{{$each->opr_name}}</td>
                  <td>
                    <a href="{{ asset('accounting/collection/or_issuance') }}/{{$each->transid}}"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>
                @endforeach
                @else
                @endisset
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">

  </script>
@endsection