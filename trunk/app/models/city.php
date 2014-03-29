<?php
//
// This source code was recovered by Recover-PHP.com
//


class City extends AppModel
{
    public $name = "City";
    public $actsAs = array("MultiValidatable", "Search.Searchable");
    public $_findMethods = array("search" => true);
    public $filterArgs = array(array("name" => "name", "type" => "like"));
    public $belongsTo = array("Country" => array("className" => "Country", "conditions" => "Country.iso3166_1=City.iso3166_1", "dependent" => false, "foreignKey" => false));
    public $validationSets = array("city_name" => array("name" => array("rule" => "notEmpty", "required" => true, "message" => "Please enter name.")));

}
