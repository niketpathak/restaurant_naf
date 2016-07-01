var app = angular.module('wp', ['ngRoute', 'ngSanitize']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when('/', {
		templateUrl: localized.partials + 'main.html',
		controller: 'Main'
	})
	.when('/info/:slug', {
			templateUrl: localized.partials + 'page_content.html',
			controller: 'Page'
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
//Content Controller
app.controller('Content',
		['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
			$http.get('restaurant/wp-json/wp/v2/posts/?filter[name]=' + $routeParams.slug).success(function(res){
				$scope.singlepost = res[0];
				console.log("singlePost",res[0]);
			});
			console.log("Inside content-controller:slug->",$routeParams.slug);
		}
	]
);
//Page Controller
app.controller('Page',
	['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
		$http.get('restaurant/wp-json/wp/v2/pages/' ).success(function(res){
			var all_pages = res;
			angular.forEach(all_pages, function(value, key) {
				//console.log(key + ': ' + value.slug);
				if(value.slug == $routeParams.slug) {
					$http.get('restaurant/wp-json/wp/v2/pages/' + value.id).success(function(res){
						$scope.singlepage = res;
						console.log("singlePage",res);
					});
				}
			});
			//console.log("pages",all_pages);
		});
		console.log("Inside pages-controller:slug->",$routeParams.slug);
	}
	]
);
