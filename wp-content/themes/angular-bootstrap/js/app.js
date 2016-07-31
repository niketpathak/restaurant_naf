//@global_var
var doc_root = "restaurant";	// without starting/trailing slash
//Load App with dependencies
var app = angular.module('wp', ['ngRoute', 'ngSanitize', 'angular.filter', 'ngAnimate', 'ui.bootstrap']);

//Config Phase
app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when('/', {
		templateUrl: localized.partials + 'main.html',
		controller: 'MainController'
	})
	.when('/menu', {
		templateUrl: localized.partials + 'menu_content.html',
		controller: 'menuController'
	})
	.when('/reservations', {
		templateUrl: localized.partials + 'reservations.html',
		controller: 'ReservationController'
	})
	.when('/test', {
		templateUrl: localized.partials + 'test_page.html',
		controller: 'testController'
	})
	.when('/info/:slug/:page_id', {
		templateUrl: localized.partials + 'page_content.html',
		controller: 'pageController'
		})
	.when('/:slug', {
		templateUrl: localized.partials + 'post_content.html',
		controller: 'postController'
	})
	.when('/category/:slug/:cat_id', {
		templateUrl: localized.partials + 'category_content.html',
		controller: 'categoryController'
	})
	.otherwise({
		redirectTo: '/'
	});
});
