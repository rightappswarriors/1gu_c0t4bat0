@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Requisition Issuance Slip','icon'=>'none','st'=>true]
    ];
    $_ch = "Requisition Issuance Slip"; // Module Name
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
		                    <center><h3>REQUISTION AND ISSUANCE SLIP</h3><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center></th>
		                  <th style="border: none !important;"><img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" style="max-width: 85px;"></th>
		                </div>
		                </tr>
		              </thead>
		          </table>

		          <table  class="table table-bordered table-striped">
		            <thead>
		            <tr>
		                 <th style="white-space: nowrap;font-size:14px;"><center>Stock</center> No.</th>
		                 <th style="white-space: nowrap;font-size:14px;"><center>Unit</center></th>
		                 <th style="width:50%;font-size:15px;"><center>Description</center></th>
		                 <th nowspan style="width:25%;font-size:15px;"><center>Quantity</center></th>
		                 <th nowspan style="width:25%;font-size:15px;"><center>Quantity</center></th>
		                 <th style="width:25%;font-size:15px;"><center>Remarks</center></th>

		            </tr>
		          </thead>
		            <tbody>
	              @foreach($reclne as $rl)
		            <tr>
		                 <td>{{$rl->ln_num}}</td>
		                 <td>{{$rl->unit_desc}}</td>
		                 <td>{{$rl->item_desc}}</td>
		                 <td>{{$rl->qty}}</td>
		                 <td></td>
		                 <td></td>
		            </tr>
		            @endforeach 	
		            </tbody>
		          </table>

				  <div class="col-sm-12" >
		          <div class="row">
		          	<h4>Purpose: </h4>
		          	<p></p>
		          </div>
		      	  </div>

		          <table  class="table table-bordered table-striped">
		            <tfoot>
		              <tr>
		                {{-- <th colspan="8">Office/Department: {{$are_header->office}}</th> --}}
		              </tr>
		            </tfoot>
		          </table>

		          <table class="table table-bordered table-striped">
		            <tr>
		             <th colspan="3"></th>
		             <th colspan="2"><center>Received By: </center></th>
		             <th colspan="3"><center>Approved:</center></th>
		             <th colspan="3"><center>Issued To:</center></th>
		             <th colspan="2"><center>Received By: </center></th>		             
		           </tr>
					<tr>
		             <th colspan="3">
		              <div><font size="2"><center><i>Signature</i></center></font></div>
		             </th>
		             <th colspan="2">
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th colspan="3">
		               {{-- <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		             <th colspan="2">
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th colspan="3">
		              {{--  <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		           </tr>
		           <tr>
		             <th colspan="3">
		              <div><font size="2"><center><i>Printed Name</i></center></font></div>
		             </th>
		             <th colspan="2">
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th colspan="3">
		               <div><font size="2"><center><b>CARLO JORGE JOAN L. REYES</b></center></font></div>
		             </th>
		             <th colspan="2">
		               <div><font size="2"><center><b>GIAN CARLO A. MIJARES</b></center></font></div>
		             </th>
		             <th colspan="3">
		              {{--  <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		           </tr>
		           <tr>
		             <th colspan="3">
		              <div><font size="2"><center><i>Designation</i></center></font></div>
		             </th>
		             <th colspan="2">
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th colspan="3">
		               <div><font size="2"><center><i>City Mayor</i></center></font></div>
		             </th>
		             <th colspan="2">
		               <div><font size="2"><center><i>City Administrator / GSO Designate</i></center></font></div>
		             </th>
		             <th colspan="3">
		              {{--  <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		           </tr>
		           <tr>
		             <th colspan="3">
		              <div><font size="2"><center><i>Date</i></center></font></div>
		             </th>
		             <th colspan="2">
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th colspan="3">
		               {{-- <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		             <th colspan="2">
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th colspan="3">
		              {{--  <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
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
        white-space: nowrap;
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

       window.print(); 
       //location.href= "{{route('inventory.are')}}";
     }



    </script>
	
@endsection