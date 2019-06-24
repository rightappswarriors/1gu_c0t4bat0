@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("inventory/receiving_po"),'desc'=>'Acknowledgement Receipt Equipment','icon'=>'none','st'=>true]
    ];
    $_ch = "Acknowledgement Receipt Equipment"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <table id="tbl_list" class="table table-bordered table-striped">
                <thead>
                <tr><th colspan="7"><center><h3>ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</h3><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center></th>
                </tr>
              </thead>
              <thead>
                <tr>
                     <th>Item No.</th>
                     <th>QTY</th>
                     <th>UNIT</th>
                     <th>DESCRIPTION</th>
                     <th>SERIAL NO./PROPERTY NO.</th>
                     <th>UNIT COST</th>
                     <th>AMOUNT</th>
                </tr>
              </thead>
                <tbody>
                @foreach($reclne as $rl)
                <tr>
                     <td>{{$rl->ln_num}}</td>
                     <td>{{$rl->qty}}</td>
                     <td>{{$rl->unit_desc}}</td>
                     <td>{{$rl->item_desc}}</td>
                     <td>{{$rl->item_code}}</td>
                     <td>{{$rl->price}}</td>
                     <td>{{$rl->ln_amnt}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="7">Location/Office:</th>
                  </tr>
                  <tr>
                    <th colspan="4">Received From:</th>
                    <th colspan="4">Received By:</th>
                  </tr>
                </tfoot>
              </table>
        </div>
      </div>
      
    </section>

    <script>
     window.onload = function() { window.print(); }
    </script>
	
@endsection