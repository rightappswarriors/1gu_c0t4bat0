 <!DOCTYPE html>
<html>
	@include ('layout._head')
	<style type="text/css">
	  .load{position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);
	  /*change these sizes to fit into your project*/
	  width:100px;
	  height:100px;
	}
	.load hr{border:0;margin:0;width:40%;height:40%;position:absolute;border-radius:50%;animation:spin 2s ease infinite}

	/*.load :first-child{background:#00A65A;animation-delay:-1.5s}
	.load :nth-child(2){background:#00A65A;animation-delay:-1s}
	.load :nth-child(3){background:#00A65A;animation-delay:-0.5s}
	.load :last-child{background:#00A65A}*/

	{{--@keyframes spin{
	  0%,100%{transform:translate(0)}
	  25%{transform:translate(160%)}
	  50%{transform:translate(160%, 160%)}
	  75%{transform:translate(0, 160%)}
	}--}}
	</style>
	@php
		$_bc = [];
	@endphp
	<body class="hold-transition skin-blue sidebar-mini skin-green fixed">

		<div class="load" style="z-index: 999999;">
		 <hr/><hr/><hr/><hr/>
		 <img src="{{asset('root/public/img/131.gif')}}" alt="loading image">
	    </div> 

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
	<script>
		 $( document ).ajaxComplete(function() {
	        $('.load').hide();
	      });

		 $( document ).ajaxStart(function() {
	        $('.load').show();
	      });

	      $(document).ready(function(){
	        $('.load').hide();
	      })
	</script>
</html>