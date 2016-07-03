//Post Controller
app.controller('postController',
		['$scope', '$http', '$routeParams', '$sce', function($scope, $http, $routeParams, $sce) {
			$http.get(doc_root+'/wp-json/wp/v2/posts/?filter[name]=' + $routeParams.slug).success(function(res){
				$scope.singlepost = res[0];
				$scope.postContent = $sce.trustAsHtml(res[0].content.rendered);
				//console.log("singlePost",res[0]);
			});
			$scope.doc_root = doc_root;
		}
	]
);
