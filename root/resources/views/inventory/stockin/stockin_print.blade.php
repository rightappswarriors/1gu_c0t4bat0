@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Stock In','icon'=>'none','st'=>true]
    ];
    $_ch = "Stock In"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
        <!-- Main content -->
        <section class="content">
        	<div class="row">
        		<div class="col-sm-12">
        			<h2><center>INSPECTION AND ACCEPTANCE REPORT</center></h2>
        				<center><h4>Local Government Unit – City of Guihulngan</h4><h4>General Services Office</h4></center>
   
        		</div>
    		</div>
    		<br>

     
      <div class="row">
        <div class="col-sm-12">
          <table id="tbl_list" class="table table-bordered table-striped">
              <div class="row">	
		<div class="" style="width: 58.33333333%; float: left; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;">
					<h5>Supplier: {{$rechdr->supplier}}</h5>
					<h5>Delivery Receipt: <u>__________________</u></h5>
					<h5>Mode of Procurement: <b><u>SVP</u></b></h5>
					<h5>Requisitioning Office/Department: {{$rechdr->office}}</h5>
		</div>
		<div class="">
					<h5>IAR NO.: {{$rechdr->purc_ord}}</h5>
					<h5>Date:  {{$rechdr->date}}</h5>
		</div>
		</div>
              {{-- <thead> --}}
                <tr>
                     <td>Item No.</td>
                     <td>QTY</td>
                     
                     <td>UNIT</td>
                     <td>DESCRIPTION</td>
                     <td>UNIT COST</td>
                     <td>AMOUNT</td>
                </tr>
              {{-- </thead> --}}
                <tbody>
                @foreach($reclne as $rl)
                <tr>
                     <td>{{$rl->ln_num}}</td>
                     <td>{{number_format($rl->qty)}}</td>
                     <td>{{$rl->unit}}</td>
                     <td>{{$rl->item_desc}}</td>
                     <td>{{number_format($rl->price, 2)}}</td>
                     <td>{{number_format($rl->ln_amnt, 2)}}</td>
                </tr> 
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="7" ><h4 align="right">Grand Total:&nbsp;&nbsp;{{number_format($total->total)}}</h4></th>
                  </tr>
                  <tr>
                    <th colspan="4">INSPECTION:
                    	<div><center><br><u>_____________________________</u></center></div><div><center><font size="2">Date</font></center></div>
                    </th>
                    <th colspan="4">ACCEPTANCE
                    	<div><center><br><u>_____________________________</u></center></div><div><center><font size="2">Date</font></center></div>
                    </th>
                  </tr>
                  <tr>
                    <th colspan="4"><h5>Inspected, verified and found OK as to quanity and Specifications</h5>
					<div><center><br><b>ERWIN S. RUBIO</b></center></div><div><center><font size="3"><i>Storekeeper IV</i></font></center></div>
					<div><center><br><b>LAARNI E. BARCELO</b></center></div><div><center><font size="3"><i>Computer Operator IV</i></font></center></div>
					<h5>Noted by:</h5>				
					<div><center><br><b>MARIA JOFERDINE Y. CUI, CPA, CESE</b></center></div><div><center><font size="3"><i>City Accountant</i></font></center></div>
                    </th>
                    <th colspan="4">
                    <div class="col-sm-1"> <h5><b>Complete</b> <div class="center"></div></h5> </div>
                    <div class="col-sm-1"> <h5><b>Partial</b> <div class="center"></div></h5> </div>
					<div><center><br><b>GIAN CARLO A. MIJARES</b></center></div><div><center><font size="3"><i>City Administractor GSO Designate</i></font></center></div>
					<h5>Noted by:</h5>				
					<div><center><br><b>GIAN CARLO A. MIJARES</b></center></div><div><center><font size="3"><i>City Administractor GSO Designate</i></font></center></div>

                    </th>
                  </tr>
                </tfoot>
              </table>
        </div>
      </div>

    </section>
    <style>
.center {
  margin: auto;
  width: 20%;
  border: 3px solid /*#73AD21*/;
  padding: 10px;
}
</style>

    <script>
     window.onload = function() { window.print(); }
    </script>
	
@endsection