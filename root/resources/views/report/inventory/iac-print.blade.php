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
                 <th width="30%" style="font-size:14px;" rowspan="2" colspan=""><center>PARTICULARS</center></th>
                 <th width="10%" style="font-size:14px;" rowspan="2" colspan=""><center>UNIT</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="2" colspan=""><center>UNIT AMOUNT</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>BEGINNING BALANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>ADDITIONAL BALANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>TOTAL BALANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>ISSUANCES</center></th>
                 <th width="20%" style="font-size:14px;" rowspan="" colspan="2"><center>ENDING BALANCES</center></th>
            </tr>
            <tr>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>QUANTITY</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="" colspan=""><center>COST</center></th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $d)
            <tr>
                 <td>{{$d->item_desc}}</td>
                 <td align="center">{{$d->unit}}</td>
                 <td align="center">{{$d->cost}}</td>
                 <td align="center">{{$d->begbal}}</td>
                 <td align="center">{{number_format($d->begbalcost, 2)}}</td>
                 <td align="center">{{$d->addbal}}</td>
                 <td align="center">{{number_format($d->addbalcost, 2)}}</td>
                 <td align="center">{{$d->totalbal}}</td>
                 <td align="center">{{number_format($d->totalbalcost, 2)}}</td>
                 <td align="center">{{$d->issbal}}</td>
                 <td align="center">{{number_format($d->issbalcost, 2)}}</td>
                 <td align="center">{{$d->endbal}}</td>
                 <td align="center">{{number_format($d->endbalcost, 2)}}</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>TOTAL</td>
                <td align="center">{{number_format($total->totalbegbalcost, 2)}}</td>
                <td>TOTAL</td>
                <td align="center">{{number_format($total->totaladdbalcost, 2)}}</td>
                <td>TOTAL</td>
                <td align="center">{{number_format($total->totalbalcost, 2)}}</td>
                <td>TOTAL</td>
                <td align="center">{{number_format($total->totalissbalcost, 2)}}</td>
                <td>TOTAL</td>
                <td align="center">{{number_format($total->totalendbalcost, 2)}}</td>
            </tr>
          </tbody>
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