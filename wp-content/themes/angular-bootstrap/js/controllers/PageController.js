//Page Controller
app.controller('pageController',
	['$scope', '$http', '$routeParams', '$sce', 'CachePagesService', '$timeout', function($scope, $http, $routeParams, $sce, CachePagesService, $timeout) {
		$scope.doc_root = doc_root;
		/************** specific to contact page start *************/
		$scope.rest_stat = "";
		$scope.rest_stat_hide = true;
		$scope.reservation_forceDisable = false;
		$scope.ajax_loader_hide = true;
		//handle form submit
		$scope.submitContactRequest = function () {
			$scope.contact_forceDisable = true;
			$scope.ajax_loader_hide = false;
			var data_in = {
				"name": $scope.name,
				"email": $scope.email,
				"sub": $scope.subject,
				"msg": $scope.msg
			};
			$http.post(doc_root+'/make_contact.php', data_in).then(function(e){
				// console.log('success fired',e);
				$scope.ajax_loader_hide = true;
				$scope.rest_stat_hide = false;
				if(e.data.res==0) {
					$scope.reservation_forceDisable = false;
				}
				$scope.rest_stat = e.data.msg;
				$timeout(function () {
					$scope.rest_stat = "";
					$scope.rest_stat_hide = true;
				}, 4000);
			}, function(e){
				//@to-do: handle failure of ajax req
				return;
			});
		}
		/************** specific to contact page end *************/

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