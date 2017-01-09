<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/json");

error_reporting(E_ALL|E_STRICT);
ini_set("display_errors", true);

define("__ROOT__", dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__."/api/classes/class.mode.inc.php");
require_once(__ROOT__."/api/classes/class.pin.inc.php");

require_once(__ROOT__."/api/includes/inc.angular.php");
require_once(__ROOT__."/api/includes/inc.pins.php");
