@extends('_main')
@section('content')
<?php $old = $flagData = null; $runningAmountTotal = $headerDataCount = $amountFromLoop = $runningAmountTotal = $runningt = $runningGT = $runningRowTotal = $totalOR = 0; $runningColTotal = []; $flag = true;?>
  <section class="content">
      <div class="box box-default">
 
      <!-- /.box-header -->
      <div class="box-body" style="">

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
            

              <tr>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">Date</td>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">O.R No.</td>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">Name of Tax Payer</td>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">Amount</td>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;" colspan="2"></td>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;" colspan="2"></td>
                @isset($groupedTax)
                @foreach($groupedTax as $tax)
                <th class="text-center" colspan="{{count($tax) - 1}}">{{$tax['description']}}</th>
                @endforeach
                @endisset
              </tr>


               @isset($groupedTax)
               <tr>
               @foreach($groupedTax as $tax)
               <?php $headerDataCount += count($tax) - 1; ?>
               @for($i = 0; $i < count($tax) - 1 ; $i++)
                  <th scope="col" class="text-center"><p>{{($tax[$i]->taxtype_desc)}}</p> ({{$tax[$i]->tax_code}})</th>              
               @endfor
               @endforeach
               <td style="vertical-align : middle;text-align:center; font-weight: bold;">TOTAL</td>
               <td style="vertical-align : middle;text-align:center; font-weight: bold;">GRAND TOTAL</td>
               </tr>
               @endisset
              
            </thead>
            <tbody>
              @isset($groupedData)
              {{-- start loop of groupedData --}}
              @foreach($groupedData as $key => $values)
                <?php $flagData = $key;?>
                {{-- start 2nd dimension loop of groupedData --}}
                @foreach($values as $keyGroup => $valuesGroup)
                <?php $totalOR += $valuesGroup['total']; ?>
                <tr>
                  {{-- for head data (date, or payee) --}}
                  <td>
                    @if($flagData != $old)
                      <?php $old = $flagData;?>
                      {{$key}}
                    @endif
                  </td>
                  <td>{{key($values)}}</td>
                  <td>various taxpayers</td>
                  <td>{{number_format($valuesGroup['total'],2)}}</td>
                  {{-- end for head data (date, or payee) --}}

                  {{-- for groupedTax loop --}}
                  @foreach($groupedTax as $tax)
                    {{-- inside loop for taxtypes --}}
                    @for($l = 0; $l < count($tax) - 1 ; $l++)
                      <?php $formedData = $tax[$l]->taxtype_id; $amountFromLoop = 0 ?>

                      @if(isset($valuesGroup[$formedData]))
                        <?php 
                        $amountFromLoop = $valuesGroup[$formedData]['total']; $runningRowTotal += $amountFromLoop;
                        ?>
                      @endif
                      {{-- for filling in data on each fields --}}
                      <td>{{number_format($amountFromLoop,2)}}</td>
                      <?php
                       $runningColTotal[$tax[$l]->taxtype_id] = (isset($runningColTotal[$tax[$l]->taxtype_id]) ? $runningColTotal[$tax[$l]->taxtype_id] + $amountFromLoop : $amountFromLoop);
                      ?>
                      {{-- end for filling in data on each fields --}}
                    @endfor
                    {{-- end of inside loop for taxtypes --}}

                  @endforeach
                  {{-- end for groupedTax loop --}}
                  <td>{{number_format($runningRowTotal,2)}} <?php $runningt += $runningRowTotal; ?></td>
                  <td>{{number_format($runningRowTotal,2)}} <?php $runningGT += $runningRowTotal; ?></td>
                  <?php $runningRowTotal = 0; ?>
                </tr>
                  

                @endforeach
                {{-- end 2nd dimension loop of groupedData --}}
                


              @endforeach
              {{-- end loop of groupedData --}}

              {{-- for total under OR --}}
              <?php 
                $editedArr = array_values($runningColTotal);
              ?>
              <tr style="font-weight: bold;">
                  <td></td>
                  <td>TOTAL</td>
                  <td></td>
                  <td>{{number_format($totalOR,2)}}</td>
               </tr>
               {{-- end for total under OR --}}

                <tr style="font-weight: bold;">
                  <td>Total This Page</td>
                  <td colspan="3"></td>
                  @for($p = 0; $p < ($headerDataCount ); $p++)
                    <td scope="col" class="text-center">{{$editedArr[$p]}}</td>
                  @endfor
                  <td>{{Number_format($runningt)}}</td>
                  <td>{{Number_format($runningGT)}}</td>
               </tr>
               <tr style="font-weight: bold;">
                 <td>Cumulative Total to Date</td>
                 <td colspan="3"></td>
                 @for($p = 0; $p < ($headerDataCount ); $p++)
                    <td scope="col" class="text-center">{{$editedArr[$p]}}</td>
                 @endfor
                   <td>{{Number_format($runningt)}}</td>
                   <td>{{Number_format($runningGT)}}</td>
               </tr>
              @endisset


            </tbody>
          </table>
        </div>

      {{-- {{dd($runningColTotal)}} --}}
      </div>
      <!-- /.box-body -->
    </div>

        
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
  <script type="text/javascript">
      
  </script>
@endsection