var formCheck =
    {
	ssRep:'/likediscount',
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

        checkByType: function(value, type){

            switch(type){
                case 'isEmpty': if(value.val() == ''){return true};break;
				case 'isPhoneNumber':return (jQuery.trim(value.val()).length > 0) ? !(eval("/^((0[6-7])[0-9]{8})$/").test(jQuery.trim(value.val()))):true;break;
				case 'isValidName':return (jQuery.trim(value.val()).length > 0 )? !(/^[^&~#\{\(\[\|`_\\\^@\)\]°=\}\+¤\$£\^¨€%\*µ!§:\/;\.,\?<>0123456789£¤¨µ§]{2,32}$/i.test(jQuery.trim(value.val()))):true;break;
				case 'isValidEmail':return (jQuery.trim(value.val()).length > 0) ? !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(jQuery.trim(value.val()))):true;break;
				case 'isChecked':return !(value.is(':checked'));break;
				case 'newAccount' : res = false;
						$.ajax(
						{
							url: formCheck.ssRep+'/AJ/00/formCheck/newAccount',
							type: "POST",
							dataType: "text",
							data: "val="+jQuery.trim(value.val()),
							async:false,
							success: function(re){res=re;return re;}
						});
						return eval(res);
						break;
			}
            
        }



    };

$(document).ready(function(){
    $('form.formCheck').submit(function(){
        var self = this;
		var errorOK = false;
        //alert($('input[type="text"]',this).attr('value'));
        $('input',this).each(function(){
            var inputValue = $(this).attr('value');
            var inputName = $(this).attr('name')
			var inputJquery = $(this);


            if($('#'+inputName+'_errors div',self).length>0){
                $('#'+inputName+'_errors div').each(function(){
					if(!errorOK){
						if(formCheck.checkByType(inputJquery, $(this).attr('class'))){
							var classDivError = $('#'+inputName+'_errors .formcheckErrorDiv').attr('value');
							var textError = $(this).html();
							$('.'+classDivError).html(textError);
							errorOK = true
						}
					}
                })
            }
			
        })

		if(errorOK==true)
			return false;
    })
});