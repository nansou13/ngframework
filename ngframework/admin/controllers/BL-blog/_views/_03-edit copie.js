
$(document).ready(function() {
	$(".step2 .btn-primary").on("click", function(e) {
		var vals = $("#formStep2").serializeArray();
		vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
		$.ajax({
			type: "POST",
			url: "/blog/edit",
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
	$("#addImgPict").on("click", function(e) {
		var valueMandat = $("#mandat2").val();
		var nbimgMandat = $('.imgMandat').length + 1;
		if (nbimgMandat < 10)
			nbimgMandat = "0" + nbimgMandat;

		$(".imgMandat").removeClass("selected");
		$('<div class="col-sm-3 imgMandat selected" id="mini-' + nbimgMandat + '"><img src="http://neuf.immextenso.fr/LD/IM/globals/neufimg/' + valueMandat + '/mini/' + nbimgMandat + '.jpg"></div>').insertBefore("#addImgPict");
		$("#btnSuccessPhoto").removeClass("disabled");
	});
	$("body").on("click", ".imgMandat", function(e) {

		$(".imgMandat").removeClass("selected");
		$(this).addClass("selected");
		$("#btnSuccessPhoto").removeClass("disabled");
	});
	$('.deleteIMG').on("click", function(e) {
		var nbimgplz = $('.imgMandat').length;
		var mandatID = $("#mandat2").val();
		console.log(nbimgplz);
		if (nbimgplz == 1)
			$('.deleteIMG').addClass("disabled");

		//supprime le dernier
		if (nbimgplz < 10)
			nbimgplz = "0" + nbimgplz;


		$.ajax({
			type: "POST",
			url: "/PN/97",
			data: {delImg: nbimgplz, id: mandatID}
		}).done(function(msg) {
			$('#mini-' + nbimgplz).remove();

		});


	});
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

});

$(document).ready(function() {
	var nbimgplz = $('.imgMandat').length;

	if (nbimgplz > 0) {
		console.log("supAzero");
		$('.deleteIMG').removeClass("disabled");
	}
});




$(function() {
	'use strict';
	// Change this to the location of your server-side upload handler:
	$('#fileupload').fileupload({
		url: '/PN/98',
		dataType: 'json',
		start: function() {
			//lance le chargement
			$('#progressBarPhoto').removeClass('hidden');
		},
		done: function(e, data) {

			$.each(data.result.files, function(index, file) {
				var idid = $('.imgMandat.selected').attr('id').split('-');
				var mandatID = $('#mandat2').val();

				$.ajax({
					type: "POST",
					url: "/PN/97",
					data: {fileName: file.name, id: mandatID, idpict: idid[1]}
				}).done(function(msg) {
					var info = msg.split('-');
					var d = new Date();
					//refresh miniature
					$('#mini-' + info[1] + ' img').attr("src", "http://neuf.immextenso.fr/LD/IM/globals/neufimg/" + info[0] + "/mini/" + info[1] + ".jpg?" + d.getTime());
					//disabled bouton et remove selected
					$(".imgMandat").removeClass("selected");
					$("#btnSuccessPhoto").addClass("disabled");
					$('#progressBarPhoto').addClass('hidden');

				});

			});
		}
	});
	$('#fileuploadLot').fileupload({
		url: '/PN/98',
		dataType: 'json',
		start: function() {
			//lance le chargement
			$('#progressBarPhoto').removeClass('hidden');
		},
		done: function(e, data) {

			$.each(data.result.files, function(index, file) {
				var idid = $('#lot_nom').val();
				var mandatID = $('#mandat2').val();

				$.ajax({
					type: "POST",
					url: "/PN/90",
					data: {fileName: file.name, id: mandatID, idpict: idid}
				}).done(function(msg) {
					//affiche que c'est uploade
					$('#messageLotOK').html('Fichier ajoute');
					$('#progressBarPhoto').addClass('hidden');

				});

			});
		}
	});

});


