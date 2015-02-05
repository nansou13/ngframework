
$(document).ready(function() {
	$(".step1 .btn-primary").on("click", function(e) {
		$.ajax({
			type: "POST",
			url: "/transaction/addville",
			data: {
				ville : $("#ville").val(),
				cp : $("#cp").val()
			},
			success: function() {
				$(".step1").css("display", "none");
				$(".step3").css("display", "block");
			},
			error: function() {
				alert("erreur");

			}

		});
		e.preventDefault();
		return false;
	});

	


});