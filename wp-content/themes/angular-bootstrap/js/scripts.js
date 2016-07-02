var app = angular.module('wp', ['ngRoute', 'ngSanitize']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when('/', {
		templateUrl: localized.partials + 'main.html',
		controller: 'MainController'
	})
	.when('/info/:slug/:page_id', {
			templateUrl: localized.partials + 'page_content.html',
			controller: 'pageController'
		})
	.when('/:slug', {
		templateUrl: localized.partials + 'post_content.html',
		controller: 'postController'
	})
	.otherwise({
		redirectTo: '/'
	});
});



//Main controller
app.controller('MainController', ['$scope', 'ThemeService', function($scope, ThemeService) {
	//Get Categories from ThemeService
	ThemeService.getAllCategories();
	
	//Get the first page of posts from ThemeService
	ThemeService.getPosts(1);

	$scope.data = ThemeService;
	console.log("Inside Main-controller");

}]);

//Content Controller
app.controller('postController',
		['$scope', '$http', '$routeParams', '$sce', function($scope, $http, $routeParams, $sce) {
			$http.get('restaurant/wp-json/wp/v2/posts/?filter[name]=' + $routeParams.slug).success(function(res){
				$scope.singlepost = res[0];
				$scope.postContent = $sce.trustAsHtml(res[0].content.rendered);
				//console.log("singlePost",res[0]);
			});
		}
	]
);

//Page Controller
app.controller('pageController',
	['$scope', '$http', '$routeParams', '$sce', function($scope, $http, $routeParams, $sce) {
		$http.get('restaurant/wp-json/wp/v2/pages/' + $routeParams.page_id).success(function(res){
			$scope.singlepage = res;
			$scope.pageContent = $sce.trustAsHtml(res.content.rendered);
			//console.log("singlePage",res);
			});
		}
	]
);
