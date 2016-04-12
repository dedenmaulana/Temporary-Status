<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<title>Facebook Temporary Status</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('res/semantic.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('sweetalert/sweetalert.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('daterangepicker/daterangepicker.min.css')}}">
	<style type="text/css">
		body{
			background: #f1f1f1;
		}
		#primary-container{
			padding-top: 70px;
		}
		.status p{
			word-wrap: break-word;
		}
		#statuses{
			margin-top: 15px;
		}
		.facebook.menu{background-color:#3b5998 !important;}
		.twitter.menu{background-color:#00aced !important;}
	</style>
	@stack('style')
</head>
<body>
	@include('page.header')
	<div class="ui container" id="primary-container">
		<div class="ui three column grid">
			<div class="four wide tablet only computer only column">
				@include('page.left-side')
			</div>

			<div class="sixteen wide mobile twelve wide tablet eight wide computer column">
				@yield('content')
			</div>
			
			<div class="four wide computer only column">
				@include('page.right-side')
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{{asset('jquery-1.12.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('res/semantic.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('app.js')}}"></script>
	<script type="text/javascript" src="{{asset('form.js')}}"></script>
	<script type="text/javascript" src="{{asset('sweetalert/sweetalert.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('daterangepicker/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('daterangepicker/daterangepicker.min.js')}}"></script>
</body>
</html>