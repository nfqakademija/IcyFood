var recipeApp = angular.module('recipeApp',['ngRoute', 'ngTagsInput', 'ui.bootstrap', 'wu.masonry', 'infinite-scroll']);
recipeApp.config(function($routeProvider, $locationProvider, tagsInputConfigProvider) {
    $routeProvider
        // route for the home page
        .when('/', {
            templateUrl : 'part/home.html',
            controller  : 'homeController'
        })
        // route for the show page
        .when('/show/:id', {
            templateUrl : '/part/show.html',
            controller  : 'showController'
        });

    $locationProvider
        // dont use hashtags for urls
        .html5Mode(true);

    tagsInputConfigProvider
        .setDefaults('tagsInput', {
            placeholder: 'Surašykite jūsų turimus ingredientus',
            displayProperty: 'name',
            addFromAutocompleteOnly: true,
            replaceSpacesWithDashes: false
        })
        .setDefaults('autoComplete', {
            debounceDelay: 500,
            minLength: 1
        })
});
