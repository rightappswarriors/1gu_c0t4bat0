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