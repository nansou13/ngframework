
$(document).ready(function() {
	$(".step1 .btn-primary").on("click", function(e) {
		$("#mandat2").val($("#mandat").val());
		var valueMandat = $("#mandat").val();
		$.ajax({
			type: "POST",
			url: "/transaction/demandenew",
			data: {
				mandat: valueMandat
			},
			success: function(msg) {
				var result = msg;
				if(result==='error'){
					alert("erreur");
				}else{
				window.location.replace("/transaction/demandeadd/"+result);
				
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