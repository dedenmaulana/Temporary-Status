const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : CSRF_TOKEN,
    }
});

$('.message .close') .on('click', function() {
    $(this) .closest('.message').transition('fade');
});