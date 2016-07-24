//Page Controller
app.controller('pageController',
	['$scope', '$http', '$routeParams', '$sce', 'CachePagesService', function($scope, $http, $routeParams, $sce, CachePagesService) {
		$scope.doc_root = doc_root;
		if(CachePagesService.cached === false) {
					//FirstRun: receives a Promise
					CachePagesService.getAllPages().then(function(){
					$scope.singlepage = CachePagesService.getPage($routeParams.page_id);
					$scope.pageContent = $sce.trustAsHtml($scope.singlepage.content.rendered);
				});
			} else {
				$scope.singlepage = CachePagesService.getPage($routeParams.page_id);
				$scope.pageContent = $sce.trustAsHtml($scope.singlepage.content.rendered);
			}
		}
	]
);