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
                    <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" style="max-width: 85px;"></th>
                  <th colspan="8">
                    <center><h3>ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</h3><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center></th>
                  <th><img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" style="max-width: 85px;"></th>
                </div>
                </tr>
              </thead>
          </table>

          <table class="table table-bordered table-striped">
            <thead>
            <tr>
                 <th>Item No.</th>
                 <th>Qty</th>
                 <th>Unit</th>
                 <th>Description</th>
                 <th>Serial No.</th>
                 <th>Property No.</th>
                 <th>Unit Cost</th>
                 <th>Amount</th>
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
          </table>

          <table class="table table-bordered table-striped">
            <tfoot>
              <tr>
                <th colspan="8">Office/Department: {{$are_header->office}}</th>
              </tr>
            </tfoot>
          </table>

          <table class="table table-bordered table-striped">
            <tr>
             <th colspan="3">Received From:</th>
             <th colspan="2">Received By: </th>
             <th colspan="3">Issued To:</th>
           </tr>
           <tr>
             <th colspan="3">
              <br>
               <center><u>{{$are_header->receivedfrom}}</u></center></div><div><center>{{$are_header->receivedfromdesig}}</center></div>
             </th>
             <th colspan="2">
              <br>
               <div><center><u>{{$are_header->receivedby}}</u></center></div><div><center>{{$are_header->receivedbydesig}}</center></div>
             </th>
             <th colspan="3">
              <br>
               <center><u>{{$are_header->issuedto}}</u></center></div><div><center>{{$are_header->issuedtodesig}}</center></div>
             </th>
           </tr>
           <tr>
             <th colspan="3">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
             <th colspan="2">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
             <th colspan="3">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
           </tr>
          </table>
        </div>
      </div>
      
    </section>

    <style>
      @media print {
        * {

        }
        #Header, #Footer {display: none ! important;}

        #sidebar-parent {
          display: none;
        }

        #print_hide, #print_name_hide {
          display: none;
        }
      }
    </style>
    <script>

     window.onload = function() 
     {
       window.print(); 
       location.href= "{{route('inventory.are')}}";
     }


    </script>
	
@endsection