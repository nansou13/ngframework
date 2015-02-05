/*jQuery(function() {
	jQuery("#pano0").ddpanorama({width: 1000, height: 440, minSpeed: -20, loop: false, slideshow: false, bounce: false});
});*/

$(function() {

	$('.visuelmini').on("click", function(e) {
		$("#testCarousel-s").flexslider({animation: "slide", animationLoop: false, directionNav: false, slideshow: false, itemWidth: 80, itemMargin: 5, controlNav: false, asNavFor: '#slider'});
		$('#slider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			directionNav: false,
			slideshow: false,
			sync: "#carousel"
		});
	});
	
	$(".menuspe").eq(2).one("click",function(e){
		// Lancement de la construction de la carte google map
			var addressMap = $('#mapAdress').val();
			google.maps.event.addDomListener(window, 'load', initialiserCarte(addressMap));
	});

});



