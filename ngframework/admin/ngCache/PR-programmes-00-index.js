$(document).ready(function() {

	$('.typeahead').typeahead({
		name: 'localisation',
		prefetch: '/data/ville.json',
		limit: 10
	});
});
