recipeApp.controller('navController', function($scope, $location) {
    $scope.isActive = function (viewLocation) {
        return viewLocation === $location.url() ? "active" : "";
    };
});
