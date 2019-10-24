@extends('_main')
@section('content')
<?php $old = $flagData = null; $runningAmountTotal = $headerDataCount = $amountFromLoop = $runningAmountTotal = $runningt = $runningGT = $runningRowTotal = 0; $runningColTotal = [];?>
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
                  <th scope="col" class="text-center"><p>{{$tax[$i]->taxtype_desc}}</p> ({{$tax[$i]->tax_code}})</th>              
               @endfor
               @endforeach
               <td style="vertical-align : middle;text-align:center; font-weight: bold;">TOTAL</td>
               <td style="vertical-align : middle;text-align:center; font-weight: bold;">GRAND TOTAL</td>
               </tr>
               @endisset
              
            </thead>
            <tbody>
              @isset($groupedData)
              @foreach($groupedData as $key => $values)
              <?php $flagData = $key;?>
               @for($j = 0; $j < count($values); $j++)
               <tr>
                  <td>
                  @if($flagData != $old)
                  <?php $old = $flagData; $runningAmountTotal += $groupedData[$key][$j]->amount; ?>
                  {{$key}}
                  @endif
                  
                  </td>
                  <td scope="col" class="text-center">{{$groupedData[$key][$j]->orno}}</td>
                  <td scope="col" class="text-center">{{$groupedData[$key][$j]->taxpayer}}</td>
                  <td scope="col" class="text-center">{{number_format($groupedData[$key][$j]->amount,2)}}</td>
                  {{-- for extra TD and DATA --}}
                  @foreach($groupedTax as $tax)
                   @for($l = 0; $l < count($tax) - 1 ; $l++)
                        <?php $formattedTaxDesc = strtolower(trim(str_replace(' ', '', urldecode(preg_replace("/[^A-Za-z]/", '', $tax[$l]->taxtype_desc))))); ?>
                        @if(strpos(strtolower(trim(str_replace(' ', '', urldecode(preg_replace("/[^A-Za-z]/", '', $groupedData[$key][$j]->description))))), $formattedTaxDesc) !== false)

                        <?php $amountFromLoop = $groupedData[$key][$j]->amount; ?>
                        @endif
                      <td scope="col" class="text-center">{{Number_format($amountFromLoop,0)}}</td>
                      <?php $runningColTotal[$formattedTaxDesc.''.$l] = (isset($runningColTotal[$formattedTaxDesc.''.$l]) ? $runningColTotal[$formattedTaxDesc.''.$l] + $amountFromLoop : $amountFromLoop); ?>
                      <?php $runningRowTotal += $amountFromLoop; ?>
                      <?php $amountFromLoop = 0.00; ?>
                   @endfor
                   {{-- total area  --}}
                  @endforeach
                  <td>{{Number_format($runningRowTotal,2)}} <?php $runningt += $runningRowTotal; ?></td>
                  <td>{{number_format($groupedData[$key][$j]->amount,2)}} <?php $runningGT += $groupedData[$key][$j]->amount; ?></td>
               </tr>
               @endfor
               <tr style="font-weight: bold;">
                 <td></td>
                 <td colspan="2">TOTAL</td>
                 <td>{{Number_format($runningAmountTotal,2)}}</td>

                 {{-- for extra TD --}}
                 @for($k = 0; $k < ($headerDataCount  + 2); $k++)
                  <td scope="col" class="text-center"></td>
                 @endfor
               </tr>

               @endforeach
               <tr style="font-weight: bold;">
                 <td colspan="4">Total This Page</td>
                 {{-- for extra TD --}}
                 <?php $editedArr = array_values($runningColTotal); ?>
                 @for($p = 0; $p < ($headerDataCount ); $p++)
                  <td scope="col" class="text-center">{{$editedArr[$p]}}</td>
                 @endfor
                 <td>{{Number_format($runningt)}}</td>
                 <td>{{Number_format($runningGT)}}</td>
               </tr>
               <tr style="font-weight: bold;">
                 <td colspan="2">Cumulative Total to Date</td>
                 <td colspan="2"></td>
                  {{-- for extra TD --}}
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