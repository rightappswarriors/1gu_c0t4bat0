@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Acknowledgement Receipt Equipment','icon'=>'none','st'=>true]
    ];
    $_ch = "Acknowledgement Receipt Equipment"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
        <!-- Main content -->
        <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Acknowledgement Receipt Equipment List</h3>
              <a href="{{route('inventory.are_add')}}"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create</button></a>
              <!-- <button class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tbl_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code #</th>
                  <th>Reference</th>
                  {{-- <th>RIS NO</th>
                  <th>SAI NO</th> --}}
                  <th>Date</th>
                  <th>Office</th>
                  <!-- <th>Stock Location</th>
                  <th>Branch</th> -->
                  <th>Request</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data as $d)
                <tr>
                  <td>{{$d->rec_num}}</td>
                  <td>{{$d->_reference}}</td>
                  {{-- <td>{{$d->ris_no}}</td>
                  <td>{{$d->sai_no}}</td> --}}
                  <td>{{$d->trnx_date}}</td>
                  <td>{{$d->cc_code}}</td>
                  <!-- <td>{{$d->whs_code}}</td>
                  <td>{{$d->branch}}</td> -->
                  <td>{{$d->recipient}}</td>
                  <td>
                    <center>
                      <a class="btn btn-social-icon btn-warning" href="{{route('inventory.are_edit', $d->rec_num)}}"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-social-icon btn-primary" href="{{route('inventory.are_print', $d->rec_num)}}"><i class="fa fa-print"></i></a>&nbsp;
                      <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#cancel-modal"><i class="fa fa-close"></i></a>
                    </center>  
                  </td>
                </tr>
                @endforeach
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
      <div class="row">
      <div class="modal fade in" id="approve-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Approve Transaction</h4>
            </div>
            <div class="modal-body">
              <center>
                  <h4 class="text-transform: uppercase;">Are you sure you want to approve this transaction?
                  </h4>
              </center>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="approve()">Yes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      </div>

      <div class="row">
      <div class="modal fade in" id="cancel-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Cancel Transaction</h4>
            </div>
            <div class="modal-body">
              <center>
                  <h4 class="text-transform: uppercase;">Are you sure you want to cancel this transaction?
                  </h4>
              </center>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="cancel()">Yes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      </div>

      <script>
        
        var selectedRow = 0;

        $('#tbl_list').on( 'click', 'tr', function () {
                
                var tbl_list = $('#tbl_list').DataTable();
                selectedRow = tbl_list.row( this ).index() ;

                console.log('rowindex: '+selectedRow);
            } );

        function approve()
        {
           var tbl_list = $('#tbl_list').DataTable();
           var data = tbl_list.row(selectedRow).data();
           var code = data[0];
           
           $.ajax({
                     url: '{{asset('inventory/are/are_approve')}}/'+code,
                     method: 'GET',
                     success: function(flag)
                              {
                                if(flag == 'true')
                                {
                                  console.log(flag);
                                  location.href = "{{route('inventory.are')}}";
                                }
                                else
                                {
                                  console.log(flag);
                                  alert('ERROR.');
                                }
                              } 

                  });
        }

        function cancel()
        {
           var tbl_list = $('#tbl_list').DataTable();
           var data = tbl_list.row(selectedRow).data();
           var code = data[0];
           
           $.ajax({
                     url: '{{asset('inventory/are/are_cancel')}}/'+code,
                     method: 'GET',
                     success: function(flag)
                              {
                                if(flag == 'true')
                                {
                                  console.log(flag);
                                  location.href = "{{route('inventory.are')}}";
                                }
                                else
                                {
                                  alert('SYSTEM ERROR:\n'+flag);
                                }
                              } 

                  });
        }

      </script>
    </section>
	
@endsection