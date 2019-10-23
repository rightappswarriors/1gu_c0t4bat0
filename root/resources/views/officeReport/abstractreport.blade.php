<?php $old = $flagData = null; $runningAmountTotal = $headerDataCount = 0;?>
<table class="table table-bordered">
          <thead>
          

            <tr>
              <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">Date</td>
              <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">O.R No.</td>
              <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">Name of Tax Payer</td>
              <td style="vertical-align : middle;text-align:center; font-weight: bold;" rowspan="2">Amount</td>
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
             </tr>
             @endisset
            
          </thead>
          <tbody>
            @isset($groupedData)
            @foreach($groupedData as $key => $values)

            <?php $flagData = $key; $runningAmountTotal = 0;?>
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
                {{-- for extra TD --}}
                @for($k = 0; $k < ($headerDataCount); $k++)
                <td scope="col" class="text-center"></td>
                @endfor
             </tr>
             @endfor
             <tr style="font-weight: bold;">
               <td></td>
               <td colspan="2">TOTAL</td>
               <td>{{Number_format($runningAmountTotal,2)}}</td>

               {{-- for extra TD --}}
               @for($k = 0; $k < ($headerDataCount); $k++)
                <td scope="col" class="text-center"></td>
               @endfor
             </tr>

             @endforeach
             <tr style="font-weight: bold;">
               <td colspan="4">Total This Page</td>
               {{-- for extra TD --}}
               @for($k = 0; $k < ($headerDataCount); $k++)
                <td scope="col" class="text-center"></td>
               @endfor
             </tr>
             <tr style="font-weight: bold;">
               <td colspan="2">Cumulative Total to Date</td>
               <td colspan="2"></td>
                {{-- for extra TD --}}
               @for($k = 0; $k < ($headerDataCount); $k++)
                <td scope="col" class="text-center"></td>
               @endfor
             </tr>
              
             
            @endisset
          </tbody>
        </table>