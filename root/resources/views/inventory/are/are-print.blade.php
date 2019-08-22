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
      <div class="graph-image graph-7">
        <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" />
      </div>
      <div class="row" >
        <div class="col-sm-12" >
          <table style="border: 1px solid #000;"  id="tbl_list" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <div class="image">
                  <th style="border: none !important;">
                    <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" style="max-width: 85px;"></th>
                  <th style="border: none !important;">
                    <center><h3>ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</h3><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center></th>
                  <th style="border: none !important;"><img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" style="max-width: 85px;"></th>
                </div>
                </tr>
              </thead>
          </table>

          <table  class="table table-bordered table-striped">
            <thead>
            <tr>
                 <th style="white-space: nowrap;font-size:14px;">Item #</th>
                 <th style="white-space: nowrap;font-size:14px;">Qty</th>
                 <th style="white-space: nowrap;font-size:14px;">Unit</th>
                 <th style="width:50%;font-size:15px;">Description</th>
                 <th  style="width:25%;font-size:15px;">Serial No.</th>
                 <th style="width:25%;font-size:15px;">Property No.</th>
                 <th style="white-space: nowrap;font-size:14px;">Unit Cost</th>
                 <th style="white-space: nowrap;font-size:14px;">Amount</th>
            </tr>
          </thead>
            <tbody>
            @foreach($are as $a)
            <tr>
                 <td>{{$a->ln_num}}</td>
                 <td>{{$a->qty}}</td>
                 <td>{{$a->unit_desc}}</td>
                 <td><textarea>{{$a->item_desc}}</textarea></td>
                 <td>{{$a->serial_no}}</td>
                 <td>{{$a->part_no}}</td>
                 <td>{{$a->price}}</td>
                 <td>{{$a->ln_amnt}}</td>
            </tr>
            @endforeach
            </tbody>
          </table>

          <table  class="table table-bordered table-striped">
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
               <center><u>{{$are_header->receivedfrom}}</u></center><div><center>{{$are_header->receivedfromdesig}}</center></div>
             </th>
             <th colspan="2">
              <br>
               <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div>
             </th>
             <th colspan="3">
              <br>
               <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div>
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
              .table td{
        background-color: transparent !important;
        border: 1px solid #000 !important;
      }
       .table th{
        background-color: transparent !important;
        border: 1px solid #000 !important;
      }
        * {

        }
        
        #Header, #Footer {display: none ! important;}

        #sidebar-parent {
          display: none;
        }

        #print_hide, #print_name_hide {
          display: none;
        }
         .graph-image img{
        opacity: 0.2; /* set your opacity */ 
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        left:0;
      }
      } 
      textarea {
    border: none;
    overflow: hidden;
    outline: none;

    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    scroll-behavior: none;

    resize: none; /*remove the resize handle on the bottom right*/
    }
      .graph-7{background: url({{url('images/Carabao.jpg')}}) no-repeat;}
    </style>

    <script>
    
    window.onload = function() 
     {
       $('textarea').each(function() {
        $(this).height($(this).prop('scrollHeight'));
        });

       // window.print(); 
       // location.href= "{{route('inventory.are')}}";
     }

    </script>
	
@endsection