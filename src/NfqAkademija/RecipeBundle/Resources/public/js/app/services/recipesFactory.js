
recipeApp.factory('recipesFactory', function($q, $http) {

    var get = function (tags, offset, limit) {
        var deferred = $q.defer();
        var vars = {
            ingredients: tags,
            offset: offset,
            limit: limit
        };
        $http.post('/api/recipes', vars)
            .success(function(data){
                deferred.resolve(data);
            })
            .error(function(reason){
                deferred.reject(reason);
            });
        return deferred.promise;
    };

    var getRecipe = function (id) {
        var deferred = $q.defer();
        $http.get('/api/recipe/'+id)
            .success(function(data){
                deferred.resolve(data);
            })
            .error(function(reason){
                deferred.reject(reason);
            });
        return deferred.promise;
    };

    return {
        get : get,
        getRecipe: getRecipe
    };

});