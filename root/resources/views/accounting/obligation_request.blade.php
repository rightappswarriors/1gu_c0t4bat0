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
              <a href="{{ asset('accounting/collection/obr_new') }}"><button type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> New OBR Entry</button></a>
            </div>
          </div>
          <div class="col-md-1">
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
          <div class="box-body">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th width="10%">Ref. #</th>
                <th>Payee</th>
                <th>Date</th>
                <th>Disbursement Link</th>
                <th width="10%">Options</th>
              </tr>
              </thead>
              <tbody>
                @if(count($collection) > 0) @foreach($collection AS $collectionEach)
                <tr>
                  <td>{{$collectionEach[0]->obr_ref}}</td>
                  <td>{{$collectionEach[0]->payee}}</td>
                  <td>{{$collectionEach[0]->t_date}}</td>
                  <td>{{$collectionEach[0]->j_code}}-{{$collectionEach[0]->j_num}}</td>
                  <td>@isset($collectionEach[0]->j_code) <a href="{{ asset('accounting/collection/obligation_request') }}/{{$collectionEach[0]->obr_code}}"><button class="btn btn-info"><i class="fa fa-file-text-o"></i></button></a> @else <a href="{{ asset('accounting/collection/obligation_request/edit') }}/{{$collectionEach[0]->obr_code}}"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a> @endisset</td>
                </tr>
                @endforeach @endif
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