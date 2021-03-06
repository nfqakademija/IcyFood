var recipeApp = angular.module('recipeApp',['angular-loading-bar', 'ngTagsInput', 'ui.bootstrap', 'ui.router', 'wu.masonry', 'infinite-scroll', 'ngSanitize']);
recipeApp.config(function(cfpLoadingBarProvider, $urlRouterProvider, $stateProvider, tagsInputConfigProvider, $locationProvider) {

    cfpLoadingBarProvider.includeSpinner = false;

    // $routeProvider
    //     // route for the home page
    //     .when('/', {
    //         templateUrl : 'part/home.html',
    //         controller  : 'homeController'
    //     })
    //     // route for the show page
    //     .when('/show/:id', {
    //         templateUrl : '/part/show.html',
    //         controller  : 'showController'
    //     })
    //     .otherwise({redirectTo: '/'});

    $locationProvider
    //     // dont use hashtags for urls
         .html5Mode(true);
 
    $urlRouterProvider.otherwise('/');

    var modal = null;
    $stateProvider
        .state('home', {
            url: '/',
            views: {
                '@': {
                    templateUrl: '/part/home.html',
                    controller: 'homeController'
                }
            }
        })
        .state('modal',{
            abstract: true,
            parent: 'home',
            url: '',
            onEnter: ['$modal', '$rootScope', '$state',
                function($modal, $rootScope, $state){
                    modal = $modal.open({
                        template: '<div ui-view="modal"></div>',
                        backdrop: true
                    });
                    modal.result.finally(function(){
                        modal: null;
                        $state.go('home');
                    })
                }
            ],
            onExit: function(){
                if(modal){
                    modal.close();
                }
            }
        })
        .state('show', {
            parent: 'modal',
            url: 'show/{id:int}',
            views: {
                'modal@': {
                    templateUrl: '/part/show.html',
                    controller: 'showController'
                }
            }
        })
        .state('naujas', {
            parent: 'modal',
            url: 'naujas',
            views: {
                'modal@': {
                    templateUrl: '/part/new.html',
                    controller: 'formController'
                }
            }
        });
    tagsInputConfigProvider
        .setDefaults('tagsInput', {
            placeholder: 'Ką turite šaldytuve?',
            displayProperty: 'name',
            addFromAutocompleteOnly: true,
            replaceSpacesWithDashes: false
        })
        .setDefaults('autoComplete', {
            debounceDelay: 500,
            minLength: 1
        })
});
