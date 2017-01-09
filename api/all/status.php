<?php
header("Content-Type: text/plain");

require_once("../includes/inc.gpio.php");
require_once("../classes/class.shell.inc.php");

$shell = new shell();
$pins = $shell->parse_gpio_readall();

// totally optional to filter
$gpio_pins = array_filter($pins, array(new pin(0), 'filter_gpio')); // get GPIO pins only

// totally optional to sort
usort($gpio_pins, array(new pin(0), 'sort_gpio'));

#print_r($pins);
#print_r($gpio_pins);

$statuses = array();
foreach ($gpio_pins as $p => $pin) { // pin class object
    $statuses[$p] = $pin->statusDetails();
}
echo json_encode($statuses);
