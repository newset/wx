angular.module('wx')
	.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
		$stateProvider
			.state('auth', {
				url : '/auth',
				controller : 'Auth',
				templateUrl : 'template/login.html'
			});
		$urlRouterProvider.otherwise('/auth');
	}])
	.controller('Auth', ['$scope', 'Request', function ($scope, Request) {

		$scope.userData = {};
		
		$scope.doLogin = function(login){
			Request.login(login).success(function(res){
				location = baseUrl;
			});
		}

		$scope.doRegister = function(){
			Request.register($scope.register)
			.success(function(res){
				notify('注册成功，请登录', 'success');
				location = baseUrl;
			})
			.error(function(res){
				if (res.email) {};
				notify('注册失败', 'danger');
			})
		}
	}])