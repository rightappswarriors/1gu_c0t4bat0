@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Biological Acquisition','icon'=>'none','st'=>true]
    ];
    $_ch = "Biology"; // Module Name
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
              <h3 class="box-title">Create Acquisition List</h3>
              <a href="{{route('inventory.biologyacqusition_add')}}"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create</button></a>
              <!-- <button class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tbl_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Item Code</th>
                  <th>Fund</th>
                  <th>Kind Of Animals</th>
                  <th>Reference</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data as $d)
                <tr>
                  <td>{{$d->code}}</td>
                  <td>{{$d->fund}}</td>
                  <td>{{$d->kindofanimals}}</td>
                  <td>{{$d->reference}}</td>
                  <td>
                    <center><a class="btn btn-social-icon btn-warning" href="{{route('inventory.biologyacqusition_edit', $d->code)}}"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#cancel-modal"><i class="fa fa-close"></i></a></center></td>
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

        $(document).ready(function() {

      $('#tbl_list').DataTable( {
        "columnDefs": [
            {
                "targets": [ 0 ], // hide unit code col
                "visible": false,
                "searchable": false
            }
        ]
      } );
      } );
        
        var selectedRow = 0;

        $('#tbl_list').on( 'click', 'tr', function () {
                
                var tbl_list = $('#tbl_list').DataTable();
                selectedRow = tbl_list.row( this ).index() ;

                console.log('rowindex: '+selectedRow);
            } );

        function cancel()
        {
           var tbl_list = $('#tbl_list').DataTable();
           var data = tbl_list.row(selectedRow).data();
           var id = data[0];
           
           $.ajax({
                     type: 'POST',
                     url: '{{route('inventory.bioAcq_cancel')}}',
                     data : {code: id},
                     dataTy : 'json',
                     success: function(flag)
                      {
                        if(flag == 'true')
                        {
                          console.log(flag);
                          location.reload();
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