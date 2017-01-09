<!DOCTYPE html>
<html lang="en-US">
<title>GPIO Control</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/gpio.css">
<script src="js/angular.min.js"></script>
<script src="js/gpio.js"></script>
</head>
<body class="w3-lightgray" ng-app="gpioApplication" ng-controller="gpioController">
<div class="wrapper">
    <div class="w3-blue" ng-include="'_menus.php'"></div>
    <div class="w3-row w3-white" style="border: 1px solid black; margin-bottom: 5px;"
         ng-repeat="(p, pin) in pins">
        <div class="w3-container w3-green">
            <h2>GPIO #{{pin.number}}</h2>
        </div>
        <div class="w3-container">
            <h2>
                <a class="w3-btn w3-round-xxlarge w3-sand w3-left" ng-click="gpio.mode(pin, p, 'IN')"
                   ng-show="pin.mode=='IN'">IN</a>
                <a class="w3-btn w3-round-xxlarge w3-yellow w3-left" ng-click="gpio.mode(pin, p, 'OUT')"
                   ng-show="pin.mode=='OUT'">OUT</a>

                <a class="w3-btn w3-round-xxlarge w3-right"
                   ng-class="{'w3-red':pin.status==1,'w3-pale-blue':pin.status!=1}" ng-click="gpio.flip(pin, p);
">{{pin.statusText}}</a>
            </h2>
        </div>
    </div>

    <div class="error w3-panel w3-yellow w3-topbar w3-bottombar w3-border-amber">{{gpio.error}}</div>
</div>
</body>
</html>