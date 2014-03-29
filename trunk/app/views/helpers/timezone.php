<?php

class TimeZoneHelper extends AppHelper {

    public $helpers = array('Form');
    var $timezones = array(
        '-12.0' => '(GMT -12:00) Eniwetok, Kwajalein',
        '-11.0' => '(GMT -11:00) Midway Island, Somoa',
        '-10.0' => '(GMT -10:00) Hawaii',
        '-9.0' => '(GMT -9:00) Alaska',
        '-8.0' => '(GMT -8:00) Pacific Time (US & Canada)',
        '-7.0' => '(GMT -7:00) Mountain Time (US & Canada)',
        '-6.0' => '(GMT -6:00) Central Time (US & Canada), Mexico City',
        '-5.0' => '(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima, Quito',
        '-4.0' => '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz',
        '-3.5' => '(GMT -3:30) Newfoundland',
        '-3.0' => '(GMT -3:00) Brazil, Buenos Aires, Georgetown',
        '-2.0' => '(GMT -2:00) Mid-Atlantic',
        '-1.0' => '(GMT -1:00) Azores, Cape Verde Islands',
        '0.0' => '(GMT) Western Europe Time, London, Lisbon, Casablanca, Monrovia',
        '+1.0' => '(GMT +1:00) CET(Central Europe Time), Brussels, Copenhagen, Madrid, Paris,Switzerland',
        '+2.0' => '(GMT +2:00) EET(Eastern Europe Time), Kaliningrad, South Africa',
        '+3.0' => '(GMT +3:00) Baghdad, Kuwait, Riyadh, Moscow, St. Petersburg, Volgograd, Nairobi',
        '+3.5' => '(GMT +3:30) Tehran',
        '+4.0' => '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi,Yerevan,Dubai',
        '+4.5' => '(GMT +4:30) Kabul',
        '+5.0' => '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
        '+5.5' => '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi',
        '+6.0' => '(GMT +6:00) Almaty, Dhaka, Colombo',
        '+7.0' => '(GMT +7:00) Bangkok, Hanoi, Jakarta',
        '+8.0' => '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong, Chongqing, Urumqi, Taipei',
        '+9.0' => '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
        '+9.5' => '(GMT +9:30 ) Adelaide, Darwin',
        '+10.0' => '(GMT +10:00) EAST(East Australian Standard), Guam, Papua New Guinea, Vladivostok',
        '+11.0' => '(GMT +11:00) Magadan, Solomon Islands, New Caledonia',
        '+12.0' => '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka, Marshall Island'
    );

    function select($fieldname, $label="Please Choose a timezone") {

        $list = $this->Form->input($fieldname, array("type" => "select", "label" => $label, "options" => $this->timezones, "error" => "Please choose a timezone"));
        return $this->output($list);
    }

    function display($index) {
        if(empty($this->timezones[$index])){
            return '';
        }else{
            return $this->output($this->timezones[$index]);
        }
    }

    function show() {
        $zones = array(
            'Pacific/Apia' => 'Apia, Upolu, Samoa', // UTC-11:00
            'US/Hawaii' => 'Honolulu, Oahu, Hawaii, United States', // UTC-10:00
            'US/Alaska' => 'Anchorage, Alaska, United States', // UTC-09:00
            'US/Pacific' => 'Los Angeles, California, United States', // UTC-08:00
            'US/Mountain' => 'Phoenix, Arizona, United States', // UTC-07:00
            'US/Central' => 'Chicago, Illinois, United States', // UTC-06:00
            'US/Eastern' => 'New York City, United States', // UTC-05:00
            'America/Santiago' => 'Santiago, Chile', // UTC-04:00
            'America/Sao_Paulo' => 'São Paulo, Brazil', // UTC-03:00
            'Atlantic/South_Georgia' => 'South Georgia, S. Sandwich Islands', // UTC-02:00
            'Atlantic/Cape_Verde' => 'Praia, Cape Verde', // UTC-01:00
            'Europe/London' => 'London, United Kingdom', // UTC+00:00
            'UTC' => 'Universal Coordinated Time (UTC)', // UTC+00:00
            'Europe/Paris' => 'Paris, France', // UTC+01:00
            'Africa/Cairo' => 'Cairo, Egypt', // UTC+02:00
            'Europe/Moscow' => 'Moscow, Russia', // UTC+03:00
            'Asia/Dubai' => 'Dubai, United Arab Emirates', // UTC+04:00
            'Asia/Karachi' => 'Karachi, Pakistan', // UTC+05:00
            'Asia/Dhaka' => 'Dhaka, Bangladesh', // UTC+06:00
            'Asia/Jakarta' => 'Jakarta, Indonesia', // UTC+07:00
            'Asia/Hong_Kong' => 'Hong Kong, China', // UTC+08:00
            'Asia/Tokyo' => 'Tokyo, Japan', // UTC+09:00
            'Australia/Sydney' => 'Sydney, Australia', // UTC+10:00
            'Pacific/Noumea' => 'Nouméa, New Caledonia, France', // UTC+11:00
        );
        $dateTime = new DateTime('now');
        foreach ($zones as $zone => $name) {
            $zoneObject = new DateTimeZone($zone);
            $dateTime->setTimezone($zoneObject);
            $zones[$zone] = $dateTime->format('g:i A - ') . $name;
        }
        return $zones;
    }

}

?> 