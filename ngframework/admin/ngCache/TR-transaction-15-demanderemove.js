$(document).ready(function() {
	$(".step3 .btn-contrast").on("click", function(e) {
		var mandatID = $("#idMandat").val();
		$.ajax({
			type: "POST",
			url: "/transaction/demanderemove",
			data: {
				mandatID: mandatID
			},
			success: function(msg) {
				window.location.replace("/transaction/demande/");

			},
			error: function() {
				alert("erreur");

			}

		});


		e.preventDefault();
		return false;
	});

	

	


});