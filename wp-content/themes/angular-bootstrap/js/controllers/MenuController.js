//Menu Controller
app.controller('menuController',
	['$scope', '$http', '$routeParams', '$sce','CacheMenuService', 'CacheCategoryService', function($scope, $http, $routeParams, $sce, CacheMenuService, CacheCategoryService) {
			$scope.doc_root = doc_root;
			if(CacheMenuService.cached === false) {
				CacheMenuService.getMenu().then(function(){
					if(CacheCategoryService.cached === false) {
						CacheCategoryService.getAllCategories().then(function(){
							CacheMenuService.mergeCatsMenuItems(CacheCategoryService.all_categories);
							$scope.menu = CacheMenuService.menu;
							//console.log("FR:cachemenu", CacheMenuService.menu);
							//$scope.pageContent = $sce.trustAsHtml($scope.singlepage.content.rendered);
						});
					}
				});
			} else {
				$scope.menu = CacheMenuService.menu;
				//console.log("Cached:cachemenu", CacheMenuService.menu);

				//$scope.pageContent = $sce.trustAsHtml($scope.singlepage.content.rendered);
			}

		}
	]
);