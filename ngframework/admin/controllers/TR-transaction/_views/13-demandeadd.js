

$(document).ready(function() {



    $(".step2 .btn-primary").on("click", function(e) {
		var vals = $("#formStep2").serializeArray();
		vals.push({name: 'localisation_maxi', value: CKEDITOR.instances.localisation_maxi.getData()});
		vals.push({name: 'detail', value: CKEDITOR.instances.detail.getData()});
        $.ajax({
            type: "POST",
            url: "/transaction/demandeadd",
            data: vals,
            success: function() {
                $(".step2").css("display", "none");
                $(".step3").css("display", "block");
            },
            error: function() {
                alert("erreur");

            }

        });
        e.preventDefault();
        return false;
    });
    
	$('.ckeditor').each(function(e) {
		var nameEditor = $(this).attr('name');
		var editor = CKEDITOR.replace(nameEditor,
				{
					toolbar: [
						{name: 'styles', items: ['FontSize']},
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

});

