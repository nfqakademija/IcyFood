tagApp.controller('recipeController', function($scope, $http) {
	$http.get('/recipe').success(function(data) {
		$scope.recipes = data;
  	});
});
tagApp.controller('tagController', function($scope, $http) {
	$scope.loadTags = function(query) {
		return $http.get('/search?q=' + query);
	};
});
tagApp.filter('filterByTags', function ($http) {
  return function (items, tags) {
    var filtered = [];
    if (typeof tags === "undefined" || tags.length === 0){
      return items;
    } else {
      if (tags.length < 2){
        // $http.post('/recipes', ['Bulvės']).then(function(response) {
        //   return response;
        //   console.log(response);
        // });
        // filtered = response;
      } else {
        (items || []).forEach(function (items) {
          var ingredients = items.ingredients;
          var matches = tags.some(function (tag) {
          //console.log(tag);
            for (i=0;i<ingredients.length; i++){
              if (ingredients[i].name.indexOf(tag.name) > -1){
                return items;
              }
            }
          });
          if(matches){
            filtered.push(items);
          }
        });
      }
    }
    return filtered;
  };
});