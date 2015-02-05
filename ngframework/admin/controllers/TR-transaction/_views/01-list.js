$(document).ready(function() {

	$('.typeahead').typeahead({
		name: 'villes',
		prefetch: '/data/ville.json',
		limit: 10
	});
	$('.mandatahead').typeahead({
		name: 'mandat',
		prefetch: '/data/mandat.json',
		limit: 10
	});
	
	$(".typeahead, .mandatahead").on("blur", function(e) {
		$(this).val($(this).parent().find('.tt-suggestion p').html());
	});

});