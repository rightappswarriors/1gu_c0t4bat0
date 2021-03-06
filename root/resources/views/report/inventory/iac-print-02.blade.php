@extends('_main')
@php
     $_bc = [
        ['link'=>'#','desc'=>'Reports','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'','desc'=>'COA Report','icon'=>'none','st'=>true]
    ];
    $_ch = "COA REPORT"; // Module Name
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
        <div id="pageCounter">
        <div id="mainDivForCount">
        <div class="col-sm-12" >
          <table id="tbl_list" class="table table-striped">
              <thead>
                <tr>
                  <div class="image">
                  <th style="border: none !important;">
                    <center>
                      <h4>Republic of the Philippines</h4>
                      <h4>Province of Negros Oriental</h4>
                      <h4>City of Guihulngan</h4>
                      <h3>INVENTORY of {{strtoupper($itmgrpdesc->grp_desc)}} as of <u>{{$asofdt}}</u></h3>
                    </center>
                  </th>
                </div>
                </tr>
              </thead>
          </table>

          <table  class="table table-bordered table-striped" style="margin:10px 0 10px 0 !important;">
            <thead>
            <tr>
                 <th width="10%" style="font-size:14px;" rowspan="2" colspan=""><center>PURCHASE NO</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="2" colspan=""><center>ITEM NO</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="2" colspan=""><center>PARTICULARS</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="2" colspan=""><center>UNIT</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="2" colspan=""><center>UNIT AMOUNT</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>BEGINNING BALANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>ADDITIONAL BALANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>TOTAL BALANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>ISSUANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>ENDING BALANCES</center></th>
            </tr>
            <tr>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $row = 1; 
            ?>

            @foreach($data as $d)
            <tr>
                 <td align="center">{{$d->code}}</td>
                 <td><center>{{$row++}}</center></td>
                 <td>{{$d->item_desc}}</td>
                 <td align="center">{{$d->unit}}</td>
                 <td align="center">{{number_format($d->cost, 2)}}</td>
                 <td align="center">{{number_format($d->begbal)}}</td>
                 <td align="center">{{number_format($d->begbalcost, 2)}}</td>
                 <td align="center">{{number_format($d->addbal)}}</td>
                 <td align="center">{{number_format($d->addbalcost, 2)}}</td>
                 <td align="center">{{number_format($d->totalbal)}}</td>
                 <td align="center">{{number_format($d->totalbalcost, 2)}}</td>
                 <td align="center">{{number_format($d->issbal)}}</td>
                 <td align="center">{{number_format($d->issbalcost, 2)}}</td>
                 <td align="center">{{number_format($d->endbal)}}</td>
                 <td align="center">{{number_format($d->endbalcost, 2)}}</td>
            </tr>
            @endforeach
            <tr>
              <td></td>
              <td></td>
              <td>..*NOTHING FOLLOWS*..</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b>TOTAL</b></td>
                <td align="center"><b>{{number_format($total->totalbegbalcost, 2)}}</b></td>
                <td><b>TOTAL</b></td>
                <td align="center"><b>{{number_format($total->totaladdbalcost, 2)}}</b></td>
                <td><b>TOTAL</b></td>
                <td align="center"><b>{{number_format($total->totalbalcost, 2)}}</b></td>
                <td><b>TOTAL</b></td>
                <td align="center"><b>{{number_format($total->totalissbalcost, 2)}}</b></td>
                <td><b>TOTAL</b></td>
                <td align="center"><b>{{number_format($total->totalendbalcost, 2)}}</b></td>
            </tr>
          </tbody>
          </table>
          <table style="width:100%; margin: 80px 0 0 0 !important;">
            <tr>
              <td style="width: 50%;padding: 0 0 0 10%;">Prepared by:</td>
              <td style="width: 50%;padding: 0 0 0 10%;">Approved by:</td>
            </tr>
            <tr>
              <td class="text-center"><strong>LELYBETH U. ALIPAN</strong></td>
              <td class="text-center"><strong>GIAN CARLO A. MIJARES</strong></td>
            </tr>
             <tr>
              <td class="text-center">Supply Officer III</td>
              <td class="text-center">City Administrator/GSO Designate</td>
            </tr>
            {{-- <tr class="page"></tr> --}}
          </table>
        </div>
      </div> {{-- main div count --}}
    </div> {{-- page counter --}}
      </div>
      
    </section>

    <style>
    	   .table td{
        background-color: transparent !important;
        border: 1px solid #000 !important;
         padding: 0 8px 0 8px !important;
      }
       .table th{
        white-space: nowrap;
        background-color: transparent !important;
        border: 1px solid #000 !important;
      }
      @media print{
        #Headers, #Footers {
          display: none !important;
        }
	.logo{
		margin-top: -95%;
	}
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
                 #pageCounter {
                   counter-reset: pageTotal;
                  }
                  #pageCounter span {
                   counter-increment: pageTotal;
                  }
                  #mainDivForCount {
                   counter-reset: currentPage;
                  }
                  #mainDivForCount tr.page:before {
                   counter-increment: currentPage;
                   content: "Page " counter(currentPage) " of ";
                  }
                  #mainDivForCount tr.page:after {
                   content: counter(currentPage);
                  }
                  .breakPage{
                  page-break-before: always;
                  }

                  tr.page-break  { display: block; page-break-before: always; }
      } 
        @page {size: 8.5in 13in; size: landscape; margin: 0.75in 0.4in 0 0.4in;}
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