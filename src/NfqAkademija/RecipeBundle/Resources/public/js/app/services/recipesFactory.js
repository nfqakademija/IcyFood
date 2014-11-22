
recipeApp.factory('recipesFactory', function($q, $http) {

    var get = function (tags) {
        var deferred = $q.defer();
        $http.post('/api/recipes', tags)
            .success(function(data){
                deferred.resolve(data);
            })
            .error(function(){
                deferred.reject("error");
            });
        return deferred.promise;
    };
    var getRecipe = function (id) {
        var deferred = $q.defer();
        $http.get('/api/recipe/'+id)
            .success(function(data){
                deferred.resolve(data);
            })
            .error(function(){
                deferred.reject("error");
            });
        return deferred.promise;
    };
    return {
        get : get,
        getRecipe: getRecipe
    };

});