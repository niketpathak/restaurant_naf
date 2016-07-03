/*
 * Caching for All Pages
 *
 * Author: Niket PATHAK
 * http://www.niketpathak.com
 * Version: 1.0
 * Date: 2nd July 2016
 */

//Register the Service
app.factory('CachePagesService', ['$http', CachePagesService]);
function CachePagesService($http) {

	var Cache = {
		all_pages: [],
		cached: false
	};

	Cache.getAllPages = function() {
		//If already cached, don't fetch again
		if (Cache.all_pages.length) {
			return;
		}
		//fetch pages from API, return promise
		return $http.get(doc_root+'/wp-json/wp/v2/pages/').success(function(res){
			Cache.all_pages = res;
			Cache.cached = true;
			//console.log("in_pageCache_Service",res);
		});
	};

	Cache.getPage = function(page_id) {
		for (var i = 0, len = Cache.all_pages.length; i < len; i++) {
			//console.log("RunCount:"+i);
			if (Cache.all_pages[i].id == page_id) {
				return Cache.all_pages[i];
			}
		}
	}

	Cache.clear = function(){
		Cache.cached = false;
	}

	return Cache;
}