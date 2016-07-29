'use strict';

var ioc = angular.module('ioc-App', ['ui.router']);

ioc.config(function($stateProvider, $urlRouterProvider){
	
	$urlRouterProvider.otherwise('/');

	$stateProvider
	.state('ioc',{
		url: '/',
		views: {
			/*'breadcrumb': {
				templateUrl: 'templates/breadcrumb'
			},
			'breadcrumb': {
				templateUrl: 'templates/breadcrumb'
			},
			'sidebar-menu': {
				templateUrl: 'templates/sidebar_menu'
			},
			'page_contents-widgets': {
				templateUrl: 'templates/page_contents_widgets'	
			},*/
			'sidebar-menu': {
				templateUrl: 'templates/sidebar_menu'
			},
			'page-content': {
				templateUrl: 'templates/page_contents.html'	
			},

			'msg-task': {
				templateUrl: 'templates/msg_task'
			},
			'msg-messages': {
				templateUrl: 'templates/msg_messages'
			},
		}
	})

	.state('ioc.dashboard', {
		url: 'dashboard',
		views: {
			'content@': {
				templateUrl: 'templates/page_contents',
				controller: 'DashboardController'
			}
		}
		
	})
	
	.state('ioc.campaigns', {
		url: 'campaigns',
		views: {
			'content@': {
				templateUrl: 'templates/page_contents',
				controller: 'CampaignController'
			}
		}
		
	})
	
	.state('ioc.subscribers', {
		url: 'subscribers',
		views: {
			'content@': {
				templateUrl: 'templates/page_contents',
				controller: 'SubscriberController'		
			}
		}
		
	})
	.state('ioc.subscribers.detail', {
		url: '/:id', 
		/*
		templateUrl: 'templates/partials/subscriber-detail.html',
		controller: 'SubscriberDetailController'
		*/
		
		views: {
			'detail@ioc.subscribers': {
				templateUrl: 'templates/partials/subscriber-detail.html',
				controller: 'SubscriberDetailController'		
			}
		}
		
	}); 
	
});

ioc.controller('DashboardController', function($scope) {
    
});

ioc.controller('ItemController', function($scope) {
    
});

ioc.controller('SubscriberController', function($scope, SubscribersService) {
    $scope.subscribers = SubscribersService.list();
    //$scope.
});

ioc.controller('SubscriberDetailController', function($scope, $stateParams, SubscribersService) {
    $scope.selected = SubscribersService.find($stateParams.id);
});

ioc.factory('SubscribersService',function(){
	var subscribers = [{id: 1, name:'Craig McKeachie',email: 'craig@test.com', description:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora, repellendus facere expedita, magni cumque, voluptas vero nulla fugit enim ullam repellat earum vitae. Porro repellendus, officia quasi, alias numquam commodi.'},{id: 2, name:'John Doe',email: 'johndoe@gmail.com', description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore magnam nostrum officiis dolor delectus ipsa magni error culpa, autem sit, perferendis eligendi officia quod amet perspiciatis dignissimos omnis molestias tempore.'}];

	return {
		list: function(){
			return subscribers;
		},
		find: function(id){
			return _.find(subscribers,function(subscriber){
				return subscriber.id == id;
			})
		}

	}
});


