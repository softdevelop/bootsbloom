<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class Testimonial extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "testimonial_title", "type" => "string" ), array( "name" => "from_name", "type" => "string" ) );
    public $name = "Testimonial";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "from_name" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("testimonials", "Please enter  name", true) ) ), "testimonial_title" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("testimonials", "Please enter title", true) ) ), "testimonial_description" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("testimonials", "Please enter description", true) ) ) );
    }

    public function testimonial_title($data)
    {
        return "Select testimonial_title from testimonials WHERE value LIKE '%" . $data["testimonial_title"] . "%'  AND field = 'Testimonial.testimonial_title'";
    }

    public function from_name($data)
    {
        return "Select from_name from testimonials WHERE value LIKE '%" . $data["from_name"] . "%'  AND field = 'Testimonial.from_name'";
    }

}




?>