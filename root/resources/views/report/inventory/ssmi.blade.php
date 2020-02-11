@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("inventory/are"),'desc'=>'Summary of Supplies and Materials Issued','icon'=>'none','st'=>true]
    ];
    $_ch = "Summary of Supplies and Materials Issued"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="graph-image graph-7">
        {{-- <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" /> --}}
      </div>
      <div class="row" >
        <div class="col-sm-12" >
          <table style="border: 1px solid #000;margin:10px 0 10px 0 !important;"  id="tbl_list" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <div class="image">
                  <th style="border: none !important;">
                    {{-- <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" style="width: 145px;"> --}}</th>
                  <th style="border: none !important;">
                    <center><h3>SUMMARY OF SUPPLIES AND MATERIALS ISSUED</h3><h4>LGU-GUIHULNGAN CITY</h4><h4>DRUGS AND MEDICINE</h4><h4>AS OF NOVEMBER 30, 2019</h4></center></th>
                  <th style="border: none !important;">{{-- <img src="{{url('images/guihulngan.png')}}" class="img-circle logo" alt="logo" style="width:152px;"> --}}</th>
                </div>
                </tr>
              </thead>
          </table>

          <table  class="table table-bordered table-striped" style="margin:10px 0 10px 0 !important;">
            <thead>
            <tr>
                 <th width="75%" style="font-size:14px;" rowspan="2">Item Description</th>
                 <th style="white-space: nowrap;font-size:14px;" rowspan="2">Unit of Measurement</th>
                 <th style="white-space: nowrap;font-size:14px;">REQUISITION & ISSUE SLIP NUMBERS</th>
                 <th nowspan style="font-size:14px;" rowspan="2">TOTAL QUANTITY ISSUED</th>
                 <th width="40%" style="font-size:14px;">UNIT COST</th>
                 <th style="white-space: nowrap;font-size:14px;">TOTAL COST</th>
                 <th style="white-space: nowrap;font-size:14px;">Amount</th>
            </tr>
            <tr>
              <td></td>
              <td>Quantity Issued</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </thead>
            <tbody>
            
            <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
            </tr>
           
            </tbody>
          </table>

          <table  class="table table-bordered table-striped" style="margin:8px 0 8px 0 !important;">
            <tfoot>
              <tr>
                <th colspan="8">Office/Department: </th>
              </tr>
            </tfoot>
          </table>

          <table class="table table-bordered table-striped">
            <tr>
             <th colspan="3">Received From:</th>
             <th colspan="2">Received By: </th>
             <th colspan="3">Issued To:</th>
           </tr>
           <tr>
             <th colspan="3">
              <br>
               </div>
             </th>
             <th colspan="2">
              <br>
               <div></div>
             </th>
             <th colspan="3">
              <br>
               </div>
             </th>
           </tr>
           <tr>
             <th colspan="3">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
             <th colspan="2">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
             <th colspan="3">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
           </tr>
          </table>
        </div>
      </div>
      
    </section>

    <style>
      @media print {
	.logo{
		margin-top: -95%;
	}
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
      
    </style>

    <script>
  
    window.onload = function() 
     {

       window.print(); 
       
     }



    </script>
	
@endsection