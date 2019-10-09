@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Waste Material','icon'=>'none','st'=>true]
    ];
    $_ch = "Waste Material"; // Module Name
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
		                  <th class="text-right" style="border: none !important;">
		                    <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" width="145"></th>
		                  <th style="border: none !important;">
		                    <center><h4>REPUBLIC OF THE PHILIPPINES</h4><h4>PROVINCE OF NEGROS ORIENTAL</h4><h4>CITY OF GUIHULNGAN</h4></center></th>
		                  <th class="text-left" style="border: none !important;"><img src="{{url('images/guihulngan.png')}}" class="img-circle " alt="logo" width="130"></th>
		                </tr>
		                <tr>
		                	<th colspan="3" class="text-center" style="font-size: 18px;border-top: hidden !important">WASTE MATERIAL REPORT</th>
		                </tr>
		                <tr>
		                	<th colspan="2">Place of Storage</th>
		          			<th>Date:</th>
		                </tr>
		                <tr>
		                	<th colspan="2">ITEMS FOR DISPOSAL</th>
		                	<th>Control #:</th>
		                </tr>
		              </thead>
		          </table>		      
		          <table  class="table table-bordered table-striped">
		            <thead>
		            	<tr>
		            		<th width="10%" class="text-center" nowrap style="font-size:14px;border-bottom: hidden !important">ITEM</th>
			                 <th width="10" class="text-center" style="font-size:14px;border-bottom: hidden !important">QTY.</th>
			                 <th width="10" class="text-center" style="font-size:15px;border-bottom: hidden !important">UNIT</th>
			                 <th nowspan class="text-center" style="font-size:15px;border-bottom: hidden !important">DESCRIPTION</th>
		            		<th colspan="2" class="text-center">RECORD OF SALES</th>
		            	</tr>
		            <tr>
		                 <th></th>
		                 <th></th>
		                 <th></th>
		                 <th></th>
		                 <th width="15%" class="text-center">OR NO.</th>
		                 <th width="15%" class="text-center">Amount</th>
		            </tr>
		          </thead>
		            <tbody>
	              @foreach($reclne as $rl)
		            <tr>
		                <td></td>
		                <td></td>
		                <td></td>
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
		          	<tr>
		          		<th rowspan="3">
		             	<h4>Certified Correct:</h4><center><strong>GIAN CARLO A. MIJARES</strong><br>City Administrator/GSO Designate <br> Property Officer	</center>
		             	
		             </th>
		             <th rowspan="3">
		             	<h4><left> Disposal Approved: </left></h4> 
		             </th>	
		          	</tr>
		            
		          </table>
		          <hr style="border: none;border-top: 1px dashed black;">
		          <div class="text-center"><strong><h5><i>CERTIFICATE OF INSPECTION</i></h5></strong></div>
		          <table class="table table-bordered table-striped">
		          	<tr>
		          		<td>To be filled up upon disposal 
		          			<p style="margin: 0px !important;">I hereby certify that the proerty enumerated above was disposed of as follows:</p>
		          			<p style="margin: 0px !important;">Item ____________________</p>
		          			<p style="margin: 0px !important;">Item ____________________</p>
		          			<p style="margin: 0px !important;">Item ____________________</p>
		          			<p style="margin: 0px !important;">Item ____________________</p>
		          		</td>
		          		<td style="border-left: hidden !important; "><br>
		          			<br>
		          			<p style="margin: 0px !important;">Destroyed</p>
		          			<p style="margin: 0px !important;">Sold at Private sale</p>
		          			<p style="margin: 0px !important;">Sold at Public sale</p>
		          			<p style="margin: 0px !important;">Transferred without ___________</p>
		          		</td>
		          	</tr>
		          	<tr>
		          		<td><h4>Property Inspector:</h4><center><strong>______________________</strong><br>Property Inspector</center></td>
		          		<td><h4>Witness to:</td>
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