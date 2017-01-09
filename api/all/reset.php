<?php
require_once("../includes/inc.gpio.php");

// resets all pins to low or high

//$common_new_status = $_POST['lowOrHigh']==1?0:1;
$common_mode = $_POST['lowOrHigh']==1?"DOWN":"UP";

foreach($valid_pins as $p => $pin_number)
{
	$pin = new pin($pin_number);
	$pin->mode($common_mode);
	$status = $pin->status();

	//$status = $common_new_status;
	$statuses[$p] = $pin->statusDetails();
}

echo json_encode($statuses);
