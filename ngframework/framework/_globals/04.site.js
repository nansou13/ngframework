var Site = {
	init: function() {
		//Charge click twitter
		
	},
	loadJS: function(jsFile, callBack, cache)
	{
		$.ajax({type: "GET", url: jsFile, success: callBack, dataType: "script", cache: true});
	},
	loadCSS: function(cssFile)
	{
		if ( $('head link[href*="' + cssFile + '"]').length > 0 ) {return this;}

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
    stopDefault: function( event )
	{
		( event && event.preventDefault ) ? event.preventDefault() : window.event.returnValue = false;
	},
	redirect: function(url) {
		window.location = url;
	}
}
$(document).ready( function(){Site.init();} );