<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>GS | Guihulngan System</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{url('bower_components/font-awesome/css/font-awesome.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{url('bower_components/Ionicons/css/ionicons.min.css')}}">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{url('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
	<!-- AdminLTE Skins. Choose a skin from the css/Skins
	   folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{url('dist/css/skins/_all-skins.min.css')}}">
	<link rel="stylesheet" href="{{url('dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="{{url('dist/css/dataTables.checkboxes.css')}}">
	<!-- Reancy -->
	<link rel="stylesheet" href="{{url('bower_components/morris.js/morris.css')}}">
	<link rel="stylesheet" href="{{url('bower_components/jvectormap/jquery-jvectormap.css')}}">
	<link rel="stylesheet" href="{{url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
	<link rel="stylesheet" href="{{url('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" href="{{url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
	<script src="{{url('bower_components/jquery/dist/jquery.min.js')}}"></script>
    @yield('head')
    <style>

		{{-- bootstrap 4.3.1 basic support added by Syrel --}}
    	.border{
    		border: 1px solid black!important;
    	}
    	.m-0{margin:0!important}.mt-0,.my-0{margin-top:0!important}.mr-0,.mx-0{margin-right:0!important}.mb-0,.my-0{margin-bottom:0!important}.ml-0,.mx-0{margin-left:0!important}.m-1{margin:.25rem!important}.mt-1,.my-1{margin-top:.25rem!important}.mr-1,.mx-1{margin-right:.25rem!important}.mb-1,.my-1{margin-bottom:.25rem!important}.ml-1,.mx-1{margin-left:.25rem!important}.m-2{margin:.5rem!important}.mt-2,.my-2{margin-top:.5rem!important}.mr-2,.mx-2{margin-right:.5rem!important}.mb-2,.my-2{margin-bottom:.5rem!important}.ml-2,.mx-2{margin-left:.5rem!important}.m-3{margin:1rem!important}.mt-3,.my-3{margin-top:1rem!important}.mr-3,.mx-3{margin-right:1rem!important}.mb-3,.my-3{margin-bottom:1rem!important}.ml-3,.mx-3{margin-left:1rem!important}.m-4{margin:1.5rem!important}.mt-4,.my-4{margin-top:1.5rem!important}.mr-4,.mx-4{margin-right:1.5rem!important}.mb-4,.my-4{margin-bottom:1.5rem!important}.ml-4,.mx-4{margin-left:1.5rem!important}.m-5{margin:3rem!important}.mt-5,.my-5{margin-top:3rem!important}.mr-5,.mx-5{margin-right:3rem!important}.mb-5,.my-5{margin-bottom:3rem!important}.ml-5,.mx-5{margin-left:3rem!important}.p-0{padding:0!important}.pt-0,.py-0{padding-top:0!important}.pr-0,.px-0{padding-right:0!important}.pb-0,.py-0{padding-bottom:0!important}.pl-0,.px-0{padding-left:0!important}.p-1{padding:.25rem!important}.pt-1,.py-1{padding-top:.25rem!important}.pr-1,.px-1{padding-right:.25rem!important}.pb-1,.py-1{padding-bottom:.25rem!important}.pl-1,.px-1{padding-left:.25rem!important}.p-2{padding:.5rem!important}.pt-2,.py-2{padding-top:.5rem!important}.pr-2,.px-2{padding-right:.5rem!important}.pb-2,.py-2{padding-bottom:.5rem!important}.pl-2,.px-2{padding-left:.5rem!important}.p-3{padding:1rem!important}.pt-3,.py-3{padding-top:1rem!important}.pr-3,.px-3{padding-right:1rem!important}.pb-3,.py-3{padding-bottom:1rem!important}.pl-3,.px-3{padding-left:1rem!important}.p-4{padding:1.5rem!important}.pt-4,.py-4{padding-top:1.5rem!important}.pr-4,.px-4{padding-right:1.5rem!important}.pb-4,.py-4{padding-bottom:1.5rem!important}.pl-4,.px-4{padding-left:1.5rem!important}.p-5{padding:3rem!important}.pt-5,.py-5{padding-top:3rem!important}.pr-5,.px-5{padding-right:3rem!important}.pb-5,.py-5{padding-bottom:3rem!important}.pl-5,.px-5{padding-left:3rem!important}

    	/*end*/
    	.parsley-errors-list {
    		color:red;
    		list-style: none;
    	}
    	#alert {
    		position: absolute;
    		top: 7rem;
    		right: 3rem;
    		z-index: 1;
    	}
    	#return-to-top {
		    position: fixed;
		    bottom: 20px;
		    right: 20px;
		    background: rgb(0, 0, 0);
		    background: rgba(0, 0, 0, 0.7);
		    width: 50px;
		    height: 50px;
		    display: block;
		    text-decoration: none;
		    -webkit-border-radius: 35px;
		    -moz-border-radius: 35px;
		    border-radius: 35px;
		    display: none;
		    -webkit-transition: all 0.3s linear;
		    -moz-transition: all 0.3s ease;
		    -ms-transition: all 0.3s ease;
		    -o-transition: all 0.3s ease;
		    transition: all 0.3s ease;
		}
		#return-to-top i {
		    color: #fff;
		    margin: 0;
		    position: relative;
		    left: 16px;
		    top: 13px;
		    font-size: 19px;
		    -webkit-transition: all 0.3s ease;
		    -moz-transition: all 0.3s ease;
		    -ms-transition: all 0.3s ease;
		    -o-transition: all 0.3s ease;
		    transition: all 0.3s ease;
		}
		#return-to-top:hover {
		    background: rgba(0, 0, 0, 0.9);
		}
		#return-to-top:hover i {
		    color: #fff;
		    top: 5px;
		}

        @media print
        {
        	.no-print, .no-print*
                {
                  display: none !important;
                }
        }
		

    </style>
</head>