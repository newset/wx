angular.module('wx')
	.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
		$stateProvider
			.state('auth', {
				url : '/auth',
				controller : 'Auth',
				templateUrl : '../templates/auth.html'
			});

		$urlRouterProvider.otherwise('/auth');
	}])
	.controller('Auth', ['$scope', 'Request', function ($scope, Request) {

		$scope.doLogin = function(){
			Request.login($scope.login).success(function(res){
				console.log(res);
			})
		}

		$scope.doRegister = function(){
			Request.register($scope.register).success(function(res){
				console.log(res);
			})
		}
	}])