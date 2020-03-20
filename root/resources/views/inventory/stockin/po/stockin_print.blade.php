@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Stock In','icon'=>'none','st'=>true]
    ];
    $_ch = "Stock In"; // Module Name
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      {{-- <div class="graph-image graph-7">
        <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" />
      </div> --}}
      <div class="row" >
        <div class="col-sm-12" >
          <table style="border: 1px solid #000;margin:10px 0 10px 0 !important;"  id="tbl_list" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <div class="image">
                  <th style="border: none !important;" align="right">
                    <center><img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" align="right" style="width: 120px;"></center>
                  </th>
                  <th style="border: none !important;">
                    <center><h3>PURCHASE ORDER</h3><h4>City of Guihulngan</h4><h4>Local Government Unit</h4></center>
                  </th>
                  <th style="border: none !important;" align="center">
                    <img src="{{url('images/Carabao.jpg')}}" class="img-circle" alt="logo" style="width:140px;"></th>
                </div>
                </tr>
                <tr>
                  <td colspan="2">
                    <i>Supplier:</i> {{$rechdr->supplier}}<br>
                    <i>Address:</i> {{$rechdr->supl_add}}<br>
                    <i>Tel. No/ Cell Phone No.:</i><br>
                    <i>PhilGEPS Organization Number:</i><br>
                    <i>Mode of Procurement:</i> <b>Small Value Procurement</b>
                  </td>
                  <td>
                    <i>P.O. No.:</i> {{$rechdr->purc_ord}}<br>
                    <i>P.O. Date:</i> {{$rechdr->date}}<br>
                    <i>P.R. No.:</i><br>
                    <i>P.O. Date:</i><br>
                  </td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <i>Place of Delivery:</i> LGU-Guihulngan-GSO<br>
                    <i>Date of Delivery:</i>
                  </td>
                  <td>
                    <i>Delivery Term:</i><br>
                    <i>Payment Term:</i><br>
                  </td>
                </tr>
              </thead>
          </table>

          <table  class="table table-bordered table-striped" style="margin:10px 0 10px 0 !important;">
            <thead>
            <tr>
                 <th width="10%" style="white-space: nowrap;font-size:14px;" align="center">ITEM NO.</th>
                 <th style="white-space: nowrap;font-size:14px;" align="center">QTY</th>
                 <th style="white-space: nowrap;font-size:14px;" align="center">UNIT</th>
                 <th width="40%" style="font-size:14px;" align="center">DESCRIPTION</th>
                 <th style="white-space: nowrap;font-size:14px;" align="center">UNIT COST</th>
                 <th style="white-space: nowrap;font-size:14px;" align="center">AMOUNT</th>
            </tr>
          </thead>
            <tbody>
            <?php $row = 1; ?>
            @foreach($reclne as $r)
            <tr>
                 <td align="center">{{$row}}</td>
                 <td align="center">{{number_format($r->qty)}}</td>
                 <td align="center">{{$r->unit}}</td>
                 <td>{{$r->item_desc}}</td>
                 <td align="right">₱ {{number_format($r->price, 2)}}</td>
                 <td align="right">₱ {{number_format($r->ln_amnt, 2)}}</td>
            </tr>

            <?php $row++ ?>
            @endforeach
            <tr>
              <td colspan="5" align="right"><b>TOTAL</b></td>
              <td align="right"><b>₱ {{number_format($total->total, 2)}}</b></td>
            </tr>
            <tr>
              <td colspan="6">
                <i>(Total Amount in Words)</i><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{$totalamtwords}} Pesos Exactly.
              </td>
            </tr>
            <tr>
              <td class="noborderbottom" colspan="6">
                &nbsp;&nbsp;&nbsp;&nbsp;In case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1/10) of one percent for every day of delay shall be imposed.
              </td>
            </tr>
            <tr>
              <td class="nobordertopbotright" colspan="4" align="right">
                Very truly yours,
              </td>
              <td class="nobordertopbotleft" colspan="2"></td>
            </tr>
            <tr>
              <td class="nobordertopright" colspan="4" align="center">
                <i>I hereby undertake to refund the Local Government Unit of<br> Guihulngan City the price difference in any or all of the items<br> supplied under this Contract in the event that the same is/are<br> found by the Commission on Audit to be overpriced.</i><br><br>
                Conforme: ______________________________<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i>(Signature Over Printed Name)</i><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ______________________________<br>
                Date
              </td>
              <td class="nobordertopleft" colspan="2" align="center">
                <u>CARLO JORGE JOAN L. REYES</u><br>
                City Mayor
              </td>
            </tr>
            <tr>
              <td colspan="4" class="noborderbottom">
                <b>Noted by:</b>
              </td>
              <td colspan="2" class="noborderbottom"></td>
            </tr>
            <tr>
              <td colspan="3" class="nobordertopright" align="center">
                <u>GIAN CARLO A. MIJARES</u><br>
                City Administrator /GSO Designate
              </td>
              <td class="nobordertopleft" align="center">
                <u>MARIA JOFERDINE Y. CUI, CPA, CESE</u><br>
                City Accountant
              </td>
              <td class="nobordertop" colspan="2" align="center">
                ObR No: ______________<br>
                Amount: ______________
              </td>
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

        tr.noborder td{
          border-bottom: none !important;
          border-top: none !important;
          border-right: none !important;
          border-spacing: -50px;
        }

        tr td.nobordertopright{
          border-top: none !important;
          border-right: none !important;
        }
        td.nobordertopleft{
          border-top: none !important;
          border-left: none !important;
        }
        td.nobordertopbotright{
          border-top: none !important;
          border-right: none !important;
          border-bottom: none !important;
          
        }
        td.nobordertopbotleft{
          border-top: none !important;
          border-left: none !important;
          border-bottom: none !important;
          
        }
        td.noborderbottom{
          border-bottom: none !important; 
        }
        td.nobordertop{
          border-top: none !important; 
        }
        
        #Header, #Footer {display: none ! important;}

        #sidebar-parent {
          display: none;
        }

        #print_hide, #print_name_hide {
          display: none;
        }
        
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
       $('textarea').each(function() {
        $(this).height($(this).prop('scrollHeight'));
        });

       window.print(); 
       //location.href= "{{route('inventory.are')}}";
     }



    </script>
  
@endsection