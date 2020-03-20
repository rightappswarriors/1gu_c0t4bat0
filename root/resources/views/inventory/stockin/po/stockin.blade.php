@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Stock In','icon'=>'none','st'=>true]
    ];
    $_ch = "Stock In"; // Module Name
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
              
              <div class="row">
                <div class="col-sm-6">
                  <div class="col-sm-12">
                       <h3 class="box-title">Stock In List</h3>
                       <a href="{{route('inventory.stockinpo_add')}}"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create</button></a>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="col-sm-1">
                      <label>From:</label> 
                  </div>  
                  <div class="col-sm-5">
                      <input type="date" name="dtp_frmdate" class="form-control pull-right" id="datepicker" onchange="onchangedt()" value="{{$dtfrm}}">
                  </div>
                  <div class="col-sm-1">
                      <label>To:</label> 
                  </div>  
                  <div class="col-sm-5">
                      <input type="date" name="dtp_todate" class="form-control pull-right" id="datepicker" onchange="onchangedt()" value="{{$dtto}}">
                  </div>
                </div>
              </div>

              <!-- <button class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tbl_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Purchase No</th>
                  <th>Supplier</th>
                  <th>Reference</th>
                  <th>Purchase Date</th>
                  <th>User ID</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                 {{--  @foreach($data as $d)
                <tr>
                  <td>{{$d->rec_num}}</td>
                  <td>{{$d->purc_ord}}</td>
                  <td>{{$d->supl_name}}</td>
                  <td>{{$d->_reference}}</td>
                  <td>{{$d->trnx_date}}</td>
                  <td>{{$d->recipient}}</td>
                  <td>
                    <center><a class="btn btn-social-icon btn-primary" href="{{route('inventory.stockin_print', $d->rec_num)}}"><i class="fa fa-print"></i></a>&nbsp;<a class="btn btn-social-icon btn-warning" href="{{route('inventory.stockin_edit', $d->rec_num)}}"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#cancel-modal"><i class="fa fa-close"></i></a></center></td>
                </tr>
                @endforeach --}}
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
           var code = data[0];
           
           $.ajax({
                     url: '{{asset('inventory/stockinpo/stockin_cancel')}}/'+code,
                     method: 'GET',
                     success: function(flag)
                              {
                                if(flag == 'true')
                                {
                                  console.log(flag);
                                  location.href = "{{route('inventory.stockinpo')}}";
                                }
                                else
                                {
                                  alert('SYSTEM ERROR:\n'+flag);
                                }
                              } 

                  });
        }

        function onchangedt()
        {
             var frmdt = $('input[name="dtp_frmdate"]').val();
             var todt = $('input[name="dtp_todate"]').val();

             var date = [frmdt, todt];

             var tbl_list = $('#tbl_list').DataTable();

             if(!Date.parse(frmdt))
             {
               alert('Selected From Date is invalid.');
             }
             else if(!Date.parse(todt))
             {
               alert('Selected To Date is invalid.');
             }
             else
             {
                tbl_list.clear().draw();
             
                $.ajax({
                   url: '{{asset('inventory/stockinpo/view')}}/'+date,
                   success: function(data)
                   {
                     console.log(data);
                     if(data.length > 0)
                     {
                       for(var i = 0; i < data.length; i++)
                       {
                          rec_num = data[i]["rec_num"];
                          purc_ord = data[i]["purc_ord"];
                          supl_name = data[i]["supl_name"];
                          reference = data[i]["_reference"];
                          trnx_date = data[i]["trnx_date"];
                          recipient = data[i]["recipient"];

                          //print = "route('inventory.stockin_print', "+rec_num+")";

                          buttons = '<center><a class="btn btn-social-icon btn-primary" href="{{asset('inventory/stockinpo/stockin_print')}}/'+rec_num+'"><i class="fa fa-print"></i></a>&nbsp;<a class="btn btn-social-icon btn-warning" href="{{asset('inventory/stockinpo/stockin_edit')}}/'+rec_num+'"><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#cancel-modal"><i class="fa fa-close"></i></a></center></td>';

                          tbl_list.row.add([rec_num, purc_ord, supl_name, reference, trnx_date, recipient, buttons]).draw();
                       }
                     }
                   }
                });
             }
        }

        window.onload = function() 
        {
          onchangedt(); 
        }

      </script>
    </section>
	
@endsection