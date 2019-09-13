@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Report','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'SAAOB','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget SAAOB"; // Module Name
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      {{-- <div class="graph-image graph-7">
        <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" />
      </div> --}}
      <div class="row">
        <div class="col-sm-12">
          <center><b>Republic of the Philippines<br> Province of Negros Oriental<br> LGU-City of Guihulngan<br><br>
            <u>{{$fund->fdesc}}</u></b><br>
          </center>
        </div>
      </div>
      <br>
      <div class="row">
        <center>
        <div class="col-sm-12">
          <table class="table table-bordered" style="border: 1px solid #000;">
            <thead>
              <tr>
                <th height="50" style="border: 1px solid #000; width:15%; "><center>Account Code</center></th>
                <th height="50" style="border: 1px solid #000; width:90%; "><center>Function/Program/Project</center></th>
                <th height="50" style="border: 1px solid #000; width:20%; "><center>Appropriation</center></th>
                <th height="50" style="border: 1px solid #000; width:20%; "><center>Allotment</center></th>
                <th height="50" style="border: 1px solid #000; width:20%; "><center>Obligation</center></th>
                <th height="50" style="border: 1px solid #000; width:20%; " colspan="2"><center>Balances of</center></th>
              </tr>
            </thead>
            <tbody>
              <tr class="noborder">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b>APPROPRIATIONS</b></td>
                <td><b>ALLOTMENTS</b></td>
              </tr>
              <tr class="noborder">
                <td></td>
                <td height="50"><b><u><center>CURRENT YEAR APPROPRIATION</center></u></b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              @php
                $grandtotal = 0.00;
              @endphp

              @isset($Function)
              @foreach($Function as $F)
              <tr class="noborder">
                <td><center><b>{{$F->funcid}}</b></center></td>
                <td height="50" style="text-indent: 20px;"><b>{{strtoupper($F->funcdesc)}}</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              @isset($Header)
              @foreach($Header as $h)

              @if($F->funcid == $h->funcid)
              <tr class="noborder">
                <td><center><b>{{$h->office_code}}</b></center></td>
                <td><b><u>{{strtoupper($h->office)}}</u></b></td>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
                

                @foreach($PPA as $P) {{-- PPA --}}

                @php
                $total_ppaamt = 0.00;
                @endphp

                @if($h->b_num == $P->b_num) {{-- HEADER == PPA --}}
                  
                  <tr class="noborder">
                    <td></td>
                    <td height="50" style="text-indent: 10px; vertical-align: bottom;"><b>{{$P->subgrpdesc}}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                     <td></td>
                  </tr>

                  @foreach($Line as $L) {{-- LINE --}}
                  @if($h->b_num == $L->b_num)
                  @if($P->grpid == $L->grpid)
                  <tr class="noborder noborder2">
                    <td><center>{{$L->at_code}}</center></td>
                    <td>{{$L->at_desc}}</td>
                    <td align="right">{{number_format($L->appro_amnt, 2)}}</td>
                    <td align="right">{{number_format($L->allot_amnt, 2)}}</td>
                    <td align="right">{{number_format($L->obr, 2)}}</td>
                    <td align="right">{{number_format($L->appro_amnt - $L->allot_amnt, 2)}}</td>
                    <td align="right">{{number_format($L->allot_amnt - $L->obr, 2)}}</td>
                  </tr>

                  @php
                  $total_ppaamt += $L->appro_amnt;
                  $grandtotal += $L->appro_amnt;
                  @endphp

                  @endif
                  @endif
                  @endforeach {{-- LINE --}}

                  <tr class="noborder noborder3">
                    <td></td>
                    <td><b>Total {{$P->subgrpdesc}}</b></td>
                    <td align="right"><b>{{number_format($total_ppaamt, 2)}}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  @php
                  // $total_amt += $P->total_amt;
                  @endphp

                @endif  {{-- HEADER == PPA --}}
                @endforeach {{-- PPA --}}
              {{-- @endisset --}}
              @endif    
              @endforeach
              @endisset  
              @endforeach
              @endisset    
                  <tr class="noborder noborder3">
                    <td></td>
                    <td height="50" style="vertical-align: bottom;"><b>GRAND TOTAL</b></td>
                    <td align="right" height="50" style="vertical-align: bottom;"><b>{{number_format($grandtotal, 2)}}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
              
            </tbody>
          </table>














          
        </div>
      </center>
      </div>
      
    </section>

    <style>
      @media print{
        
        .table th{
        background-color: transparent !important;
        border: 1px solid #000 !important;
      }

      .table td{
        background-color: transparent !important;
        border: 1px solid #000 !important;
        /*border-right:none !important;
border-left:none !important;*/

      }

      /*table > tbody > td .hideborder{
        border: hidden;
      }*/
      tr.noborder td{
        border-bottom:none !important;
        border-top:none !important;
      }

      tr.noborder2 td:last-child {
        border-bottom: 1px solid #000 !important;
        border-top: 1px solid #000 !important;
      }

      tr.noborder3 td:last-child {
        border-bottom: 2px solid #000 !important;
        border-top: 2px solid #000 !important;
      }

      /*tr.noborder td{
        border-bottom:none !important;
border-top:none !important;
      }*/
    }
    </style>

    <script>
    
    window.onload = function() 
     {
       $('textarea').each(function() {
        $(this).height($(this).prop('scrollHeight'));
        });

       window.print(); 
       //location.href= "{{url("budget/budget-proposal-entry")}}";
     }

    </script>
  
@endsection