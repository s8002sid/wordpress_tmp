// nivo slider 
jQuery(window).load(function() {
	jQuery('#slider').nivoSlider({ effect: 'fade' });
});

jQuery(document).ready( function(){
	jQuery('blockquote').append('<span class="bubble"></span>');	// add bubble to blockquotes
	var wwd = jQuery(window).width();
	if( wwd > 999 ){
		fixedHeader(); 	// fix header on page scroll
	}
});

jQuery(window).scroll( function(){
	var wwd = jQuery(window).width();
	if( wwd > 999 ){
		fixedHeader(); 	// fix header on page scroll
	}
});

// function to fix header on page scroll / load
var fixedHeader = function(){
	var hdrHt = jQuery('header.header').height();
	var scrPos = jQuery(window).scrollTop();
	var aBarHt = jQuery('#wpadminbar').height();
	if( scrPos > (hdrHt+35)/3 ){
		jQuery('header.header').addClass('fixed_header');
		jQuery('header.header').next().css('margin-top',(hdrHt+35)+'px');
	}else{
		jQuery('header.header').removeClass('fixed_header');
		jQuery('header.header').next().css('margin-top','0');
	}
}

// navigation script for responsive
var ww = jQuery(window).width();
jQuery(document).ready(function() { 
	jQuery("nav#nav li a").each(function() {
		if (jQuery(this).next().length > 0) {
			jQuery(this).addClass("parent");
		};
	})
	jQuery(".mobile_nav a").click(function(e) { 
		e.preventDefault();
		jQuery(this).toggleClass("active");
		jQuery("nav#nav").slideToggle('fast');
	});
	adjustMenu();
})
// navigation orientation resize callbak
jQuery(window).bind('resize orientationchange', function() {
	ww = jQuery(window).width();
	adjustMenu();
});
// navigation function for responsive
var adjustMenu = function() {
	if (ww < 999) {
		jQuery(".mobile_nav a").css("display", "block");
		if (!jQuery(".mobile_nav a").hasClass("active")) {
			jQuery("nav#nav").hide();
		} else {
			jQuery("nav#nav").show();
		}
		jQuery("nav#nav li").unbind('mouseenter mouseleave');
	} else {
		jQuery(".mobile_nav a").css("display", "none");
		jQuery("nav#nav").show();
		jQuery("nav#nav li").removeClass("hover");
		jQuery("nav#nav li a").unbind('click');
		jQuery("nav#nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
			jQuery(this).toggleClass('hover');
		});
	}
}

// Tabs
jQuery(document).ready(function(){
	jQuery('ul.tabs > br').remove();
	jQuery('.tabs-wrapper').append(jQuery('.tabs li div'));
	jQuery('.tabs li:first a').addClass('defaulttab selected');
	jQuery('.tabs a').click(function(){
		switch_tabs(jQuery(this));
	});
	switch_tabs(jQuery('.defaulttab'));
	function switch_tabs(obj) {
		jQuery('.tab-content').hide();
		jQuery('.tabs a').removeClass("selected");
		var id = obj.attr("rel");
		jQuery('#'+id).show();
		obj.addClass("selected");
	}
});

// Content Toggle
jQuery(function(){
    // Initial state of toggle (hide)
    jQuery(".slide_toggle_content").hide();
    // Process Toggle click (http://api.jquery.com/toggle/)
    jQuery("h3.slide_toggle").toggle(function(){
	    jQuery(this).addClass("clicked");
	}, function () {
	    jQuery(this).removeClass("clicked");
    });
    // Toggle animation (http://api.jquery.com/slideToggle/)
    jQuery("h3.slide_toggle").click(function(){
		jQuery(this).next(".slide_toggle_content").slideToggle();
    });
});

// Content Accordion
jQuery(document).ready(function(){
    jQuery('.accordion-container').hide();
    jQuery('.accordion-toggle:first').addClass('active').next().show();
    jQuery('.accordion-toggle').click(function(){
        if( jQuery(this).next().is(':hidden') ) {
            jQuery('.accordion-toggle').removeClass('active').next().slideUp();
            jQuery(this).toggleClass('active').next().slideDown();
        }
        return false; // Prevent the browser jump to the link anchor
    });
});
