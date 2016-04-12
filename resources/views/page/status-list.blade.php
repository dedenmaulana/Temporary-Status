<div id="statuses">
	@if(count($statuses) > 0)
		@foreach($statuses as $status)
			@include('page.status')
		@endforeach
	@else
		<div class="ui message">
			<p>You have no statuses yet.</p>
		</div>
	@endif
</div>
