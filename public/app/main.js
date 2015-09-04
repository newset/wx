angular.module('wx')
	.run(['$rootScope', '$http', function ($rootScope, $http) {
		$rootScope.$on('$stateChangeError', function(event, toState, toParams, fromState, fromParams, error){
			
		});

		$http.get(baseUrl + '/api/dash/user').success(function(res){
			$rootScope.currentLoginUser = res;
		});
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
			.state('home', {
				url : '/',
				templateUrl : 'templates/index.html',
				controller : 'Home'
			})
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
					'Weixin' : ['Request', '$stateParams', '$q', '$state', function(Request, $stateParams, $q, $state){
						var defer = $q.defer();

						Request.getWeixin($stateParams.id)
						.success(function(res){
							defer.resolve(res);
						})
						.error(function(res){
							notify(res.error, 'danger');
							defer.reject(res);
							$state.go('weixins.index');
						});

						return defer.promise;
					}]
				}
			})
			.state('tags', {
				url : '/tags/:page',
				templateUrl : 'templates/tags.html',
				controller : 'TagsCtrl'
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

		// 获取可以操作的公众号
		Request.get_weixin().success(function(res){
			$state.go('weixins.show', {id : res.id});
		});
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
			$scope.cates = data;
			$scope.tags = data.map(function(v){
				return v.tags;
			});
		})

		$scope.mark = function(tag){
			if($scope.tagMarked.length == 3){
				notify('至多选择三个标签', 'danger');
				return;
			}

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

			if (data.length == 0) {
				notify('至少选择一个标签', 'danger');
				return
			};			
			Request.mark($scope.weixin.id, data);

			.success(function(res){
				if (res.code == 0) {
					$state.go('weixins.show', {'id' : res.next.id}, {'reload': true});
				};
			})
			.error(function(){

			});
		}
	}])
	.controller('TagsCtrl', ['$scope', 'Tags', 'Request', function ($scope, Tags, Request) {
		Tags.all().then(function(data){
			// 显示已标注
			$scope.cates = data;
		});

		// 导入文件
		$scope.import = function(){
			Request.import($scope.newTags)
				.success(function(res){
					$scope.newTags = '';
					$scope.cates = res.tags;
					if (res.status) {
						notify('导入成功', 'success');
					}else{
						notify('部分导入出错, 标签已存在', 'danger');
					};
				})
				.error(function(){
					notify('部分导入出错,包含已有标签', 'danger');
				});
		}
	}]);