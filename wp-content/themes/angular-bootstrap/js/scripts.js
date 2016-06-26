var app = angular.module('wp', ['ngRoute', 'ngSanitize']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when('/', {
		templateUrl: localized.partials + 'main.html',
		controller: 'Main'
	})
	.when('/:slug', {
		templateUrl: localized.partials + 'content.html',
		controller: 'Content'
	})
	.otherwise({
		redirectTo: '/'
	});
});
//Main controller
app.controller('Main', ['$scope', 'ThemeService', function($scope, ThemeService) {
	//Get Categories from ThemeService
	ThemeService.getAllCategories();
	
	//Get the first page of posts from ThemeService
	ThemeService.getPosts(1);

	$scope.data = ThemeService;
	console.log("Inside Main-controller");

}]);

app.controller('Content',
		['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
			$http.get('restaurant/wp-json/wp/v2/posts/?filter[name]=' + $routeParams.slug).success(function(res){
				$scope.singlepost = res[0];
				console.log("res",res[0]);
			});
			console.log("Inside content-controller:slug->",$routeParams.slug);
		}
	]
);
