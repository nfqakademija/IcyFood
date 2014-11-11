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
