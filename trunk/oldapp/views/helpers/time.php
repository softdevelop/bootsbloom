<?php

class TimeHelper extends AppHelper {

    public $helpers = array('Form');
    var $timearr = array('0' => '12:00 AM', '1800' => '12:30 AM', '3600' => '01:00 AM', '5400' => '01:30 AM', '7200' => '02:00 AM', '9000' => '02:30 AM',
        '10800' => '03:00 AM', '12600' => '03:30 AM', '14400' => '04:00 AM', '16200' => '04:30 AM', '18000' => '05:00 AM', '19800' => '05:30 AM',
        '21600' => '06:00 AM', '23400' => '06:30 AM', '25200' => '07:00 AM', '27000' => '07:30 AM', '28800' => '08:00 AM', '30600' => '08:30 AM',
        '32400' => '09:00 AM', '34200' => '09:30 AM', '36000' => '10:00 AM', '37800' => '10:30 AM', '39600' => '11:00 AM', '41400' => '11:30 AM',
        '43200' => '12:00 PM', '45000' => '12:30 PM', '46800' => '01:00 PM', '48600' => '01:30 PM', '50400' => '02:00 PM', '52200' => '02:30 PM',
        '54000' => '03:00 PM', '55800' => '03:30 PM', '57600' => '04:00 PM', '59400' => '04:30 PM', '61200' => '05:00 PM', '63000' => '05:30 PM',
        '64800' => '06:00 PM', '66600' => '06:30 PM', '68400' => '07:00 PM', '70200' => '07:30 PM', '72000' => '08:00 PM', '73800' => '08:30 PM',
        '75600' => '09:00 PM', '77400' => '09:30 PM', '79200' => '10:00 PM', '81000' => '10:30 PM', '82800' => '11:00 PM', '84600' => '11:30 PM'
    );
    var $month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

    function time_select($fieldname, $selected=0, $options=array('label' => "Please Select Time", "error" => "Please choose a time", 'empty' => "Please Select Time")) {
        $list = $this->Form->select($fieldname, $this->timearr, $selected, $options);
        return $this->output($list);
    }

    function month_select($fieldname, $selected=0, $options=array('label' => "Please Select Month", "error" => "Please choose a month", 'empty' => "Please Select Month")) {
        $list = $this->Form->select($fieldname, $this->month, $selected, $options);
        return $this->output($list);
    }

    function year_select($fieldname, $selected=0, $max_value=5, $options=array('label' => "Please Select Year", "error" => "Please choose a Year", 'empty' => "Please Select Year")) {
        $current_year = date("Y");
        $year_array = array();
        for ($y = $current_year; $y <= ($current_year + $max_value); $y++) {
            $year_array[$y] = $y;
        }
        $list = $this->Form->select($fieldname, $year_array, $selected, $options);
        return $this->output($list);
    }

    function get_month($month_val=0) {
        return $this->month[$month_val];
    }

}