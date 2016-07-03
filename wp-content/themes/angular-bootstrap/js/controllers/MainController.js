//Main controller
app.controller('MainController', ['$scope', 'ThemeService', function($scope, ThemeService) {
	//Get Categories from ThemeService
	ThemeService.getAllCategories();
	
	//Get the first page of posts from ThemeService
	ThemeService.getPosts(1);

	$scope.data = ThemeService;
	$scope.doc_root = doc_root;
	console.log("Inside Main-controller");

}]);