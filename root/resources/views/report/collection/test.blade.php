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
		  grid-template-columns: auto auto auto auto;
		  /*grid-gap: 30px;*/
		  /*padding: 10px;*/
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