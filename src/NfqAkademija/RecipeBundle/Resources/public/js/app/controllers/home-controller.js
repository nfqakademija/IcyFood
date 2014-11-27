recipeApp
    .controller('homeController', function($scope, $http, recipesFactory) {

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

        $scope.recipesArrange = function(newRecipes) {

            if (!($scope.recipes instanceof Array)) {
                $scope.recipes = newRecipes;
                return;
            }
            var i=0;
            while ( i<$scope.recipes.length) {
                while ($scope.recipes[i].recipe.id != newRecipes[i].recipe.id) {
                    $scope.recipes.splice(i,1);
                    if (typeof $scope.recipes[i] == 'undefined') {
                        i--;
                        break;
                    }
                }
                i++;
            }
            while (i<newRecipes.length){
                $scope.recipes.push(newRecipes[i]);
                i++;
            }
        };
        $scope.$watchCollection('tags', function(newValue, oldValue, $scope) {            var promesa = recipesFactory.get(newValue);
            promesa.then(function(value) {
                $scope.recipesArrange(value);
                $scope.newrecipes = [];
                for (var i = 0; i < 4; i++){
                    $scope.newrecipes.push($scope.recipes[i])
                };
                $scope.loadMore = function() {
                    var last = $scope.newrecipes.length - 1;
                    for(var i = 1; i <= 4; i++) {
                        if (typeof $scope.recipes[last+i] == 'undefined'){
                            $scope.noMore = function(){
                                return true;
                            };             
                        } else {
                            $scope.newrecipes.push($scope.recipes[last + i]); 
                        }
                    }
                };
                $scope.noMore = function(){
                    return false;
                };
            }, function(reason) {
                $scope.error = reason;
            });
        });      
    })

    .controller('showController', function($scope, $stateParams, recipesFactory, $location) {
        var promesa = recipesFactory.getRecipe($stateParams.id);
        promesa.then(function(value){
            $scope.r = value;
            $scope.absurl = $location.absUrl();
            console.log($location.absUrl());
        }, function(reason) {
            $scope.errors = reason;
        })
    })

    .controller('RatingCtrl', function ($scope, $http) {

        $scope.max = 5;
        $scope.isReadonly = false;

        $scope.$watch('r', function(newValue, oldValue, $scope) {
            if(typeof $scope.r === 'object') {
                $scope.init($scope.r.rating, $scope.r.readonly);
            }
        });

        $scope.init = function(rating, allowedToVote){
            $scope.rate = rating;
            $scope.isReadonly = allowedToVote;
        };

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

            $http.post('/api/rate/recipe', angular.toJson(data), {cache: false})
                .success(function(data){
                    $scope.isReadonly = true;
                })
                .error(function(data){
                });
        };
    })
    .directive('fbComments', function() {
        return {
            restrict: 'C',
            link: function(scope, element, attributes) { 
                element[0].dataset.href = document.location.href;
                return typeof FB !== "undefined" && FB !== null ? FB.XFBML.parse(element.parent()[0]) : void 0;
            }
        }
    });
