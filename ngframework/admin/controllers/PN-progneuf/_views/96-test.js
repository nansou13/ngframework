
$(document).ready(function() {
	$(".APNicon").draggable({
		containment: "parent",
		stop: function() {
			var mandatID = 'TOTO';
			var top = $(this).css('top');
			var left = $(this).css('left');
			console.log(top, left);

			$.ajax({
				url: "/progneuf/test/",
				type: "POST",
				data: {
					mandatAPN: mandatID,
					idapn: $(this).attr('id'),
					top: top,
					left: left,
					img: ''
				}
			});
		}
	});
	$(".APNicon").on("click", function(e) {
		console.log('clic sur ' + $(this).attr('id'));
	});
	$(".ADDAPN").on("click", function(e) {
		var NEWID = $('.APNicon').length + 1;
		$("#planModele").append('<div class="APNicon" id="apn-' + NEWID + '"></div>');
		$("#apn-"+NEWID).draggable({
			containment: "parent",
			stop: function() {
				var mandatID = 'TOTO';
				var top = $(this).css('top');
				var left = $(this).css('left');
				console.log(top, left);

				$.ajax({
					url: "/progneuf/test/",
					type: "POST",
					data: {
						mandatAPN: mandatID,
						idapn: $(this).attr('id'),
						top: top,
						left: left,
						img: ''
					}
				});
			}
		});
	});
});


