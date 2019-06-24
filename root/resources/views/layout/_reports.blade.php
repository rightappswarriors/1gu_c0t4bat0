{{-- 
	This page is used on blades under the following folder/file:
	-(folder)temporary

	*By: Paolo 1/25/2019 11:57 AM
 --}}
<!DOCTYPE html>
<html>
<head>
	<title>Reports{{($pageTitle != null) ? "-".$pageTitle : ""}}</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/temp.css')}}">
	<script type="text/javascript" src="{{url('js/print-window.js')}}"></script>
</head>
<body>
	<span class="alert-text no-print">Note:Please set the layout/orientation to {{($printOrientation != "portrait") ? $printOrientation : "Portrait"}}</span>
	<button class="no-print" onclick="PrintPage()">Print</button>
	<div class="content">
		@yield('content')
	</div>
</body>
</html>