//Menu Controller
app.controller('menuController',
	['$scope', '$http', '$routeParams', '$sce','CacheMenuService', 'CacheCategoryService', function($scope, $http, $routeParams, $sce, CacheMenuService, CacheCategoryService) {
			$scope.doc_root = doc_root;
			if(CacheMenuService.cached === false) {
				CacheMenuService.getMenu().then(function(){
					if(CacheCategoryService.cached === false) {
						CacheCategoryService.getAllCategories().then(function(){
							CacheMenuService.mergeCatsMenuItems(CacheCategoryService.all_categories);
							//$scope.menu = CacheMenuService.menu;	//@deprecated: 16th July 16

							//group items by category
							var cats = {};
							cats = _.groupBy(CacheMenuService.menu, function(item){
								return item.categories;
							});
							cats = _.toArray(cats);
							//split categories into half
							var total_items = Math.round(_.size(cats)/2);
							cats_split = _.groupBy(cats, function(element, index){
								return Math.floor(index/total_items);
							});

							//assign and rearrange side with lesser items
							var LHS = cats_split[0];
							var RHS = cats_split[1];
							var equilibrium = 0;
							while (equilibrium === 0) {
								var RHS_count = 0;
								var LHS_count = 0;
								for(var index in LHS) {
									LHS_count = LHS_count + LHS[index].length;
								}
								for(var index in RHS) {
									RHS_count = RHS_count + RHS[index].length;
								}

								if((LHS_count > RHS_count + 2) && LHS.length > 1) {	//2 items given as buffer
									RHS.push(_.last(LHS));
									LHS.pop();
								} else if(LHS_count < RHS_count && RHS.length > 1){
									LHS.push(_.last(RHS));
									RHS.pop();
								} else {
									equilibrium = 1;
								}

							}


							// update caching service, scope
							CacheCategoryService.setLHS(LHS);
							CacheCategoryService.setRHS(RHS);
							$scope.menu_lhs = CacheCategoryService.LHS;
							$scope.menu_rhs = CacheCategoryService.RHS;


							//console.log("LHS_count",LHS_count);
							//console.log("RHS_count",RHS_count);
							//console.log("cats",cats);
							//console.log("cats_split",cats_split);
							//console.log("LHS",LHS);
							//console.log("RHS",RHS);




						});
					}
				});
			} else {
				//$scope.menu = CacheMenuService.menu;	//@deprecated: 16th July 16
				$scope.menu_lhs = CacheCategoryService.LHS;
				$scope.menu_rhs = CacheCategoryService.RHS;
			}

		}
	]
);