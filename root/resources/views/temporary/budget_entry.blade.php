@extends('layout._reports')

@section('content')
<div class="header">
	<h4>{{strtoupper('bgt01.t_desc')}}</h4>
	<h4>{{strtoupper('bgt01.fid')}}</h4>
	<h4>bgt01.t_date</h4>
</div>
<div class="table-container">
	<table class="table">
		<thead>
			<tr>
				<th>Account</th>
				<th rowspan="2">Function/Program/Project</th>
				<th rowspan="2">Appropriation</th>
				<th rowspan="2">Allotment</th>
				<th rowspan="2">Obligations</th>
				<th colspan="2">Balances of</th>
			</tr>
			<tr>
				<th>Code</th>
				<th>APPROPRIATIONS</th>
				<th>ALLOTMENTS</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				@for($i=0;$i<7;$i++)
				@if($i==1)
				<td class="text-center"><u>CURRENT YEAR APPROPRIATIONS</u></td>
				@else
				<td></td>
				@endif
				@endfor
			</tr>
		</tbody>
	</table>
</div>
@stop