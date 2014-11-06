recipeApp.controller('recipeController', function($scope, $http) {
  $http.get('/recipe').success(function(data) {
    $scope.recipes = data;
  });
});