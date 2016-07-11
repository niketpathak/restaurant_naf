/*
 * Caching for All Pages
 *
 * Author: Niket PATHAK
 * http://www.niketpathak.com
 * Version: 1.0
 * Date: 2nd July 2016
 */

//Register the Service
app.factory('CacheMenuService', ['$http', CacheMenuService]);
function CacheMenuService($http) {

	var Cache = {
		menu: [],
		cached: false
	};

	Cache.getMenu = function() {
		//If already cached, don't fetch again
		if (Cache.menu.length) {
			return;
		}
		//fetch posts from API, return promise
		return $http.get(doc_root+'/wp-json/wp/v2/posts/').success(function(res){
			Cache.menu = res;
			Cache.cached = true;
			//console.log("in_pageCache_Service",res);
		});
	};

	Cache.mergeCatsMenuItems = function(cats) {
		for (var i = 0, len = cats.length; i < len; i++) {
			for (var j = 0, leng = Cache.menu.length; j < leng; j++) {
				if (Cache.menu[j].categories[0] == cats[i].id) {
					Cache.menu[j].categories.category_name = cats[i].name;
					Cache.menu[j].categories.category_description = cats[i].description;
					Cache.menu[j].categories.category_link = cats[i].link;
					//console.log("merged-data",Cache.menu[j]);
				}
			}
		}
	}

	Cache.getPost = function(post_id) {
		for (var i = 0, len = Cache.menu.length; i < len; i++) {
			//console.log("RunCount:"+i);
			if (Cache.menu[i].id == post_id) {
				return Cache.menu[i];
			}
		}
	}

	Cache.clear = function(){
		Cache.cached = false;
	}

	return Cache;
}