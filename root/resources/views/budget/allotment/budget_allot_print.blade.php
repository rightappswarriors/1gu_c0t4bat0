@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Appropriation Entry','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Appropriation"; // Module Name
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
            <u>{{$Header->fund}}</u></b><br>
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
                <th height="50" style="border: 1px solid #000; width:80%; "><center>Function/Program/Project</center></th>
                @if($Header->type == 'O')
                   <th height="50" style="border: 1px solid #000; width:20%; "><center>Obligation</center></th>
                @else
                   <th height="50" style="border: 1px solid #000; width:20%; "><center>Appropriation</center></th>
                @endif
                <th height="50" style="border: 1px solid #000; width:20%; "><center>Allotment</center></th>
              </tr>
            </thead>
            <tbody>
              <tr class="noborder">
                <td></td>
                <td height="50"><b><u><center>CURRENT YEAR ALLOTMENT</center></u></b></td>
                <td></td>
                <td></td>
              </tr>
              <tr class="noborder">
                <td><center><b>{{$Header->funcid}}</b></center></td>
                <td height="50" style="text-indent: 20px;"><b>{{strtoupper($Header->function)}}</b></td>
                <td></td>
                <td></td>
              </tr>
              <tr class="noborder">
                <td><center><b>{{$Header->office_code}}</b></center></td>
                <td><b><u>{{strtoupper($Header->office)}}</u></b></td>
                <td ></td>
                <td></td>
              </tr>
              @isset($PPA)
                @php
                $total_allotamt = 0.00;
                $total_approamt = 0.00;
                $total_obligamt = 0.00;
                @endphp

                @foreach($PPA as $P)
                  <tr class="noborder">
                    <td></td>
                    <td height="50" style="text-indent: 10px; vertical-align: bottom;"><b>{{$P->subgrpdesc}}</b></td>
                    <td></td>
                    <td></td>
                  </tr>
                  @foreach($Line as $L)
                  @if($P->subgrpid == $L->grpid)
                  <tr class="noborder noborder2">
                    <td><center>{{$L->at_code}}</center></td>
                    <td>{{$L->at_desc}}</td>
                    @if($Header->type == 'O')
                       <td align="right">{{number_format($L->oblig_amnt, 2)}}</td>
                    @else
                       <td align="right">{{number_format($L->appro_amnt, 2)}}</td>
                    @endif   
                    <td align="right">{{number_format($L->allot_amnt, 2)}}</td>
                  </tr>
                  @endif
                  @endforeach
                  <tr class="noborder noborder3">
                    <td></td>
                    <td><b>Total {{$P->subgrpdesc}}</b></td>
                    @if($Header->type == 'O')
                       <td align="right"><b>{{number_format($P->total_obligamt, 2)}}</b></td>
                    @else
                       <td align="right"><b>{{number_format($P->total_approamt, 2)}}</b></td>
                    @endif
                    <td align="right"><b>{{number_format($P->total_allotamt, 2)}}</b></td>
                  </tr>
                  @php
                  $total_allotamt += $P->total_allotamt;
                  $total_approamt += $P->total_approamt;
                  $total_obligamt += $P->total_obligamt;
                  @endphp
                @endforeach
                  
                  <tr class="noborder noborder3">
                    <td></td>
                    <td height="50" style="vertical-align: bottom;"><b>GRAND TOTAL</b></td>
                    @if($Header->type == 'O')
                      <td align="right" height="50" style="vertical-align: bottom;"><b>{{number_format($total_obligamt, 2)}}</b></td>
                    @else
                      <td align="right" height="50" style="vertical-align: bottom;"><b>{{number_format($total_approamt, 2)}}</b></td>
                    @endif  
                      <td align="right" height="50" style="vertical-align: bottom;"><b>{{number_format($total_allotamt, 2)}}</b></td>
                  </tr>
              @endisset
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
     }

    </script>
	
@endsection