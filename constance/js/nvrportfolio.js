jQuery(document).ready(function(){
	
	/*Add Class Js to html*/
	jQuery('html').addClass('js');	
	
	show_pflightbox();
	show_pfcarousel();
});

jQuery(window).load(function(){
	pfisotopeinit();
});

jQuery(window).resize(function(){
	pfisotopeinit();
});

function show_pflightbox(){
	"use strict";
	/*=================================== PRETTYPHOTO ===================================*/
	jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',gallery_markup:'',social_tools:'',slideshow:2000});
}

function show_pfcarousel(){
	"use strict";
	var ctype = {
		"pcarousel" : {
			"index" : '.pcarousel .flexslider-carousel',
			"minItems" : 1,
			"maxItems" : 5,
			"itemWidth" : 298
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

function pfisotopeinit(){
	"use strict";
	
	var pffilter = jQuery('#nvr-pf-filter');
    pffilter.isotope({
        itemSelector : '.element'
    });
	
	pffilter.infinitescroll({
		loading: {
			finishedMsg: interfeis_var.loadfinish,
			msg: null,
			msgText: interfeis_var.pfloadmore,
			img: interfeis_var.themeurl + 'images/pf-loader.gif'
		  },
			navSelector  : '#loadmore-paging',    // selector for the paged navigation 
			nextSelector : '#loadmore-paging .loadmorebutton a:first',  // selector for the NEXT link (to page 2)
			itemSelector : '.element',     // selector for all items you'll retrieve
			bufferPx: 40
		},
       	// call Isotope as a callback
		function ( newElements ) {

			var $newElems = jQuery( newElements ).css({ opacity: 0 });
			$newElems.imagesLoaded(function(){
				$newElems.animate({ opacity: 1 });
				pffilter.isotope( 'appended', $newElems, true );
				pffilter.isotope('reLayout');
				show_lightbox();
				jQuery('#loadmore-paging').css('display','block');
			});
		}
	);
	
	jQuery('#filters li').click(function(){
        jQuery('#filters li').removeClass('selected');
        jQuery(this).addClass('selected');
        var selector = jQuery(this).find('a').attr('data-option-value');
        pffilter.isotope({ filter: selector });
        return false;
    });
	
	jQuery(window).unbind('.infscr');
	
	jQuery('#loadmore-paging .loadmorebutton a:first').click(function(evt){
		pffilter.infinitescroll('retrieve');
		return false;
	});
	jQuery(document).ajaxError(function(e,xhr,opt){
		if(xhr.status==404){jQuery('#loadmore-paging a').remove();}
	});
}