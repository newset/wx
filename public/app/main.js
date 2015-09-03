angular.module('wx')
	.run(['$rootScope', function ($rootScope) {
		$rootScope.$on('$stateChangeError', function(event, toState, toParams, fromState, fromParams, error){
			
		})
	}])
	.factory('Tags', ['$http', '$q', '$timeout', function ($http, $q, $timeout) {
		var cache = [];
		return {
			all : function(){
				var defer = $q.defer();

				if (cache.length) {
					$timeout(function(){
						defer.resolve(cache);
					}, 0);
					return defer.promise;
				}else{
					$http.get(baseUrl + '/api/tags').success(function(res){
						cache = res;
						defer.resolve(cache);
					})
					.error(function(){
						defer.reject(cache, 'error');
					});
					return defer.promise;
				};
			}
		};
	}])
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
				url : '/weixins',
				abstract : true,
				template : '<div ui-view></div>'
			})
			.state('weixins.index', {
				url : '/:page',
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
			.state('weixins.show', {
				url : '/show/:id',
				templateUrl : 'templates/weixin-one.html',
				controller : 'ShowWeixin',
				resolve : {
					'Weixin' : ['Request', '$stateParams', '$q', function(Request, $stateParams, $q){
						var defer = $q.defer();

						Request.getWeixin($stateParams.id)
						.success(function(res){
							defer.resolve(res);
						})
						.error(function(res){
							notify(res.error, 'danger');
							defer.reject(res);
						});

						return defer.promise;
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

	}])
	.controller('ShowWeixin', ['$scope', 'Request', '$state', 'Weixin', 'Tags', function ($scope, Request, $state, Weixin, Tags) {
		$scope.weixin = Weixin;
		$scope.tagMarked = [];
		$scope.tagMarkedIds = [];

		$scope.tagMarked = $scope.weixin.tags;
		$scope.tagMarkedIds = $scope.weixin.tags.map(function(v){
			return v.id;
		});

		Tags.all().then(function(data){
			// 显示已标注
			$scope.tags = data;
		})

		$scope.mark = function(tag){
			if($scope.tagMarkedIds.indexOf(tag.id) != -1) return;
			$scope.tagMarked.push(tag);
			$scope.tagMarkedIds.push(tag.id);
		}

		$scope.remove = function(index){
			$scope.tagMarked.splice(index, 1);
			$scope.tagMarkedIds.splice(index, 1);
		}

		$scope.confirm = function(){
			var data = $scope.tagMarked.map(function(v){
				return v.id;
			});

			Request.mark($scope.weixin.id, data)
			.success(function(res){

			})
			.error(function(){

			});
		}
	}])
	.controller('TagsCtrl', ['$scope', 'Tags', function ($scope, Tags) {
		Tags.all().then(function(data){
			// 显示已标注
			$scope.tags = data;
		})
	}]);