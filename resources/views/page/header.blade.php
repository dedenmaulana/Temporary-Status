<div class="ui fixed {{Request::segment(1)}} inverted borderless menu">
	<div class="ui container">
		<a href="#" class="header item">
			<img src="{{Auth::user()->profile_picture}}" style="margin-right:10px">
			<span>{{Auth::user()->name}}</span>
		</a>
		<div class="right menu">
			<a href="{{URL::to('facebook/logout')}}" class="header item">Logout</a>
		</div>
	</div>
</div>