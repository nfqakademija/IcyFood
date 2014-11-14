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


tagApp.controller('RatingCtrl', function ($scope, $http) {

  $scope.max = 5;
  $scope.isReadonly = false;

  $scope.hoveringOver = function(value) {
    $scope.overStar = value;
    $scope.percent = 100 * (value / $scope.max);
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
      return;
    }

    var data = {
      rating: $scope.rate,
      id: id
    };

    $http.post('api/rate/recipe', angular.toJson(data), {cache: false})
       .success(function(data){
        })
        .error(function(data){
          alert(data.message);
        });
  };
});
