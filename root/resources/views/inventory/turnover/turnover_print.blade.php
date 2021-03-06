@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Turn Over','icon'=>'none','st'=>true]
    ];
    $_ch = "Turn Over"; // Module Name
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
		          <table style="border: 1px solid #000;margin:0 !important;"  id="tbl_list" class="table table-bordered table-striped">
		              <thead>
		                <tr>
		                  <div class="image">
		                  <th style="border: none !important;text-align: right;">
		                    <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" width="145"></th>
		                  <th style="border: none !important;">
		                    <center><h3>CITY OF GUIHULNGAN</h3><h4>Local Government Unit</h4><h4>General Services Office</h4></center></th>
		                  <th style="border: none !important;text-align: left;"><img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" width="129"></th>
		                </div>
		                </tr>
		              </thead>
		          </table>

		          <div class="row">
		          	<div class="col-md-12">
		          		<h3><b><center>TURN OVER OF PROPERTY ACCOUNTABILITIES</center></b></h3>
		          	</div>
		          	<div class="col-md-12 text-right">
		          			<h4><b>TURN OVER DATE: {{$rechdr->date}}</b></h4>
		          	</div>		          	
		          </div>
		          <br>

		          <table  class="table table-bordered table-striped" style="margin: 0 !important">
		            <thead>
		            <tr>
		                 <th style="white-space: nowrap;font-size:14px;"><center>ARTICLE</center> No.</th>
		                 <th style="white-space: nowrap;font-size:14px;"><center>QTY.</center></th>
		                 <th style="width:50%;font-size:15px;"><center>Description</center></th>
		                 <th nowspan style="width:25%;font-size:15px;"><center>REMARKS</center></th>
		            </tr>
		          </thead>
		            <tbody>
	              @foreach($reclne as $rl)
		            <tr>
		                 <td>{{$rl->to_article}}</td>
		                 <td>{{number_format($rl->recv_qty, 2)}}</td>
		                 <td><textarea>{{$rl->item_desc}}</textarea></td>
		                 <td>{{$rl->notes}}</td>
		            </tr>
		            @endforeach 	
		            </tbody>
		          </table>


		          <table  class="table table-bordered table-striped" style="margin:8px 0 8px 0 !important;border: hidden !important;margin: 0 !important;">
                    <tfoot>
                      <tr>
                        <th colspan="8">Office/Department: {{$rechdr->office}}</th>
                      </tr>
                    </tfoot>
                  </table>

		          <table class="table table-bordered table-striped">
		            <th rowspan="3">
		             	<h4><left>Received By: </h4></left>
		             	<br>
		              <div><center>{{$rechdr->turnoverby}}<br>_____________________________</center></div><div><center><font size="1">Signature Over Printed Name</font></center></div>
		              <br>
					<div><center>{{$rechdr->designation}}<br>_____________________________</center></div><div><center><font size="1">Postion/Office</font></center></div>
		             </th>
		             <th rowspan="3">
		             	<h4><left> Received From: </left></h4> 
		             	&nbsp;&nbsp;
		             	&nbsp;&nbsp;&nbsp;&nbsp;
		              <div><font size="2"><center><b>{{-- {{$rechdr->to_receivedby}} --}}GIAN CARLO A. MIJARES</b><br>_____________________________</center></font></div>
		              <div><font size="2"><center><i>City Administration/ GSO Designate</i></center></font></div>
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