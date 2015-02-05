
$(document).ready(function() {
    $('.widget-content .nav-tabs li a').on("click", function(e) {
        $('.widget-content .nav-tabs li').removeClass("active");
        $(this).parent().addClass("active");
        $('.stepLot, .stepImg, .stepDesc').css("display", "none");

        $('.' + $(this).attr('rel')).css("display", "block");
        e.preventDefault();
    });
	
	$('#lot_nom').keyup(function() {
 		if($(this).val()!=''){
			$('#btnValidPiece').removeClass("disabled");
		}else{
			$('#btnValidPiece').addClass("disabled");
		}
	});
	
    $("body").on("click", ".icon-trash-a", function(e) {
        //ajax suppression
        var parentBlock = $(this).parent().parent();
        var idpiece2deleteArray = $(this).parent().parent().attr('id');
        var idpiece2delete = idpiece2deleteArray.split('-');
        console.log(idpiece2delete);
        $.ajax({
            type: "POST",
            url: "/admin/edit",
            data: {
                deletelot: idpiece2delete[1]

            },
            success: function(msg) {
                parentBlock.remove();
            },
            error: function() {
                alert("erreur");

            }

        });

        e.preventDefault();
    });
    
	$('#lot_nom, #lot_type, #lot_etage, #lot_surface, #lot_terasse, #lot_prix').keyup(function(e) { 
        if (e.keyCode == 13) {
            //votre code à exécuter
            $("#btnValidLot").get(0).click();
        }
    });
    
    $("#btnValidLot").on("click", function(e) {
        var valueMandat = $("#mandat2").val();
		//check si ya une image
		if($('#messageLotOK').html()==''){
			alert('Attention il n\'y a pas de fichier PDF');
			$('#messageLotOK').html('aucun PDF');
			return;
		}
		
        $.ajax({
            type: "POST",
            url: "/admin/edit",
            data: {
                mandat3: valueMandat,
                nom: $("#lot_nom").val(),
                type: $("#lot_type").val(),
                etage: $("#lot_etage").val(),
                surface: $("#lot_surface").val(),
                terasse: $("#lot_terasse").val(),
                prix: $("#lot_prix").val()
            },
            success: function(msg) {
                console.log('ok piece' + msg);

                var htmlContent = '<tr class="contentPiece" id="idp-' + msg + '"><td>' + $("#lot_nom").val() + '</td><td>' + $("#lot_type").val() + '</td><td>' + $("#lot_etage").val() + '</td><td>' + $("#lot_surface").val() + 'm2</td><td>' + $("#lot_terasse").val() + 'm2</td><td>' + $("#lot_prix").val() + '</td><td><a href="#" class="icon-trash-a"><i class="icon-trash"></i></a></td></tr>';
                $('#lot_nom, #lot_type, #lot_etage, #lot_surface, #lot_terasse, #lot_prix').val('');
				$('#messageLotOK').html('');
                $('#lots tbody').append(htmlContent);
            },
            error: function() {
                alert("erreur");

            }

        });
        $("#mandat2").attr("disabled");
        e.preventDefault();
        return false;
    });

    $(".step2 .btn-primary").on("click", function(e) {
        $('.stepLot, .stepImg, .stepDesc').css("display", "block");
var vals = $("#formStep2").serializeArray();
vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
        $.ajax({
            type: "POST",
            url: "/admin/edit",
            data: vals,
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
    $("#addImgPict").on("click", function(e) {
        var valueMandat = $("#mandat2").val();
        var nbimgMandat = $('.imgMandat').length + 1;
        if (nbimgMandat < 10)
            nbimgMandat = "0" + nbimgMandat;

        $(".imgMandat").removeClass("selected");
        $('<div class="col-sm-3 imgMandat selected" id="mini-' + nbimgMandat + '"><img src="/LD/IM/globals/neufimg/' + valueMandat + '/mini/' + nbimgMandat + '.jpg"></div>').insertBefore("#addImgPict");
        $("#btnSuccessPhoto").removeClass("disabled");
    });
    $("body").on("click", ".imgMandat", function(e) {

        $(".imgMandat").removeClass("selected");
        $(this).addClass("selected");
        $("#btnSuccessPhoto").removeClass("disabled");
    });
    $('.deleteIMG').on("click", function(e) {
        var nbimgplz = $('.imgMandat').length;
        var mandatID = $("#mandat2").val();
        console.log(nbimgplz);
        if (nbimgplz == 1)
            $('.deleteIMG').addClass("disabled");

        //supprime le dernier
        if (nbimgplz < 10)
            nbimgplz = "0" + nbimgplz;


        $.ajax({
            type: "POST",
            url: "/99/97",
            data: {delImg: nbimgplz, id: mandatID}
        }).done(function(msg) {
            $('#mini-' + nbimgplz).remove();

        });


    });
	$('.ckeditor').each(function(e) {
		var nameEditor = $(this).attr('name');
		var editor = CKEDITOR.replace(nameEditor,
				{
					toolbar: [
						{name: 'styles', items: ['Styles', 'Font', 'FontSize']},
						{name: 'colors', items: ['TextColor', 'BGColor']},
						{name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike']},
						'/',
						{name: 'insert', items: ['HorizontalRule']},
						{name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
						{name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
						{name: 'links', items: ['Link', 'Unlink', 'Anchor']}
					]
				});

	});

});

$(document).ready(function() {
    var nbimgplz = $('.imgMandat').length;

    if (nbimgplz > 0) {
        console.log("supAzero");
        $('.deleteIMG').removeClass("disabled");
    }
});




$(function() {
    'use strict';
    // Change this to the location of your server-side upload handler:
    $('#fileupload').fileupload({
        url: '/99/98',
        dataType: 'json',
        start: function() {
            //lance le chargement
            $('#progressBarPhoto').removeClass('hidden');
        },
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                var idid = $('.imgMandat.selected').attr('id').split('-');
                var mandatID = $('#mandat2').val();

                $.ajax({
                    type: "POST",
                    url: "/99/97",
                    data: {fileName: file.name, id: mandatID, idpict: idid[1]}
                }).done(function(msg) {
                    var info = msg.split('-');
                    var d = new Date();
                    //refresh miniature
                    $('#mini-' + info[1] + ' img').attr("src", "/LD/IM/globals/neufimg/" + info[0] + "/mini/" + info[1] + ".jpg?" + d.getTime());
                    //disabled bouton et remove selected
                    $(".imgMandat").removeClass("selected");
                    $("#btnSuccessPhoto").addClass("disabled");
                    $('#progressBarPhoto').addClass('hidden');

                });

            });
        }
    });
	$('#fileuploadLot').fileupload({
        url: '/99/98',
        dataType: 'json',
        start: function() {
            //lance le chargement
            $('#progressBarPhoto').removeClass('hidden');
        },
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                var idid = $('#lot_nom').val();
                var mandatID = $('#mandat2').val();

                $.ajax({
                    type: "POST",
                    url: "/99/90",
                    data: {fileName: file.name, id: mandatID, idpict: idid}
                }).done(function(msg) {
                    //affiche que c'est uploade
					$('#messageLotOK').html('Fichier ajoute');
                    $('#progressBarPhoto').addClass('hidden');

                });

            });
        }
    });

});


