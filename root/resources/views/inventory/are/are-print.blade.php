@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("inventory/are"),'desc'=>'Acknowledgement Receipt Equipment','icon'=>'none','st'=>true]
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
                <tr>
                  <div class="image">
                  <th>
                    <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" style="max-width: 90px;"></th>
                  <th colspan="6">
                    <center><h3>ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</h3><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center></th>
                  <th><img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" style="max-width: 85px;"></th>
                </div>
                </tr>
              </thead>
              <thead>
                <tr>
                     <th>Item No.</th>
                     <th>QTY</th>
                     <th>UNIT</th>
                     <th>DESCRIPTION</th>
                     <th>SERIAL NO.</th>
                     <th>PROPERTY NO.</th>
                     <th>UNIT COST</th>
                     <th>AMOUNT</th>
                </tr>
              </thead>
                <tbody>
                @foreach($are as $a)
                <tr>
                     <td>{{$a->ln_num}}</td>
                     <td>{{$a->qty}}</td>
                     <td>{{$a->unit_desc}}</td>
                     <td>{{$a->item_desc}}</td>
                     <td>{{$a->serial_no}}</td>
                     <td>{{$a->part_no}}</td>
                     <td>{{$a->price}}</td>
                     <td>{{$a->ln_amnt}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="8">Office/Department:</th>
                  </tr>
                  <tr>
                    <th colspan="3">Received From:</th>
                    <th colspan="2">Received By:</th>
                    <th colspan="3">Issued To:</th>
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