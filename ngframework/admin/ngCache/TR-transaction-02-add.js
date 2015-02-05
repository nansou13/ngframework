
$(document).ready(function() {
	$(".step1 .btn-primary").on("click", function(e) {
		$("#mandat2").val($("#mandat").val());
		var valueMandat = $("#mandat").val();
		$.ajax({
			type: "POST",
			url: "/transaction/add",
			data: {
				mandat: valueMandat
			},
			success: function(msg) {
				var result = msg;
				if(result==='error'){
					alert("erreur");
				}else{
				//$(".step1").css("display", "none");
				//$(".step2").css("display", "block");
				window.location.replace("/transaction/edit/"+valueMandat);
				}
			},
			error: function() {
				alert("erreur");

			}

		});


		e.preventDefault();
		return false;
	});
	$(".icon-euro.contrast").on("click", function(e) {
		$("#mandat2").removeAttr("disabled");
		console.log($("#formStep2").serialize());
		$("#mandat2").attr("disabled");
	});

	$("#btnValidPiece").on("click", function(e) {
		$("#mandat2").removeAttr("disabled");
		var valueMandat = $("#mandat2").val();
		console.log('mandat->'+valueMandat);
		$.ajax({
			type: "POST",
			url: "/transaction/add",
			data: {
				mandat3: valueMandat,
				nom : $("#piece_nom").val(),
				surface : $("#piece_surface").val(),
				orientation : $("#piece_orientation").val(),
				solmur : $("#piece_solmur").val(),
				note : $("#piece_note").val()
			},
			success: function(msg) {
				console.log('ok piece'+msg);
			},
			error: function() {
				alert("erreur");

			}

		});
		$("#mandat2").attr("disabled");
		e.preventDefault();
		return false;
	});
	$(".step2 .btn-primary").on("click", function(e) {
		$("#mandat2").removeAttr("disabled");
		$.ajax({
			type: "POST",
			url: "/transaction/add",
			data: $("#formStep2").serialize(),/*{
				mandat2: valueMandat,
				titre : $("#titre").val(),
				url : $("#url").val(),
				description : $("#description").val(),
				superficie : $("#superficie").val(),
				nbrepiece : $("#nbrepiece").val(),
				localisation : $("#localisation").val(),
				prix : $("#prix_const").val(),
				cp : $("#cp").val()
			},*/
			success: function() {
				$(".step2").css("display", "none");
				$(".step3").css("display", "block");
			},
			error: function() {
				alert("erreur");

			}

		});
		$("#mandat2").attr("disabled");
		e.preventDefault();
		return false;
	});

	$(".imgMandat").on("click", function(e) {
		$(".imgMandat").removeClass("selected");
		$(this).addClass("selected");
	});


});


$(function() {
	'use strict';
	// Change this to the location of your server-side upload handler:
	$('#fileupload').fileupload({
		url: '/TR/98',
		dataType: 'json',
		done: function(e, data) {

			$.each(data.result.files, function(index, file) {
				var idid = $('.imgMandat.selected').attr('id').split('-');
				var mandatID = $('#mandat2').val();

				$.ajax({
					type: "POST",
					url: "/TR/97",
					data: {fileName: file.name, id: mandatID, idpict: idid[1]}
				}).done(function(msg) {
					var info = msg.split('-');
					var d = new Date();
					//refresh miniature
					$('#mini-' + info[1] + ' img').attr("src", "/LD/IM/globals/mandatimg/" + info[0] + "/mini/" + info[1] + ".jpg?" + d.getTime());
					console.log('#mini-' + info[1]);
					//refresh 
					//$('#' + info[0] + '-' + info[1]).attr("src", "../images/" + info[0] + "/" + info[1] + ".jpg?" + d.getTime());

				});
				$('<p/>').text(file.name).appendTo('#files');
			});
		},
		progressall: function(e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .bar').css(
					'width',
					progress + '%'
					);
		}
	});
});


