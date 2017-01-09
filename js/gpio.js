var APIURL = "/gpio/api";

var app = angular.module('gpioApplication', []);

app.controller('gpioController', ["$scope", "$http", function($scope, $http) {
	$scope.gpio = {
		"error": "",
		"statuses": function()
		{
			// read the current statuses
			$http({
				method : "POST",
				url : APIURL+"/all/status.php",
				data: {
				},
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(function mySucces(response) {
				$scope.pins = response.data;
			}, function myError(response) {
				$scope.error = response; // response.statusText;
			});
		},
		"reset": function(lowOrHigh)
		{
			// reset the current statuses to low or high for all pins
			$http({
				method : "POST",
				url : APIURL+"/all/reset.php",
				data: {
					"lowOrHigh": lowOrHigh,
				},
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(function mySucces(response) {
				$scope.pins = response.data;
			}, function myError(response) {
				$scope.error = response; // response.statusText;
			});
		},
		"flip": function(pin, $id)
		{
			//alert("Checking single pin: "+pin);
			console.log(this);

			$http({
				method : "POST",
				url : APIURL+"/single/flip.php",
				data: pin,
				headers: {"Content-Type": "application/x-www-form-urlencoded"},
			}).then(function mySucces(response) {
				// update the particular pin that got modified
				$scope.pins[$id] = response.data;
			}, function myError(response) {
				$scope.error = response; // response.statusText;
			});
		},
		"mode": function(pin, $id, mode)
		{
			$http({
				method : "POST",
				url : APIURL+"/single/mode.php",
				data: pin,
				headers: {"Content-Type": "application/x-www-form-urlencoded"},
			}).then(function mySucces(response) {
				// update the particular pin that got modified
				$scope.pins[$id] = response.data;
			}, function myError(response) {
				$scope.error = response; // response.statusText;
			});
		},
	};
	
	$scope.gpio.statuses();
}]);