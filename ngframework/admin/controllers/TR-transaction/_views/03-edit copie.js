

$(document).ready(function() {


$("#manageimgarray tbody").sortable(
            {
                update: function(event, ui) {
					var mandatID = $("#mandat2").val();
                    var newOrder = $(this).sortable('toArray').toString();
					console.log(newOrder, $(this), ui.item.attr('id'));
                    $.post('/transaction/93/', {order: newOrder, id: mandatID});
                }})
            .disableSelection();

$('#myModal').on('shown.bs.modal', function() {
        var mandatID = $("#mandat2").val();
       
        $.ajax({
            type: "POST",
            url: "/TR/93",
            data: {getimglist: 1, id: mandatID}
        }).done(function(msg) {
            $('#manageimgarray tbody').html(msg);

        });
    })



$("#pieceArrayExt tbody").sortable(
            {
                update: function(event, ui) {
                    var newOrder = $(this).sortable('toArray').toString();
					console.log(newOrder, $(this));
                    $.post('/transaction/edit/', {order_ext: newOrder});
                }})
            .disableSelection();
$("#pieceArray tbody").sortable(
            {
                update: function(event, ui) {
                    var newOrder = $(this).sortable('toArray').toString();
					console.log(newOrder, $(this));
                    $.post('/transaction/edit/', {order: newOrder});
                }})
            .disableSelection();


    $('.widget-content .nav-tabs li a').on("click", function(e) {
        $('.widget-content .nav-tabs li').removeClass("active");
        $(this).parent().addClass("active");
        $('.stepDetail, .stepImg, .stepDesc').css("display", "none");

        $('.' + $(this).attr('rel')).css("display", "block");
        e.preventDefault();
    });
	
	/*$('#title').tooltip({'trigger':'focus', 'title': 'title tooltip'});*/

    $(".APNicon").draggable({
        containment: "parent",
        stop: function() {
            $("#mandat2").removeAttr("disabled");
            var mandatID = $("#mandat2").val();
            var top = $(this).css('top');
            var left = $(this).css('left');
            console.log(top, left);

            $.ajax({
                url: "/transaction/edit/",
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
    $("body").on("click", ".APNicon", function(e) {
        $(".APNicon").removeClass("selected");
        var mandatID = $("#mandat2").val();
        $(this).addClass("selected");
        var idPictoto = $(this).attr('id');
        $(".deleteSpot").removeClass("hidden").attr('rel', $(this).attr('id'));
        $(".addpanoSpot").removeClass("hidden").attr('rel', $(this).attr('id'));
        $(".infoApnAdd").removeClass("hidden");

        //check si image
        $.ajax({
            url: "http://monagence.immextenso.fr/LD/IM/globals/mandatimg/" + mandatID + "/pano/" + $(this).attr('id') + ".jpg",
            success: function(msg) {
                if (msg === "") {
                    $('#panoImgImg').attr("src", "http://monagence.immextenso.fr/LD/IM/globals/noImgPano.jpg");
                } else {
                    $('#panoImgImg').attr("src", "http://monagence.immextenso.fr/LD/IM/globals/mandatimg/" + mandatID + "/pano/" + idPictoto + ".jpg");
                }
            }
        });

        console.log('clic sur ' + $(this).attr('id'));
    });
    $(".deleteSpot").on("click", function(e) {
        $("#mandat2").removeAttr("disabled");
        var mandatID = $("#mandat2").val();
        var idapnDelete = $(this).attr('rel');
        $.ajax({
            url: "/transaction/edit/",
            type: "POST",
            data: {
                mandatAPNDelete: mandatID,
                idapn: idapnDelete
            },
            success: function(msg) {
                $('#' + idapnDelete).remove();
                $('#panoImgImg').attr("src", "http://monagence.immextenso.fr/LD/IM/globals/noImgPano.jpg");
                $('.infoApnAdd').addClass("hidden");
            }
        });
    });
    $(".ADDAPN").on("click", function(e) {
        $("#mandat2").removeAttr("disabled");
        var mandatID = $("#mandat2").val();
        $.ajax({
            url: "/transaction/edit/",
            type: "POST",
            data: {
                mandatAPN: mandatID,
                idapn: '',
                top: "0px",
                left: "0px",
                img: ''
            },
            success: function(msg) {
                $("#planModele").append('<div class="APNicon" id="idapn-' + msg + '"></div>');
                $("#idapn-" + msg).draggable({
                    containment: "parent",
                    stop: function() {
                        $("#mandat2").removeAttr("disabled");
                        var mandatID = $("#mandat2").val();

                        var top = $(this).css('top');
                        var left = $(this).css('left');
                        console.log(top, left);

                        $.ajax({
                            url: "/transaction/edit/",
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

            }
        });
});
	$(".removemap").on("click", function(e) {
        $("#mandat2").removeAttr("disabled");
        var mandatID = $("#mandat2").val();
        $.ajax({
            url: "/TR/95/",
            type: "POST",
            data: {
                idplan: mandatID,
                delImg: '99'
            },
            success: function(msg) {

                    //refresh miniature
                    $('#planImgImg').attr("src", "");
                    //cache l'ajout du plan
                    $('.planBlockTotal').css('display', 'block');
                    $('.plan2addPicto').removeClass("col-sm-11").addClass("col-sm-7");
                    $('.ADDAPN').css("display", "none");
					$('.removemap').css("display", "none");

            }
        });


    });
	
	$('#SaveEditPiece').on('click', function() {
		
		var nomedit = $('#edit_piece_nom').val();
		var surfaceedit = $('#edit_piece_surface').val();
		var orientationedit = $('#edit_piece_orientation').val();
		var solmuredit = $('#edit_piece_solmur').val();
		var noteedit = $('#edit_piece_note').val();	
		var idedit = $('#idpieceedit').val();
		var idinput = $('#idinput').val();


var idinputsplit = idinput.split('-');

$.ajax({
            type: "POST",
            url: "/transaction/92",
            data: {
                saveeditpiece: idedit,
				ext : idinputsplit[2]==='ext'?1:0,
				nom : nomedit,
				surface : surfaceedit,
				orientation : orientationedit,
				solmur : solmuredit,
				note : noteedit
            },
            success: function(msg) {
                $('#'+idinput+' td').eq(0).html(nomedit);
	$('#'+idinput+' td').eq(1).html(surfaceedit+'m2');
	$('#'+idinput+' td').eq(2).html(orientationedit);
	$('#'+idinput+' td').eq(3).html(solmuredit);
	$('#'+idinput+' td').eq(4).html(noteedit);

			//close dialog


            },
            error: function() {
                alert("erreur");

            }

        });



	
		
        
    })

	$("body").on("click", ".icon-edit-a", function(e) {
        //ajax suppression
        var parentBlock = $(this).parent().parent('.contentPiece');
        var idpiece2deleteArray = $(this).parent().parent('.contentPiece').attr('id');
        var idpiece2delete = idpiece2deleteArray.split('-');
        console.log(idpiece2delete);
        $.ajax({
            type: "POST",
            url: "/transaction/92",
            data: {
                editpiece: idpiece2delete[1],
				ext : idpiece2delete[2]==='ext'?1:0

            },
            success: function(msg) {
                //parentBlock.remove();
            },
            error: function() {
                alert("erreur");

            }

        });

        e.preventDefault();
    });


    $("body").on("click", ".icon-trash-a", function(e) {
        //ajax suppression
        var parentBlock = $(this).parent().parent('.contentPiece');
        var idpiece2deleteArray = $(this).parent().parent('.contentPiece').attr('id');
        var idpiece2delete = idpiece2deleteArray.split('-');
        console.log(idpiece2delete);
        $.ajax({
            type: "POST",
            url: "/transaction/edit",
            data: {
                deletepiece: idpiece2delete[1],
				ext : idpiece2delete[2]==='ext'?1:0

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
    $('#piece_nom, #piece_surface, #piece_orientation, #piece_solmur, #piece_note').keyup(function(e) { //remplacez {id_img} par l'id de votre image
        if (e.keyCode == 13) {
            //votre code à exécuter
            $("#btnValidPiece").get(0).click();
        }
    });
    $('#piece_nom_ext, #piece_surface_ext, #piece_orientation_ext, #piece_solmur_ext, #piece_note_ext').keyup(function(e) { //remplacez {id_img} par l'id de votre image
        if (e.keyCode == 13) {
            //votre code à exécuter
            $("#btnValidPiece_ext").get(0).click();
        }
    });
	$("#btnValidPiece_ext").on("click", function(e) {
        $("#mandat2").removeAttr("disabled");
        var valueMandat = $("#mandat2").val();
        console.log('mandat->' + valueMandat);
        $.ajax({
            type: "POST",
            url: "/transaction/edit",
            data: {
                mandat3: valueMandat,
                nom: $("#piece_nom_ext").val(),
                surface: $("#piece_surface_ext").val(),
                orientation: $("#piece_orientation_ext").val(),
                solmur: $("#piece_solmur_ext").val(),
                note: $("#piece_note_ext").val(),
				pos : $('#pieceArrayExt tbody tr').length+1,
				ext: 1
            },
            success: function(msg) {
                console.log('ok piece' + msg);

               
var htmlContent = '<tr class="contentPiece" id="idp-' + msg + '-ext"><td>' + $("#piece_nom_ext").val() + '</td><td>' + $("#piece_surface_ext").val() + 'm2</td><td>' + $("#piece_orientation_ext").val() + '</td><td>' + $("#piece_solmur_ext").val() + '</td><td>' + $("#piece_note_ext").val() + '</td><td><a class="icon-trash-a" href="#"><i class="icon-trash"></i></a><a style="margin-left: 5px;" class="icon-edit-a editint" href="/TR/92/'+msg+'/1" data-target="#myModalEditPiece" data-toggle="modal"><i class="icon-edit"></i></a></td></tr>';
			

                $('#piece_nom_ext, #piece_surface_ext, #piece_orientation_ext, #piece_solmur_ext, #piece_note_ext').val('')
                $('#pieceArrayExt tbody').append(htmlContent);
            },
            error: function() {
                alert("erreur");

            }

        });
        $("#mandat2").attr("disabled");
        e.preventDefault();
        return false;
    });
    $("#btnValidPiece").on("click", function(e) {
        $("#mandat2").removeAttr("disabled");
        var valueMandat = $("#mandat2").val();
        console.log('mandat->' + valueMandat);
        $.ajax({
            type: "POST",
            url: "/transaction/edit",
            data: {
                mandat3: valueMandat,
                nom: $("#piece_nom").val(),
                surface: $("#piece_surface").val(),
                orientation: $("#piece_orientation").val(),
                solmur: $("#piece_solmur").val(),
				pos : $('#pieceArray tbody tr').length+1,
                note: $("#piece_note").val()
            },
            success: function(msg) {
                console.log('ok piece' + msg);

var htmlContent = '<tr class="contentPiece" id="idp-' + msg + '"><td>' + $("#piece_nom").val() + '</td><td>' + $("#piece_surface").val() + 'm2</td><td>' + $("#piece_orientation").val() + '</td><td>' + $("#piece_solmur").val() + '</td><td>' + $("#piece_note").val() + '</td><td><a class="icon-trash-a" href="#"><i class="icon-trash"></i></a><a style="margin-left: 5px;" class="icon-edit-a editint" href="/TR/92/'+msg+'/0" data-target="#myModalEditPiece" data-toggle="modal"><i class="icon-edit"></i></a></td></tr>';


                $('#piece_nom, #piece_surface, #piece_orientation, #piece_solmur, #piece_note').val('')
                $('#pieceArray tbody').append(htmlContent);
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
        $("#mandat2").removeAttr("disabled");
        $('.stepDetail, .stepImg, .stepDesc').css("display", "block");
		var vals = $("#formStep2").serializeArray();
		vals.push({name: 'description', value: CKEDITOR.instances.description.getData()});
		vals.push({name: 'extrainfo', value: CKEDITOR.instances.extrainfo.getData()});
        $.ajax({
            type: "POST",
            url: "/transaction/edit",
            data: vals, /*{
             mandat2: valueMandat,
             titre : $("#titre").val(),
             url : $("#url").val(),
             description : $("#description").val(),
             superficie : $("#superficie").val(),
             nbrepiece : $("#nbrepiece").val(),
             localisation : $("#localisation").val(),
             prix : $("#prix_const").val(),
             type : $('input[name=type]:checked', '.form-group').val(),
             cp : $("#cp").val()
             },*/
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
		var d = new Date();
        $("#mandat2").removeAttr("disabled");
        var valueMandat = $("#mandat2").val();
        var nbimgMandat = $('.imgMandat').length + 1;
        if (nbimgMandat < 10)
            nbimgMandat = "0" + nbimgMandat;

        $(".imgMandat").removeClass("selected");
        $('<div class="col-sm-3 imgMandat selected" id="mini-' + nbimgMandat + '"><img src="http://monagence.immextenso.fr/LD/IM/globals/mandatimg/' + valueMandat + '/mini/' + nbimgMandat + '.jpg?'+d.getTime()+'"></div>').insertBefore("#addImgPict");
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
            url: "/TR/97",
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
						{name: 'styles', items: ['FontSize']},
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
        url: '/TR/98',
        dataType: 'json',
		dropZone: null,
        start: function() {
            //lance le chargement
            $('#progressBarPhoto').removeClass('hidden');
			$('#addImgPict').addClass('hidden');
        },
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                var idid = $('.imgMandat.selected').attr('id').split('-');
                var mandatID = $('#mandat2').val();

                $.ajax({
                    type: "POST",
                    url: "/TR/97",
                    data: {fileName: file.name, id: mandatID, idpict: idid[1]}
                }).done(function(msg) {
                    var info = msg.split('-');
                    var d = new Date();
                    //refresh miniature
                    $('#mini-' + info[1] + ' img').attr("src", "http://monagence.immextenso.fr/LD/IM/globals/mandatimg/" + info[0] + "/mini/" + info[1] + ".jpg?" + d.getTime());
                    //disabled bouton et remove selected
                    $(".imgMandat").removeClass("selected");
                    $("#btnSuccessPhoto").addClass("disabled");
                    $('#progressBarPhoto').addClass('hidden');
					$('#addImgPict').removeClass('hidden');

                });

            });
        }
    });
    $('#fileuploadPlan').fileupload({
        url: '/TR/98',
        dataType: 'json',
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                var mandatID4plan = $('#mandat2').val();

                $.ajax({
                    type: "POST",
                    url: "/TR/95",
                    data: {fileName: file.name, idplan: mandatID4plan}
                }).done(function(msg) {

                    var d = new Date();
                    //refresh miniature
                    $('#planImgImg').attr("src", "http://monagence.immextenso.fr/LD/IM/globals/mandatimg/" + mandatID4plan + "/plan/plan.jpg?" + d.getTime());
                    //cache l'ajout du plan
                    $('.planBlockTotal').css('display', 'none');
                    $('.plan2addPicto').removeClass("col-sm-7").addClass("col-sm-11");
                    $('.ADDAPN').css("display", "block");
					$('.removemap').css("display", "block");

                });
            });
        }
    });
    $('#fileuploadPano').fileupload({
        url: '/TR/98',
        dataType: 'json',
        start: function() {
            //lance le chargement
            $('#panoImgImg').addClass("hidden");
            $('#panoImgImgLoader').removeClass('hidden');

        },
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                var mandatID4pano = $('#mandat2').val();
                var pictoID = $(".addpanoSpot").attr('rel');
                $.ajax({
                    type: "POST",
                    url: "/TR/94",
                    data: {fileName: file.name, idplan: mandatID4pano, idpicto: pictoID}
                }).done(function(msg) {
                    var d = new Date();
                    //refresh miniature
                    $('#panoImgImgLoader').addClass("hidden");
                    $('#panoImgImg').removeClass('hidden');
                    $('#panoImgImg').attr("src", "http://monagence.immextenso.fr/LD/IM/globals/mandatimg/" + mandatID4pano + "/pano/" + pictoID + ".jpg?" + d.getTime());
                    //cache l'ajout du plan
                });
            });
        }
    });
});


