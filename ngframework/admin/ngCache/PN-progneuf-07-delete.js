$(document).ready(function() {
	$(".step3 .btn-contrast").on("click", function(e) {
		var mandatID = $("#idMandat").val();
		$.ajax({
			type: "POST",
			url: "/progneuf/delete",
			data: {
				mandatID: mandatID
			},
			success: function(msg) {
				window.location.replace("/progneuf/list/");
			},
			error: function() {
				alert("erreur");

			}

		});


		e.preventDefault();
		return false;
	});

	

	


});