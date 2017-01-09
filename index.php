<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>GPIO Control</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/gpio.css">
    <script src="js/angular.min.js"></script>
    <script src="js/gpio.js"></script>
</head>
<body class="w3-lightgray" ng-app="gpioApplication" ng-controller="gpioController">
<div class="wrapper">
    <div class="w3-blue" ng-include="'_menus.php'"></div>

    <div class="pins">
        <div class="pin" ng-repeat="(p, pin) in pins">
            <a class="w3-btn" ng-class="{'w3-red':pin.status==1,'w3-pale-blue':pin.status!=1}"
               ng-click="gpio.flip(pin, p);">G#{{pin.number}} [{{p}}] = {{pin.status}}</a>

            <span ng-show="false">gpio mode {{pin.number}} out; gpio write {{pin.number}} 0;</span>

            <div class="modes-menus">
                <span ng-click="gpio.mode(pin, p, 'in')" class="w3-btn w3-green">In</span>
                <span ng-click="gpio.mode(pin, p, 'out')" class="w3-btn w3-red">Out</span>
            </div>
        </div>
    </div>

    <div class="w3-black">
        <p>Footer!</p>
    </div>

    <div class="error w3-panel w3-yellow w3-topbar w3-bottombar w3-border-amber">{{gpio.error}}</div>
</div>
</body>
</html>