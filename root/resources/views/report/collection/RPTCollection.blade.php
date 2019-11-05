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

	<?php $dateFlag = null; ?>

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
			  <tr>
			    <td class="tg-0pky">{{( $dateFlag != $key ? $key : '')}}</td>
			    <td class="tg-0pky"></td>
			    <td class="tg-dvpl"></td>
			    <td class="tg-dvpl"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			    <td class="tg-0pky"></td>
			  </tr>
			  <?php $dateFlag = $key; ?>
			  @endforeach
			  @endisset
			</table>
		
	</section>

@endsection