
(function($){

	$(document).ready(function(){
		/* -------------------------------- */
		new WOW().init();
		/* -------------------------------- */
		$('a').click(function(e){
			e.preventDefault();
			volver  = $(this).attr('href');
			$('html, body').animate({
			scrollTop: $(volver).offset().top
			}, 500);
		});
		/* -------------------------------- */
	});
})(jQuery);
