//Main-menu: add/remove active class
(function($) {
	$(document).ready(function(){

		// **** menu active items
		$(".menu-item a").click(function(){
			$(".menu-item").removeClass("active");
			$(this).parent().addClass("active");
			//return false;
		});
		$('.menu').addClass('menu_transparent');	//make menu transparent on page load
		$(".menu-item").each(function(){
			$(this).removeClass("active");
			$(this).removeClass("current-menu-item");
		});

		// **** sticky nav
		var stickyNavTop = $('#masthead').offset().top;
		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop();
			if (scrollTop > stickyNavTop) {
				$('#masthead').addClass('sticky');
				$('.outermost').css('margin-top',"120px");

				//make menu_dark/bright by position
				if(scrollTop < stickyNavTop + 90) {
					$('.menu').addClass('menu_transparent');
				} else {
					$('.menu').removeClass('menu_transparent');
				}
			} else {
				$('#masthead').removeClass('sticky');
				$('.outermost').css('margin-top',"0px");
				$('.menu').addClass('menu_transparent');	//keep transparency at top
			}
		});

	}); // doc.ready fn
}(jQuery));

// background: rgba(0, 0, 0, 0.87);