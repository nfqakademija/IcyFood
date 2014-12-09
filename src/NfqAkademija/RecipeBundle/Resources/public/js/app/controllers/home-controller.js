recipeApp
    .controller('homeController', function($scope, $http, recipesFactory) {

        $scope.tags = [];
        $scope.scrollBusy = false;

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
                var newId = (i<newRecipes.length) ? newRecipes[i].recipe.id : null;
                while ($scope.recipes[i].recipe.id != newId) {
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
        $scope.$watchCollection('tags', function(newValue, oldValue, $scope) {
            var promesa = recipesFactory.get(newValue);
            promesa.then(function(value) {
                $scope.recipesArrange(value);
                $scope.scrollBusy = false;
                $scope.loadMore = function() {
                    if ($scope.scrollBusy) return;
                    $scope.scrollBusy = true;
                    var last = $scope.recipes.length;
                    var promesa1 = recipesFactory.get(newValue, last, 4);
                    promesa1.then(function(value){
                        for(var i = 0; i < value.length; i++) {
                            $scope.recipes.push(value[i]);
                        }
                        $scope.scrollBusy = value.length == 0;
                    });
                };
            }, function(reason) {
                $scope.error = reason;
            });
        });  
    })

    .controller('showController', function($scope, $stateParams, recipesFactory, $location) {
        var promesa = recipesFactory.getRecipe($stateParams.id);
        $scope.absurl = $location.absUrl();
        promesa.then(function(value){
            $scope.r = value;
        }, function(reason) {
            $scope.errors = reason;
        })
    })

    .controller('formController', function($scope, $http, $compile, $sce) {
        $scope.formUrl = "/part/form";
        $scope.data = {};
        $scope.images = [];
        $scope.ingredients = [];

        $scope.addImage = function() {
            $scope.images.push($sce.trustAsHtml($('#form_images').data('prototype')))
        };

        $scope.addIngredient = function() {

            $scope.images.push($sce.trustAsHtml($('#form_ingredients').data('prototype')));
        };

        $scope.submit = function() {
            $http({
                method  : 'POST',
                url     : '/form/naujas/submit',
                data    : $scope.data,
                headers : { 'Content-Type': 'multipart/form-data' }
            })
                .success(function(data) {
                    $scope.formResponse = $compile(data)($scope);
                });

        };
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
            link: function($scope, element, attributes) { 
                element[0].dataset.href = $scope.absurl;
                return typeof FB !== "undefined" && FB !== null ? FB.XFBML.parse(element.parent()[0]) : void 0;
            }
        }
    })
    .directive('fbLike', function() {
        return {
            restrict: 'C',
            link: function($scope, element, attributes) { 
                element[0].dataset.href = $scope.absurl;
                return typeof FB !== "undefined" && FB !== null ? FB.XFBML.parse(element.parent()[0]) : void 0;
            }
        }
    });