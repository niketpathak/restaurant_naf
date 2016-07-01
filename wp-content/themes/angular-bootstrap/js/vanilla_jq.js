//Main-menu: add/remove active class
(function($) {
	$(document).ready(function(){
		$(".menu-item a").click(function(){
			$(".menu-item").removeClass("active");
			$(this).parent().addClass("active");
			//return false;
		});
	});
}(jQuery));