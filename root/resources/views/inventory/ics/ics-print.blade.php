@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory Custodian Slip','icon'=>'none','st'=>true]
    ];
    $_ch = "Inventory Custodian Slip"; // Module Name
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
		          <table style="border: 1px solid #000;margin-bottom: 5px !important"  id="tbl_list" class="table table-bordered table-striped">
		              <thead>
		                <tr>
		                  <div class="image">
		                  <th style="border: none !important;">
		                    <img src="{{url('images/logo1.jpg')}}" width="148" class="img-circle" alt="logo" ></th>
		                  <th style="border: none !important;padding: 10px 0 3rem 10px;">
		                    <center><h3>CITY OF GUIHULNGAN</h3><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center></th>
		                  <th style="border: none !important;"><img src="{{url('images/guihulngan.png')}}" width="129" class="img-circle" alt="logo"></th>
		                </div>
		                </tr>
		              </thead>
		          </table>
<div class="col-sm-12">
	<div class="row">
		<div ><center><b><h3>INVENTORY CUSTODIAN SLIP</h3></b></center></div>
	
           		<table  border="0">
		            <tfoot>
		              <tr>
		                <th colspan="8">ICS No: {{$rechdr->rec_num}}</th>
		              </tr>
		            </tfoot>
		          </table>
		      </div>
		      </div>
		          <table class="table table-bordered table-striped">
		            <thead>
		            <tr>
		                 <th style="white-space: nowrap;font-size:14px;"><center>Qty.</center> No.</th>
		                 <th style="white-space: nowrap;font-size:14px;"><center>Unit</center></th>
		                 <th style="width:50%;font-size:15px;"><center>Description</center></th>
		                 <th nowspan style="width:25%;font-size:15px;"><center>Amount</center></th>
		                 <th nowspan style="width:25%;font-size:15px;"><center>Inventory</center></th>
		                 <th style="width:25%;font-size:15px;"><center>Estimated Usefull</center></th>

		            </tr>
		          </thead>
		            <tbody>
	              @foreach($reclne as $rl)
		            <tr>
		                 <td>{{$rl->qty}}</td>
		                 <td>{{$rl->unit_desc}}</td>
		                 <td>{{$rl->item_desc}}</td>
		                 <td></td>
		                 <td></td>
		                 <td></td>
		            </tr>
		            @endforeach 	
		            </tbody>
		          </table>
		          <table  class="table table-bordered table-striped">
		            <tfoot>
		              <tr>
		                {{-- <th colspan="8">Office/Department: {{$are_header->office}}</th> --}}
		              </tr>
		            </tfoot>
		          </table>

		          <table class="table table-bordered table-striped">

		             <th rowspan="3">
		             	<h4><left>Received By: </h4></left>
		              <div><center>____________________</center></div><div><center><font size="1">Signature Over Printed Name</font></center></div>
		              <div><center>____________________</center></div><div><center><font size="1">Postion/Office</font></center></div>
		              <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
		             </th>
		             <th rowspan="3">
		             	<h4><left> Received From: </left></h4> 
		             	&nbsp;&nbsp;
		             	&nbsp;&nbsp;&nbsp;&nbsp;
		              <div><font size="2"><center><b>GIAN CARLO A. MIJARES</b></center></font></div>
		              <div><font size="2"><center><i>City Administration/ GSO Designate</i></center></font></div><div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
		             </th>
		           </tr>	


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