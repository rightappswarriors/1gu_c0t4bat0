@extends('_main')
@php
    $totalYes = $totalTo = $runningTotalRowAccord = $runningTotalColAccordTotal = $runningTotalColAccordYes = $runningTotalColAccordToday = $runningHeretoTotal = $runningCollectionTotal = 0;
    $isAF56 = false;
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    {{-- @include('layout._contentheader') --}}
        <!-- Main content -->
    <section class="content">

        	<h4><center>SUMMARY OF DAILY COLLECTIONS</center></h4>
        	<div class="grider-container">
	  			<div><u></u></div>
	  			<div><u></u></div>
	  			<div></div>
	  			<div><u>{{(isset($selectedDate) ? Date('F j, Y',strtotime($selectedDate)) : null)}}</u></div>
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
	            	@isset($allData[0])
	            	@foreach($allData[0] as $keyAccourd => $accord)
	            	<tr>
	            		<td class="text-center" colspan="4">{{$keyAccourd}}</td>
	            		@for($i = 0; $i < count($accord); $i++)

							<?php 
							if($accord[$i]->ortype != 'AF56'){
								$isAF56 = false;
							} else {
								$isAF56 = true;
							}
							$runningTotalColAccordTotal += ($isAF56 ? ($accord[$i]->today /2) : $accord[$i]->today);

							if($accord[$i]->todayflag == 'today'){
								$totalTo += ($isAF56 ? ($accord[$i]->today /2) : $accord[$i]->today);
								$runningTotalRowAccord +=  ($isAF56 ? ($accord[$i]->today /2) : $accord[$i]->today);
							} else {
								$totalYes += ($isAF56 ? ($accord[$i]->today /2) : $accord[$i]->today);
								$runningTotalRowAccord +=  ($isAF56 ? ($accord[$i]->today /2) : $accord[$i]->today);
							}

							?>
	            		@endfor

	            		<td class="text-center" colspan="4">{{number_format($totalYes,2)}} <?php $runningTotalColAccordYes += $totalYes; ?></td>
	            		<td class="text-center" colspan="4">{{number_format($totalTo,2)}} <?php $runningTotalColAccordToday += $totalTo; ?></td>
	            		<td class="text-center" colspan="4">{{number_format($runningTotalRowAccord,2)}}</td>
			
	            	</tr>
	            	<?php 
	            	
	            	?>
	            	<?php $totalYes = $totalTo = $runningTotalRowAccord = 0; ?>
	            	@endforeach
	            	@endisset
	            	<tr>
	            		<td class="text-center" colspan="4">CUMMULATIVE TOTAL</td>
	            		<td class="text-center" colspan="4">{{number_format($runningTotalColAccordYes,2)}}</td>
	            		<td class="text-center" colspan="4">{{number_format($runningTotalColAccordToday,2)}}</td>
	            		<td class="text-center" colspan="4">{{number_format($runningTotalColAccordTotal,2)}}</td>
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
		            	@isset($hereto)
		            	@foreach($hereto as $here)
		            	<?php $runningHeretoTotal += $here->depossitedamount; ?>
		            	<tr>
		            		<td class="text-center" colspan="4">{{$here->collector}}</td>
		            		<td class="text-center" colspan="4"></td>
		            		<td class="text-center" colspan="4">{{number_format($here->depossitedamount)}}</td>
		            	</tr>
		            	@endforeach
		            	@endisset
					</table>
						<div class="grider-container">
							<div><u></u></div>
				  			<div><u></u></div>
				  			<div>TOTAL COLLECTION FOR TODAY ------------------- </div>
				  			<div> P           <u><b>{{Number_format($runningHeretoTotal,2)}}</b></u></div>
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
			            	@isset($collection)
			            	@foreach($collection as $col)
			            	<?php $runningCollectionTotal += $col->colamount; ?>
			        		<tr>
			            		<td  colspan="3">{{strtoupper(trim(urldecode($col->payment_desc)))}}</td>
			                	<td  colspan="7"><center></center></td>
			                	<td class="text-right" colspan="2">{{number_format($col->colamount)}}</td>	
			            	</tr>			
			            	@endforeach
			            	@endisset            		            	

			            	<tr>
			            		<td  colspan="3"><b>TOTAL </b></td>
			                	<td  colspan="7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			                	<td class="text-right" colspan="2">{{Number_format($runningCollectionTotal,2)}}</td>	
			            	</tr>
						</table>
						<br>
						<div class="grid1-container">
							<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY to have received this ____________________ day of ____________________ 2019 shown above which agree with the total collections for today shown in the records and abstract of collection in the <br>amount of P<u><b>{{Number_format($runningCollectionTotal,2)}}</b></u>.</p>
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