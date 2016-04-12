<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', 'Temporary Status')</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('res/semantic.min.css')}}">
	<style type="text/css">
		body{
			background: #f1f1f1;
			padding-top: 80px;
		}
	</style>
</head>
<body>
	<div class="ui fixed blue inverted borderless menu">
		<div class="ui container">
			<a href="/" class="header item">
				<img src="{{asset('logo.png')}}" style="margin-right:10px">
				Temporary Status
			</a>
			<a href="/privacypolicy" class="header item">
				Privacy &amp; Policy
			</a>
			<a href="/terms" class="header item">
				Terms of Service
			</a>
		</div>
	</div>
	<div class="ui container" id="primary-container">
		<div class="ui two column grid">
			<div class="twelve wide column">
				<header class="ui header">	
					<h2>@yield('title', 'Temporary Status')</h2>
				</header>
				<div class="ui segment">
					@yield('content')
				</div>
			</div>
			<div class="four wide column">
			&nbsp;
			</div>
		</div>
	</div>
</body>
</html>