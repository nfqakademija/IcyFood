
recipeApp.controller('homeController', function($scope, $http, recipesFactory) {

    $scope.tags = [];

    $scope.loadTags = function(query) {
        return $http.get('/api/ingredients/filter/' + query);
    };

    $scope.isChecked = function(ingredientId) {
        if($scope.tags.length > 0){
            for (var i=0; i<$scope.tags.length; i++) {
                if ($scope.tags[i].id == ingredientId) {
                    return true;
                }
            }
        }
        return false;
    };

    $scope.toggleIngredient = function(ingredient) {
        for (var i=0; i<$scope.tags.length; i++) {
            if ($scope.tags[i].id == ingredient.id) {
                $scope.tags.splice(i,1);
                return;
            }
        }
        $scope.tags.push({id: ingredient.id, name: ingredient.name});
    };

    $scope.$watchCollection('tags', function(newValue, oldValue, $scope) {
        var promesa = recipesFactory.get(newValue);
        promesa.then(function(value) {
            $scope.recipes = value;
        }, function(reason) {
            $scope.error = reason;
        });
    });

})
.controller('showController', function($scope, $routeParams, recipesFactory){
    var recipe = recipesFactory.getRecipe($routeParams.id);
    recipe.then(function(value){
        $scope.recipe = value;
    }, function(reason) {
        $scope.errors = reason;
    });
});

recipeApp.controller('RatingCtrl', function ($scope, $http) {

    $scope.max = 5;
    $scope.isReadonly = false;

    $scope.init = function(rating, allowedToVote){
        $scope.rate = rating;
        $scope.isReadonly = allowedToVote;
    }

    $scope.ratingStates = [
        {stateOn: 'glyphicon-ok-sign', stateOff: 'glyphicon-ok-circle'},
        {stateOn: 'glyphicon-star', stateOff: 'glyphicon-star-empty'},
        {stateOn: 'glyphicon-heart', stateOff: 'glyphicon-ban-circle'},
        {stateOn: 'glyphicon-heart'},
        {stateOff: 'glyphicon-off'}
    ];

    $scope.setRating = function(id) {

        if($scope.isReadonly == true){
            return false;
        }

        var data = {
            rating: $scope.rate,
            id: id
        };

        $http.post('api/rate/recipe', angular.toJson(data), {cache: false})
            .success(function(data){
                $scope.isReadonly = true;
            })
            .error(function(data){
            });
    };
});
