
function ThemeService($http) {

	var ThemeService = {
		categories: [],
		posts: [],
		pageTitle: 'Latest Posts:',
		currentPage: 1,
		totalPages: 1,
		currentUser: {}
	};

	//Set the page title in the <title> tag
	function _setTitle(documentTitle, pageTitle) {
		document.querySelector('title').innerHTML = documentTitle + ' | Escale Indienne';
		ThemeService.pageTitle = pageTitle;
	}

	//Setup pagination
	function _setArchivePage(posts, page, headers) {
		ThemeService.posts = posts;
		ThemeService.currentPage = page;
		ThemeService.totalPages = headers('X-WP-TotalPages');
	}

	ThemeService.getAllCategories = function() {
    	//If they are already set, don't need to get them again
		if (ThemeService.categories.length) {
			return;
		}

		//Get the category terms from wp-json
		return $http.get('restaurant/wp-json/wp/v2/categories/').success(function(res){
			ThemeService.categories = res;
			//console.log(ThemeService.categories);
		});
	};

	ThemeService.getPosts = function(page) {
		return $http.get('restaurant/wp-json/wp/v2/posts/?page=' + page + '&filter[posts_per_page]=1').success(function(res, status, headers){
			ThemeService.posts = res;
			console.log("posts",ThemeService.posts);
			page = parseInt(page);

			// Check page variable for sanity
			if ( isNaN(page) || page > headers('X-WP-TotalPages') ) {
				_setTitle('Page Not Found', 'Page Not Found');
			} else {
				//Deal with pagination
				if (page>1) {
					_setTitle('Posts on Page ' + page, 'Posts on Page ' + page + ':');
				} else {
					_setTitle('Home', 'Latest Posts:');
				}

				_setArchivePage(res,page,headers);

			}
		});
	};

	return ThemeService;
}

//Finally register the service
app.factory('ThemeService', ['$http', ThemeService]);

//********************************************** CUSTOM_NPK *********************************************//


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
		return $http.get('restaurant/wp-json/wp/v2/pages/').success(function(res){
			Cache.all_pages = res;
			Cache.cached = true;
			//console.log("in_Cache_Service",res);
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
//Register this Service
app.factory('CachePagesService', ['$http', CachePagesService]);
