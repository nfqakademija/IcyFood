tagApp.controller('recipeController', function($scope, $http) {
	$http.get('/recipe').success(function(data) {
		$scope.recipes = data;
		//$scope.b = tags;
		//console.log($scope.b);
  	});
});
tagApp.controller('tagController', function($scope, $http) {
	$scope.loadTags = function(query) {
		return $http.get('/search?q=' + query);
	};
});
tagApp.factory('FilterRecipes', function($http){
	var service = {
    	results: {}
  	};
	$http.get('/show/1').then(function(response) {
		service.results = response.data;
	});
	console.log(service);
	return service;

});
tagApp.filter('filterec', function(FilterRecipes){
	return function(items, tags){
		//console.log(tags);
		id = 2;
		return FilterRecipes;
	}
});
tagApp.filter('startsWithLetter', function () {
 	return function (items, tags) {
 		var filtered = [];
  		if(typeof tags === "undefined") {
      		return items;
    	} else {
    		if (tags.length > 0){
    			for (i = 0; i < items.length; i++){
    				for (x=0;x<items[i].ingredients.length; x++){
    					for(z=0;z<tags.length;z++){
    						if (items[i].ingredients[x].name == tags[z].name){
    							filtered.push(items[i]);
    						}
    					}
    					
    				}
    			}
    			return filtered;
    		} else {
    			return items;
    		}
  		}
    }
    
});