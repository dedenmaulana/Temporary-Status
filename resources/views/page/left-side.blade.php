<div class="ui vertical menu" style="width:100%">
	<a href="{{URL::to('facebook')}}" class="{{Request::segment(1)==='facebook'?'active':''}} blue item"><i class="facebook square icon"></i> Facebook</a>
	<a href="{{URL::to('twitter')}}" class="{{Request::segment(1)==='twitter'?'active':''}} blue item"><i class="twitter square icon"></i> Twitter</a>
</div>