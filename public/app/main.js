angular.module('wx')
	.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
		$stateProvider
			.state('articles', {
				url : '/articles/:page',
				templateUrl : 'templates/articles.html',
				controller : 'Article',
				resolve : {
					'Articles' : ['Request', '$stateParams', function(Request, $stateParams){
						return Request.articles().success(function(res){
							return res;
						});
					}]
				}
			})
			.state('weixins', {
				url : '/weixins/:page',
				templateUrl : 'templates/weixin.html',
				controller : 'Weixin',
				resolve : {
					'Weixins' : ['Request', '$stateParams', function(Request, $stateParams){
						return Request.weixins().success(function(res){
							return res;
						});
					}]
				}
			})
			.state('tags', {
				url : '/tags/:page',
				templateUrl : 'templates/tags.html',
				controller : 'Tags',
				resolve : {
					'Tags' : ['Request', '$stateParams', function(Request, $stateParams){
						return Request.tags().success(function(res){
							return res;
						});
					}]
				}
			});

		$urlRouterProvider.otherwise('/');
	}])
	.controller('Article', ['$scope', 'Request', 'Articles', '$state', function ($scope, Request, Articles, $state) {
		$scope.articles = Articles.data;
		$scope.page = 1;


	}])
	.controller('Weixin', ['$scope', 'Request', '$state', 'Weixins', function ($scope, Request, $state, Weixins) {
		$scope.page = 1;
		$scope.weixins = Weixins.data;

	}])
	.controller('Tags', ['$scope', 'Request', '$state', 'Tags', function ($scope, Request, $state, Tags) {
		$scope.page = 1;
		$scope.tags = Tags.data;

	}]);