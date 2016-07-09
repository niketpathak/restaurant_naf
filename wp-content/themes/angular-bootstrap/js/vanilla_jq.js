//Main-menu: add/remove active class
(function($) {
	$(document).ready(function(){

		// **** menu active items
		$(".menu-item a").click(function(){
			$(".menu-item").removeClass("active");
			$(this).parent().addClass("active");
			//return false;
		});

		// **** sticky nav
		var stickyNavTop = $('#masthead').offset().top;
		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop();
			if (scrollTop > stickyNavTop) {
				$('#masthead').addClass('sticky');
				$('.outermost').css('margin-top',"120px");

			} else {
				$('#masthead').removeClass('sticky');
				$('.outermost').css('margin-top',"0px");
			}
		});

	}); // doc.ready fn
}(jQuery));