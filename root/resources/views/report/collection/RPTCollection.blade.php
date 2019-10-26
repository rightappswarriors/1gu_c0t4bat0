@extends('_main')
@section('content')

	<section class="content">
		<h4>Daily Report on Real Property Tax Collections</h4>

		<div class="table-responsive">
			<table border="1" class="table">

				<thead>
					<tr>
						<td>Region/Province/City/Municipality</td>
						<td>GUIHULNGAN CITY, NEGROS ORIENTAL</td>
						<td></td>
						<td></td>
						<td colspan="14"></td>
					</tr>
					<tr>
						<td>Period Covered</td>
						<td></td>
						<td>8/1-31/2019</td>
						<td>Number of Brangays included in Report</td>
						<td colspan="14">{{-- total here --}}</td>
					</tr>
					<tr>
						<td rowspan="4">Real Property Classification</td>
					</tr>
					<tr style="text-align: center;">
						<td colspan="7">Basic Tax</td>
						<td colspan="7">SEF</td>
						<td rowspan="3">Grand Total Gross Collection</td>
						<td rowspan="3">Grand Total Net Collections</td>
					</tr>
					<tr>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
						<td>Current Year Gross Amount</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
						<td>5</td>
						<td>6</td>
						<td>7</td>
						<td>8</td>
						<td>9</td>
						<td>10</td>
						<td>11</td>
						<td>12</td>
						<td>13</td>
						<td>14</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Residential</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
						<td>5</td>
						<td>6</td>
						<td>7</td>
						<td>8</td>
						<td>9</td>
						<td>10</td>
						<td>11</td>
						<td>12</td>
						<td>13</td>
						<td>14</td>
						<td>15</td>
						<td></td>
						<td></td>
					</tr>
				</tbody>

			</table>
		</div>
	</section>

@endsection