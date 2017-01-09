<?php
require_once("../includes/inc.gpio.php");
require_once("../classes/class.shell.inc.php");

$pin_number = intval($_POST["number"]);
$inverted_mode = $_POST["mode"]=="IN"?"OUT":"IN"; // invert the mode request

if(in_array($pin_number, $valid_pins))
{
	$pin = new pin($pin_number);
	$pin->mode($inverted_mode);
	$pin->write(0); // for safety reasons

    $status = $pin->status(); // read/generate the current status again

    $shell = new shell();
    $pins = $shell->parse_gpio_readall();
    // find the particular pin that got modified

    $statusDetails = null;
    foreach ($pins as $p => $pin) {
        if ($pin_number == $pin->number()) {
            $statusDetails = $pin->statusDetails();
            break;
        }
    }
    echo json_encode($statusDetails);
}
else
{
	# error; invalid pin request
	echo "error";
}
