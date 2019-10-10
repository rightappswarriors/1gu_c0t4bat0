	@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Turn Over','icon'=>'none','st'=>true]
    ];
    $_ch = ""; // Module Name
    $total = 0;
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
        <!-- Main content -->
    <section class="content">

        	<h4><center>SUMMARY OF DAILY COLLECTIONS</center></h4>
        	<div class="grider-container">
	  			<div><u></u></div>
	  			<div><u></u></div>
	  			<div></div>
	  			<div><u>{{Date('m/d/Y')}}</u></div>
	  			<div><u></u></div>
	  			<div><u></u></div>
	  			<div><b></b></div>
	  			<div>Date</div>
			</div>

			<h5>1. Collection Abstract Accords:</h5>
			<div class="row" >
		    <div class="col-sm-12" >
				<table  class="table table-bordered table-striped">
	        		<tr>
	                	<th class="text-center" colspan="4">Provincial Forms</th>
	                	<th class="text-center" colspan="4">Total Yesterday</th>
	                	<th class="text-center" colspan="4">Totals Todays</th>
	                	<th class="text-center" colspan="4">Totals to Date</th>
	            	</tr>
	            	<tr>
	            		<td class="text-center" colspan="4"></td>
	            		<td class="text-center" colspan="4"></td>
	            		<td class="text-center" colspan="4"></td>
	            		<td class="text-center" colspan="4"></td>
	            	</tr>
	            	<tr>
	            		<td class="text-center" colspan="4">CUMMULATIVE TOTAL</td>
	            		<td class="text-center" colspan="4">1,149,674.46</td>
	            		<td class="text-center" colspan="4">191,156.76</td>
	            		<td class="text-center" colspan="4">1,340,831.22</td>
	            	</tr>
				</table>
					<div class="grider-container">
						<div><u></u></div>
			  			<div><u></u></div>
			  			<div>Certified Correct:</div>
			  			<div></div>
			  			<div><u></u></div>
			  			<div><u></u></div>
			  			<div></div>
			  			<div><u><b>ELIZA I. BAGUIO</b></u></div>
			  			<div><u></u></div>
			  			<div><u></u></div>
			  			<div><b></b></div>
			  			<div>Clerk-In-Charge of Abstract</div>
					</div>
				</div>
			   	</div>

			   	<h5>2 . Daily Statement hereto attached:</h5>
				<div class="row" >
			    <div class="col-sm-12" >
					<table  class="table table-bordered table-striped">
		        		<tr>
		                	<th class="text-center" colspan="4">Name of Collection</th>
		                	<th class="text-center" colspan="4">Title</th>
		                	<th class="text-center" colspan="4">Amount</th>		
		            	</tr>
		            	<tr>
		            		<td class="text-center" colspan="4"></td>
		            		<td class="text-center" colspan="4"></td>
		            		<td class="text-center" colspan="4"></td>
		            	</tr>
					</table>
						<div class="grider-container">
							<div><u></u></div>
				  			<div><u></u></div>
				  			<div>TOTAL COLLECTION FOR TODAY ------------------- </div>
				  			<div> P           <u><b>191,156.76</b></u></div>
						</div>
						<br>
						<div class="grid1-container">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that the foregiong statement of collection is true and correct and the I have carefully checked, verified and made and made an actual acount of the accountable forms repoted as sold and issued and as balanced on hand shown on the attached Report of Collections and Deposits. Submitted by cash collectors listed above.
						</div>
						<br>
						<div class="grider-container">
							<div><u></u></div>
				  			<div><u></u></div>
				  			<div></div>
				  			<div>______________________</div>
				  			<div><u></u></div>
				  			<div><u></u></div>
				  			<div></div>
				  			<div>Liquidating Officer</div>
						</div>
					</div>
				   	</div>
					<br>
				   	<div class="row" >
				    <div class="col-sm-12" >
						<table  class="table table-bordered table-striped">
							<tr>
			                	<td colspan="12"><b>Summary of Collections</b></td>
			            	</tr>
			        		<tr>
			            		<td  colspan="3">RPT COLLECTION</td>
			                	<td  colspan="7"><center></center></td>
			                	<td class="text-right" colspan="2">5,737.20</td>	
			            	</tr>			            	
			            	<tr>
			            		<td  colspan="3">GENERAL COLLECTIONS</td>
			                	<td  colspan="7"><center></center></td>
			                	<td class="text-right" colspan="2">61,527.24</td>	
			            	</tr>
			            	<tr>
			            		<td  colspan="3">MARKET FEES</td>
			                	<td  colspan="7"><center></center></td>
			                	<td class="text-right" colspan="2">20,172.32</td>	
			            	</tr>			            	
			            	<tr>
			            		<td  colspan="3">WATER FEES</td>
			                	<td  colspan="7"><center></center></td>
			                	<td class="text-right" colspan="2">20,172.32</td>	
			            	</tr>
			            	<tr>
			            		<td  colspan="3"><b>TOTAL </b></td>
			                	<td  colspan="7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			                	<td class="text-right" colspan="2">191,156.76</td>	
			            	</tr>
						</table>
						<br>
						<div class="grid1-container">
							<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY to have received this ____________________ day of ____________________ 2019 shown above which agree with the total collections for today shown in the records and abstract of collection in the <br>amount of P<u><b>191,156.76</b></u>.</p>
						</div>
						<div class="grider-container">
							<div><u></u></div>
				  			<div><u></u></div>
				  			<div></div>
				  			<div><u><b>PAMELA A. CALIJAN</b></u></div>
				  			<div><u></u></div>
				  			<div><u></u></div>
				  			<div></div>
				  			<div>Assistant City Treasurer/OIC-City Treasurer</div>
						</div>
					</div>
					</div>

	
        </section>

<style>
		.grid-container {
		  display: grid;
		  grid-template-columns: auto auto auto auto;
		  /*grid-gap: 30px;*/
		  padding: 5px;
		}
		.grid-container > div {
		  /*border: 1px solid black;*/
		  /*text-align: center;*/
		  font-size: 12px;
		  font-weight:normal;
		}
		.grider-container {
		  display: grid;
		  grid-template-columns: auto auto auto auto ;
		  text-align: center;
		}
		.grid1-container {
		  display: grid;
		  grid-template-columns: auto ;
		  text-align: justify;
		}
</style>

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
	
@endsection