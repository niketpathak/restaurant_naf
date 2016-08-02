//Main-menu: add/remove active class
(function($) {
	$(document).ready(function(){

		// **** menu active items
		$(".menu-item a").click(function(){
			$(".menu-item").removeClass("active");
			$(this).parent().addClass("active");
			$("html, body").animate({ scrollTop: 0 }, "slow");
			//return false;
		});
		$("html").on("click",".main_menu_al",function (e) {
			$("html, body").animate({ scrollTop: 0 }, "slow");
			$(".menu-item").removeClass("active");
		});

		//scroll-to-top btn
		$("html").on("click",".go-top",function (e) {
			e.preventDefault();
			$("html, body").animate({ scrollTop: 0 }, "slow");
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
				//manage scroll-to-top button
				if(scrollTop > 200) {
					$(".go-top").fadeIn();
				} else {
					$(".go-top").fadeOut();
				}
			} else {
				$('#masthead').removeClass('sticky');
				$('.outermost').css('margin-top',"0px");
				$('.menu').addClass('menu_transparent');	//keep transparency at top
				$(".go-top").fadeOut();
			}
		});

	}); // doc.ready fn
}(jQuery));

// background: rgba(0, 0, 0, 0.87);