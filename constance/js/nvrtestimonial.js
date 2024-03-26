jQuery(document).ready(function(){
	
	/*Add Class Js to html*/
	jQuery('html').addClass('js');	
	
	testislider_init();
});

function testislider_init(){
	"use strict";
	var slidereffect 			= 'slide';
    var slider_interval 		= '8000';
    var direction_nav 			= true;
    var control_nav 			= false;

    jQuery('.nvr-trotating.flexslider').flexslider({
        animation: slidereffect,
        slideshowSpeed: slider_interval,
        directionNav: direction_nav,
        controlNav: control_nav,
        smoothHeight: true,
		pauseOnHover: true,
		prevText : '',
		nextText : '',
		start : function(){
			jQuery('#slideritems').removeClass('preloader');
		}
    });
}