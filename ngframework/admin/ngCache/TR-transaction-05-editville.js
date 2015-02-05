
$(document).ready(function() {
	$(".step2 .btn-primary").on("click", function(e) {
		$.ajax({
			type: "POST",
			url: "/transaction/editville/"+$("#idville").val(),
			data: {
				id : $("#idville").val(),
				ville : $("#ville").val(),
				cp : $("#cp").val()
			},
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



});
