
    'use strict';
    var app = angular.module('app', [
        'ngRoute', //$routeProvider
        'mgcrea.ngStrap', //bs-navbar, data-match-route directives
        'controllers',    //Our module frontend/web/js/controllers.js
        'ngAnimate',
        'services'
    ]);

    app.config(['$routeProvider', '$httpProvider',
        function ($routeProvider, $httpProvider) {
            $routeProvider.
                    when('/', {
                        templateUrl: 'partials/ads.html',
                    }).
                    when('/about', {
                        templateUrl: 'partials/about.html'
                    }).
                    otherwise({
                        templateUrl: 'partials/404.html'
                    });
            $httpProvider.interceptors.push('dataFactoryInterceptor');
        }
    ]);





