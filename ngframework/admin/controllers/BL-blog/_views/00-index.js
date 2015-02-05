$(document).on('focusin', function(e) {
         e.stopImmediatePropagation();
});



$(document).ready(function() {
	$('.ckeditor').each(function(e) {
		var nameEditor = $(this).attr('name');
		var editor = CKEDITOR.replace(nameEditor,
				{
					toolbar: [
						{name: 'styles', items: ['Styles', 'Font', 'FontSize']},
						{name: 'colors', items: ['TextColor', 'BGColor']},
						{name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike']},
						'/',
						{name: 'insert', items: ['HorizontalRule']},
						{name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
						{name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
						{name: 'links', items: ['Link', 'Unlink', 'Anchor']}
					]
				});

	});

	$("#SaveBlog").on("click", function(e) {
		$.ajax({
			url: '/BL/00',
			type: 'POST',
			data: {
				title: $('#title').val(),
				content: CKEDITOR.instances['description'].getData()
			},
			success: function(data, textStatus, jqXHR) {
				$("#myModal").modal('hide');
				document.location.reload();
			}
		});

		e.preventDefault();
		return false;
	});
	$(".bubble").on("click", function(e) {


		/*$(this).animate({
		 height: '600px'
		 },1000, function() {
		 // Animation complete.
		 });*/
		e.preventDefault();
		return false;
	});
});
