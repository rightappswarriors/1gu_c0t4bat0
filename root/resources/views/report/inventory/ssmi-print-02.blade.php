@extends('_main')
@php
     $_bc = [
        ['link'=>'#','desc'=>'Reports','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'','desc'=>'SSMI Report','icon'=>'none','st'=>true]
    ];
    $_ch = "SUMMARY OF SUPPLIES AND MATERIALS ISSUED REPORT"; // Module Name
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="graph-image graph-7">
        {{-- <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" /> --}}
      </div>
      <!-- <div id="pageCounter">
          <span></span>
          <span></span>
      </div> -->  <!--  page counter -->   
      <div class="row" >
        <div id="pageCounter">
        <div id="mainDivForCount">
          

        <div class="col-sm-12" >
          <table style="border: 1px solid #000;margin:10px 0 0 0 !important;"  id="tbl_list" class="table table-bordered">
              <thead>
                <tr>
                  <div class="image">
                  <th style="border: none !important;">
                    {{-- <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" style="width: 145px;"> --}}</th>
                  <th style="border: none !important;">
                    <center><h3><strong>SUMMARY OF SUPPLIES AND MATERIALS ISSUED</strong></h3><h4>LGU-GUIHULNGAN CITY</h4><h4>{{$itmgrpdesc->grp_desc}}</h4><h4>AS OF {{$asofdt}}</h4></center></th>
                  <th style="border: none !important;">{{-- <img src="{{url('images/guihulngan.png')}}" class="img-circle logo" alt="logo" style="width:152px;"> --}}</th>
                </div>
                </tr>
              </thead>
          </table>

          

          <table  class="table table-bordered" style="margin:0 0 10px 0 !important;">
            <thead>
            <tr>
                 <th width="10%" style="font-size:14px;white-space: normal;" rowspan="3" colspan=""><center>Purchase No</center></th>
                 <th width="30%" style="font-size:14px;" rowspan="3" colspan=""><center>ITEM No. Description</center></th>
                 <th width="10%" style="font-size:14px;white-space: normal;" rowspan="3" colspan=""><center>Unit of Measurement</center></th>
                 <th width="40%" style="font-size:14px;" rowspan="" colspan="14"><center>REQUISITION & ISSUE SLIP NUMBERS</center></th>
                 <th  style="font-size:12px;white-space: normal;" rowspan="3" colspan=""><center>TOTAL QUANTITY ISSUED</center></th>
                 <th  style="font-size:12px;white-space: normal;" rowspan="3" colspan=""><center>UNIT COST</center></th>
                 <th style="font-size:12px;" rowspan="3" colspan=""><center>TOTAL COST</center></th>
            </tr>
            <tr>
              <td width="40%" style="font-size:14px;" rowspan="1" colspan="14" align="center"><b>QUANTITY ISSUED</b></td>
            </tr>
            <tr>
              <td width="5%" style="font-size:14px;" rowspan="" colspan="" align="center">1</td>
              <td width="5%" style="font-size:14px;" align="center">2</td>
              <td width="5%" style="font-size:14px;" align="center">3</td>
              <td width="5%" style="font-size:14px;" align="center">4</td>
              <td width="5%" style="font-size:14px;" align="center">5</td>
              <td width="5%" style="font-size:14px;" align="center">6</td>
              <td width="5%" style="font-size:14px;" align="center">7</td>
              <td width="5%" style="font-size:14px;" align="center">8</td>
              <td width="5%" style="font-size:14px;" align="center">9</td>
              <td width="5%" style="font-size:14px;" align="center">10</td>
              <td width="5%" style="font-size:14px;" align="center">11</td>
              <td width="5%" style="font-size:14px;" colspan="3" align="center">12</td>
            </tr>
          </thead>
            <tbody>
            
            <?php 
            $count = 8;
            ?>

            @foreach($data as $d)

            <?php 
            $count += 1;

            if($count == 21)
            {
               $count = 0;
               ?> 
               <tr class="page page-break"><span></span></tr>
               <tr class="page-break"></tr>

               <?php
            }
            ?>
              <tr>
                 <td align="center">{{$d->code}}</td>
                 <td>{{$d->item_desc}}</td>
                 <td align="center">{{$d->unit}}</td>
                 <td align="center">{{number_format($d->jan)}}</td>
                 <td align="center">{{number_format($d->feb)}}</td>
                 <td align="center">{{number_format($d->mar)}}</td>
                 <td align="center">{{number_format($d->apr)}}</td>
                 <td align="center">{{number_format($d->may)}}</td>
                 <td align="center">{{number_format($d->jun)}}</td>
                 <td align="center">{{number_format($d->jul)}}</td>
                 <td align="center">{{number_format($d->aug)}}</td>
                 <td align="center">{{number_format($d->sep)}}</td>
                 <td align="center">{{number_format($d->oct)}}</td>
                 <td align="center">{{number_format($d->nov)}}</td>
                 <td colspan="3" align="center">{{number_format($d->dec)}}</td>
                 <td align="center">{{number_format($d->total_qty)}}</td>
                 <td align="right">{{number_format($d->unit_cost, 2)}}</td>
                 <td align="right">{{number_format($d->total_cost, 2)}}</td>
                 
            </tr>
            @endforeach
            <tr>
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
              <td colspan="3"></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td align="right">TOTAL:</td>
              <td></td>
              <td>{{number_format($total->jan)}}</td>
              <td>{{number_format($total->feb)}}</td>
              <td>{{number_format($total->mar)}}</td>
              <td>{{number_format($total->apr)}}</td>
              <td>{{number_format($total->may)}}</td>
              <td>{{number_format($total->jun)}}</td>
              <td>{{number_format($total->jul)}}</td>
              <td>{{number_format($total->aug)}}</td>
              <td>{{number_format($total->sep)}}</td>
              <td>{{number_format($total->oct)}}</td>
              <td>{{number_format($total->nov)}}</td>
              <td colspan="3">{{number_format($total->dec)}}</td>
              <td>{{number_format($total->total_qty)}}</td>
              <td align="right">{{number_format($total->unit_cost, 2)}}</td>
              <td align="right">{{number_format($total->total_cost, 2)}}</td>
            </tr>
            </tbody>
          </table>
          <table style="width:100%; margin: 80px 0 0 0 !important;">
            <tr>
              <td style="width: 33.33%">Prepared by:</td>
              <td style="width: 33.33%">Certified by:</td>
              <td style="width: 33.33%">Posted in the SLC by/date</td>
            </tr>
             <tr>
              <td class="text-center"><strong>LELYBETH U. ALIPAN</strong></td>
              <td class="text-center"><strong>GIAN CARLO A. MIJARES</strong></td>
              <td class="text-center"><strong>MARIA JOFERDINE Y. QUE, CPA, CESE</strong></td>
            </tr>
             <tr>
              <td class="text-center">Supply Officer III</td>
              <td class="text-center">City Administrator/GSO Designate</td>
              <td class="text-center">City Accountant</td>
            </tr>
            {{-- <tr class="page"></tr> --}}
          </table>
        </div>
      
      </div> <!-- FOR PRINT -->
      </div>

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

      @media print {
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