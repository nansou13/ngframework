var header = {
    init: function(){
	    $('.clientmenu li').on('click',function(e){
			$('.clientmenu li').removeClass('active');
			$(this).addClass('active');
			$('.contentstep').css('display','none');
			$('.contentstep.step'+($(this).index()+1)).css('display','block');
			e.preventDefault();
		});

    }
};
$(document).ready( function(){header.init();} );