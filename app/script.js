var app = angular.module('demo', ['ui.router']);
 
app.config(function($stateProvider, $urlRouterProvider){
 
    $urlRouterProvider.otherwise('/');
 
    $stateProvider
    .state('app',{
        url: '/',
        views: {
            'header': {
                templateUrl: '/templates/partials/header.html'
            },
            'content': {
                templateUrl: '/templates/partials/content.html' 
            },
            'footer': {
                templateUrl: '/templates/partials/footer.html'
            }
        }
    })
 
    .state('app.dashboard', {
        url: 'dashboard',
        views: {
            'content@': {
                templateUrl: 'templates/dashboard.html',
                controller: 'DashboardController'
            }
        }
 
    })
 
    .state('app.campaigns', {
        url: 'campaigns',
        views: {
            'content@': {
                templateUrl: 'templates/campaigns.html',
                controller: 'CampaignController'
            }
        }
 
    })
 
    .state('app.subscribers', {
        url: 'subscribers',
        views: {
            'content@': {
                templateUrl: 'templates/subscribers.html',
                controller: 'SubscriberController'      
            }
        }
 
    })
    .state('app.subscribers.detail', {
        url: '/:id',
        /*
        templateUrl: 'templates/partials/subscriber-detail.html',
        controller: 'SubscriberDetailController'
        */
 
        views: {
            'detail@app.subscribers': {
                templateUrl: 'templates/partials/subscriber-detail.html',
                controller: 'SubscriberDetailController'        
            }
        }
 
    });
 
});