@extends('layout._reports')

@section('content')
<div class="header">
	<h4>Province of Negros</h4>
	<h3>{{strtoupper('CITY OF GUIHULNGAN')}}</h3>
	<h2>Office of the City Budget Officer</h2>
	<div class="divider"></div>
</div>
<div class="heading">
	<div class="letter-date">{{date('F d, Y')}}</div>
</div>
<div class="address">
	<p>The Honnorable Sangguniang Panlungsod <br>
		Sangguniang Panglungsod <br>
		City of Guihulngan, Negros Oriental
	</p>
</div>
<div class="greeting">
	Sir/Madam:
</div>
<div class="body">
	<p style="text-indent: 5rem; text-align: justify;">
		I am transmitting herewth the Annual Budget for Calendar Year 2017 of the General Funds this City pursuant to P.D. No. 477 as amenced by P.D. No. 1375 and in accordance to the Republic Act No. 7160 known as the new Local Government Code of 1991 for submission to the Office of the Sangguiniang Panlalawigan, Dumaguete City, Province of Negros Oriental.
	<br><span style="padding-left: 5rem;">Thank you and vest regards</span>
	</p>
</div>
<div class="clossing">
	Very yours truly,
</div>
<div class="clossing-signature">
	{{strtoupper('Ma. Socorro M. Nunez')}}
	<br>City Budget Officer
</div>
<div class="noted">
	Noted By:
</div>
<div class="noted-signature">
	{{strtoupper('Carlo Jorge Joan L. Reyes')}}
	<br>City Mayor
</div>

<script type="text/javascript">
	PrintPage();
</script>
@stop