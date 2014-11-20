var recipeApp = angular.module('recipeApp',['ngRoute', 'ngTagsInput', 'ui.bootstrap']);
recipeApp.config(function($routeProvider, $locationProvider, tagsInputConfigProvider) {
    $routeProvider
        // route for the home page
        .when('/', {
            templateUrl : 'part/home.html',
            controller  : 'homeController'
        });

    $locationProvider
        // dont use hashtags for urls
        .html5Mode(true);

    tagsInputConfigProvider
        .setDefaults('tagsInput', {
            placeholder: 'Ką turite šaldytuve?',
            displayProperty: 'name',
            addFromAutocompleteOnly: true,
            replaceSpacesWithDashes: false
        })
        .setDefaults('autoComplete', {
            debounceDelay: 0,
            minLength: 1
        })
});
