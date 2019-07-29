@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'LBP','icon'=>'none','st'=>false]
    ];
    $_ch = "LBP Form"; // Module Name
@endphp
@section('content')
<style>
	.border{
		border:2px solid black!important;
	}
	tr,td,th{
		border:2px solid black!important;
	}
	th{
		text-align: center;
	}
</style>
<!-- Content Header (Page header) -->
@include('layout._contentheader')

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form 8 Report</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
            </div>
		</div>
		<div class="box-body" style="">
			<div class="row">
				<div class="container " style="text-align: right;">BUDGET OPERATIONS MANUAL FOR LOCAL GOVERNMENT UNITS</div>
			</div>
			<div class="row" style="margin-top: 20px;">
				<div class="container " style="text-align: left;">LBP Form No. 8</div>
			</div>
			<div class="row" style="margin-top: 20px; font-weight: bold;">
				<div class="container " style="text-align: center;">STATEMENT OF FUNDING SOURCES</div>
				<div class="container " style="text-align: center;">(SUPPLEMENTAL BUDGET)</div>
				<div class="container " style="text-align: center;">FY {{$otherDetails['fy']}}</div>
			</div>

			<div class="row" style="margin-top: 20px; font-weight: bold;">
				<div class="container " style="text-align: center;"><u>{{$otherDetails['prov']}}</u></div>
				<div class="container " style="text-align: center;">Province/City/Municipality</div>
			</div>

			<div class="row" style="margin-top: 20px; font-weight: bold;">
				<div class="container " style="text-align: center;"><u>{{$otherDetails['fund']}}</u></div>
				<div class="container " style="text-align: center;">Fund/Special Account</div>
			</div>

			<div class="container table-responsive" style="margin-top: 30px; font-weight: bold;">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>
								Particulars<br>
								1
							</th>
							<th>
								Account Classification<br>
								2
							</th>
							<th>
								Amounts<br>
								3
							</th>
						</tr>
					</thead>
					<tbody>
						{{-- new revenue --}}
						<tr>
							<td>
								1.0 New Revenue Sources
								<div class="col-md" style="padding-left: 20px; padding-top: 5px;">
									@foreach($newrevenue as $key => $revenue)
										<div>
											{{($revenue->seq_desc ?? null)}}
										</div>
									@endforeach
								</div>
							</td>
							<td></td>
							<td>{{($newrevenue['total' ?? null])}}</td>
						</tr>
						{{-- actual collection --}}
						<tr>
							<td style="vertical-align: middle;">2.0 Actual Collection in Excess of the Estimated Income</td>
							<td>
								@foreach($actualcollection as $key => $collection)
									<div>
										{{($collection->seq_desc ?? null)}}
									</div>
								@endforeach
							</td>
							<td style="text-align: center; vertical-align: middle;">
								&#8369; {{(isset($actualcollection['total']) ? number_format($actualcollection['total'],2) : 0.00)}}
							</td>
						</tr>
						{{-- savings --}}
						<tr>
							<td style="vertical-align: middle;">3.0 Savings</td>
							<td>
								@foreach($savings as $key => $saving)
									<div>
										{{($saving->seq_desc ?? null)}}
									</div>
								@endforeach
							</td>
							<td style="text-align: center; vertical-align: middle;">
								&#8369; {{(isset($savings['total']) ? number_format($savings['total'],2) : 0.00)}}
							</td>
						</tr>

						{{-- realignment --}}
						<tr>
							<td style="vertical-align: middle;">4.0 Realignment</td>
							<td>
								@foreach($realignment as $key => $realign)
									<div>
										{{($realign->seq_desc ?? null)}}
									</div>
								@endforeach
							</td>
							<td style="text-align: center; vertical-align: middle;">
								&#8369; {{(isset($realignment['total']) ? number_format($realignment['total'],2) : 0.00)}}
							</td>
						</tr>
						
						{{-- reversion --}}
						<tr>
							<td style="vertical-align: middle;">5.0 Reversion</td>
							<td>
								@foreach($reversion as $key => $rever)
									<div>
										{{($rever->seq_desc ?? null)}}
									</div>
								@endforeach
							</td>
							<td style="text-align: center; vertical-align: middle;">
								&#8369; {{(isset($reversion['total']) ? number_format($reversion['total'],2) : 0.00)}}
							</td>
						</tr>

						{{-- total --}}

						<tr>
							<td style="text-align: center;">Total Estimated Income</td>
							<td></td>
							<td style="text-align: center; vertical-align: middle;">&#8369; {{$otherDetails['total']}}</td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</section>

@endsection