/*
 * Caching for All Categories
 *
 * Author: Niket PATHAK
 * http://www.niketpathak.com
 * Version: 1.0
 * Date: 2nd July 2016
 */
//Register the Service
app.factory('CacheCategoryService', ['$http', CacheCategoryService]);
function CacheCategoryService($http) {

	var Cache = {
		all_categories: [],
		cached: false,
		LHS: [],
		RHS: []
	};

	Cache.getAllCategories = function() {
		//If already cached, don't fetch again
		if (Cache.all_categories.length) {
			return;
		}
		//fetch pages from API, return promise
		return $http.get(doc_root+'/wp-json/wp/v2/categories/').success(function(res){
			Cache.all_categories = res;
			Cache.cached = true;
			console.log("in_CategoryCache_Service",res);
		});
	};

	Cache.getCategory = function(cat_id) {
		for (var i = 0, len = Cache.all_categories.length; i < len; i++) {
			//console.log("RunCount:"+i);
			if (Cache.all_categories[i].id == cat_id) {
				return Cache.all_categories[i];
			}
		}
	}

	Cache.setLHS = function(lhs_input) {
		Cache.LHS = lhs_input;
	}

	Cache.setRHS = function(rhs_input) {
		Cache.RHS = rhs_input;
	}

	Cache.clear = function(){
		Cache.cached = false;
		Cache.LHS = [];
		Cache.RHS = [];
	}

	return Cache;
}
