$(document).ready(function() {
	$(".step3 .btn-contrast").on("click", function(e) {
		var mandatID = $("#idMandat").val();
		$.ajax({
			type: "POST",
			url: "/transaction/deleteville",
			data: {
				villeID: mandatID
			},
			success: function(msg) {
				window.location.replace("/transaction/listville/");
			},
			error: function() {
				alert("erreur");

			}

		});


		e.preventDefault();
		return false;
	});

	

	


});