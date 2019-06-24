<!DOCTYPE html>
<html>
	@include ('layout._head')
	@php
		$_bc = [];
	@endphp
	<body class="hold-transition skin-blue sidebar-mini skin-green fixed">
		@include ('layout._header')
		@include ('layout._alert')
		@include('layout._sidebar')
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			@yield('content')
		</div>
		@include ('layout._footer')
		@include ('layout._right-sidebar')
	</body>
	@include ('layout._script')
</html>