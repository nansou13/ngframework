var Site = {
	init: function() {
		$('.dataTableInit').dataTable({
			"oLanguage": {
				"sProcessing": "Traitement en cours...",
				"sSearch": "Rechercher&nbsp;:",
				"sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
				"sInfo": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
				"sInfoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
				"sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
				"sInfoPostFix": "",
				"sLoadingRecords": "Chargement en cours...",
				"sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
				"sEmptyTable": "Aucune donnŽe disponible dans le tableau",
				"oPaginate": {
					"sFirst": "Premier",
					"sPrevious": "Pr&eacute;c&eacute;dent",
					"sNext": "Suivant",
					"sLast": "Dernier"
				},
				"oAria": {
					"sSortAscending": ": activer pour trier la colonne par ordre croissant",
					"sSortDescending": ": activer pour trier la colonne par ordre dŽcroissant"
				}

			}
		});
	},
	loadJS: function(jsFile, callBack, cache)
	{
		$.ajax({type: "GET", url: jsFile, success: callBack, dataType: "script", cache: true});
	},
	loadCSS: function(cssFile)
	{
		if ($('head link[href*="' + cssFile + '"]').length > 0) {
			return this;
		}

		if (Site.isIE) {
			var headID = document.getElementsByTagName("head")[0];
			var cssNode = document.createElement('link');
			cssNode.type = 'text/css';
			cssNode.rel = 'stylesheet';
			cssNode.href = cssFile;
			cssNode.media = 'all';
			headID.appendChild(cssNode);

		} else {
			h = '<link href="' + cssFile + '" media="all" rel="stylesheet" type="text/css" />';
			$('head link[type="text/css"]:last').after(h);
		}

		return this;
	},
	stopDefault: function(event)
	{
		(event && event.preventDefault) ? event.preventDefault() : window.event.returnValue = false;
	},
	redirect: function(url) {
		window.location = url;
	}
}
$(document).ready(function() {
	Site.init();
});