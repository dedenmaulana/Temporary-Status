@push('style')
<style type="text/css">
	#form .menu{
		border:none;
	}
	.live-in{
		padding: 10px !important;
	}
	.photo{
		overflow: hidden;
	}
	.photo input{
		position: absolute;
		top: 0;
		left: 0;
		font-size: 1000px !important;
		overflow: hidden;
		opacity: 0;
		z-index: 10;
	}
	#image-photo{
		width: 80px;
		height: 80px;
		overflow: hidden;
		border:1px solid #ddd;
		border-radius: 3px;
	}
	#image-photo img{
		max-width: initial;
	}
	#form-body{
		border-top:6px solid #3b5998 !important;
	}
</style>
@endpush

<div class="ui negative message" style="display:none">
	<i class="close icon"></i>
	<div class="header">Oops, Error has been occurred.</div>
	<p>message</p>
</div>

<form method="post" action="{{URL::current()}}" class="ui form" enctype="multipart/form-data">
	<div class="ui segments" style="margin-top:0" id="form">
		<div class="ui facebook segment" id="form-body">
			<h4 class="ui dividing header" style="padding-bottom:10px;">
				<i class="pencil square icon"></i>
				<div class="content">Update Status</div>
			</h4>
			<div class="field">
				<textarea name="message" rows="3" placeholder="Your status here"></textarea>
			</div>
			<div class="field" style="display:none">
				<input type="url" id="link" name="link" placeholder="http://example.com/link">
			</div>
			<div class="ui image" style="display:none" id="image-photo">
				<img>
			</div>
		</div>
		<div class="ui segment" style="padding:0">
			<div class="ui borderless menu">
				<span class="header item disabled photo" data-content="Currently is not supported">
					<!-- <input type="file" name="image"> -->
					<i class="camera icon"></i>
				</span>
				<a href="#" class="header item show-link">
					<i class="linkify icon"></i>
				</a>
				<div class="live-in menu">
					<div class="inline field">
						<input type="hidden" name="post_in" value="{{date('Y-m-d H:i:s')}}">	
						<input type="hidden" name="delete_in" value="{{date('Y-m-d H:i:s', strtotime('+1 Weeks'))}}">
						<label>Live in :</label>
						<div class="ui icon button" id="dateRange"><i class="calendar icon"></i> 7 days</div>
					</div>
				</div>
				<div class="right menu">
					<div class="item" style="padding-right: 10px;">
						<button class="ui facebook icon button" id="post"><i class="facebook square icon"></i> Post</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
