$(document).ready(function(){

	$('#dateRange').daterangepicker({
		startDate: moment(),
		endDate: moment().add(7, 'days'),
		minDate: moment(),
		maxDate: moment().add(1,'months'),
		"ranges": {
			"2 Days": [moment(), moment().add(1,'days')],
			"1 Week": [moment(), moment().add(1,'weeks')],
			"1 Month": [moment(), moment().add(1,'months')],
	    }
	}).on('apply.daterangepicker', function(event, picker) {
		$('[name=post_in]').val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
		$('[name=delete_in]').val(picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
		var caption = picker.endDate.from(picker.startDate, true);
		$(this).html('<i class="calendar icon"></i> '+caption);
	});

	$('#post').click(function(e){
		var button = $(this);
		e.preventDefault();
		var form = $(this).closest('.form');
		var message = form.find('textarea').val();
		var link = form.find('[type=url]');
		
		if (message === '') {
			form.find('textarea').parent().addClass('error');
			return false;
		} else {
			form.find('textarea').parent().removeClass('error');
		}

		if (link.is(':visible') && link.val() === '') {
			form.find('[type=url]').parent().addClass('error');
			return false;
		} else {
			form.find('[type=url]').parent().removeClass('error');
		}

		var data = new FormData(form[0]);
		button.addClass('loading');

		$.ajax({
			url: form.action,
			type: 'post',
			processData: false,
			contentType: false,
			data: data,
			complete: function(){
				button.removeClass('loading');
			},
			success: function(response) {
				$('.message').hide();
				if (response.status === 'success') {
					$('#statuses').find('.message').remove();
					$('#statuses').prepend(response.data);
					form[0].reset();
				} else {
					$('.message').show().find('p').html(response.message);
				}
			},
			error: function(data){
				var errors = data.responseJSON;
				var messages = '';

				if (typeof errors === 'undefined') {
					messages = data.statusText;
				} else {
					$.each(errors, function(index, message){
						messages += '<div>'+message[0]+'</div>';
					});
				}

				$('.message').show().find('p').html(messages);
			}
		});
	});

	$(document).on('click', '.show-link', function(e){
		e.preventDefault();
		$(this).find('i').removeClass('linkfy').addClass('unlink');
		$('[type=url]').parent().show();
		$(this).addClass('hide-link').removeClass('show-link');
	}).on('click', '.hide-link', function(e){
		e.preventDefault();
		$(this).find('i').removeClass('unlink').addClass('linkfy');
		$('[type=url]').parent().hide();
		$(this).addClass('show-link').removeClass('hide-link');
	});

	// $(document).on('change','[type=file]', function(){
	// 	var form = $(this).closest('#form');
	// 	form.find('#link').val('').parent().hide();
 //        form.find('#image-photo img').attr('src', URL.createObjectURL(this.files[0])).load(function(){
 //        	var image = $(this);
	//         image.parent().show();
	// 		if(image.width() > image.height()) {
 //        		image.css({'height':'100%','width':'auto'});
 //        	} else {
 //        		image.css({'width':'100%','height':'auto'});
 //        	}
 //        });
	// });
	
	$('[data-content]').popup();

	$(document).on('click', '.delete-status', function(){
		var status = $(this).closest('.status');
		var id = status.data('id');
		var provider = status.data('provider');

		swal({
			title: "Are you sure?",
			type: "warning",   
			showCancelButton: true,
			confirmButtonColor: "#3b5998",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false 
		}, function(){
			$.ajax({
				url: 'http://test.flipbox.co.id/'+provider+'/index/'+id,
				type: 'DELETE',
				success: function(response) {
					$('.message').hide();
					if (response.status === 'success') {
						swal("Deleted!", "Your Status has been deleted.", "success");
						status.remove();
					} else {
						$('.message').show().find('p').html(response.message);
					}
				},
				error: function(data){
					var errors = data.responseJSON;
					var messages = '';

					if (typeof errors === 'undefined') {
						messages = data.statusText;
					} else {
						$.each(errors, function(index, message){
							messages += '<div>'+message[0]+'</div>';
						});
					}

					$('.message').show().find('p').html(messages);
				}
			});
		});
	});

	$(document).on('click', '.post-status', function(){
		var status = $(this).closest('.status');
		var id = status.data('id');
		var provider = status.data('provider');

		swal({
			title: "Are you want to Send to Facebook now?",
			type: "warning",   
			showCancelButton: true,
			confirmButtonColor: "#3b5998",
			confirmButtonText: "Yes, Send it!",
			closeOnConfirm: false 
		}, function(){
			$.ajax({
				url: 'http://test.flipbox.co.id/'+provider+'/index/'+id,
				type: 'PUT',
				success: function(response) {
					$('.message').hide();
					if (response.status === 'success') {
						swal("Success!", "Your Status has been send.", "success");
						setTimeout(function(){
							window.location.reload();
						}, 1000);
					} else {
						$('.message').show().find('p').html(response.message);
					}
				},
				error: function(data){
					var errors = data.responseJSON;
					var messages = '';

					if (typeof errors === 'undefined') {
						messages = data.statusText;
					} else {
						$.each(errors, function(index, message){
							messages += '<div>'+message[0]+'</div>';
						});
					}

					$('.message').show().find('p').html(messages);
				}
			});
		});
	});
});
