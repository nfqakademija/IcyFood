tagApp.controller('tagController', function($scope, $http, recipesFactory) {

    $scope.loadTags = function(query) {
        return $http.get('/api/ingredients/filter/' + query);
    };

    $scope.$watchCollection('tags', function(newValue, oldValue, $scope) {
        var promesa = recipesFactory.get(newValue);
        promesa.then(function(value) {
            $scope.recipes = value;
        }, function(reason) {
            $scope.error = reason;
        });
    });

});

tagApp.controller('ratingController', function($scope, $http) {
    $scope.rateFunction = function(rating, id){
        var _url = '/api/rate/recipe'
        var data = {
            rating: rating,
            id: id
        };

        $http.post(_url, angular.toJson(data), {cache: false})
        .success(function(data){
            console.log(data);
        })
        .error(function(data){
            console.log(data)
        });
    };
});
