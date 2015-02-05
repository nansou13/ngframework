var CJAjaxRequest =
    {
	launch: function(url, type, data) {
	    if(type == undefined) type = 'GET';
	    if(data == undefined){if(type == 'GET') data = 'tplSelf'; else data = '';}

	    $("#loading").show();
	    $.ajax({
		url: url,
		type: type,
		data: data,
		success:function(jsonresponse){ CJAjaxRequest.parseAjaxResponse(jsonresponse);},
		error: function(){$("#loading").hide();if (window.console && window.console.error){ console.error(arguments); }}
	    });
	},

	parseAjaxResponse: function(jsonresponse){
	    var arrayResponse = eval("(" + jsonresponse + ")");
	    try {
		if(arrayResponse['html'] != null && arrayResponse != ''){
		    $('body').append(arrayResponse['html']);
		}

		if (arrayResponse['js'] != null && arrayResponse['js'] != '') {
		    if(jQuery.isArray( arrayResponse['js'] )) {
			    for (var i=0; i < arrayResponse['js'].length; i++) {
				    //console.log(arrayResponse['js'][i]);
				    eval('(' + arrayResponse['js'][i] + ')');
			    }
		    } else {
			    eval('(' + arrayResponse['js'] + ')');
		    }
		}
	    }catch(error){
		alert(error);
	    }

	    $("#loading").hide();
	},
	dialogMessage: function(message, fctOk) {
	    var id = $('.dialogMessage').length;
	    $('#actionDialogPreloads .dialogMessage').clone().appendTo('body').attr('id',id)
		    .find('.message').html(message).end()
		    .find('.button').click(function() {
			    if (fctOk != 'undefined' && fctOk != '') {
				    try { eval('(' + fctOk + ')'); }
				    catch(err) { alert(err); }
			    }
			    $('#'+id+'.dialogMessage').dialog("destroy").remove();
		    }).end()
	    .dialog({
		    title: $('#'+id+'.dialogMessage .dialogTitle').html(),
		    modal: true,
		    zIndex: 10000 + id,
		    draggable: false,
		    closeOnEscape: false,
		    open: function () { $('.ui-dialog-titlebar-close:last').remove();}
	    });
	},

	forward: function(url) {
		$("#loading").show();
		window.location.href = url;
	},

	reload : function() {
		$("#loading").show();
		window.location.reload();
	},

	backward: function() {
		$("#loading").show();
		window.history.back();
	}



    };

$(document).ready(function(){
    $('a.ajr').expire('click').livequery('click',function(e){
	if (!$(this).is('.disabled')) { CJAjaxRequest.launch($(this).attr('href')); }
	( e && e.preventDefault ) ? e.preventDefault() : window.event.returnValue = false;
    });
});