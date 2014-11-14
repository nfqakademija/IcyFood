var recipeApp = angular.module('recipeApp',[]);
var tagApp = angular.module('tagApp', ['ngTagsInput', 'ui.bootstrap']);
tagApp.config(function(tagsInputConfigProvider) {
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
