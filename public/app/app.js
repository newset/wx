angular.module('wx', ['ui.router', 'ngCookies', 'ngSanitize', 'ui.bootstrap'])
	.run(['$rootScope', '$cookies', '$http', '$state', function ($rootScope, $cookies, $http, $state) {
        $http.defaults.headers.post['X-CSRFToken'] = $cookies.csrftoken;
        // $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

        $rootScope.$state = $state;
        $rootScope.baseUrl = baseUrl;
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
			articles : function(page){
				return $http.get(baseUrl + '/api/articles', {'params' : {'page' : page}});
			},
			weixins : function(page){
				return $http.get(baseUrl + '/api/weixins', {'params' : {'page' : page}});
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
			},
			import : function(data){
				return $http.post(baseUrl + '/api/tags/import', {'tags' : data});
			}
		};
	}])
	.controller('Home', ['$scope', 'Request', function($scope, Request){
		$scope.dash = {};
		Request.dash().success(function(res){
			$scope.dash = res;
		});
	}]);