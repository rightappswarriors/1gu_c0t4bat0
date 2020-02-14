@extends('_main')
@section('content')

	<style type="text/css">
	.tg  {border-collapse:collapse;border-spacing:0;}
	.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
	.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
	.tg .tg-lboi{border-color:inherit;text-align:left;vertical-align:middle}
	.tg .tg-9wq8{border-color:inherit;text-align:center;vertical-align:middle}
	.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
	.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
	.tg .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}
	</style>

	<?php 
		$dateFlag = null; $forGross = $forDiscount = $prioryear = $totalTothis = 0; $forTotal = [];
		function getPenalty($date,$qtr,$gross,$selection){
			/* selection current year 1, previous 2 */
			$toReturn = 0;
			if(isset($date) && isset($qtr) && isset($gross) && isset($selection)){
				/*$base = (int)((Date('d',strtotime($date))  / 3) < 0 ? (Date('d',strtotime($date))  / 3) : 1);*/
				$base = ltrim(Date('d',strtotime($date)), '0');
				$yearFromDate = Date('Y',strtotime($date));
				$yearFromQtr = substr($qtr, -4);
				switch ($selection) {
					case 1:
						if($yearFromQtr > $yearFromDate){
							return $toReturn;
						}
						break;
					case 2:
						if($yearFromQtr < $yearFromDate){
							return $toReturn;
						}
						break;
				}

				$data = DB::table('rssys.rptpenalty')->where('year',$yearFromQtr)->first();
				if(isset($data)){
					$toReturn = $gross * ((json_decode($data->value)->$base ?? 0) / 100);
				}
			}
			return $toReturn;
		}
		
	?>

	<section class="content">
		<h4>Daily Report on Real Property Tax Collections</h4>

		<div class="table-responsive">
			<table class="tg">
			  <tr>
			    <th class="tg-lboi" rowspan="3">Date</th>
			    <th class="tg-lboi" rowspan="3">Name of Tax Payer</th>
			    <th class="tg-lboi" rowspan="3">Period Covered</th>
			    <th class="tg-lboi" rowspan="3">O.R. No.</th>
			    <th class="tg-lboi" rowspan="3">TD/ARP. No.</th>
			    <th class="tg-lboi" rowspan="3">Name of Brangay</th>
			    <th class="tg-c3ow" colspan="7">Basic Tax</th>
			    <th class="tg-0pky" colspan="7">SEF</th>
			  </tr>
			  <tr>
			    <td class="tg-lboi" rowspan="2">Current  Year Gross Amount</td>
			    <td class="tg-lboi" rowspan="2">Discount</td>
			    <td class="tg-lboi" rowspan="2">Prior Years</td>
			    <td class="tg-9wq8" colspan="2">Penalties</td>
			    <td class="tg-9wq8" rowspan="2">Sub Total Gross Collections<br>(7+9+10+11)</td>
			    <td class="tg-9wq8" rowspan="2">Sub Total Net Collections<br>(12-8)</td>
			    <td class="tg-lboi" rowspan="2">Current  Year Gross Amount</td>
			    <td class="tg-lboi" rowspan="2">Discount</td>
			    <td class="tg-lboi" rowspan="2">Prior Years</td>
			    <td class="tg-c3ow" colspan="2">Penalties</td>
			    <td class="tg-9wq8" rowspan="2">Sub Total Gross Collections<br>(14+16+17+19)</td>
			    <td class="tg-9wq8" rowspan="2">Sub Total Net Collections<br>(19-5)</td>
			  </tr>
			  <tr>
			    <td class="tg-0pky">Current Year</td>
			    <td class="tg-0pky">Prior Years</td>
			    <td class="tg-0pky">Current Year</td>
			    <td class="tg-0pky">Prior Years</td>
			  </tr>
			  <tr>
			    <td class="tg-c3ow">1</td>
			    <td class="tg-c3ow">2</td>
			    <td class="tg-c3ow">3</td>
			    <td class="tg-c3ow">4</td>
			    <td class="tg-c3ow">5</td>
			    <td class="tg-c3ow">6</td>
			    <td class="tg-c3ow">7</td>
			    <td class="tg-c3ow">8</td>
			    <td class="tg-c3ow">9</td>
			    <td class="tg-c3ow">10</td>
			    <td class="tg-c3ow">11</td>
			    <td class="tg-c3ow">12</td>
			    <td class="tg-c3ow">13</td>
			    <td class="tg-c3ow">14</td>
			    <td class="tg-c3ow">15</td>
			    <td class="tg-c3ow">16</td>
			    <td class="tg-c3ow">17</td>
			    <td class="tg-c3ow">18</td>
			    <td class="tg-c3ow">19</td>
			    <td class="tg-c3ow">20</td>
			  </tr>
			  @isset($data)
			  @foreach($data as $key => $det)
			  @foreach($det as $orkey => $ordata)
			  @foreach($ordata as $qtrkey => $qtrdata)
			  <?php $forGross = $forDiscount = $prioryear = $newprioryear = $tPriorYear = 0; ?>
			  <tr>
			    <td class="tg-0pky">
			    	{{-- date --}}
			    	{{Date('m-d-Y',strtotime($key))}}
			    </td>
			    <td class="tg-0pky">
			    	{{-- payer --}}
			    	{{$qtrdata[0][0]->payer}}
			    </td>
			    <td class="tg-dvpl">
			    	{{-- quarter --}}
			    	{{$qtrkey}}
			    </td>
			    <td class="tg-dvpl">
			    	{{-- or --}}
			    	{{$orkey}}
				</td>
			    <td class="tg-0pky">
			    	{{-- bus --}}
			    	{{$qtrdata[0][0]->bus}}
			    </td>

			    <td class="tg-0pky">
			    	{{-- barangay --}}
			    	<?php 
			    		if(isset($qtrdata[0][0]->bus)){
			    			echo Core::getBarangayName($qtrdata[0][0]->bus);
			    		}
			    	?>
			    	
			    </td>
			    <td class="tg-0pky">
			    	{{-- gorss --}}
			    	@if($qtrdata[0][0]->periodcoveredyear != Date('Y'))
			    	@foreach($qtrdata as $insdeData)
			    		@if(strtolower($insdeData[0]->flag) == 'gross')
			    		<?php $forGross +=  $insdeData[0]->sum;?>
			    		@endif
			    	@endforeach
			    	@endif
			    	{{number_format($forGross,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][7] = $forGross; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- discount --}}
			    	{{-- @foreach($qtrdata as $insdeData) --}}
			    		{{-- @if(strtolower($insdeData[0]->flag) == 'discount') --}}
			    		{{-- @php $forDiscount +=  $insdeData[0]->sum; @endphp --}}
			    		{{-- @endif --}}
			    	{{-- @endforeach --}}
			    	<?php 
			    		$forDiscount = ((strpos($qtrkey, 'Qtr') !== false) ? ($forGross * .10) : 0);
			    	?>
			    	{{number_format($forDiscount,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][8] = $forDiscount; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- prior year --}}
			    	@if($qtrdata[0][0]->periodcoveredyear == Date('Y'))
			    	@foreach($qtrdata as $insdeData)
			    		@if(strtolower($insdeData[0]->flag) == 'gross')
			    		<?php $newprioryear +=  $insdeData[0]->sum;?>
			    		@endif
			    	@endforeach
			    	@endif
			    	{{number_format($newprioryear,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][9] = $newprioryear; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- penalties current year --}}
			    	@if(is_int($forTotal[$orkey][$qtrkey][7]))
						<?php $prioryear = 0; ?>
			    	@else
						<?php $prioryear = ($forTotal[$orkey][$qtrkey][7] * .12); ?>
			    	@endif
			    	<?php $prioryear = getPenalty(Date('m-d-Y',strtotime($key)), $qtrkey, ($forGross > 0 ? $forGross : $newprioryear),2); ?>
			    	{{number_format($prioryear,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][10] = $prioryear; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- penalties prior year --}}
			    	<?php $tPriorYear = getPenalty(Date('m-d-Y',strtotime($key)), $qtrkey, ($forGross > 0 ? $forGross : $newprioryear),1); ?>
			    	{{number_format($tPriorYear,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][11] = $tPriorYear; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- sub total gross collections --}}
			    	<?php $forTotal[$orkey][$qtrkey][12] = $forTotal[$orkey][$qtrkey][7] + $forTotal[$orkey][$qtrkey][9] + $forTotal[$orkey][$qtrkey][10] + $forTotal[$orkey][$qtrkey][11] ?>
			    	{{number_format( $forTotal[$orkey][$qtrkey][12] ,2 ) }}
			    </td>
			    <td class="tg-0pky">
			    	{{-- sub total total net collections --}}
			    	<?php $forTotal[$orkey][$qtrkey][13] = $forTotal[$orkey][$qtrkey][12] - $forTotal[$orkey][$qtrkey][8];?>
			    	{{number_format( $forTotal[$orkey][$qtrkey][13] ,2 ) }}
			    </td>


				<?php $forGross = $forDiscount = $prioryear = $tPriorYear = 0; ?>

			    <td class="tg-0pky">
			    	{{-- gross --}}
			    	@if($qtrdata[0][0]->periodcoveredyear != Date('Y'))
			    	@foreach($qtrdata as $insdeData)
			    		@if(strtolower($insdeData[0]->flag) == 'gross')
			    		<?php $forGross +=  $insdeData[0]->sum;?>
			    		@endif
			    	@endforeach
			    	@endif
			    	{{number_format($forGross,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][14] = $forGross; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- discount --}}
			    	{{-- @foreach($qtrdata as $insdeData)
			    		@if(strtolower($insdeData[0]->flag) == 'discount')
			    		@php $forDiscount +=  $insdeData[0]->sum; @endphp
			    		@endif
			    	@endforeach --}}
			    	<?php $forDiscount = ((strpos($qtrkey, 'Qtr') !== false) ? ($forGross * .10) : 0); ?>
			    	{{number_format($forDiscount,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][15] = $forDiscount; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- prior year --}}

			    	@if($qtrdata[0][0]->periodcoveredyear == Date('Y'))
			    	@foreach($qtrdata as $insdeData)
			    		@if(strtolower($insdeData[0]->flag) == 'gross')
			    		<?php $newprioryear +=  $insdeData[0]->sum;?>
			    		@endif
			    	@endforeach
			    	@endif
			    	{{number_format($newprioryear,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][16] = $newprioryear; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- penalties current year --}}
			    	@if(is_int($forTotal[$orkey][$qtrkey][14]))
						<?php $prioryear = 0; ?>
			    	@else
						<?php $prioryear = ($forTotal[$orkey][$qtrkey][14] * .12); ?>
			    	@endif
			    	<?php $prioryear = getPenalty(Date('m-d-Y',strtotime($key)), $qtrkey, ($forGross > 0 ? $forGross : $newprioryear),2); ?>
			    	{{number_format($prioryear,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][17] = $prioryear; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- penalties prior year --}}
			    	<?php $tPriorYear = getPenalty(Date('m-d-Y',strtotime($key)), $qtrkey, ($forGross > 0 ? $forGross : $newprioryear),1); ?>
			    	{{number_format($tPriorYear,2)}}
			    	<?php $forTotal[$orkey][$qtrkey][18] = $tPriorYear; ?>
			    </td>
			    <td class="tg-0pky">
			    	{{-- sub total gross collections --}}
			    	<?php $forTotal[$orkey][$qtrkey][19] = $forTotal[$orkey][$qtrkey][14] + $forTotal[$orkey][$qtrkey][16] + $forTotal[$orkey][$qtrkey][17] ?>
			    	{{number_format( $forTotal[$orkey][$qtrkey][19] ,2 ) }}
			    </td>
			    <td class="tg-0pky">
			    	{{-- sub total total net collections --}}
			    	<?php $forTotal[$orkey][$qtrkey][20] = $forTotal[$orkey][$qtrkey][19] - $forTotal[$orkey][$qtrkey][15];?>
			    	{{number_format( $forTotal[$orkey][$qtrkey][20] ,2 ) }}
			    </td>
			  </tr>
			  <?php $dateFlag = $key; ?>
			  @endforeach
			  @endforeach
			  @endforeach
			  @endisset

			  <tr>
			  	<td class="tg-0pky" colspan="2">Total this page</td>
			  	<td class="tg-0pky"></td><td class="tg-0pky"></td><td class="tg-0pky"></td><td class="tg-0pky"></td>
			  	@for($i = 7; $i < 21; $i++)
				@foreach($det as $orkey => $ordata)
				@foreach($ordata as $qtrkey => $qtrdata)
					<?php $totalTothis += $forTotal[$orkey][$qtrkey][$i]; ?>
				@endforeach
				@endforeach
				<td class="tg-0pky">{{number_format($totalTothis,2)}}</td>
				<?php $totalTothis = 0; ?>
				@endfor
			  </tr>

			  <tr>
			  	<td class="tg-0pky" colspan="3">CUMULATIVE TOTAL TO DATE</td>
			  	<td class="tg-0pky"></td><td class="tg-0pky"></td><td class="tg-0pky"></td>
			  	@for($i = 7; $i < 21; $i++)
				@foreach($det as $orkey => $ordata)
				@foreach($ordata as $qtrkey => $qtrdata)
					<?php $totalTothis += $forTotal[$orkey][$qtrkey][$i]; ?>
				@endforeach
				@endforeach
				<td class="tg-0pky">{{number_format($totalTothis,2)}}</td>
				<?php $totalTothis = 0; ?>
				@endfor
			  </tr>

			</table>
		</div>
		
	</section>

@endsection