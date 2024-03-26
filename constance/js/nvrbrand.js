jQuery(document).ready(function(){
	
	/*Add Class Js to html*/
	jQuery('html').addClass('js');	
	
	show_brandcarousel();
});

function show_brandcarousel(){
	"use strict";
	var ctype = {
		"bcarousel" : {
			"index" : '.brand .flexslider-carousel',
			"minItems" : 2,
			"maxItems" : 5,
			"itemWidth" : 197
		}
	}
	
	for(var key in ctype){
		var carousel = ctype[key];
		jQuery(carousel.index).flexslider({
			animation: "slide",
			animationLoop: true,
			directionNav: true,
			controlNav: false,
			prevText : '',
			nextText : '',
			itemWidth: carousel.itemWidth,
			itemMargin: 0,
			minItems: carousel.minItems,
			maxItems: carousel.maxItems
		 });
	}
}