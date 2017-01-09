<?php
require_once("../includes/inc.gpio.php");
require_once("../classes/class.shell.inc.php");

$pin_number = intval($_POST["number"]);

if (in_array($pin_number, $valid_pins)) {
    $pin = new pin($pin_number);
    $pin->flip();

    // read the current status again
    $status = $pin->status();

    $shell = new shell();
    $pins = $shell->parse_gpio_readall();
    // find the particular pin that got modified

    $statusDetails = null;
    foreach ($pins as $p => $pin) { // pin class object

        if ($pin_number == $pin->number()) {
            $statusDetails = $pin->statusDetails();
            break;
        }
    }

    echo json_encode($statusDetails);

} else {
    # error; invalid pin request
    echo "error";
}
