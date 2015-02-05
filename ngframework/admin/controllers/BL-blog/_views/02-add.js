
$(document).ready(function() {
	$(".step1 .btn-primary").on("click", function(e) {
		var valueMandat = $("#title").val();
		$.ajax({
			type: "POST",
			url: "/blog/add",
			data: {
				title: valueMandat
			},
			success: function(msg) {
				var result = msg;
				if(result==='error'){
					alert("erreur");
				}else{
				
				window.location.replace("/blog/edit/"+result);
				}
			},
			error: function() {
				alert("erreur");

			}

		});


		e.preventDefault();
		return false;
	});


});


