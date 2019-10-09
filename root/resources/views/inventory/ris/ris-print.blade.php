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
		          <table style="border: 1px solid #000;margin-bottom: 0px;"  id="tbl_list" class="table table-bordered table-striped">
		              <thead>
		                <tr>
		                  <div class="image">
		                  <th style="border: none !important;">
		                    <img src="{{url('images/logo1.jpg')}}" width="145" class="img-circle" alt="logo"></th>
		                  <th style="border: none !important;">
		                    <center><h5>Republic of the Philippines</h5><h5>Province of Negros Oriental</h5><h4 class="ct"><strong>CITY OF GUIHULNGAN</strong></h4><h4>OFFICE OF THE GENERAL SERVICES</h4></center>
		                </th>
		                  <th style="border: none !important;"><img src="{{url('images/guihulngan.png')}}" width="129" class="img-circle" alt="logo"></th>
		                </div>
		                </tr>
		                <tr>
		                	<th colspan="3" class="text-center ris">Requisition and Issue Slip</th>
		                </tr>
		                
		              </thead>

		          </table>
		          <table style="border-top: hidden;margin-bottom: 0px;"  id="tbl_list" class="table table-bordered table-striped">
		          	<thead>
		          		<tr>
		          			<td width="30%" style="padding: 4px;border-bottom: hidden !important;">Division: GUIHULNGAN <u></u></td>
		          			<td width="25%" style="padding: 4px;border-bottom: hidden !important;">Responsibility Center</td>
		          			<td style="padding: 4px;border-right:hidden !important;border-bottom: hidden !important; ">RIS NO. {{$rechdr->ris_no}}<u></u></td>
		          			<td style="padding: 4px;border-left:hidden !important;border-bottom: hidden !important;">Date: {{$rechdr->date}}<u></u></td>
		          		</tr>
		          		<tr>
		          			<td style="padding: 4px;border-top: hidden !important;">Office: {{$rechdr->office}}<u></u></td>
		          			<td style="padding: 4px;border-top: hidden !important">Code: {{$rechdr->office_code}}<u></u></td>
		          			<td style="padding: 4px;border-right:hidden !important;border-top: hidden !important;">SAI NO. {{$rechdr->sai_no}}<u></u></td>
		          			<td style="padding: 4px;border-left:hidden !important;border-top: hidden !important;">Date:	<u></u></td>
		          		</tr>
		          	</thead>
		          </table>

		          <table style="border-top:hidden;margin-bottom: 10px !important;" class="table table-bordered table-striped">
		            <thead>
		           	<tr>
		           		<th colspan="4" class="text-center"><i><strong>Requisition</strong></i></th>
		           		<th colspan="2" class="text-center"><i><strong>Issuance</strong></i></th>
		           	</tr>
		            <tr>
		                 <th width="10" nowrap style="font-size:14px;">Stock #</th>
		                 <th width="10" style="font-size:14px;"><center>Unit</center></th>
		                 <th width="" style="font-size:15px;"><center>Description</center></th>
		                 <th width="10" nowrap style="font-size:15px;"><center>Quantity</center></th>
		                 <th width="10" nowrap style="font-size:15px;"><center>Quantity</center></th>
		                 <th style="font-size:15px;"><center>Remarks</center></th>

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
				<div class="row">	
				  <div class="col-sm-12" >
		           	<h4>Purpose: </h4>		          	
		          </div>
		      	  </div>

		          <table style="margin-top: -10px !important;" class="table table-bordered table-striped">
		            <tfoot>
		              <tr>
		                {{-- <th colspan="8">Office/Department: {{$are_header->office}}</th> --}}
		              </tr>
		            </tfoot>
		          </table>

		          <table class="table table-bordered table-striped">
		            <tr>
		             <th></th>
		             <th><center>Requested By: </center></th>
		             <th><center>Approved:</center></th>
		             <th><center>Issued To:</center></th>
		             <th><center>Received By: </center></th>		             
		           </tr>
					<tr>
		             <th>
		              <div><font size="2"><center><i>Signature</i></center></font></div>
		             </th>
		             <th>
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th>
		               {{-- <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		             <th>
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th>
		              {{--  <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		           </tr>
		           <tr>
		             <th>
		              <div><font size="2"><center><i>Printed Name</i></center></font></div>
		             </th>
		             <th>
		               <div><center>{{$rechdr->requestedby}}</center><div>
		             </th>
		             <th>
		               <div><font size="2"><center><b>CARLO JORGE JOAN L. REYES</b></center></font></div>
		             </th>
		             <th>
		               <div><font size="2"><center><b>GIAN CARLO A. MIJARES</b></center></font></div>
		             </th>
		             <th>
		              <div><center>{{$rechdr->receivedby}}</center><div>
		             </th>
		           </tr>
		           <tr>
		             <th>
		              <div><font size="2"><center><i>Designation</i></center></font></div>
		             </th>
		             <th>
		               <div><center><i>{{$rechdr->requestedbydesig}}</i></center><div><center>{{-- {{$are_header->receivedbydesig}} --}}</center></div>
		             </th>
		             <th>
		               <div><font size="2"><center><i>City Mayor</i></center></font></div>
		             </th>
		             <th>
		               <div><font size="2"><center><i>City Administrator / GSO Designate</i></center></font></div>
		             </th>
		             <th>
		              <div><center>{{$rechdr->receivedbydesig}}</center><div>
		             </th>
		           </tr>
		           <tr>
		             <th>
		              <div><font size="2"><center><i>Date</i></center></font></div>
		             </th>
		             <th>
		               
		             </th>
		             <th>
		               {{-- <center><u>{{$are_header->issuedto}}</u></center><div><center>{{$are_header->issuedtodesig}}</center></div> --}}
		             </th>
		             <th>
		               {{-- <div><center><u>{{$are_header->receivedby}}</u></center><div><center>{{$are_header->receivedbydesig}}</center></div> --}}
		             </th>
		             <th>
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