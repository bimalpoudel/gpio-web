<?php

class pin
{
    private $bcm; // ...
    private $wpi; // ...
    private $name;
    private $mode; // OUT, IN
    private $value; // status: 0, 1
    private $physical; // 1 ... 39

    //private $is_gpio = false; // @todo

    public function __construct($pin)
    {
        // wpi used as standard reading, writing
        // validate this pin
        $this->wpi = $pin;
    }

    private function validPin($pin)
    {
        return (int)$pin;
    }

    private function isValid()
    {
        // verify this's current pin number
        return true;
    }

    public function bcm($pin)
    {
        $this->bcm = $this->validPin($pin);
    }

    public function wpi($pin)
    {
        $this->wpi = $this->validPin($pin);
    }

    public function number()
    {
        return $this->wpi;
    }

    public function name($value)
    {
        $this->name = $value;
    }

    public function mode($MODE)
    {
        $this->mode = ($MODE == "OUT") ? "OUT" : "IN";

        $status = null;
        if ($this->isValid()) {
            $command = "gpio mode {$this->wpi} {$this->mode}";
            $status = $this->_command($command);
        }

        return $status;
    }

    public function currentMode()
    {
        return $this->mode;
    }

    public function value($value)
    {
        // 0 or 1
        $this->value = (int)$value == 1 ? 1 : 0;
    }

    public function physical($pin)
    {
        $this->physical = $this->validPin($pin);
    }

    public function process()
    {
        // set GPIO or not
        //$this->is_gpio = preg_match("/GPIO/", $this->name) == 1;
    }

    public function filter_gpio(pin $pin)
    {
        return preg_match("/GPIO/", $pin->name) == 1;
        //return $pin->is_gpio;
    }

    public function sort_gpio(pin $pin1, pin $pin2)
    {
        return ($pin1->wpi < $pin2->wpi) ? -1 : 1;
    }

    /**
     * Query, save and return the current status of a pin
     * @return null
     */
    public function status()
    {
        $status = null;
        if ($this->isValid()) {
            $command = "gpio read {$this->wpi}";
            $status = $this->_command($command);
        }

        $this->value = $status == 1; // 1 or 0
        return $this->value;
    }

    public function currentStatus()
    {
        return $this->value;
    }

    /**
     * Shared in JSON for single or all pins
     * @return array
     */
    public function statusDetails()
    {
        $status = $this->currentStatus(); // 0, 1...
        $details = array(
            #"name" => "", // our device pin name
            #"device" => "", // where is it connected to?
            "mode" => $this->currentMode(), // IN our out
            "number" => $this->number(),
            "status" => $status, // value
            "statusText" => $status == 1 ? "ON" : "OFF", // value
        );

        return $details;
    }

    private function _command($command = "#")
    {
        $output = null;
        $return = null;

        exec($command, $output, $return);
        #print_r($output);

        return isset($output[0]) ? $output[0] : null;
    }

    public function flip()
    {
        if ($this->isValid()) {
            $status = $this->status();
            $flipped_status = $status == 0 ? 1 : 0;

            $this->write($flipped_status);
        }
    }

    public function write($mode)
    {
        if ($this->isValid()) {
            $command = "gpio write {$this->wpi} {$mode}";
            $this->_command($command);
        }
    }
}
