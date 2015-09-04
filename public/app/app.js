angular.module('wx', ['ui.router', 'ngCookies', 'ngSanitize'])
	.run(['$rootScope', '$cookies', '$http', '$state', function ($rootScope, $cookies, $http, $state) {
        $http.defaults.headers.post['X-CSRFToken'] = $cookies.csrftoken;
        // $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

        $rootScope.$state = $state;
	}])
	.factory('Request', ['$http', '$q', function ($http, $q) {
		var baseUrl = window.baseUrl;
		return {
			login : function(data){
				return $http.post(baseUrl + '/auth/login', data);
			},
			register : function(data){
				return $http.post(baseUrl + '/auth/register', data);
			},
			articles : function(){
				return $http.get(baseUrl + '/api/articles');
			},
			weixins : function(){
				return $http.get(baseUrl + '/api/weixins');
			},
			getWeixin : function(id){
				return $http.get(baseUrl + '/api/weixins/show/'+ id);
			},
			get_weixin : function(){
				return $http.get(baseUrl + '/api/weixins/next');
			},
			tags : function(){
				return $http.get(baseUrl + '/api/tags');
			},
			mark : function(weixin, tags){
				return $http.post(baseUrl + '/api/weixins/mark', {
					'id' : weixin,
					'tags' : tags
				});
			},
			dash : function(){
				return $http.get(baseUrl + '/api/dash');
			}
		};
	}])
	.controller('Home', ['$scope', 'Request', function($scope, Request){
		$scope.dash = {};
		Request.dash().success(function(res){
			$scope.dash = res;
		});
	}]);