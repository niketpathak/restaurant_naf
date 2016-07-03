//Category Controller
app.controller('categoryController',
	['$scope', '$http', '$routeParams', '$sce', 'CacheCategoryService', function($scope, $http, $routeParams, $sce, CacheCategoryService) {
		if(CacheCategoryService.cached === false) {
			//FirstRun: receives a Promise
			CacheCategoryService.getAllCategories().then(function(){
				$scope.singlecategory = CacheCategoryService.getCategory($routeParams.cat_id);
				$scope.categoryContent = $sce.trustAsHtml($scope.singlecategory.description);
			});
		} else {
			$scope.singlecategory = CacheCategoryService.getCategory($routeParams.cat_id);
			$scope.categoryContent = $sce.trustAsHtml($scope.singlecategory.description);
		}
		$scope.doc_root = doc_root;
	}
	]
);
