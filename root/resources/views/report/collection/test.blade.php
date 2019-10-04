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

			<div class="grid-container">
			  <div>Fund : </div>
			  <div></div>
			  <div>Date :</div>
			  <div></div>
			  <div>Name of Accountable Officer : </div>
			  <div></div>
			  <div>Report No. : </div>
			  <div></div>
			  
			</div>

	
		      	<div class="row" >
		        <div class="col-sm-12" >
		          <table  class="table table-bordered table-striped">	
		          	<tr>
		                 <td class="text-left" colspan="22">COLLECTIONS <br> 1. For Collectors</td>
		            </tr>        
		            <tr>
		                 <td class="text-center" align="justify" colspan="7" rowspan="2">TYPE <br> (FORM NO.)</td>
		                 <td class="text-center" colspan="10">Official Receipt / Serial No.</td>
		                 <td class="text-center" colspan="5" rowspan="2">Amount</td>
		            </tr>
		            <tr>
		                 <td class="text-center" colspan="5">From</td>
		                 <td class="text-center" colspan="5">To</td>
		            </tr>
		            <tr>

		            	<td class="text-center" colspan="7"> </td>
		                <td class="text-center" colspan="5"> </td>
		                <td class="text-center" colspan="5"> </td>
		                 <td class="text-center" colspan="5"> </td>

		            </tr>
		            <tr>
		            	<td class="text-right" colspan="17">TOTAL  </td>
		                 <td class="text-center" colspan="5"></td>
		            </tr>
		            <tr>
		                 <td class="text-left" colspan="22">2. For Liquidating Officers/Treasurers</td>
		            </tr>
		            <tr>
		                 <td class="text-center" align="justify" colspan="7">Name of Accountable Officer</td>
		                 <td class="text-center" colspan="5">Report No. </td>
		                 <td class="text-center" colspan="9">Amount</td>
		            </tr>
		            <tr>
		                 <td class="text-center" colspan="7">B. Remittances/Deposits</td>
		                 <td class="text-center" colspan="15"></td>
		            </tr>
		            <tr>
		                 <td class="text-center" align="justify" colspan="7">Accountable Officer Bank</td>
		                 <td class="text-center" colspan="5">Reference</td>
		                 <td class="text-center" colspan="9">Amount</td>
		            </tr>
		            <tr>
		                 <td class="text-left" colspan="22">C. ACCOUNTABILITY FOR ACCOUNTABLE FORMS</td>
		            </tr>
		            <tr>
		                 <td class="text-center" align="justify" colspan="2" rowspan="2">Name of Forms <br> and Numbers</td>
		                 <td class="text-center" colspan="5">Beginning Balance</td>
		                 <td class="text-center" colspan="5">Receipt</td>
		                 <td class="text-center" colspan="5">Issued</td>
		                 <td class="text-center" colspan="5">Ending Balance</td>
		            </tr>
		            <tr>
		            	 <td class="text-center" colspan="1">Qty</td>
		                 <td class="text-center" colspan="2">From</td>
		                 <td class="text-center" colspan="2">To</td>
		                 <td class="text-center" colspan="1">Qty</td>
		                 <td class="text-center" colspan="2">From</td>
		                 <td class="text-center" colspan="2">To</td>
		                 <td class="text-center" colspan="1">Qty</td>
		                 <td class="text-center" colspan="2">From</td>
		                 <td class="text-center" colspan="2">To</td>
		                 <td class="text-center" colspan="1">Qty</td>
		                 <td class="text-center" colspan="2">From</td>
		                 <td class="text-center" colspan="2">To</td>
		            </tr>
		            <tr>
		            	 <td class="text-center" colspan="2"></td>
		            	 <td class="text-center" colspan="1"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="1"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="1"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="1"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="2"></td>
		            </tr>
		            <tr>
		            	<td class="text-left" colspan="22">D. SUMMARY OF COLLECTION AND REMITTANCES / DEPOSITS</td>
		            </tr>
		          </table>


		          <table class="table table-bordered table-striped">
		            <th rowspan="11">
						<div class="grid-container">
							<div></div>
				  			<div></div>
				  			<div></div>
				  			<div>____________</div>

				  			<div>Beginning Balance</div>
				  			<div>______________</div>
				  			<div>.2018</div>
				  			<div>P___________</div>

				  			<div></div>
				  			<div>Gen. Basic</div>
				  			<div>40,432.00</div>
				  			<div>____________</div>

				  			<div>Add Collection</div>
				  			<div>SEF</div>
				  			<div>15,488.00</div>
				  			<div>____________</div>

				  			<div></div>
				  			<div>Cash</div>
				  			<div></div>
				  			<div><u>58,568.00</u></div>

				  			<div></div>
				  			<div>Checks</div>
				  			<div>____________</div>
				  			<div>____________</div>

				  			<div>Total</div>
				  			<div></div>
				  			<div></div>
				  			<div><u>56,887.00</u></div>

				  			<div>Less: </div>
				  			<div>Remittance/Deposit to</div>
				  			<div></div>
				  			<div>____________</div>

				  			<div></div>
				  			<div>Treasurer/<u>Depository Banck</u></div>
				  			<div></div>
				  			<div>____________</div>

				  			<div>Blance </div>
				  			<div></div>
				  			<div></div>
				  			<div>____________</div>
				  		</div>
		            </th>
		            <th colspan="12">
		            	List of Checks:
		            	<tr>
		            	 <td class="text-center" colspan="2">Check No.</td>
		            	 <td class="text-center" colspan="1">Bank</td>
		                 <td class="text-center" colspan="2">Payee</td>
		                 <td class="text-center" colspan="2">Amount</td>
		                </tr>
		                <tr>
		            	 <td class="text-center" colspan="2"></td>
		            	 <td class="text-center" colspan="1"></td>
		                 <td class="text-center" colspan="2"></td>
		                 <td class="text-center" colspan="2"></td>
		                </tr>
		                <tr>
		            	 <td class="text-center" colspan="5">TOTAL</td>
		                 <td class="text-center" colspan="2"></td>
		                </tr>
		                <tr>
		            	 <td colspan="12"></td>
		                </tr>		            
		      		</th>
		          </table>


		          <table class="table table-bordered table-striped">
		            <th rowspan="11">
		            	<h6><left>CERTIFICATION: </h6></left>
		            	<p><center>I hereby certify that the foregoing <br> report of collections and deposits <br> and accountability for accountable <br> forms is true and correct.
						</center></p>
		              <br>
					<div class="grider-container">
			  			<div><u>ANNABELLE P. BULADO</u></div>
			  			<div><u>12/05/1997</u></div>
			  			<div><b>RCC II</b></div>
			  			<div>Date</div>
			  		</div>
		            </th>
		            <th rowspan="11">
		            	<h6><left>VERIFICATION AND ACKNOWLEDGEMENT </left></h6>
		            	<p><center>I hereby certify that the foregoing <br> report of collections has been verified <br> and acknowledge receipt of ___________ .
						</center></p>
					<div class="griders-container">
			  			<div></div>
			  			<div></div>
			  			<div>(P________________)</div>
			  		</div>
			  		<br>
			  		<div class="grider-container">
			  			<div><u>PAMELA A. CALIJAN</u></div>
			  			<div><u>12/05/1997</u></div>
			  			<div><b>Asst. City Treasurer/ OIC - City Treasurer</b></div>
			  			<div>Date</div>
			  		</div>
		            </th>
		          </table>

		        </div>
		      	</div>
	
        </section>

		<style>
		.grid-container {
		  display: grid;
		  grid-template-columns: auto auto auto auto;
		  /*grid-gap: 30px;*/
		  padding: 10px;
		}
		.grid-container > div {
		  /*border: 1px solid black;*/
		  /*text-align: center;*/
		  font-size: 20px;
		}
		.grider-container {
		  display: grid;
		  grid-template-columns: auto auto ;
		  text-align: center;
		  /*grid-gap: 30px;*/
/*		  padding: 10px;*/
		}
		.griders-container {
		  display: grid;
		  grid-template-columns: auto auto auto;
		  text-align: center;
		  /*grid-gap: 30px;*/
/*		  padding: 10px;*/
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