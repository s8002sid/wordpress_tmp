jQuery(function($){

	//Goto Top
	$('.sp-totop').click(function(event) {
		 event.preventDefault();
		 $('html, body').animate({
			 scrollTop: $("body").offset().top
		 }, 500);
	});	
	//End goto top

});
jQuery(document).ready(function($){
    $(window).load(function(){
		$window        = $(window),
        $window.scroll(function(event){
			$("#sp-position-1").height(($('.carousel-home').height())/2);
			$("#sp-bottom-wrapper").css('padding-top', $('.carousel-home').height());
			$(".contact-map").height(($('.contact-form').height()));
		});
		
    });
	
	$("#sp-position-1").height(($('.carousel-home').height())/2);
	$("#sp-bottom-wrapper").css('padding-top', $('.carousel-home').height());
	$(".contact-map").height(($('.contact-form').height()));
});
