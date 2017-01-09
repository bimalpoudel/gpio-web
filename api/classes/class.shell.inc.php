<?php

class shell
{
    public function parse_gpio_readall()
    {
        $shell_output_lines = array();
        exec("gpio readall", $shell_output_lines);
        #print_r($shell_output_lines);
        #die("That was shell.");

        $shell_output = implode("\r\n", $shell_output_lines);

        //  | BCM | wPi |   Name  | Mode | V | Physical
        $preg_left = "/ \|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|\|/i";
        $data_left = array();
        preg_match_all($preg_left, $shell_output, $data_left);
        #print_r($data_left);

        #// ical | V | Mode | Name    | wPi | BCM |
        $preg_right = "/\|\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|/i";
        $data_right = array();
        preg_match_all($preg_right, $shell_output, $data_right);
        #print_r($data_right);

        for ($i = 1; $i < 6; ++$i) {
            $data_left[$i] = array_map("trim", $data_left[$i]);
            $data_right[$i] = array_map("trim", $data_right[$i]);
        }

        $pins = array();

        $left_bcm_index = 1;
        $left_wpi_index = 2;
        $left_name_index = 3;
        $left_mode_index = 4;
        $left_value_index = 5;
        $left_physical_index = 6; // header
        // |  13 |  23 | GPIO.23 |  OUT | 1 | 33 ||
        foreach ($data_left[3] as $index => $name) {
            $pin = new pin($data_left[$left_physical_index][$index]);
            $pin->bcm($data_left[$left_bcm_index][$index]);
            $pin->wpi($data_left[$left_wpi_index][$index]);
            $pin->name($data_left[$left_name_index][$index]);
            $pin->mode($data_left[$left_mode_index][$index]);
            $pin->value($data_left[$left_value_index][$index]);
            $pin->physical($data_left[$left_physical_index][$index]);

            $pin->process();
            #print_r($pin); die();

            $pins[] = $pin;
        }

        $right_bcm_index = 6;
        $right_wpi_index = 5;
        $right_name_index = 4;
        $right_mode_index = 3;
        $right_value_index = 2;
        $right_physical_index = 1; // header
        // || 40 | 1 | OUT  | GPIO.29 | 29  | 21  |
        foreach ($data_right[4] as $index => $name) {
            $pin = new pin($data_right[$right_physical_index][$index]);
            $pin->bcm($data_right[$right_bcm_index][$index]);
            $pin->wpi($data_right[$right_wpi_index][$index]);
            $pin->name($data_right[$right_name_index][$index]);
            $pin->mode($data_right[$right_mode_index][$index]);
            $pin->value($data_right[$right_value_index][$index]);
            $pin->physical($data_right[$right_physical_index][$index]);

            $pin->process();
            #print_r($pin); die();

            $pins[] = $pin;
        }

        return $pins;
    }
}