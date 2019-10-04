@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">List of liquidated cash</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Collector Name</th>
                <th width="10%">Options</th>
              </tr>
              </thead>
              <tbody>
                @isset($collectors) @foreach($collectors AS $each)
                <tr>
                  <td>{{$each->opr_name}}</td>
                  <td>
                    <a href="{{ url('collection/Bank-Deposit/') }}/{{$each->liquidateid}}"><button class="btn btn-primary"><i class="fa fa-files-o"></i></button></a>
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