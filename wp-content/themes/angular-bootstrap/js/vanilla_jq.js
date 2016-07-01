document.addEventListener("DOMContentLoaded", function(event) {
	var main_menu = document.getElementById("main-menu");
	var main_menu_items  = document.getElementsByClassName("menu-item");
	main_menu_items.addEventListener("click", menuItemCLick);	//this event works only with getElementbyId();
});

function menuItemCLick(){
	console.log("clicked>>.");
}